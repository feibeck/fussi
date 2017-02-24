import { JsonTournamentRound } from './json-tournament-round.model';

export interface JsonTournamentDetail {
    id: number;
    name: string;
    type: string;
    active: boolean;
    ready: boolean;
    finished?: boolean;
    winnerName?: string;
    secondName?: string;
    rounds?: JsonTournamentRound[];
}
