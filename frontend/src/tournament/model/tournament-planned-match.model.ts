import { JsonTournamentPlannedMatch } from './json-tournament-planned-match.model';

export class TournamentPlannedMatch {

    public static fromJsonTournamentPlannedMatch(jsonMatch: JsonTournamentPlannedMatch): TournamentPlannedMatch {
        const match = new TournamentPlannedMatch();
        match.id = jsonMatch.id;
        match.teamOneName = jsonMatch.teamOneName;
        match.teamTwoName = jsonMatch.teamTwoName;
        match.played = jsonMatch.played;
        match.ready = jsonMatch.ready;
        match.score = jsonMatch.score;
        return match;
    }

    public id: number = null;
    public teamOneName: string = '';
    public teamTwoName: string = '';
    public played: boolean = false;
    public ready: boolean = false;
    public score: string = '';

}
