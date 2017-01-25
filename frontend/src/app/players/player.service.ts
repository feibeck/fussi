import { Injectable } from '@angular/core';
import {AsyncSubject, Observable} from 'rxjs';

@Injectable()
export class PlayerService {

    public mockPlayers = [
        {
            name: 'Player 1',
            points: 1000,
            matchCount: 1
        },
        {
            name: 'Player 2',
            points: 1000,
            matchCount: 1
        }
    ];

    public getPlayers(): AsyncSubject<any> {

        let recentMatchSubject: AsyncSubject<any> = new AsyncSubject<any>();

        recentMatchSubject.next(this.mockPlayers);
        recentMatchSubject.complete();

        return recentMatchSubject;

    }

}
