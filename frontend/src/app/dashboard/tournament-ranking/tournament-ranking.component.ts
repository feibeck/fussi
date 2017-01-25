import {Component, Input} from '@angular/core';

@Component({
    selector: 'tournament-ranking',
    templateUrl: './tournament-ranking.component.html'
})
export class TournamentRankingComponent {

    @Input() tournament;

}
