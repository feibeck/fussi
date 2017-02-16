import { ReactiveFormsModule } from '@angular/forms';
import { HttpModule } from '@angular/http';
import { PlayerService } from './player.service';
import { PointLogService } from './point-log.service';
import { PlayerListComponent } from './player-list.component';
import { PlayerDetailComponent } from './player-detail.component';
import { PlayerEditComponent } from './player-edit.component';
import { NgModule } from '@angular/core';
import { MatchPlayerComponent } from '../app/match-player/match-player.component';
import { MatchResultComponent } from '../app/match-result/match-result.component';
import { SharedModule } from '../shared';
import { RouterModule } from '@angular/router';
import { CommonModule } from '@angular/common';

@NgModule({
    bootstrap: [ ],
    declarations: [
        PlayerListComponent,
        PlayerDetailComponent,
        PlayerEditComponent
    ],
    imports: [
        ReactiveFormsModule,
        HttpModule,
        RouterModule,
        CommonModule,
        SharedModule
    ],
    exports: [
        PlayerListComponent,
        PlayerDetailComponent,
        PlayerEditComponent
    ],
    providers: [
        PlayerService,
        PointLogService
    ]
})
export class PlayerModule {
}
