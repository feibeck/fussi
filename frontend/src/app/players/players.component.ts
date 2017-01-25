import {Component, OnInit} from '@angular/core';
import {PlayerService} from "./player.service";

@Component({
    selector: 'players',
    templateUrl: './players.component.html'
})
export class PlayersComponent implements OnInit {

    public players = [];

    constructor(private playerService: PlayerService) {

    }

    ngOnInit() {
        this.playerService.getPlayers().subscribe(players => this.players = players);
    }

}
