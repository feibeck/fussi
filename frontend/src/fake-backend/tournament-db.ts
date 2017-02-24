import { Injectable } from '@angular/core';
import { JsonTournament } from '../tournament/model/json-tournament.model';

@Injectable()
export class TournamentDb {

    private tournaments = [
        {
            id: 1,
            name: 'Tournament 1',
            type: 'League',
            active: true
        },
        {
            id: 2,
            name: 'Tournament 2',
            type: 'League',
            active: false
        },
        {
            id: 3,
            name: 'Tournament 3',
            type: 'Tournament',
            active: true,
            ready: true,
            finished: false,
            winnerName: '',
            secondName: '',
            rounds: [
                {
                    matches: [
                        {
                            id: 1,
                            teamOneName: 'Flo/Hans',
                            teamTwoName: 'Peter/Stefan',
                            played: true,
                            ready: true,
                            score: '2 / 0'
                        },
                        {
                            id: 2,
                            teamOneName: 'Michael/Sebastian',
                            teamTwoName: 'Simon/Jürgen',
                            played: false,
                            ready: true,
                            score: ''
                        }
                    ]
                },
                {
                    matches: [
                        {
                            id: 3,
                            teamOneName: 'Flo/Hans',
                            teamTwoName: '',
                            played: false,
                            ready: false,
                            score: ''
                        }
                    ]
                },
            ]
        }
    ];

    public getActive() {
        return this.tournaments
            .filter((tournament) => { return tournament.active; })
            .map(this.toJsonTournament);
    }

    public getAll() {
        return this.tournaments.map(this.toJsonTournament);
    }

    public toJsonTournament(tournament): JsonTournament
    {
        return {
            id: tournament.id,
            name: tournament.name,
            type: tournament.type,
            active: tournament.active
        };
    }

    public get(id: number) {
        const foundTournaments = this.tournaments.filter((tournament) => {
            return tournament.id === id;
        });

        if (foundTournaments) {
            return foundTournaments[0];
        }

        return null;
    }

}
