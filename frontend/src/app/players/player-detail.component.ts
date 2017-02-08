import { OnInit, Component } from '@angular/core';
import { ActivatedRoute, Params } from '@angular/router';
import { PlayerService } from './player.service';
import { Player } from './player.model';
import { PointLog } from './point-log.model';

@Component({
    selector: 'player-detail',
    templateUrl: './player-detail.component.html'
})
export class PlayerDetailComponent implements OnInit {

    public player: Player;

    public pointLog: PointLog[];

    constructor(
        private route: ActivatedRoute,
        private service: PlayerService
    ) {}

    public ngOnInit() {
        this.route.params
            .switchMap((params: Params) => this.service.getPlayer(+params['id']))
            .subscribe((player: Player) => this.player = player);

        this.route.params
            .switchMap((params: Params) => this.service.getPointLog(+params['id']))
            .subscribe((pointLog: PointLog[]) => this.pointLog = pointLog);
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
