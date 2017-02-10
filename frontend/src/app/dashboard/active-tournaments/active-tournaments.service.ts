import { Injectable } from '@angular/core';
import { Http } from '@angular/http';
import { Observable } from 'rxjs';
import { Tournament } from '../../model/Tournament.model';

@Injectable()
export class ActiveTournamentsService {

    constructor(private http: Http) {
    }

    public getActiveTournaments(): Observable<Tournament[]> {
        return this.http
            .get('http://localhost:8080/api/tournaments')
            .map((response) => {
                return response.json();
            });
    }

}
