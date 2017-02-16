import { ReactiveFormsModule } from '@angular/forms';
import { HttpModule } from '@angular/http';
import { NgModule } from '@angular/core';
import { SharedModule } from '../shared';
import { RouterModule } from '@angular/router';
import { CommonModule } from '@angular/common';
import { PlayerListComponent } from './component/player-list.component';
import { PlayerDetailComponent } from './component/player-detail.component';
import { PlayerEditComponent } from './component/player-edit.component';
import { PlayerService } from './service/player.service';
import { PointLogService } from './service/point-log.service';

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
