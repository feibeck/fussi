import { TestBed, async, inject } from '@angular/core/testing';
import { BaseRequestOptions, HttpModule, Http, Response, ResponseOptions } from '@angular/http';
import { MockBackend } from '@angular/http/testing';
import { ActiveTournamentsService } from './active-tournaments.service';
import { Tournament } from '../../model/Tournament.model';

describe('ActiveTournamentService', () => {

    beforeEach(() => {
        TestBed.configureTestingModule({
            imports: [HttpModule],
            providers: [
                ActiveTournamentsService,
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
            inject([ActiveTournamentsService, MockBackend], (activeTournamentsService, mockBackend) => {

            const mockResponse: Tournament[] = [
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

            activeTournamentsService.getActiveTournaments().subscribe((tournaments: Tournament[]) => {
                expect(tournaments.length).toBe(2);
                expect(tournaments[0].name).toEqual('Foo');
                expect(tournaments[1].name).toEqual('Bar');
            });

        }));

    });

});