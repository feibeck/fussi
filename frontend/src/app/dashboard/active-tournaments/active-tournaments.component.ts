import { Component, OnInit } from '@angular/core';
import { TournamentService } from '../../../tournament/service/tournament.service';

@Component({
    selector: 'active-tournaments',
    templateUrl: './active-tournaments.component.html'
})
export class ActiveTournamentsComponent implements OnInit {

    public tournaments = [];

    constructor(private tournamentService: TournamentService) {

    }

    public ngOnInit() {
        this.tournamentService.getActiveTournaments().subscribe(
            (tournaments) => {
                this.tournaments = tournaments;
            }
        );
    }

}
