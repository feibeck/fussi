import { Injectable } from '@angular/core';
import { Http } from '@angular/http';
import { Observable } from 'rxjs';
import { Match } from '../../model/Match.model';

@Injectable()
export class RecentMatchService {

    constructor(private http: Http) {
    }

    public getRecentMatches(): Observable<Match[]> {
        return this.http.get('http://localhost:8080/api/matches')
            .map((response) => {
                return response.json();
            });
    }

}
