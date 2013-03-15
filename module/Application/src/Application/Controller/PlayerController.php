<?php
/**
 * Definition of Application\Controller\PlayerController
 *
 * @copyright Copyright (c) 2013 The Fußi-Team
 * @license   THE BEER-WARE LICENSE (Revision 42)
 *
 * "THE BEER-WARE LICENSE" (Revision 42):
 * The Fußi-Team wrote this software. As long as you retain this notice you
 * can do whatever you want with this stuff. If we meet some day, and you think
 * this stuff is worth it, you can buy us a beer in return.
 */

namespace Application\Controller;

use \Zend\Mvc\Controller\AbstractActionController;

use \Doctrine\ORM\EntityManager;

use \Application\Form\Player as PlayerForm;
use Application\Model\Entity\Player as Player;

/**
 * Managing players
 */
class PlayerController extends AbstractActionController
{

    /**
     * @var EntityManager
     */
    private $em;

    /**
     * @param EntityManager $em
     */
    public function __construct(EntityManager $em)
    {
        $this->em = $em;
    }

    /**
     * @return array
     */
    public function listAction()
    {
        $playerRepository = $this->em->getRepository('Application\Entity\Player');
        $players = $playerRepository->findAll();
        return array(
            'players' => $players
        );
    }

    /**
     * @return array|\Zend\Http\Response
     */
    public function addAction()
    {
        $form = new PlayerForm();

        $player = new Player();
        $form->bind($player);

        $form->setInputFilter(
            new \Application\Form\InputFilter\Player(
                $this->em->getRepository('\Application\Entity\Player')
            )
        );

        if ($this->request->isPost()) {
            $form->setData($this->request->getPost());
            if ($form->isValid()) {
                $this->em->persist($player);
                $this->em->flush();
                return $this->redirect()->toRoute('players');
            }
        }

        return array(
            'form' => $form
        );
    }

}
