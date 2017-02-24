import { TournamentDetailTournament } from './tournament-detail-tournament.model';
import { JsonTournamentDetail } from './json-tournament-detail.model';

describe('TournamentDetailTournament', () => {

    describe('fromJsonTournamentDetail()', () => {

        it('works', () => {

            const fixture: JsonTournamentDetail = {
                id: 3,
                name: 'Tournament 3',
                type: 'Tournament',
                active: true,
                ready: true,
                finished: true,
                winnerName: 'C3PO',
                secondName: 'R2D2',
                rounds: []
            };

            const actual = TournamentDetailTournament.fromJsonTournamentDetail(fixture);

            expect(actual.ready).toBeTruthy();
            expect(actual.finished).toBeTruthy();
            expect(actual.winnerName).toBe('C3PO')
            expect(actual.secondName).toBe('R2D2');
            expect(actual.rounds.length).toBe(0);

        });

    });

});
