import { Component, OnInit } from '@angular/core';
import { PlayerService } from './player.service';
import { Player } from './player.model';

@Component({
    selector: 'players',
    templateUrl: './players.component.html'
})
export class PlayersComponent implements OnInit {

    public players: Player[] = [];

    constructor(private playerService: PlayerService) {
    }

    public ngOnInit() {
        this.playerService.getPlayers().subscribe(
            (players: Player[]) => {
                this.players = players;
            }
        );
    }

}
