import { Injectable } from '@angular/core';
import { AsyncSubject, Observable } from 'rxjs';
import { Player } from './player.model';
import { PointLog } from './point-log.model';
import { Http, Response } from '@angular/http';
import { PlayerSaveError } from './player-save-error.model';

@Injectable()
export class PlayerService {

    private static handleError (error: Response | any) {

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

    public getPlayers(): Observable<Player[]> {
        return this.http.get('http://localhost:8080/api/player')
            .map((response) => {
                return response.json();
            });
    }

    public getPlayer(id: number): Observable<Player> {
        return this.http.get('http://localhost:8080/api/player/' + id)
            .map((response) => {
                return response.json();
            });
    }

    public getPointLog(id: number): Observable<PointLog[]> {
        let subject = new AsyncSubject<any>();
        return this.http.get('http://localhost:8080/api/player/' + id + '/pointlog')
            .map((response) => {
                return response.json();
            });
    }

    public save(player: Player): Observable<Player> {
        return this.http.put('http://localhost:8080/api/player', player)
            .map((response) => {
                return response.json();
            })
            .catch(PlayerService.handleError);
    }

}
