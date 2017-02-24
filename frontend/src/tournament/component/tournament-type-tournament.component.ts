import { Component, Input } from '@angular/core';

@Component({
    selector: 'tournament-type-tournament',
    templateUrl: './tournament-type-tournament.component.html'
})
export class TournamentTypeTournamentComponent {

    @Input() public tournament;

}
