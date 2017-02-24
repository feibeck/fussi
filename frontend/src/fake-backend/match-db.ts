import { Injectable } from '@angular/core';

@Injectable()
export class MatchDb {

    private latestMatches = [
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
            tournamentId: 1,
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
            tournamentId: 2,
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

    public list() {
        return this.latestMatches;
    }

}
