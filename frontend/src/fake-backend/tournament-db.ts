import { Injectable } from '@angular/core';

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
            active: true
        }
    ];

    public getActive() {
        return this.tournaments.filter((tournament) => { return tournament.active; });
    }

    public getAll() {
        return this.tournaments;
    }

}
