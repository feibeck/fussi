import { TournamentRound } from './tournament-round.model';
import { JsonTournamentRound } from './json-tournament-round.model';

describe('TournamentRound', () => {

    it('fromJsonTournamentRound', () => {

        const fixture: JsonTournamentRound = {
            matches: [
                {
                    id: 1,
                    teamOneName: 'Han/Chewbakka',
                    teamTwoName: 'Luke/Obi-Wan',
                    played: true,
                    ready: true,
                    score: '0 / 2'
                }
            ]
        };

        const actual = TournamentRound.fromJsonTournamentRound(fixture);

        expect(actual.matches.length).toBe(1);

    });

});
