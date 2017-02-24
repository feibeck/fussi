import { TournamentDetail } from './tournament-detail.model';
import { JsonTournamentDetail } from './json-tournament-detail.model';
import { TournamentDetailTournament } from './tournament-detail-tournament.model';

describe('TournamentDetail', () => {

    describe('fromJsonTournamentDetail', () => {

        it('handles Tournaments', () => {

            const fixture: JsonTournamentDetail = {
                id: 3,
                name: 'Tournament 3',
                type: 'Tournament',
                active: true,
                ready: true,
                finished: false,
                winnerName: '',
                secondName: '',
                rounds: []
            };

            const actual = TournamentDetail.fromJsonTournamentDetail(fixture);

            expect(actual.id).toBe(3);
            expect(actual.name).toBe('Tournament 3');
            expect(actual.type).toBe('Tournament');
            expect(actual.active).toBeTruthy();
            expect(actual.tournamentDetail instanceof TournamentDetailTournament).toBeTruthy()

        });

        it('handles Leagues', () => {

            const fixture: JsonTournamentDetail = {
                id: 3,
                name: 'Tournament 3',
                type: 'League',
                active: true,
                ready: true
            };

            const actual = TournamentDetail.fromJsonTournamentDetail(fixture);

            expect(actual.id).toBe(3);
            expect(actual.name).toBe('Tournament 3');
            expect(actual.type).toBe('League');
            expect(actual.active).toBeTruthy();
            expect(actual.tournamentDetail).toBeUndefined();

        });

    });

});
