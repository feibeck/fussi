import { Injectable } from '@angular/core';
import { AsyncSubject, Observable } from 'rxjs';

@Injectable()
export class ActiveTournamentsService {

    public mockTournaments = [
        {
            name: 'Tournament 1'
        },
        {
            name: 'Tournament 2'
        }
    ];

    public getActiveTournaments(): AsyncSubject<any> {

        let recentMatchSubject: AsyncSubject<any> = new AsyncSubject<any>();

        recentMatchSubject.next(this.mockTournaments);
        recentMatchSubject.complete();

        return recentMatchSubject;

    }

}
