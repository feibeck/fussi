import { Injectable } from '@angular/core';

@Injectable()
export class PlayerDb {

    private player = [
        {
            id: 1,
            name: 'Player 1',
            points: 1000,
            matchCount: 0
        },
        {
            id: 2,
            name: 'Player 2',
            points: 900,
            matchCount: 1
        },
        {
            id: 3,
            name: 'Player 3',
            points: 1100,
            matchCount: 1
        }
    ];

    public getPlayerList() {
        return this.player;
    }

    public getPlayer(id) {
        let foundPlayer = this.player.filter((currentPlayer) => {
            return currentPlayer.id === id;
        });
        if (foundPlayer.length > 0) {
            return foundPlayer[0];
        }
        return null;
    }

    public getPlayerByName(name) {
        let foundPlayer = this.player.filter((currentPlayer) => {
            return currentPlayer.name === name;
        });
        if (foundPlayer.length > 0) {
            return foundPlayer[0];
        }
        return null;
    }

    public getNextId() {
        let highestId = this.player.map((player) => {
            return player.id;
        }).reduce((prev, current) => {
            return prev > current ? prev : current;
        });
        return highestId + 1;
    }

    public save(player) {

        if (!player.id) {
            let newPlayer = {
                id: this.getNextId(),
                name: player.name,
                points: 0,
                matchCount: 0
            };
            this.player.push(newPlayer);
            return newPlayer;
        } else {
            let existingPlayer = this.getPlayer(player.id);
            if (!existingPlayer) {
                return false;
            }
            existingPlayer.name = player.name;
            return existingPlayer;
        }

    }

    public validate(player) {

        if (player.name === 'God') {
            return [
                {
                    field: 'name',
                    message: 'No one is allowed to be god.'
                }
            ];
        }

        if (this.getPlayerByName(player.name)) {
            return [
                {
                    field: 'name',
                    message: 'Name is already in use by another player.'
                }
            ];
        }

        return true;

    }

}
