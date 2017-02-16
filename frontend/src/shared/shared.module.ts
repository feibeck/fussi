import { NgModule } from '@angular/core';
import { CommonModule } from '@angular/common';
import { MatchPlayerComponent } from './match-player/match-player.component';
import { MatchResultComponent } from './match-result/match-result.component';

@NgModule({
    bootstrap: [ ],
    declarations: [
        MatchPlayerComponent,
        MatchResultComponent
    ],
    imports: [
        CommonModule
    ],
    exports: [
        MatchPlayerComponent,
        MatchResultComponent
    ],
    providers: [
    ]
})
export class SharedModule {
}
