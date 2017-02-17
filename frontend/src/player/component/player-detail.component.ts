import { OnInit, Component } from '@angular/core';
import { ActivatedRoute, Params, Router } from '@angular/router';
import { PlayerService } from '../service/player.service';
import { Player } from '../model/player.model';
import { LoadError } from '../../shared/model/load-error.model';
import { PointLogService } from '../service/point-log.service';
import { PointLog } from '../model/point-log.model';

@Component({
    selector: 'player-detail',
    templateUrl: './player-detail.component.html'
})
export class PlayerDetailComponent implements OnInit {

    public player: Player;

    public pointLog: PointLog[];

    constructor(
        private route: ActivatedRoute,
        private router: Router,
        private playerService: PlayerService,
        private pointLogService: PointLogService
    ) {}

    public ngOnInit() {
        this.route.params
            .switchMap((params: Params) => {
                return this.playerService.getPlayer(+params['id']);
            })
            .subscribe(
                (player: Player) => {
                    this.player = player;
                },
                (error: LoadError) => {
                    if (error.isNotExistsError()) {
                        this.router.navigate(['/not-found'], { skipLocationChange: true });
                    } else {
                        this.router.navigate(['/error'], { skipLocationChange: true });
                    }
                }
            );

        this.route.params
            .switchMap((params: Params) => {
                return this.pointLogService.getPointLog(+params['id']);
            })
            .subscribe(
                (pointLog: PointLog[]) => {
                    this.pointLog = pointLog;
                },
                () => {
                    console.log('Error loading Point Log');
                }
            );
    }

}
