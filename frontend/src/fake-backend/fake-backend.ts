import { Injectable } from '@angular/core';
import { MockBackend, MockConnection } from '@angular/http/testing';
import { BaseRequestOptions, ResponseOptions, RequestMethod, Http } from '@angular/http';
import { PlayerApi } from './player-api';
import { MatchApi } from './match-api';
import { TournamentApi } from './tournament-api';
import { FakeBackendConfig } from './fake-backend-config';
import { ErrorResponse } from './error-response';

@Injectable()
export class FakeBackend {

    constructor(
        private backend: MockBackend,
        private options: BaseRequestOptions,
        private playerApi: PlayerApi,
        private matchApi: MatchApi,
        private tournamentApi: TournamentApi,
        private fakeBackendConfig: FakeBackendConfig
    ) {
    }

    public create() {

        this.backend.connections.subscribe((con: MockConnection) => {

            if (this.fakeBackendConfig.isAndReset('nextRequestError')) {
                return this.sendError(con);
            }

            // GET: /api/tournament?state=active
            if (con.request.url.match(/\/api\/tournament\?state=active$/i) && this.isGet(con)) {
                return this.tournamentApi.getActive(con);
            }

            // GET: /api/tournament
            if (con.request.url.match(/\/api\/tournament$/i) && this.isGet(con)) {
                return this.tournamentApi.list(con);
            }

            // GET: /api/matches
            if (con.request.url.match(/\/api\/matches$/i) && this.isGet(con)) {
                return this.matchApi.list(con);
            }

            // GET: /api/player/:id/pointlog
            if (con.request.url.match(/\/api\/player\/([0-9]+)\/pointlog$/i) && this.isGet(con)) {
                return this.playerApi.getPointLog(con);
            }

            // GET: /api/player/:id
            if (con.request.url.match(/\/api\/player\/([0-9]+)$/i) && this.isGet(con)) {
                return this.playerApi.get(con);
            }

            // GET, PUT, POST: /api/player
            if (con.request.url.match(/\/api\/player$/i)) {

                if (this.isGet(con)) {

                    return this.playerApi.list(con);

                } else if (this.isPut(con)) {

                    return this.playerApi.update(con);

                } else if (this.isPost(con)) {

                    return this.playerApi.create(con);

                }
            }

        });

        return new Http(this.backend, this.options);
    }

    public isPost(con) {
        return con.request.method === RequestMethod.Post;
    }

    public isGet(con) {
        return con.request.method === RequestMethod.Get;
    }

    public isPut(con) {
        return con.request.method === RequestMethod.Put;
    }

    public sendError(con: MockConnection) {
        con.mockError(new ErrorResponse(new ResponseOptions({
            body: 'Internal Server Error',
            status: 500
        })));
    }

}
