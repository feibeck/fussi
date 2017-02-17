import { Injectable } from '@angular/core';
import { Http } from '@angular/http';
import { Observable } from 'rxjs';
import { JsonTournament } from '../model/json-tournament.model';
import { Tournament } from '../model/tournament.model';

@Injectable()
export class TournamentService {

    constructor(private http: Http) {
    }

    public getActiveTournaments(): Observable<Tournament[]> {
        return this.http
            .get('http://localhost:8080/api/tournament?state=active')
            .map((response) => {
                return response.json();
            })
            .map((jsonTournaments: JsonTournament[]) => {
                return jsonTournaments.map((jsonTournament: JsonTournament) => {
                    return Tournament.fromJsonTournament(jsonTournament);
                });
            });
    }

}
