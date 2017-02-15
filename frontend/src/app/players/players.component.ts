import { Component, OnInit } from '@angular/core';
import { PlayerService } from './player.service';
import { Player } from './player.model';

@Component({
    selector: 'players',
    templateUrl: './players.component.html'
})
export class PlayersComponent implements OnInit {

    public players: Player[] = [];

    public error: boolean = false;

    public errorMessage: string = '';

    constructor(private playerService: PlayerService) {
    }

    public ngOnInit() {
        this.playerService.getPlayerList().subscribe(
            (players: Player[]) => {
                this.players = players;
            },
            (message: string) => {
                this.error = true;
                this.errorMessage = message;
            }
        );
    }

}
