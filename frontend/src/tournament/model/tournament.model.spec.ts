import { JsonTournament } from './json-tournament.model';
import { Tournament } from './tournament.model';

describe('Tournament', () => {

    it('fromJsonTournament', () => {

        const jsonTournament: JsonTournament = {
            id: 1,
            name: 'Foo',
            active: true,
            type: 'League'
        };

        const tournament = Tournament.fromJsonTournament(jsonTournament);

        expect(tournament.id).toBe(1);
        expect(tournament.name).toBe('Foo');
        expect(tournament.active).toBeTruthy();
        expect(tournament.type).toBe('League');

    });

});
