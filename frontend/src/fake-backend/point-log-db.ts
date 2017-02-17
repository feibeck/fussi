import { Injectable } from '@angular/core';
import { JsonPointLog } from '../player/model/json-point-log.model';

@Injectable()
export class PointLogDb {

    private pointLog: JsonPointLog[] = [
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

    public get(_id: number) {
        return this.pointLog;
    }

}
