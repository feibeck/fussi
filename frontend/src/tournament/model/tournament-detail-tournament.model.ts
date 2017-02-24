import { TournamentRound } from './tournament-round.model';
import { JsonTournamentDetail } from './json-tournament-detail.model';
import { JsonTournamentRound } from './json-tournament-round.model';

export class TournamentDetailTournament {

    public static fromJsonTournamentDetail(jsonTournamentDetail: JsonTournamentDetail): TournamentDetailTournament {

        const detail = new TournamentDetailTournament();

        detail.ready = jsonTournamentDetail.ready;
        detail.finished = jsonTournamentDetail.finished;
        detail.winnerName = jsonTournamentDetail.winnerName;
        detail.secondName = jsonTournamentDetail.secondName;

        detail.rounds = jsonTournamentDetail.rounds.map((jsonRound: JsonTournamentRound) => {
            return TournamentRound.fromJsonTournamentRound(jsonRound);
        });

        return detail;
    }

    public ready: boolean;
    public finished: boolean;
    public winnerName: string;
    public secondName: string;

    public rounds: TournamentRound[] = [];

}
