import { Component, OnInit } from '@angular/core';
import { PlayerService } from './player.service';
import { Player } from './player.model';
import { PlayerLoadError } from './player-load-error.model';

@Component({
    selector: 'players',
    templateUrl: './player-list.component.html'
})
export class PlayerListComponent implements OnInit {

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
            (playerLoadError: PlayerLoadError) => {
                this.error = true;
                this.errorMessage = playerLoadError.getMessage();
            }
        );
    }

}
