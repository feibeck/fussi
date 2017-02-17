import { Injectable } from '@angular/core';
import { PlayerDb } from './player-db';
import { MockConnection } from '@angular/http/testing';
import { Response, ResponseOptions } from '@angular/http';
import { ErrorResponse } from './error-response';
import { PointLogDb } from './point-log-db';

@Injectable()
export class PlayerApi {

    constructor(private playerDb: PlayerDb, private pointLogDb: PointLogDb) {
    }

    public create(connection: MockConnection) {

        const requestPlayer = JSON.parse(connection.request.getBody());
        const validationResult = this.playerDb.validate(requestPlayer);

        if (validationResult === true) {

            let newPlayer = this.playerDb.save(requestPlayer);

            connection.mockRespond(new Response(new ResponseOptions({
                body: JSON.stringify(newPlayer),
                status: 201
            })));

        } else {

            connection.mockError(new ErrorResponse(new ResponseOptions({
                body: JSON.stringify({errors: validationResult}),
                status: 422
            })));

        }
    }

    public update(connection: MockConnection) {

        const requestPlayer = JSON.parse(connection.request.getBody());
        const validationResult = this.playerDb.validate(requestPlayer);

        if (validationResult === true) {

            let updatedPlayer = this.playerDb.save(requestPlayer);
            if (updatedPlayer === false) {

                connection.mockError(new ErrorResponse(new ResponseOptions({
                    body: 'Player not found',
                    status: 404
                })));

            } else {

                connection.mockRespond(new Response(new ResponseOptions({
                    body: JSON.stringify(updatedPlayer)
                })));

            }

        } else {

            connection.mockError(new ErrorResponse(new ResponseOptions({
                body: JSON.stringify({errors: validationResult}),
                status: 422
            })));

        }
    }

    public get(connection: MockConnection) {

        const id = parseInt(connection.request.url.match(/\/api\/player\/([0-9]+)/i)[1], 10);
        const foundPlayer = this.playerDb.getPlayer(id);

        if (foundPlayer) {

            connection.mockRespond(new Response(new ResponseOptions({
                body: JSON.stringify(foundPlayer)
            })));

        } else {

            connection.mockError(new ErrorResponse(new ResponseOptions({
                body: 'Player not found',
                status: 404
            })));

        }

    }

    public list(connection: MockConnection) {

        let response = new Response(new ResponseOptions({
            body: JSON.stringify(this.playerDb.getPlayerList())
        }));

        connection.mockRespond(response);

    }

    public getPointLog(connection: MockConnection) {

        const id = parseInt(connection.request.url.match(/\/api\/player\/([0-9]+)\/pointlog/i)[1], 10);

        let response = new Response(new ResponseOptions({
            body: JSON.stringify(this.pointLogDb.get(id))
        }));

        connection.mockRespond(response);

    }

}
