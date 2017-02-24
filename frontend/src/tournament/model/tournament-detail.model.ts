import { Tournament } from './tournament.model';
import { JsonTournamentDetail } from './json-tournament-detail.model';
import { TournamentDetailTournament } from './tournament-detail-tournament.model';

export class TournamentDetail extends Tournament {

    public static fromJsonTournamentDetail(jsonTournamentDetail: JsonTournamentDetail): TournamentDetail {

        const detail = new TournamentDetail(
            jsonTournamentDetail.id,
            jsonTournamentDetail.name,
            jsonTournamentDetail.type,
            jsonTournamentDetail.active
        );

        if (detail.type === 'Tournament') {
            detail.tournamentDetail = TournamentDetailTournament.fromJsonTournamentDetail(jsonTournamentDetail);
        }

        return detail;
    }

    public tournamentDetail: TournamentDetailTournament;

}
