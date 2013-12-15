<?php
/**
 * Definition of Version20131215163150
 *
 * @copyright Copyright (c) 2013 The Fußi-Team
 * @license   THE BEER-WARE LICENSE (Revision 42)
 *
 * "THE BEER-WARE LICENSE" (Revision 42):
 * The Fußi-Team wrote this software. As long as you retain this notice you
 * can do whatever you want with this stuff. If we meet some day, and you think
 * this stuff is worth it, you can buy us a beer in return.
 */

namespace DoctrineORMModule\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

class Version20131215163150 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != "sqlite", "Migration can only be executed safely on 'sqlite'.");

        $this->addSql("CREATE TABLE pointlog (id INTEGER NOT NULL, match_id INTEGER DEFAULT NULL, currentPoints1 INTEGER NOT NULL, currentPoints2 INTEGER NOT NULL, newPoints1 INTEGER NOT NULL, newPoints2 INTEGER NOT NULL, chance1 INTEGER NOT NULL, chance2 INTEGER NOT NULL, PRIMARY KEY(id))");
        $this->addSql("CREATE INDEX IDX_295663572ABEACD6 ON pointlog (match_id)");
        $this->addSql("CREATE TABLE pointlogplayer (id INTEGER NOT NULL, player_id INTEGER DEFAULT NULL, pointlog_id INTEGER DEFAULT NULL, pointsBefore INTEGER NOT NULL, pointsAfter INTEGER NOT NULL, PRIMARY KEY(id))");
        $this->addSql("CREATE INDEX IDX_8EFA62A699E6F5DF ON pointlogplayer (player_id)");
        $this->addSql("CREATE INDEX IDX_8EFA62A6C36A3189 ON pointlogplayer (pointlog_id)");
        $this->addSql("DROP INDEX IDX_BD5FB8D9FF961BCC");
        $this->addSql("DROP INDEX IDX_BD5FB8D95DFCD4B8");
        $this->addSql("CREATE TEMPORARY TABLE __temp__tournament AS SELECT id, winner_id, second_id, name, teamType, gamesPerMatch, matchMode, maxScore, start, \"end\", discr FROM tournament");
        $this->addSql("DROP TABLE tournament");
        $this->addSql("CREATE TABLE tournament (id INTEGER NOT NULL, winner_id INTEGER DEFAULT NULL, second_id INTEGER DEFAULT NULL, name VARCHAR(150) NOT NULL, teamType INTEGER NOT NULL, gamesPerMatch INTEGER NOT NULL, matchMode INTEGER NOT NULL, maxScore INTEGER NOT NULL, start DATE DEFAULT NULL, \"end\" DATE DEFAULT NULL, discr VARCHAR(255) NOT NULL, PRIMARY KEY(id), CONSTRAINT FK_BD5FB8D95DFCD4B8 FOREIGN KEY (winner_id) REFERENCES team (id) NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_BD5FB8D9FF961BCC FOREIGN KEY (second_id) REFERENCES team (id) NOT DEFERRABLE INITIALLY IMMEDIATE)");
        $this->addSql("INSERT INTO tournament (id, winner_id, second_id, name, teamType, gamesPerMatch, matchMode, maxScore, start, \"end\", discr) SELECT id, winner_id, second_id, name, teamType, gamesPerMatch, matchMode, maxScore, start, \"end\", discr FROM __temp__tournament");
        $this->addSql("DROP TABLE __temp__tournament");
        $this->addSql("CREATE INDEX IDX_BD5FB8D9FF961BCC ON tournament (second_id)");
        $this->addSql("CREATE INDEX IDX_BD5FB8D95DFCD4B8 ON tournament (winner_id)");
        $this->addSql("DROP INDEX IDX_4D41B8AC99E6F5DF");
        $this->addSql("DROP INDEX IDX_4D41B8AC33D1A3E7");
        $this->addSql("CREATE TEMPORARY TABLE __temp__tournament_players AS SELECT tournament_id, player_id FROM tournament_players");
        $this->addSql("DROP TABLE tournament_players");
        $this->addSql("CREATE TABLE tournament_players (tournament_id INTEGER NOT NULL, player_id INTEGER NOT NULL, PRIMARY KEY(tournament_id, player_id), CONSTRAINT FK_4D41B8AC33D1A3E7 FOREIGN KEY (tournament_id) REFERENCES tournament (id) NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_4D41B8AC99E6F5DF FOREIGN KEY (player_id) REFERENCES player (id) NOT DEFERRABLE INITIALLY IMMEDIATE)");
        $this->addSql("INSERT INTO tournament_players (tournament_id, player_id) SELECT tournament_id, player_id FROM __temp__tournament_players");
        $this->addSql("DROP TABLE __temp__tournament_players");
        $this->addSql("CREATE INDEX IDX_4D41B8AC99E6F5DF ON tournament_players (player_id)");
        $this->addSql("CREATE INDEX IDX_4D41B8AC33D1A3E7 ON tournament_players (tournament_id)");
        $this->addSql("DROP INDEX IDX_7A5BC505EA525D5A");
        $this->addSql("DROP INDEX IDX_7A5BC505DBBA47C7");
        $this->addSql("DROP INDEX IDX_7A5BC505D22CABCD");
        $this->addSql("DROP INDEX IDX_7A5BC505C0990423");
        $this->addSql("DROP INDEX IDX_7A5BC505AB7F249A");
        $this->addSql("DROP INDEX IDX_7A5BC50533D1A3E7");
        $this->addSql("DROP INDEX IDX_7A5BC50525F02379");
        $this->addSql("CREATE TEMPORARY TABLE __temp__match AS SELECT id, player1_id, player2_id, date, tournament_id, team1attack, team1defence, team2attack, team2defence, discr FROM \"match\"");
        $this->addSql("DROP TABLE \"match\"");
        $this->addSql("CREATE TABLE \"match\" (id INTEGER NOT NULL, tournament_id INTEGER DEFAULT NULL, player1_id INTEGER DEFAULT NULL, player2_id INTEGER DEFAULT NULL, team1attack INTEGER DEFAULT NULL, team1defence INTEGER DEFAULT NULL, team2attack INTEGER DEFAULT NULL, team2defence INTEGER DEFAULT NULL, date DATETIME NOT NULL, discr VARCHAR(255) NOT NULL, PRIMARY KEY(id), CONSTRAINT FK_7A5BC50533D1A3E7 FOREIGN KEY (tournament_id) REFERENCES tournament (id) NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_7A5BC505C0990423 FOREIGN KEY (player1_id) REFERENCES player (id) NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_7A5BC505D22CABCD FOREIGN KEY (player2_id) REFERENCES player (id) NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_7A5BC505EA525D5A FOREIGN KEY (team1attack) REFERENCES player (id) NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_7A5BC505AB7F249A FOREIGN KEY (team1defence) REFERENCES player (id) NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_7A5BC505DBBA47C7 FOREIGN KEY (team2attack) REFERENCES player (id) NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_7A5BC50525F02379 FOREIGN KEY (team2defence) REFERENCES player (id) NOT DEFERRABLE INITIALLY IMMEDIATE)");
        $this->addSql("INSERT INTO \"match\" (id, player1_id, player2_id, date, tournament_id, team1attack, team1defence, team2attack, team2defence, discr) SELECT id, player1_id, player2_id, date, tournament_id, team1attack, team1defence, team2attack, team2defence, discr FROM __temp__match");
        $this->addSql("DROP TABLE __temp__match");
        $this->addSql("CREATE INDEX IDX_7A5BC505EA525D5A ON match (team1attack)");
        $this->addSql("CREATE INDEX IDX_7A5BC505DBBA47C7 ON match (team2attack)");
        $this->addSql("CREATE INDEX IDX_7A5BC505D22CABCD ON match (player2_id)");
        $this->addSql("CREATE INDEX IDX_7A5BC505C0990423 ON match (player1_id)");
        $this->addSql("CREATE INDEX IDX_7A5BC505AB7F249A ON match (team1defence)");
        $this->addSql("CREATE INDEX IDX_7A5BC50533D1A3E7 ON match (tournament_id)");
        $this->addSql("CREATE INDEX IDX_7A5BC50525F02379 ON match (team2defence)");
        $this->addSql("DROP INDEX IDX_232B318C2ABEACD6");
        $this->addSql("CREATE TEMPORARY TABLE __temp__game AS SELECT id, match_id, goalsTeamOne, goalsTeamTwo FROM game");
        $this->addSql("DROP TABLE game");
        $this->addSql("CREATE TABLE game (id INTEGER NOT NULL, match_id INTEGER DEFAULT NULL, goalsTeamOne INTEGER NOT NULL, goalsTeamTwo INTEGER NOT NULL, PRIMARY KEY(id), CONSTRAINT FK_232B318C2ABEACD6 FOREIGN KEY (match_id) REFERENCES \"match\" (id) NOT DEFERRABLE INITIALLY IMMEDIATE)");
        $this->addSql("INSERT INTO game (id, match_id, goalsTeamOne, goalsTeamTwo) SELECT id, match_id, goalsTeamOne, goalsTeamTwo FROM __temp__game");
        $this->addSql("DROP TABLE __temp__game");
        $this->addSql("CREATE INDEX IDX_232B318C2ABEACD6 ON game (match_id)");
        $this->addSql("DROP INDEX IDX_9C26D883F59E604A");
        $this->addSql("DROP INDEX IDX_9C26D883E72BCFA4");
        $this->addSql("DROP INDEX IDX_9C26D883A6005CA0");
        $this->addSql("DROP INDEX IDX_9C26D883444177BB");
        $this->addSql("DROP INDEX IDX_9C26D88333D1A3E7");
        $this->addSql("DROP INDEX IDX_9C26D8832ABEACD6");
        $this->addSql("CREATE TEMPORARY TABLE __temp__plannedmatch AS SELECT id, tournament_id, round_id, team1_id, team2_id, match_id, winner_plays_in_planned_match_id, winnerPlaysInMatchAt FROM plannedmatch");
        $this->addSql("DROP TABLE plannedmatch");
        $this->addSql("CREATE TABLE plannedmatch (id INTEGER NOT NULL, tournament_id INTEGER DEFAULT NULL, round_id INTEGER DEFAULT NULL, team1_id INTEGER DEFAULT NULL, team2_id INTEGER DEFAULT NULL, match_id INTEGER DEFAULT NULL, winner_plays_in_planned_match_id INTEGER DEFAULT NULL, winnerPlaysInMatchAt INTEGER DEFAULT NULL, PRIMARY KEY(id), CONSTRAINT FK_9C26D88333D1A3E7 FOREIGN KEY (tournament_id) REFERENCES tournament (id) NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_9C26D883A6005CA0 FOREIGN KEY (round_id) REFERENCES round (id) NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_9C26D883E72BCFA4 FOREIGN KEY (team1_id) REFERENCES team (id) NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_9C26D883F59E604A FOREIGN KEY (team2_id) REFERENCES team (id) NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_9C26D8832ABEACD6 FOREIGN KEY (match_id) REFERENCES \"match\" (id) NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_9C26D883444177BB FOREIGN KEY (winner_plays_in_planned_match_id) REFERENCES plannedmatch (id) NOT DEFERRABLE INITIALLY IMMEDIATE)");
        $this->addSql("INSERT INTO plannedmatch (id, tournament_id, round_id, team1_id, team2_id, match_id, winner_plays_in_planned_match_id, winnerPlaysInMatchAt) SELECT id, tournament_id, round_id, team1_id, team2_id, match_id, winner_plays_in_planned_match_id, winnerPlaysInMatchAt FROM __temp__plannedmatch");
        $this->addSql("DROP TABLE __temp__plannedmatch");
        $this->addSql("CREATE INDEX IDX_9C26D883F59E604A ON plannedmatch (team2_id)");
        $this->addSql("CREATE INDEX IDX_9C26D883E72BCFA4 ON plannedmatch (team1_id)");
        $this->addSql("CREATE INDEX IDX_9C26D883A6005CA0 ON plannedmatch (round_id)");
        $this->addSql("CREATE INDEX IDX_9C26D883444177BB ON plannedmatch (winner_plays_in_planned_match_id)");
        $this->addSql("CREATE INDEX IDX_9C26D88333D1A3E7 ON plannedmatch (tournament_id)");
        $this->addSql("CREATE INDEX IDX_9C26D8832ABEACD6 ON plannedmatch (match_id)");
        $this->addSql("ALTER TABLE player ADD COLUMN points INTEGER NOT NULL default 1000");
        $this->addSql("ALTER TABLE player ADD COLUMN matchCount INTEGER NOT NULL default 0");
        $this->addSql("DROP INDEX IDX_C5EEEA3433D1A3E7");
        $this->addSql("CREATE TEMPORARY TABLE __temp__round AS SELECT id, tournament_id FROM round");
        $this->addSql("DROP TABLE round");
        $this->addSql("CREATE TABLE round (id INTEGER NOT NULL, tournament_id INTEGER DEFAULT NULL, PRIMARY KEY(id), CONSTRAINT FK_C5EEEA3433D1A3E7 FOREIGN KEY (tournament_id) REFERENCES tournament (id) NOT DEFERRABLE INITIALLY IMMEDIATE)");
        $this->addSql("INSERT INTO round (id, tournament_id) SELECT id, tournament_id FROM __temp__round");
        $this->addSql("DROP TABLE __temp__round");
        $this->addSql("CREATE INDEX IDX_C5EEEA3433D1A3E7 ON round (tournament_id)");
        $this->addSql("DROP INDEX IDX_C4E0A61FD22CABCD");
        $this->addSql("DROP INDEX IDX_C4E0A61FC0990423");
        $this->addSql("DROP INDEX IDX_C4E0A61F33D1A3E7");
        $this->addSql("CREATE TEMPORARY TABLE __temp__team AS SELECT id, player1_id, player2_id, tournament_id FROM team");
        $this->addSql("DROP TABLE team");
        $this->addSql("CREATE TABLE team (id INTEGER NOT NULL, player1_id INTEGER DEFAULT NULL, player2_id INTEGER DEFAULT NULL, tournament_id INTEGER DEFAULT NULL, PRIMARY KEY(id), CONSTRAINT FK_C4E0A61FC0990423 FOREIGN KEY (player1_id) REFERENCES player (id) NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_C4E0A61FD22CABCD FOREIGN KEY (player2_id) REFERENCES player (id) NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_C4E0A61F33D1A3E7 FOREIGN KEY (tournament_id) REFERENCES tournament (id) NOT DEFERRABLE INITIALLY IMMEDIATE)");
        $this->addSql("INSERT INTO team (id, player1_id, player2_id, tournament_id) SELECT id, player1_id, player2_id, tournament_id FROM __temp__team");
        $this->addSql("DROP TABLE __temp__team");
        $this->addSql("CREATE INDEX IDX_C4E0A61FD22CABCD ON team (player2_id)");
        $this->addSql("CREATE INDEX IDX_C4E0A61FC0990423 ON team (player1_id)");
        $this->addSql("CREATE INDEX IDX_C4E0A61F33D1A3E7 ON team (tournament_id)");
    }

    public function down(Schema $schema)
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != "sqlite", "Migration can only be executed safely on 'sqlite'.");

        $this->addSql("DROP TABLE pointlog");
        $this->addSql("DROP TABLE pointlogplayer");
        $this->addSql("DROP INDEX IDX_232B318C2ABEACD6");
        $this->addSql("CREATE TEMPORARY TABLE __temp__game AS SELECT id, match_id, goalsTeamOne, goalsTeamTwo FROM game");
        $this->addSql("DROP TABLE game");
        $this->addSql("CREATE TABLE game (id INTEGER NOT NULL, match_id INTEGER DEFAULT NULL, goalsTeamOne INTEGER NOT NULL, goalsTeamTwo INTEGER NOT NULL, PRIMARY KEY(id))");
        $this->addSql("INSERT INTO game (id, match_id, goalsTeamOne, goalsTeamTwo) SELECT id, match_id, goalsTeamOne, goalsTeamTwo FROM __temp__game");
        $this->addSql("DROP TABLE __temp__game");
        $this->addSql("CREATE INDEX IDX_232B318C2ABEACD6 ON game (match_id)");
        $this->addSql("DROP INDEX IDX_7A5BC50533D1A3E7");
        $this->addSql("DROP INDEX IDX_7A5BC505C0990423");
        $this->addSql("DROP INDEX IDX_7A5BC505D22CABCD");
        $this->addSql("DROP INDEX IDX_7A5BC505EA525D5A");
        $this->addSql("DROP INDEX IDX_7A5BC505AB7F249A");
        $this->addSql("DROP INDEX IDX_7A5BC505DBBA47C7");
        $this->addSql("DROP INDEX IDX_7A5BC50525F02379");
        $this->addSql("CREATE TEMPORARY TABLE __temp__match AS SELECT id, tournament_id, player1_id, player2_id, team1attack, team1defence, team2attack, team2defence, date, discr FROM \"match\"");
        $this->addSql("DROP TABLE \"match\"");
        $this->addSql("CREATE TABLE \"match\" (id INTEGER NOT NULL, tournament_id INTEGER DEFAULT NULL, player1_id INTEGER DEFAULT NULL, player2_id INTEGER DEFAULT NULL, team1attack INTEGER DEFAULT NULL, team1defence INTEGER DEFAULT NULL, team2attack INTEGER DEFAULT NULL, team2defence INTEGER DEFAULT NULL, date DATETIME NOT NULL, discr VARCHAR(255) DEFAULT 'single' NOT NULL, PRIMARY KEY(id))");
        $this->addSql("INSERT INTO \"match\" (id, tournament_id, player1_id, player2_id, team1attack, team1defence, team2attack, team2defence, date, discr) SELECT id, tournament_id, player1_id, player2_id, team1attack, team1defence, team2attack, team2defence, date, discr FROM __temp__match");
        $this->addSql("DROP TABLE __temp__match");
        $this->addSql("CREATE INDEX IDX_7A5BC50533D1A3E7 ON match (tournament_id)");
        $this->addSql("CREATE INDEX IDX_7A5BC505C0990423 ON match (player1_id)");
        $this->addSql("CREATE INDEX IDX_7A5BC505D22CABCD ON match (player2_id)");
        $this->addSql("CREATE INDEX IDX_7A5BC505EA525D5A ON match (team1attack)");
        $this->addSql("CREATE INDEX IDX_7A5BC505AB7F249A ON match (team1defence)");
        $this->addSql("CREATE INDEX IDX_7A5BC505DBBA47C7 ON match (team2attack)");
        $this->addSql("CREATE INDEX IDX_7A5BC50525F02379 ON match (team2defence)");
        $this->addSql("DROP INDEX IDX_9C26D88333D1A3E7");
        $this->addSql("DROP INDEX IDX_9C26D883A6005CA0");
        $this->addSql("DROP INDEX IDX_9C26D883E72BCFA4");
        $this->addSql("DROP INDEX IDX_9C26D883F59E604A");
        $this->addSql("DROP INDEX IDX_9C26D8832ABEACD6");
        $this->addSql("DROP INDEX IDX_9C26D883444177BB");
        $this->addSql("CREATE TEMPORARY TABLE __temp__plannedmatch AS SELECT id, tournament_id, round_id, team1_id, team2_id, match_id, winner_plays_in_planned_match_id, winnerPlaysInMatchAt FROM plannedmatch");
        $this->addSql("DROP TABLE plannedmatch");
        $this->addSql("CREATE TABLE plannedmatch (id INTEGER NOT NULL, tournament_id INTEGER DEFAULT NULL, round_id INTEGER DEFAULT NULL, team1_id INTEGER DEFAULT NULL, team2_id INTEGER DEFAULT NULL, match_id INTEGER DEFAULT NULL, winner_plays_in_planned_match_id INTEGER DEFAULT NULL, winnerPlaysInMatchAt INTEGER DEFAULT NULL, PRIMARY KEY(id))");
        $this->addSql("INSERT INTO plannedmatch (id, tournament_id, round_id, team1_id, team2_id, match_id, winner_plays_in_planned_match_id, winnerPlaysInMatchAt) SELECT id, tournament_id, round_id, team1_id, team2_id, match_id, winner_plays_in_planned_match_id, winnerPlaysInMatchAt FROM __temp__plannedmatch");
        $this->addSql("DROP TABLE __temp__plannedmatch");
        $this->addSql("CREATE INDEX IDX_9C26D88333D1A3E7 ON plannedmatch (tournament_id)");
        $this->addSql("CREATE INDEX IDX_9C26D883A6005CA0 ON plannedmatch (round_id)");
        $this->addSql("CREATE INDEX IDX_9C26D883E72BCFA4 ON plannedmatch (team1_id)");
        $this->addSql("CREATE INDEX IDX_9C26D883F59E604A ON plannedmatch (team2_id)");
        $this->addSql("CREATE INDEX IDX_9C26D8832ABEACD6 ON plannedmatch (match_id)");
        $this->addSql("CREATE INDEX IDX_9C26D883444177BB ON plannedmatch (winner_plays_in_planned_match_id)");
        $this->addSql("CREATE TEMPORARY TABLE __temp__player AS SELECT id, name FROM player");
        $this->addSql("DROP TABLE player");
        $this->addSql("CREATE TABLE player (id INTEGER NOT NULL, name VARCHAR(150) NOT NULL, PRIMARY KEY(id))");
        $this->addSql("INSERT INTO player (id, name) SELECT id, name FROM __temp__player");
        $this->addSql("DROP TABLE __temp__player");
        $this->addSql("DROP INDEX IDX_C5EEEA3433D1A3E7");
        $this->addSql("CREATE TEMPORARY TABLE __temp__round AS SELECT id, tournament_id FROM round");
        $this->addSql("DROP TABLE round");
        $this->addSql("CREATE TABLE round (id INTEGER NOT NULL, tournament_id INTEGER DEFAULT NULL, PRIMARY KEY(id))");
        $this->addSql("INSERT INTO round (id, tournament_id) SELECT id, tournament_id FROM __temp__round");
        $this->addSql("DROP TABLE __temp__round");
        $this->addSql("CREATE INDEX IDX_C5EEEA3433D1A3E7 ON round (tournament_id)");
        $this->addSql("DROP INDEX IDX_C4E0A61FC0990423");
        $this->addSql("DROP INDEX IDX_C4E0A61FD22CABCD");
        $this->addSql("DROP INDEX IDX_C4E0A61F33D1A3E7");
        $this->addSql("CREATE TEMPORARY TABLE __temp__team AS SELECT id, player1_id, player2_id, tournament_id FROM team");
        $this->addSql("DROP TABLE team");
        $this->addSql("CREATE TABLE team (id INTEGER NOT NULL, player1_id INTEGER DEFAULT NULL, player2_id INTEGER DEFAULT NULL, tournament_id INTEGER DEFAULT NULL, PRIMARY KEY(id))");
        $this->addSql("INSERT INTO team (id, player1_id, player2_id, tournament_id) SELECT id, player1_id, player2_id, tournament_id FROM __temp__team");
        $this->addSql("DROP TABLE __temp__team");
        $this->addSql("CREATE INDEX IDX_C4E0A61FC0990423 ON team (player1_id)");
        $this->addSql("CREATE INDEX IDX_C4E0A61FD22CABCD ON team (player2_id)");
        $this->addSql("CREATE INDEX IDX_C4E0A61F33D1A3E7 ON team (tournament_id)");
        $this->addSql("DROP INDEX IDX_BD5FB8D95DFCD4B8");
        $this->addSql("DROP INDEX IDX_BD5FB8D9FF961BCC");
        $this->addSql("CREATE TEMPORARY TABLE __temp__tournament AS SELECT id, winner_id, second_id, name, teamType, gamesPerMatch, matchMode, maxScore, start, \"end\", discr FROM tournament");
        $this->addSql("DROP TABLE tournament");
        $this->addSql("CREATE TABLE tournament (id INTEGER NOT NULL, winner_id INTEGER DEFAULT NULL, second_id INTEGER DEFAULT NULL, name VARCHAR(150) NOT NULL, teamType INTEGER NOT NULL, gamesPerMatch INTEGER NOT NULL, matchMode INTEGER NOT NULL, maxScore INTEGER NOT NULL, start DATE DEFAULT NULL, \"end\" DATE DEFAULT NULL, discr VARCHAR(255) NOT NULL, PRIMARY KEY(id))");
        $this->addSql("INSERT INTO tournament (id, winner_id, second_id, name, teamType, gamesPerMatch, matchMode, maxScore, start, \"end\", discr) SELECT id, winner_id, second_id, name, teamType, gamesPerMatch, matchMode, maxScore, start, \"end\", discr FROM __temp__tournament");
        $this->addSql("DROP TABLE __temp__tournament");
        $this->addSql("CREATE INDEX IDX_BD5FB8D95DFCD4B8 ON tournament (winner_id)");
        $this->addSql("CREATE INDEX IDX_BD5FB8D9FF961BCC ON tournament (second_id)");
        $this->addSql("DROP INDEX IDX_4D41B8AC33D1A3E7");
        $this->addSql("DROP INDEX IDX_4D41B8AC99E6F5DF");
        $this->addSql("CREATE TEMPORARY TABLE __temp__tournament_players AS SELECT tournament_id, player_id FROM tournament_players");
        $this->addSql("DROP TABLE tournament_players");
        $this->addSql("CREATE TABLE tournament_players (tournament_id INTEGER NOT NULL, player_id INTEGER NOT NULL, PRIMARY KEY(tournament_id, player_id))");
        $this->addSql("INSERT INTO tournament_players (tournament_id, player_id) SELECT tournament_id, player_id FROM __temp__tournament_players");
        $this->addSql("DROP TABLE __temp__tournament_players");
        $this->addSql("CREATE INDEX IDX_4D41B8AC33D1A3E7 ON tournament_players (tournament_id)");
        $this->addSql("CREATE INDEX IDX_4D41B8AC99E6F5DF ON tournament_players (player_id)");
    }
}
