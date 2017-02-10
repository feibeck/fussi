import { Injectable } from '@angular/core';
import { AsyncSubject, Observable } from 'rxjs';
import { Player } from './player.model';
import { PointLog } from './point-log.model';
import { Http } from '@angular/http';

@Injectable()
export class PlayerService {

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
            });
    }

}
