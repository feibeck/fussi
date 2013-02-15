<?php

namespace ApplicationTest\Form;

use Application\Entity\DoubleMatch;
use Application\Entity\Player;
use Application\Entity\Game;
use Application\Form\MatchFormDouble;

class MatchFormDoubleTest extends \PHPUnit_Framework_TestCase
{

    public function testNewMatch()
    {

        $form = $this->createForm();

        $match = new DoubleMatch();
        $form->bind($match);

        $data = array(
            'teamOneAttack'  => 1,
            'teamOneDefence' => 2,
            'teamTwoAttack'  => 3,
            'teamTwoDefence' => 4,
            'games'          => array(
                array(
                    'goalsTeamOne' => 10,
                    'goalsTeamTwo' => 3
                )
            )
        );

        $data['csrf'] = $form->get('csrf')->getCsrfValidator()->getHash(true);

        $form->setData($data);

        $valid = $form->isValid();

        $this->assertTrue($valid);
    }

    /**
     * @return \Application\Form\MatchFormDouble
     */
    protected function createForm()
    {
        $playerRepository = $this->getMock(
            'Application\Entity\PlayerRepository',
            array('find'),
            array(),
            '',
            false
        );

        $playerRepository->expects($this->exactly(4))->method('find')->will(
            $this->onConsecutiveCalls(
                $this->getPlayer(1, 'Foo'),
                $this->getPlayer(2, 'Bar'),
                $this->getPlayer(3, 'Baz'),
                $this->getPlayer(4, 'Qux')
            )
        );

        $players = array(
            $this->getPlayer(1, 'Foo'),
            $this->getPlayer(2, 'Bar'),
            $this->getPlayer(3, 'Baz'),
            $this->getPlayer(4, 'Qux'),
        );

        $form = new MatchFormDouble($playerRepository, 1, $players);
        return $form;
    }

    public function testEditMatch()
    {
        $form = $this->createForm();

        $match = new DoubleMatch();

        $player1 = $this->getPlayer(1, 'Foo');
        $player2 = $this->getPlayer(2, 'Bar');
        $match->setTeamOne($player1, $player2);

        $player3 = $this->getPlayer(3, 'Foo');
        $player4 = $this->getPlayer(4, 'Bar');

        $match->setTeamTwo($player3, $player4);

        $game = new Game();
        $game->setGoalsTeamOne(10);
        $game->setGoalsTeamTwo(3);

        $match->addGame($game);

        $form->bind($match);

        $data = array(
            'teamOneAttack'  => 1,
            'teamOneDefence' => 2,
            'teamTwoAttack'  => 3,
            'teamTwoDefence' => 4,
            'games'          => array(
                array(
                    'id'           => 1,
                    'goalsTeamOne' => 3,
                    'goalsTeamTwo' => 10
                )
            )
        );

        $data['csrf'] = $form->get('csrf')->getCsrfValidator()->getHash(true);

        $form->setData($data);
        $valid = $form->isValid();

        $this->assertTrue($valid);

        /** @var $data DoubleMatch */
        $data = $form->getData();
        $this->assertSame($match, $data);

        $games = $data->getGames();
        $this->assertSame($game, $games[0]);
    }

    protected function getPlayer($id, $name)
    {
        $player = new Player();
        $player->setId($id);
        $player->setName($name);
        return $player;
    }

}

