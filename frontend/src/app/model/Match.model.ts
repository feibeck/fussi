export interface Match {
    type: 'single'|'double';
    date: string;
    player1: Player;
    player2: Player;
    tournamentName: string;
    isTeamOneWinner: boolean;
    isTeamTwoWinner: boolean;
    games: Game[];
}
