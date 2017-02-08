import { Injectable } from '@angular/core';
import { AsyncSubject, Observable } from 'rxjs';
import { Player } from './player.model';
import { PointLog } from './point-log.model';

@Injectable()
export class PlayerService {

    public mockPlayers: Player[] = [
        {
            id: 1,
            name: 'Player 1',
            points: 1000,
            matchCount: 1
        },
        {
            id: 2,
            name: 'Player 2',
            points: 1000,
            matchCount: 1
        }
    ];

    public getPlayers(): AsyncSubject<Player[]> {
        let recentMatchSubject: AsyncSubject<Player[]> = new AsyncSubject<Player[]>();
        recentMatchSubject.next(this.mockPlayers);
        recentMatchSubject.complete();
        return recentMatchSubject;
    }

    public getPlayer(id: number): AsyncSubject<Player> {
        let recentMatchSubject: AsyncSubject<Player> = new AsyncSubject<Player>();
        recentMatchSubject.next(this.mockPlayers[0]);
        recentMatchSubject.complete();
        return recentMatchSubject;
    }

    public getPointLog(id: number): Observable<PointLog[]> {

        const pointLog: PointLog[] = [
            {
                currentPoints1: 1000,
                currentPoints2: 1000,
                newPoints1: 1010,
                newPoints2: 990,
                chance1: 1,
                chance2: 1,
                match: {
                    type: 'single',
                    date: '2016-01-13',
                    player1: {
                        id: 1,
                        name: 'Foo'
                    },
                    player2: {
                        id: 2,
                        name: 'Bar'
                    },
                    tournamentName: 'Tournament 1',
                    isTeamOneWinner: true,
                    isTeamTwoWinner: false,
                    games: [
                        {
                            goalsTeamOne: 4,
                            goalsTeamTwo: 10
                        },
                        {
                            goalsTeamOne: 3,
                            goalsTeamTwo: 10
                        }
                    ]
                }
            },
            {
                currentPoints1: 1000,
                currentPoints2: 1000,
                newPoints1: 1010,
                newPoints2: 990,
                chance1: 1,
                chance2: 1,
                match: {
                    type: 'single',
                    date: '2016-01-13',
                    player1: {
                        id: 1,
                        name: 'Foo'
                    },
                    player2: {
                        id: 2,
                        name: 'Bar'
                    },
                    tournamentName: 'Tournament 1',
                    isTeamOneWinner: true,
                    isTeamTwoWinner: false,
                    games: [
                        {
                            goalsTeamOne: 4,
                            goalsTeamTwo: 10
                        },
                        {
                            goalsTeamOne: 3,
                            goalsTeamTwo: 10
                        }
                    ]
                }
            }
        ];

        let subject: AsyncSubject<PointLog[]> = new AsyncSubject<PointLog[]>();
        subject.next(pointLog);
        subject.complete();
        return subject;
    }

}
