import { NgModule } from '@angular/core';
import { CommonModule } from '@angular/common';
import { TournamentService } from './service/tournament.service';

@NgModule({
    bootstrap: [ ],
    declarations: [
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
