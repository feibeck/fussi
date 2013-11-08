<?php
/**
 * Definition of ApplicationTest\Form\InputFilter\TournamentTest
 *
 * @copyright Copyright (c) 2013 The Fußi-Team
 * @license   THE BEER-WARE LICENSE (Revision 42)
 *
 * "THE BEER-WARE LICENSE" (Revision 42):
 * The Fußi-Team wrote this software. As long as you retain this notice you
 * can do whatever you want with this stuff. If we meet some day, and you think
 * this stuff is worth it, you can buy us a beer in return.
 */

namespace ApplicationTest\Form\InputFilter;

/**
 * @covers Application\Form\InputFilter\Tournament
 */
class TournamentTest extends \PHPUnit_Framework_TestCase
{

    protected $validData = array(
        'name' => 'Foobar',
        'games-per-match' => 1,
        'team-type' => \Application\Model\Entity\League::TYPE_SINGLE,
        'start-date' => '2013-01-01'
    );

    public function testDate()
    {
        $inputFilter = new \Application\Form\InputFilter\Tournament(
            $this->getRepository(false)
        );
        $data = $this->validData;
        $data['start-date'] = 'foobar';
        $inputFilter->setData($data);
        $this->assertFalse($inputFilter->isValid());
    }

    public function testInvalidMatchType()
    {
        $inputFilter = new \Application\Form\InputFilter\Tournament(
            $this->getRepository(false)
        );
        $data = $this->validData;
        $data['team-type'] = 3;
        $inputFilter->setData($data);
        $this->assertFalse($inputFilter->isValid());
    }

    public function testEmptyValuesIsInvalid()
    {
        $inputFilter = new \Application\Form\InputFilter\Tournament(
            $this->getRepository()
        );

        $inputFilter->setData(array());
        $this->assertFalse($inputFilter->isValid());
    }

    public function testValidDataPasses()
    {
        $inputFilter = new \Application\Form\InputFilter\Tournament(
            $this->getRepository()
        );

        $inputFilter->setData($this->validData);
        $this->assertTrue($inputFilter->isValid());
    }

    public function testNameNeedsToBeUnique()
    {
        $inputFilter = new \Application\Form\InputFilter\Tournament(
            $this->getRepository(false)
        );
        $inputFilter->setData($this->validData);
        $this->assertFalse($inputFilter->isValid());
    }

    public function testThereNeedsToBeAtLeastOneGame()
    {
        $inputFilter = new \Application\Form\InputFilter\Tournament(
            $this->getRepository(false)
        );
        $data = $this->validData;
        $data['games-per-match'] = 0;
        $inputFilter->setData($data);
        $this->assertFalse($inputFilter->isValid());
    }

    public function testGamesPerMatchIsNumber()
    {
        $inputFilter = new \Application\Form\InputFilter\Tournament(
            $this->getRepository(false)
        );
        $data = $this->validData;
        $data['games-per-match'] = "a";
        $inputFilter->setData($data);
        $this->assertFalse($inputFilter->isValid());
    }

    public function testGamesPerMatchRequired()
    {
        $inputFilter = new \Application\Form\InputFilter\Tournament(
            $this->getRepository(false)
        );
        $data = $this->validData;
        unset($data['games-per-match']);
        $inputFilter->setData($data);
        $this->assertFalse($inputFilter->isValid());
    }

    protected function getRepository($nameIsUnique = true)
    {
        $repository = $this->getMock(
            '\Application\Model\Repository\TournamentRepository',
            array(
                'isUniqueName'
            ),
            array(),
            '',
            false
        );
        $repository->expects($this->any())
                   ->method('isUniqueName')
                   ->will($this->returnValue($nameIsUnique));
        return $repository;
    }

}