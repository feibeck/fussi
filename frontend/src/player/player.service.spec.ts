import { TestBed, inject } from '@angular/core/testing';
import { BaseRequestOptions, HttpModule, Http, Response, ResponseOptions } from '@angular/http';
import { MockBackend } from '@angular/http/testing';
import { PlayerService } from './player.service';
import { JsonPlayer } from './json-player.model';
import { PlayerSaveError } from './player-save-error.model';
import { Player } from './player.model';
import { PlayerLoadError } from './player-load-error.model';

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

    describe('getPlayer()', () => {

        it('returns a player', inject([PlayerService, MockBackend], (playerService, mockBackend) => {

            const playerJson = {
                id: 1,
                name: 'Foo',
                points: 10,
                matchCount: 1
            };

            mockBackend.connections.subscribe((connection) => {
                connection.mockRespond(new Response(new ResponseOptions({
                    body: JSON.stringify(playerJson)
                })));
            });

            playerService.getPlayer(1).subscribe((player: Player) => {
                expect(player.id).toBe(1);
                expect(player.name).toBe('Foo');
                expect(player.points).toBe(10);
                expect(player.matchCount).toBe(1);
            });

        }));

        it('returns not found for unknown player', inject([PlayerService, MockBackend], (playerService, mockBackend) => {

            mockBackend.connections.subscribe((connection) => {
                connection.mockError(new Response(new ResponseOptions({
                    status: 404
                })));
            });

            playerService.getPlayer(1).subscribe(
                null,
                (error: PlayerLoadError) => {
                    expect(error.isNotExistsError()).toBeTruthy();
                    expect(error.getMessage()).toBe(PlayerLoadError.playerNotExistsError);
                }
            );

        }));

        it('returns error message in case of server error',
            inject([PlayerService, MockBackend], (playerService, mockBackend) => {

            respondWithInvalidServerError(mockBackend);

            playerService.getPlayer(1).subscribe(
                null,
                (error: PlayerLoadError) => {
                    expect(error.isGeneralError()).toBeTruthy();
                    expect(error.getMessage()).toBe(PlayerLoadError.playerLoadingError);
                }
            );

        }));

        it('returns error message in case of invalid json',
            inject([PlayerService, MockBackend], (playerService, mockBackend) => {

            respondWithInvalidJson(mockBackend);

            playerService.getPlayer(1).subscribe(
                null,
                (error: PlayerLoadError) => {
                    expect(error.isGeneralError()).toBeTruthy();
                    expect(error.getMessage()).toBe(PlayerLoadError.playerLoadingError);
                }
            );

        }));

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

            respondWithInvalidServerError(mockBackend);

            playerService.getPlayerList().subscribe(
                null,
                (error: PlayerLoadError) => {
                    expect(error.isGeneralError()).toBeTruthy();
                    expect(error.getMessage()).toBe(PlayerLoadError.listLoadingError);
                }
            );

        }));

        it('returns error message in case of invalid json',
            inject([PlayerService, MockBackend], (playerService, mockBackend) => {

            respondWithInvalidJson(mockBackend);

            playerService.getPlayerList().subscribe(
                null,
                (error: PlayerLoadError) => {
                    expect(error.isGeneralError()).toBeTruthy();
                    expect(error.getMessage()).toBe(PlayerLoadError.listLoadingError);
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

            respondWithInvalidServerError(mockBackend);

            playerService.update(updatePlayer).subscribe(
                null,
                (error: PlayerSaveError) => {
                    expect(error.isValidationError()).toBeFalsy();
                    expect(error.getMessage()).toBe(PlayerSaveError.defaultMessage);
                });
        }));

        it('handles validation error', inject([PlayerService, MockBackend], (playerService, mockBackend) => {

            respondWithValidationError(mockBackend);

            playerService.update(updatePlayer).subscribe(
                null,
                (error: PlayerSaveError) => {
                    expect(error.isValidationError()).toBeTruthy();
                    expect(error.getValidationMessages()[0].field).toBe('name');
                    expect(error.getValidationMessages()[0].message).toBe('Name already exists');
                });
        }));

        it('handles invalid json in response', inject([PlayerService, MockBackend], (playerService, mockBackend) => {

            respondWithInvalidJson(mockBackend);

            playerService.update(updatePlayer).subscribe(
                null,
                (error: PlayerSaveError) => {
                    expect(error.isValidationError()).toBeFalsy();
                    expect(error.getMessage()).toBe(PlayerSaveError.defaultMessage);
                });

        }));

    });

    describe('create()', () => {

        const newPlayer = new Player(null, 'Foo', 0, 0);

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

            playerService.create(newPlayer).subscribe((player: JsonPlayer) => {
                expect(player.id).toBe(1);
                expect(player.name).toBe('Foo');
                expect(player.points).toBe(0);
                expect(player.matchCount).toBe(0);
            });

        }));

        it('handles internal server error', inject([PlayerService, MockBackend], (playerService, mockBackend) => {

            respondWithInvalidServerError(mockBackend);

            playerService.create(newPlayer).subscribe(
                null,
                (error: PlayerSaveError) => {
                    expect(error.isValidationError()).toBeFalsy();
                    expect(error.getMessage()).toBe(PlayerSaveError.defaultMessage);
                });
        }));

        it('handles validation error', inject([PlayerService, MockBackend], (playerService, mockBackend) => {

            respondWithValidationError(mockBackend);

            playerService.create(newPlayer).subscribe(
                null,
                (error: PlayerSaveError) => {
                    expect(error.isValidationError()).toBeTruthy();
                    expect(error.getValidationMessages()[0].field).toBe('name');
                    expect(error.getValidationMessages()[0].message).toBe('Name already exists');
                });
        }));

        it('handles invalid json in response', inject([PlayerService, MockBackend], (playerService, mockBackend) => {

            respondWithInvalidJson(mockBackend);

            playerService.create(newPlayer).subscribe(
                null,
                (error: PlayerSaveError) => {
                    expect(error.isValidationError()).toBeFalsy();
                    expect(error.getMessage()).toBe(PlayerSaveError.defaultMessage);
                });

        }));

    });

    describe('save()', () => {

        it('players with an id will be updated', inject([PlayerService], (playerService) => {

            spyOn(playerService, 'update');

            let player = new Player(1, 'Foo', 1, 0);

            playerService.save(player);

            expect(playerService.update).toHaveBeenCalledWith(player);

        }));

        it('players without an id will be created', inject([PlayerService], (playerService) => {

            spyOn(playerService, 'create');

            let player = new Player(null, 'Foo', 1, 0);

            playerService.save(player);

            expect(playerService.create).toHaveBeenCalledWith(player);

        }));

    });

});

function respondWithValidationError(mockBackend: MockBackend) {
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
}

function respondWithInvalidJson(mockBackend: MockBackend) {
    mockBackend.connections.subscribe((connection) => {
        connection.mockRespond(new Response(new ResponseOptions({
            status: 200,
            body: '{"name":"Foo'
        })));
    });
}

function respondWithInvalidServerError(mockBackend: MockBackend) {
    mockBackend.connections.subscribe((connection) => {
        connection.mockError(new Response(new ResponseOptions({
            status: 500,
            body: 'Internal Server Error'
        })));
    });
}
