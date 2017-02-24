import { JsonTournamentPlannedMatch } from './json-tournament-planned-match.model';
import { TournamentPlannedMatch } from './tournament-planned-match.model';

describe('TournamentPlannedMatch', () => {

    it('fromJsonTournamentPlannedMatch()', () => {

        const json: JsonTournamentPlannedMatch = {
            id: 3,
            teamOneName: 'Foo',
            teamTwoName: 'Bar',
            played: true,
            ready: true,
            score: '2/1'
        };

        const model = TournamentPlannedMatch.fromJsonTournamentPlannedMatch(json);

        expect(model.id).toBe(3);
        expect(model.teamOneName).toBe('Foo');
        expect(model.teamTwoName).toBe('Bar');
        expect(model.played).toBeTruthy();
        expect(model.ready).toBeTruthy();
        expect(model.score).toBe('2/1');

    });

});
