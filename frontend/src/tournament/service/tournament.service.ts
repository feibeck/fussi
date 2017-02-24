import { Injectable } from '@angular/core';
import { Http, URLSearchParams, RequestOptionsArgs } from '@angular/http';
import { Observable } from 'rxjs';
import { JsonTournament } from '../model/json-tournament.model';
import { Tournament } from '../model/tournament.model';
import { LoadError } from '../../shared/model/load-error.model';
import { TournamentDetail } from '../model/tournament-detail.model';
import { TournamentDetailTournament } from '../model/tournament-detail-tournament.model';
import { TournamentRound } from '../model/tournament-round.model';
import { TournamentPlannedMatch } from '../model/tournament-planned-match.model';
import { JsonTournamentDetail } from '../model/json-tournament-detail.model';

@Injectable()
export class TournamentService {

    constructor(private http: Http) {
    }

    public getActiveTournaments(): Observable<Tournament[]> {
        let params = new URLSearchParams();
        params.set('state', 'active');
        return this.getTournaments(params);
    }

    public getTournaments(searchParams?: URLSearchParams): Observable<Tournament[]> {

        let options: RequestOptionsArgs = {};
        if (searchParams) {
            options.search = searchParams;
        }

        return this.http
            .get('http://localhost:8080/api/tournament', options)
            .map((response) => {
                return response.json();
            })
            .map((jsonTournaments: JsonTournament[]) => {
                return jsonTournaments.map((jsonTournament: JsonTournament) => {
                    return Tournament.fromJsonTournament(jsonTournament);
                });
            })
            .catch(() => {
                return Observable.throw(LoadError.createGeneralError());
            });
    }

    public getTournamentDetail(id: number): Observable<TournamentDetail> {
        return this.http
            .get('http://localhost:8080/api/tournament/' + id)
            .map((response) => {
                return response.json();
            })
            .map((jsonTournamentDetail: JsonTournamentDetail) => {
                return TournamentDetail.fromJsonTournamentDetail(jsonTournamentDetail);
            })
            .catch(() => {
                return Observable.throw(LoadError.createGeneralError());
            });
    }

}
