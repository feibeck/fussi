import { TestBed, inject } from '@angular/core/testing';
import { BaseRequestOptions, HttpModule, Http, Response, ResponseOptions } from '@angular/http';
import { MockBackend } from '@angular/http/testing';
import { PlayerService } from './player.service';
import { JsonPlayer } from './json-player.model';
import { PlayerSaveError } from './player-save-error.model';
import { Player } from './player.model';

describe('PlayerService', () => {

    beforeEach(() => {
        TestBed.configureTestingModule({
            imports: [HttpModule],
            providers: [
                PlayerService,
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

    describe('getPlayerList()', () => {

        it('returns list of players', inject([PlayerService, MockBackend], (playerService, mockBackend) => {

            const list = [
                {
                    id: 1,
                    name: 'Foo',
                    points: 10,
                    matchCount: 1
                },
                {
                    id: 2,
                    name: 'Bar',
                    points: 20,
                    matchCount: 2
                }
            ];

            mockBackend.connections.subscribe((connection) => {
                connection.mockRespond(new Response(new ResponseOptions({
                    body: JSON.stringify(list)
                })));
            });

            playerService.getPlayerList().subscribe((players: Player[]) => {
                expect(players.length).toBe(2);
                expect(players[0].id).toBe(1);
                expect(players[1].id).toBe(2);
            });

        }));

        it('returns error message in case of server error',
            inject([PlayerService, MockBackend], (playerService, mockBackend) => {

            mockBackend.connections.subscribe((connection) => {
                connection.mockError(new Response(new ResponseOptions({
                    status: 500
                })));
            });

            playerService.getPlayerList().subscribe(
                null,
                (message) => {
                    expect(message).toBe(PlayerService.listLoadingError);
                }
            );

        }));

        it('returns error message in case of invalid json',
            inject([PlayerService, MockBackend], (playerService, mockBackend) => {

            mockBackend.connections.subscribe((connection) => {
                connection.mockRespond(new Response(new ResponseOptions({
                    body: '[{"id":"1"'
                })));
            });

            playerService.getPlayerList().subscribe(
                null,
                (message) => {
                    expect(message).toBe(PlayerService.listLoadingError);
                }
            );

        }));

    });

    describe('update()', () => {

        const updatePlayer = new Player(1, 'Foo', 0, 0);

        it('returns player on success', inject([PlayerService, MockBackend], (playerService, mockBackend) => {

            const mockPlayer: JsonPlayer = {
                id: 1,
                name: 'Foo',
                points: 0,
                matchCount: 0
            };

            mockBackend.connections.subscribe((connection) => {
                connection.mockRespond(new Response(new ResponseOptions({
                    body: JSON.stringify(mockPlayer)
                })));
            });

            playerService.update(updatePlayer).subscribe((player: JsonPlayer) => {
                expect(player.id).toBe(1);
                expect(player.name).toBe('Foo');
                expect(player.points).toBe(0);
                expect(player.matchCount).toBe(0);
            });

        }));

        it('handles internal server error', inject([PlayerService, MockBackend], (playerService, mockBackend) => {

            mockBackend.connections.subscribe((connection) => {
                connection.mockError(new Response(new ResponseOptions({
                    status: 500,
                    body: 'Internal Server Error'
                })));
            });

            playerService.update(updatePlayer).subscribe(
                null,
                (error: PlayerSaveError) => {
                    expect(error.isValidationError()).toBeFalsy();
                    expect(error.getMessage()).toBe(PlayerSaveError.defaultMessage);
                });
        }));

        it('handles validation error', inject([PlayerService, MockBackend], (playerService, mockBackend) => {

            const responseErrorBody = {
                errors: [
                    {
                        field: 'name',
                        message: 'Name already exists'
                    }
                ]
            };

            mockBackend.connections.subscribe((connection) => {
                connection.mockError(new Response(new ResponseOptions({
                    status: 422,
                    body: JSON.stringify(responseErrorBody)
                })));
            });

            playerService.update(updatePlayer).subscribe(
                null,
                (error: PlayerSaveError) => {
                    expect(error.isValidationError()).toBeTruthy();
                    expect(error.getValidationMessages()[0].field).toBe('name');
                    expect(error.getValidationMessages()[0].message).toBe('Name already exists');
                });
        }));

        it('handles invalid json in response', inject([PlayerService, MockBackend], (playerService, mockBackend) => {

            mockBackend.connections.subscribe((connection) => {
                connection.mockRespond(new Response(new ResponseOptions({
                    status: 200,
                    body: '{"name":"Foo'
                })));
            });

            playerService.update(updatePlayer).subscribe(
                null,
                (error: PlayerSaveError) => {
                    expect(error.isValidationError()).toBeFalsy();
                    expect(error.getMessage()).toBe(PlayerSaveError.defaultMessage);
                });

        }));

    });

});
