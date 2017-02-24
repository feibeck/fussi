import { NgModule } from '@angular/core';
import { CommonModule } from '@angular/common';
import { TournamentService } from './service/tournament.service';
import { TournamentListComponent } from './component/tournament-list.component';
import { TournamentTypeTournamentComponent } from './component/tournament-type-tournament.component';
import { TournamentViewComponent } from './component/tournament-view.component';
import { RouterModule } from '@angular/router';

@NgModule({
    bootstrap: [ ],
    declarations: [
        TournamentListComponent,
        TournamentViewComponent,
        TournamentTypeTournamentComponent
    ],
    imports: [
        CommonModule,
        RouterModule
    ],
    exports: [
    ],
    providers: [
        TournamentService
    ]
})
export class TournamentModule {
}
