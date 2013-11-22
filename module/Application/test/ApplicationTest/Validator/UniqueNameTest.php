<?php
/**
 * Fußi
 *
 * @copyright Copyright (c) 2013 The Fußi-Team
 * @license   THE BEER-WARE LICENSE (Revision 42)
 *
 * "THE BEER-WARE LICENSE" (Revision 42):
 * The Fußi-Team wrote this software. As long as you retain this notice you
 * can do whatever you want with this stuff. If we meet some day, and you think
 * this stuff is worth it, you can buy us a beer in return.
 */

namespace ApplicationTest\Validator;

use Application\Validator\UniqueName;

class UniqueNameTest extends \PHPUnit_Framework_TestCase
{
    
    public function testNameIsUnique()
    {
        $repository = $this->getRepositoryMock(true);
        $validator = new UniqueName($repository);
        $this->assertTrue($validator->isValid('foo'));
    }
    
    public function testNameIsAlreadyUsed()
    {
        $repository = $this->getRepositoryMock(false);
        $validator = new UniqueName($repository);
        $this->assertFalse($validator->isValid('foo'));
    }

    /**
     * @param $value
     *
     * @return \Application\Model\Repository\PlayerRepository
     */
    protected function getRepositoryMock($value)
    {
        $repository = $this->getMock(
            '\Application\Model\Repository\PlayerRepository',
            array('isUniqueName'),
            array(),
            '',
            false
        );

        $repository->expects($this->any())
            ->method('isUniqueName')
            ->will($this->returnValue($value));
        
        return $repository;
    }

}