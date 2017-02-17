import { Injectable } from '@angular/core';
import { Http } from '@angular/http';
import { Observable } from 'rxjs';
import { JsonPointLog } from '../model/json-point-log.model';
import { LoadError } from '../../shared/model/load-error.model';
import { PointLog } from '../model/point-log.model';

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
                return Observable.throw(LoadError.createGeneralError());
            });
    }

}
