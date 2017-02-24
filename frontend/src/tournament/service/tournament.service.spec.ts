import { TestBed, inject } from '@angular/core/testing';
import { BaseRequestOptions, HttpModule, Http, Response, ResponseOptions, URLSearchParams } from '@angular/http';
import { MockBackend, MockConnection } from '@angular/http/testing';
import { TournamentService } from './tournament.service';
import { JsonTournament } from '../model/json-tournament.model';
import { Tournament } from '../model/tournament.model';
import { LoadError } from '../../shared/model/load-error.model';
import { TournamentDetail } from '../model/tournament-detail.model';

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

    describe('getTournaments()', () => {

        it('should return an Observable<Tournament[]>',
            inject([TournamentService, MockBackend], (tournamentService, mockBackend) => {

            const mockResponse: JsonTournament[] = [
                {
                    id: 1,
                    name: 'Foo',
                    type: 'League',
                    active: true
                },
                {
                    id: 2,
                    name: 'Bar',
                    type: 'League',
                    active: true

                }
            ];

            mockBackend.connections.subscribe((connection) => {
                connection.mockRespond(new Response(new ResponseOptions({
                    body: JSON.stringify(mockResponse)
                })));
            });

            tournamentService.getTournaments().subscribe((tournaments: Tournament[]) => {
                expect(tournaments.length).toBe(2);
                expect(tournaments[0].name).toEqual('Foo');
                expect(tournaments[1].name).toEqual('Bar');
            });

        }));

        it('should handle query parameters',
            inject([TournamentService, MockBackend], (tournamentService, mockBackend) => {

            mockBackend.connections.subscribe((connection) => {
                expect(connection.request.url).toBe('http://localhost:8080/api/tournament?foo=bar');
                connection.mockRespond(new Response(new ResponseOptions({
                    body: JSON.stringify([])
                })));
            });

            let params = new URLSearchParams();
            params.set('foo', 'bar');
            tournamentService.getTournaments(params).subscribe((tournaments: Tournament[]) => {
                expect(tournaments.length).toBe(0);
            });
        }));

        it('should handle server error',
            inject([TournamentService, MockBackend], (tournamentService, mockBackend) => {

            mockBackend.connections.subscribe((connection) => {
                connection.mockError(new Response(new ResponseOptions({
                    status: 500
                })));
            });

            tournamentService.getTournaments().subscribe(
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

            tournamentService.getTournaments().subscribe(
                null,
                (error: LoadError) => {
                    expect(error.isGeneralError).toBeTruthy();
                }
            );

        }));

    });

    describe('getActiveTournaments()', () => {

        it('should call getTournaments() with right parameters',
            inject([TournamentService], (tournamentService) => {

            spyOn(tournamentService, 'getTournaments');

            let params = new URLSearchParams();
            params.set('state', 'active');

            tournamentService.getActiveTournaments();
            expect(tournamentService.getTournaments).toHaveBeenCalledWith(params);

        }));

    });

    describe('getTournamentDetail', () => {

        const tournamentDetail = {
            id: 3,
            name: 'Tournament 3',
            type: 'Tournament',
            active: true,
            ready: true,
            finished: false,
            winnerName: '',
            secondName: '',
            rounds: [
                {
                    matches: [
                        {
                            id: 1,
                            teamOneName: 'Flo/Hans',
                            teamTwoName: 'Peter/Stefan',
                            played: true,
                            ready: true,
                            score: '2 / 0'
                        },
                        {
                            id: 2,
                            teamOneName: 'Michael/Sebastian',
                            teamTwoName: 'Simon/Jürgen',
                            played: false,
                            ready: true,
                            score: ''
                        }
                    ]
                },
                {
                    matches: [
                        {
                            id: 3,
                            teamOneName: 'Flo/Hans',
                            teamTwoName: '',
                            played: false,
                            ready: false,
                            score: ''
                        }
                    ]
                },
            ]
        };

        it('should return an Observable<TournamentDetail>',
            inject([TournamentService, MockBackend], (tournamentService, mockBackend) => {

            mockBackend.connections.subscribe((connection) => {
                connection.mockRespond(new Response(new ResponseOptions({
                    body: JSON.stringify(tournamentDetail)
                })));
            });

            tournamentService.getTournamentDetail().subscribe((tournament: TournamentDetail) => {
                expect(tournament.id).toBe(3);
                expect(tournament.name).toBe('Tournament 3');
            });

        }));

        it('should handle server error',
            inject([TournamentService, MockBackend], (tournamentService, mockBackend) => {

            mockBackend.connections.subscribe((connection) => {
                connection.mockError(new Response(new ResponseOptions({
                    status: 500
                })));
            });

            tournamentService.getTournamentDetail().subscribe(
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

            tournamentService.getTournamentDetail().subscribe(
                null,
                (error: LoadError) => {
                    expect(error.isGeneralError).toBeTruthy();
                }
            );

        }));

    });

});
