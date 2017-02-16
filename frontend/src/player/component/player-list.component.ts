import { Component, OnInit } from '@angular/core';
import { PlayerService } from '../service/player.service';
import { Player } from '../model/player.model';
import { PlayerLoadError } from '../model/player-load-error.model';

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
