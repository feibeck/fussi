import { Injectable } from '@angular/core';
import { Http, Response } from '@angular/http';
import { Observable } from 'rxjs';
import { JsonPlayer } from '../model/json-player.model';
import { PlayerSaveError } from '../model/player-save-error.model';
import { Player } from '../model/player.model';
import { PlayerLoadError } from '../model/player-load-error.model';

@Injectable()
export class PlayerService {

    private static handleError(error: Response | any) {

        let playerSaveError: PlayerSaveError;

        if (error instanceof Response && error.status === 422) {
            playerSaveError = new PlayerSaveError('Validation error', true);
            let validationMessages = error.json();
            playerSaveError.setValidationMessages(validationMessages.errors);
        } else {
            playerSaveError = new PlayerSaveError();
        }

        return Observable.throw(playerSaveError);
    }

    constructor(private http: Http) {
    }

    public getPlayerList(): Observable<Player[]> {
        return this.http.get('http://localhost:8080/api/player')
            .map((response) => {
                return response.json();
            })
            .map((jsonPlayerList: JsonPlayer[]) => {
                const playerList: Player[] = [];
                for (let jsonPlayer of jsonPlayerList) {
                    playerList.push(Player.fromJsonPlayer(jsonPlayer));
                }
                return playerList;
            })
            .catch(() => {
                return Observable.throw(PlayerLoadError.createGeneralError(PlayerLoadError.listLoadingError));
            });
    }

    public getPlayer(id: number): Observable<Player> {
        return this.http.get('http://localhost:8080/api/player/' + id)
            .map((response) => {
                return response.json();
            })
            .map((jsonPlayer: JsonPlayer) => {
                return Player.fromJsonPlayer(jsonPlayer);
            })
            .catch((error: Response | any) => {
                if (error instanceof Response && error.status === 404) {
                    return Observable.throw(PlayerLoadError.createNotExistsError());
                } else {
                    return Observable.throw(PlayerLoadError.createGeneralError(PlayerLoadError.playerLoadingError));
                }
            });
    }

    public save(player: Player): Observable<Player> {
        return player.id ? this.update(player) : this.create(player);
    }

    public update(player: Player): Observable<Player> {
        return this.http.put('http://localhost:8080/api/player', player.toJsonPlayer())
            .map((response) => {
                return response.json();
            })
            .map((jsonPlayer: JsonPlayer) => {
                return Player.fromJsonPlayer(jsonPlayer);
            })
            .catch(PlayerService.handleError);
    }

    public create(player: Player): Observable<Player> {
        return this.http.post('http://localhost:8080/api/player', player.toJsonPlayer())
            .map((response) => {
                return response.json();
            })
            .map((jsonPlayer: JsonPlayer) => {
                return Player.fromJsonPlayer(jsonPlayer);
            })
            .catch(PlayerService.handleError);
    }

}
