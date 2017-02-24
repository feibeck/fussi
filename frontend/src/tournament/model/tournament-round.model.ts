import { TournamentPlannedMatch } from './tournament-planned-match.model';
import { JsonTournamentRound } from './json-tournament-round.model';
import { JsonTournamentPlannedMatch } from './json-tournament-planned-match.model';

export class TournamentRound {

    public static fromJsonTournamentRound(jsonRound: JsonTournamentRound): TournamentRound {
        const round = new TournamentRound();
        round.matches = jsonRound.matches.map((jsonMatch: JsonTournamentPlannedMatch) => {
            return TournamentPlannedMatch.fromJsonTournamentPlannedMatch(jsonMatch);
        });
        return round;
    }

    public matches: TournamentPlannedMatch[] = [];

}
