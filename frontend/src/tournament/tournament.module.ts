import { NgModule } from '@angular/core';
import { CommonModule } from '@angular/common';
import { TournamentService } from './service/tournament.service';
import { TournamentListComponent } from './component/tournament-list.component';

@NgModule({
    bootstrap: [ ],
    declarations: [
        TournamentListComponent
    ],
    imports: [
        CommonModule
    ],
    exports: [
    ],
    providers: [
        TournamentService
    ]
})
export class TournamentModule {
}
