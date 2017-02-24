import { Injectable } from '@angular/core';
import { TournamentDb } from './tournament-db';
import { MockConnection } from '@angular/http/testing';
import { ResponseOptions, Response } from '@angular/http';
import { ErrorResponse } from './error-response';

@Injectable()
export class TournamentApi {

    constructor(private tournamentDb: TournamentDb) {
    }

    public getActive(connection: MockConnection) {

        let response = new Response(new ResponseOptions({
            body: JSON.stringify(this.tournamentDb.getActive())
        }));

        connection.mockRespond(response);

    }

    public list(connection: MockConnection) {

        let response = new Response(new ResponseOptions({
            body: JSON.stringify(this.tournamentDb.getAll())
        }));

        connection.mockRespond(response);

    }

    public get(connection: MockConnection) {

        const id = parseInt(connection.request.url.match(/\/([0-9]+)/i)[1], 10);
        const foundTournament = this.tournamentDb.get(id);

        if (foundTournament) {

            connection.mockRespond(new Response(new ResponseOptions({
                body: JSON.stringify(foundTournament)
            })));

        } else {

            connection.mockError(new ErrorResponse(new ResponseOptions({
                body: 'Tournament not found',
                status: 404
            })));

        }

    }
}
