import { TestBed, inject } from '@angular/core/testing';
import { BaseRequestOptions, HttpModule, Http, Response, ResponseOptions } from '@angular/http';
import { MockBackend } from '@angular/http/testing';
import { TournamentService } from './tournament.service';
import { JsonTournament } from '../model/json-tournament.model';
import { Tournament } from '../model/tournament.model';
import { LoadError } from '../../shared/model/load-error.model';

describe('TournamentService', () => {

    beforeEach(() => {
        TestBed.configureTestingModule({
            imports: [HttpModule],
            providers: [
                TournamentService,
                MockBackend,
                BaseRequestOptions,
                {
                    provide: Http,
                    useFactory: (mockBackend, options) => {
                        return new Http(mockBackend, options);
                    },
                    deps: [MockBackend, BaseRequestOptions]
                }
            ]
        });
    });

    describe('getActiveTournaments()', () => {

        it('should return an Observable<Tournament[]>',
            inject([TournamentService, MockBackend], (tournamentService, mockBackend) => {

            const mockResponse: JsonTournament[] = [
                {
                    name: 'Foo'
                },
                {
                    name: 'Bar'
                }
            ];

            mockBackend.connections.subscribe((connection) => {
                connection.mockRespond(new Response(new ResponseOptions({
                    body: JSON.stringify(mockResponse)
                })));
            });

            tournamentService.getActiveTournaments().subscribe((tournaments: Tournament[]) => {
                expect(tournaments.length).toBe(2);
                expect(tournaments[0].name).toEqual('Foo');
                expect(tournaments[1].name).toEqual('Bar');
            });

        }));

        it('should handle server error',
            inject([TournamentService, MockBackend], (tournamentService, mockBackend) => {

            mockBackend.connections.subscribe((connection) => {
                connection.mockError(new Response(new ResponseOptions({
                    status: 500
                })));
            });

            tournamentService.getActiveTournaments().subscribe(
                null,
                (error: LoadError) => {
                    expect(error.isGeneralError).toBeTruthy();
                }
            );

        }));

        it('should handle invalid json',
            inject([TournamentService, MockBackend], (tournamentService, mockBackend) => {

            mockBackend.connections.subscribe((connection) => {
                connection.mockRespond(new Response(new ResponseOptions({
                    body: '[{"name":'
                })));
            });

            tournamentService.getActiveTournaments().subscribe(
                null,
                (error: LoadError) => {
                    expect(error.isGeneralError).toBeTruthy();
                }
            );

        }));

    });

});
