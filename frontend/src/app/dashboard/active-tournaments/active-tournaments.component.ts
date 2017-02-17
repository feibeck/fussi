import { Component, OnInit } from '@angular/core';
import { TournamentService } from '../../../tournament/service/tournament.service';
import { Tournament } from '../../../tournament/model/tournament.model';

@Component({
    selector: 'active-tournaments',
    templateUrl: './active-tournaments.component.html'
})
export class ActiveTournamentsComponent implements OnInit {

    public tournaments: Tournament[] = [];

    public error: boolean = false;

    constructor(private tournamentService: TournamentService) {
    }

    public ngOnInit() {
        this.tournamentService.getActiveTournaments().subscribe(
            (tournaments: Tournament[]) => {
                this.tournaments = tournaments;
            },
            () => {
                this.error = true;
            }
        );
    }

}
