import { Component, OnInit } from '@angular/core';
import { ActiveTournamentsService } from './active-tournaments.service';

@Component({
    selector: 'active-tournaments',
    templateUrl: './active-tournaments.component.html'
})
export class ActiveTournamentsComponent implements OnInit {

    public tournaments = [];

    constructor(private activeTournamentService: ActiveTournamentsService) {

    }

    public ngOnInit() {
        this.activeTournamentService.getActiveTournaments().subscribe(
            (tournaments) => {
                this.tournaments = tournaments;
            }
        );
    }

}
