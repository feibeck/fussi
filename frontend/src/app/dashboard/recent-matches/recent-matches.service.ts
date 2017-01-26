import { Injectable } from '@angular/core';
import { AsyncSubject, Observable } from 'rxjs';

@Injectable()
export class RecentMatchService {

    private mockMatches = [
        {
            type: 'single',
            date: '2016-01-13',
            player1: {
                name: 'Foo'
            },
            player2: {
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
        },
        {
            type: 'double',
            date: '2016-01-13',
            team1: {
                name: 'Foo'
            },
            team2: {
                name: 'Bar'
            },
            tournamentName: 'Tournament 2',
            isTeamOneWinner: false,
            isTeamTwoWinner: true,
            games: [
                {
                    goalsTeamOne: 10,
                    goalsTeamTwo: 1
                },
                {
                    goalsTeamOne: 0,
                    goalsTeamTwo: 10
                },
                {
                    goalsTeamOne: 10,
                    goalsTeamTwo: 5
                }
            ]
        },
    ];

    public getRecentMatches(): AsyncSubject<any> {

        let recentMatchSubject: AsyncSubject<any> = new AsyncSubject<any>();

        recentMatchSubject.next(this.mockMatches);
        recentMatchSubject.complete();

        return recentMatchSubject;

    }

}
