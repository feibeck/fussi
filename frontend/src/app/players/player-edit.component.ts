import { Component, OnInit } from '@angular/core';
import { ActivatedRoute, Params } from '@angular/router';
import { PlayerService } from './player.service';
import { Player } from './player.model';

import 'rxjs/add/operator/switchMap';

@Component({
    selector: 'player-edit',
    templateUrl: './player-edit.component.html'
})
export class PlayerEditComponent implements OnInit {

    public player: Player;

    constructor(
        private playerService: PlayerService,
        private route: ActivatedRoute
    ) {
    }

    public ngOnInit(): void {
        this.route.params
            .switchMap((params: Params) => this.playerService.getPlayer(+params['id']))
            .subscribe((player) => this.player = player);
    }

}