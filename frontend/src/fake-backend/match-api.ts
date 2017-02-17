import { Injectable } from '@angular/core';
import { MatchDb } from './match-db';
import { MockConnection } from '@angular/http/testing';
import { Response, ResponseOptions } from '@angular/http';

@Injectable()
export class MatchApi {

    constructor(private matchDb: MatchDb) {
    }

    public list(connection: MockConnection) {

        let response = new Response(new ResponseOptions({
            body: JSON.stringify(this.matchDb.list())
        }));

        connection.mockRespond(response);

    }
}
