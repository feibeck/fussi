import { Injectable } from '@angular/core';
import { Http } from '@angular/http';
import { Observable } from 'rxjs';
import { JsonPointLog } from './json-point-log.model';
import { PlayerLoadError } from './player-load-error.model';
import { PointLog } from './point-log.model';

@Injectable()
export class PointLogService {

    constructor(private http: Http) {
    }

    public getPointLog(id: number): Observable<PointLog[]> {
        return this.http.get('http://localhost:8080/api/player/' + id + '/pointlog')
            .map((response) => {
                return response.json();
            })
            .map((jsonPointLogs: JsonPointLog[]) => {
                return jsonPointLogs.map((jsonPointLog: JsonPointLog) => {
                     return PointLog.fromJsonPointLog(jsonPointLog);
                });
            })
            .catch(() => {
                return Observable.throw(PlayerLoadError.createGeneralError(PlayerLoadError.pointlogLoadingError));
            });
    }

}