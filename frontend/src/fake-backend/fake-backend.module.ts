import { NgModule } from '@angular/core';
import { BaseRequestOptions, Http } from '@angular/http';
import { MockBackend } from '@angular/http/testing';
import { PlayerDb } from './player-db';
import { PlayerApi } from './player-api';
import { PointLogDb } from './point-log-db';
import { MatchDb } from './match-db';
import { MatchApi } from './match-api';
import { TournamentDb } from './tournament-db';
import { TournamentApi } from './tournament-api';
import { FakeBackendConfig } from './fake-backend-config';
import { FakeBackend } from './fake-backend';

@NgModule({
    bootstrap: [ ],
    declarations: [ ],
    imports: [
    ],
    exports: [ ],
    providers: [
        {
            provide: Http,
            deps: [FakeBackend],
            useFactory: (fakeBackend: FakeBackend) => {
                return fakeBackend.create();
            }
        },
        BaseRequestOptions,
        MockBackend,
        FakeBackendConfig,
        PlayerDb,
        PointLogDb,
        MatchDb,
        TournamentDb,
        MatchApi,
        PlayerApi,
        TournamentApi,
        FakeBackend
    ]
})
export class FakeBackendModule {
}
