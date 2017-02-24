import { Component, OnInit } from '@angular/core';
import { TournamentDetail } from '../model/tournament-detail.model';
import { TournamentService } from '../service/tournament.service';
import { Params, Router, ActivatedRoute } from '@angular/router';
import { LoadError } from '../../shared/model/load-error.model';

@Component({
    selector: 'tournament-view',
    templateUrl: './tournament-view.component.html'
})
export class TournamentViewComponent implements OnInit {

    public tournament: TournamentDetail;

    constructor(private tournamentService: TournamentService,
                private router: Router,
                private route: ActivatedRoute) {
    }

    public ngOnInit() {
        this.route.params
            .switchMap((params: Params) => {
                return this.tournamentService.getTournamentDetail(+params['id']);
            })
            .subscribe(
                (tournament: TournamentDetail) => {
                    this.tournament = tournament;
                },
                (error: LoadError) => {
                    if (error.isNotExistsError()) {
                        this.router.navigate(['/not-found'], { skipLocationChange: true });
                    } else {
                        this.router.navigate(['/error'], { skipLocationChange: true });
                    }
                }
            );
    }

}
