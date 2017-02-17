import { Component, OnInit } from '@angular/core';
import { TournamentService } from '../service/tournament.service';
import { Tournament } from '../model/tournament.model';

@Component({
    selector: 'tournament-list',
    templateUrl: './tournament-list.component.html'
})
export class TournamentListComponent implements OnInit {

    public tournaments: Tournament[] = [];

    public error: boolean = false;

    constructor(private tournamentService: TournamentService) {
    }

    public ngOnInit(): void {
        this.tournamentService.getTournaments().subscribe(
            (tournaments: Tournament[]) => {
                this.tournaments = tournaments;
            },
            () => {
                this.error = true;
            }
        );
    }
}
