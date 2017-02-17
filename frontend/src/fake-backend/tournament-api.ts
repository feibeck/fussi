import { Injectable } from '@angular/core';
import { TournamentDb } from './tournament-db';
import { MockConnection } from '@angular/http/testing';
import { ResponseOptions, Response } from '@angular/http';

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

}
