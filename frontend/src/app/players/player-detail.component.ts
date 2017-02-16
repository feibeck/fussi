import { OnInit, Component } from '@angular/core';
import { ActivatedRoute, Params, Router } from '@angular/router';
import { PlayerService } from './player.service';
import { Player } from './player.model';
import { PointLog } from './point-log.model';
import { PlayerLoadError } from './player-load-error.model';

@Component({
    selector: 'player-detail',
    templateUrl: './player-detail.component.html'
})
export class PlayerDetailComponent implements OnInit {

    public player: Player;

    public pointLog: PointLog[];

    constructor(
        private route: ActivatedRoute,
        private service: PlayerService,
        private router: Router
    ) {}

    public ngOnInit() {
        this.route.params
            .switchMap((params: Params) => {
                return this.service.getPlayer(+params['id']);
            })
            .subscribe(
                (player: Player) => {
                    this.player = player;
                },
                (error: PlayerLoadError) => {
                    if (error.isNotExistsError()) {
                        this.router.navigate(['/not-found'], { skipLocationChange: true });
                    } else {
                        this.router.navigate(['/error'], { skipLocationChange: true });
                    }
                }
            );

        this.route.params
            .switchMap((params: Params) => {
                return this.service.getPointLog(+params['id']);
            })
            .subscribe(
                (pointLog: PointLog[]) => {
                    this.pointLog = pointLog;
                }
            );
    }

    public playersChance(log: PointLog) {

        if (log.match.player1.id === this.player.id) {
            return log.chance1;
        } else {
            return log.chance2;
        }

    }

    public playersPoints(log: PointLog) {

        if (log.match.player1.id === this.player.id) {
            return log.newPoints1;
        } else {
            return log.newPoints2;
        }

    }

}
