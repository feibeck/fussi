<?php
/**
 * Definition of Version20131215160000
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

class Version20131215160000 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != "sqlite", "Migration can only be executed safely on 'sqlite'.");

        $this->addSql("CREATE TABLE tournament (id INTEGER NOT NULL, winner_id INTEGER DEFAULT NULL, second_id INTEGER DEFAULT NULL, name VARCHAR(150) NOT NULL, teamType INTEGER NOT NULL, gamesPerMatch INTEGER NOT NULL, matchMode INTEGER NOT NULL, maxScore INTEGER NOT NULL, start DATE DEFAULT NULL, \"end\" DATE DEFAULT NULL, discr VARCHAR(255) NOT NULL, PRIMARY KEY(id), CONSTRAINT FK_BD5FB8D95DFCD4B8 FOREIGN KEY (winner_id) REFERENCES team (id) NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_BD5FB8D9FF961BCC FOREIGN KEY (second_id) REFERENCES team (id) NOT DEFERRABLE INITIALLY IMMEDIATE)");
        $this->addSql("CREATE INDEX IDX_BD5FB8D95DFCD4B8 ON tournament (winner_id)");
        $this->addSql("CREATE INDEX IDX_BD5FB8D9FF961BCC ON tournament (second_id)");
        $this->addSql("CREATE TABLE tournament_players (tournament_id INTEGER NOT NULL, player_id INTEGER NOT NULL, PRIMARY KEY(tournament_id, player_id), CONSTRAINT FK_4D41B8AC33D1A3E7 FOREIGN KEY (tournament_id) REFERENCES tournament (id) NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_4D41B8AC99E6F5DF FOREIGN KEY (player_id) REFERENCES player (id) NOT DEFERRABLE INITIALLY IMMEDIATE)");
        $this->addSql("CREATE INDEX IDX_4D41B8AC33D1A3E7 ON tournament_players (tournament_id)");
        $this->addSql("CREATE INDEX IDX_4D41B8AC99E6F5DF ON tournament_players (player_id)");
        $this->addSql("CREATE TABLE \"match\" (id INTEGER NOT NULL, tournament_id INTEGER DEFAULT NULL, player1_id INTEGER DEFAULT NULL, player2_id INTEGER DEFAULT NULL, team1attack INTEGER DEFAULT NULL, team1defence INTEGER DEFAULT NULL, team2attack INTEGER DEFAULT NULL, team2defence INTEGER DEFAULT NULL, date DATETIME NOT NULL, discr VARCHAR(255) NOT NULL, PRIMARY KEY(id), CONSTRAINT FK_7A5BC50533D1A3E7 FOREIGN KEY (tournament_id) REFERENCES tournament (id) NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_7A5BC505C0990423 FOREIGN KEY (player1_id) REFERENCES player (id) NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_7A5BC505D22CABCD FOREIGN KEY (player2_id) REFERENCES player (id) NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_7A5BC505EA525D5A FOREIGN KEY (team1attack) REFERENCES player (id) NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_7A5BC505AB7F249A FOREIGN KEY (team1defence) REFERENCES player (id) NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_7A5BC505DBBA47C7 FOREIGN KEY (team2attack) REFERENCES player (id) NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_7A5BC50525F02379 FOREIGN KEY (team2defence) REFERENCES player (id) NOT DEFERRABLE INITIALLY IMMEDIATE)");
        $this->addSql("CREATE INDEX IDX_7A5BC50533D1A3E7 ON \"match\" (tournament_id)");
        $this->addSql("CREATE INDEX IDX_7A5BC505C0990423 ON \"match\" (player1_id)");
        $this->addSql("CREATE INDEX IDX_7A5BC505D22CABCD ON \"match\" (player2_id)");
        $this->addSql("CREATE INDEX IDX_7A5BC505EA525D5A ON \"match\" (team1attack)");
        $this->addSql("CREATE INDEX IDX_7A5BC505AB7F249A ON \"match\" (team1defence)");
        $this->addSql("CREATE INDEX IDX_7A5BC505DBBA47C7 ON \"match\" (team2attack)");
        $this->addSql("CREATE INDEX IDX_7A5BC50525F02379 ON \"match\" (team2defence)");
        $this->addSql("CREATE TABLE game (id INTEGER NOT NULL, match_id INTEGER DEFAULT NULL, goalsTeamOne INTEGER NOT NULL, goalsTeamTwo INTEGER NOT NULL, PRIMARY KEY(id), CONSTRAINT FK_232B318C2ABEACD6 FOREIGN KEY (match_id) REFERENCES \"match\" (id) NOT DEFERRABLE INITIALLY IMMEDIATE)");
        $this->addSql("CREATE INDEX IDX_232B318C2ABEACD6 ON game (match_id)");
        $this->addSql("CREATE TABLE plannedmatch (id INTEGER NOT NULL, tournament_id INTEGER DEFAULT NULL, round_id INTEGER DEFAULT NULL, team1_id INTEGER DEFAULT NULL, team2_id INTEGER DEFAULT NULL, match_id INTEGER DEFAULT NULL, winner_plays_in_planned_match_id INTEGER DEFAULT NULL, winnerPlaysInMatchAt INTEGER DEFAULT NULL, PRIMARY KEY(id), CONSTRAINT FK_9C26D88333D1A3E7 FOREIGN KEY (tournament_id) REFERENCES tournament (id) NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_9C26D883A6005CA0 FOREIGN KEY (round_id) REFERENCES round (id) NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_9C26D883E72BCFA4 FOREIGN KEY (team1_id) REFERENCES team (id) NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_9C26D883F59E604A FOREIGN KEY (team2_id) REFERENCES team (id) NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_9C26D8832ABEACD6 FOREIGN KEY (match_id) REFERENCES \"match\" (id) NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_9C26D883444177BB FOREIGN KEY (winner_plays_in_planned_match_id) REFERENCES plannedmatch (id) NOT DEFERRABLE INITIALLY IMMEDIATE)");
        $this->addSql("CREATE INDEX IDX_9C26D88333D1A3E7 ON plannedmatch (tournament_id)");
        $this->addSql("CREATE INDEX IDX_9C26D883A6005CA0 ON plannedmatch (round_id)");
        $this->addSql("CREATE INDEX IDX_9C26D883E72BCFA4 ON plannedmatch (team1_id)");
        $this->addSql("CREATE INDEX IDX_9C26D883F59E604A ON plannedmatch (team2_id)");
        $this->addSql("CREATE INDEX IDX_9C26D8832ABEACD6 ON plannedmatch (match_id)");
        $this->addSql("CREATE INDEX IDX_9C26D883444177BB ON plannedmatch (winner_plays_in_planned_match_id)");
        $this->addSql("CREATE TABLE player (id INTEGER NOT NULL, name VARCHAR(150) NOT NULL, PRIMARY KEY(id))");
        $this->addSql("CREATE TABLE round (id INTEGER NOT NULL, tournament_id INTEGER DEFAULT NULL, PRIMARY KEY(id), CONSTRAINT FK_C5EEEA3433D1A3E7 FOREIGN KEY (tournament_id) REFERENCES tournament (id) NOT DEFERRABLE INITIALLY IMMEDIATE)");
        $this->addSql("CREATE INDEX IDX_C5EEEA3433D1A3E7 ON round (tournament_id)");
        $this->addSql("CREATE TABLE team (id INTEGER NOT NULL, player1_id INTEGER DEFAULT NULL, player2_id INTEGER DEFAULT NULL, tournament_id INTEGER DEFAULT NULL, PRIMARY KEY(id), CONSTRAINT FK_C4E0A61FC0990423 FOREIGN KEY (player1_id) REFERENCES player (id) NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_C4E0A61FD22CABCD FOREIGN KEY (player2_id) REFERENCES player (id) NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_C4E0A61F33D1A3E7 FOREIGN KEY (tournament_id) REFERENCES tournament (id) NOT DEFERRABLE INITIALLY IMMEDIATE)");
        $this->addSql("CREATE INDEX IDX_C4E0A61FC0990423 ON team (player1_id)");
        $this->addSql("CREATE INDEX IDX_C4E0A61FD22CABCD ON team (player2_id)");
        $this->addSql("CREATE INDEX IDX_C4E0A61F33D1A3E7 ON team (tournament_id)");
    }

    public function down(Schema $schema)
    {
    }
}
