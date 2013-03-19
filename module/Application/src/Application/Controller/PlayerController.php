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

use Application\Form\InputFilter\Player as PlayerInputFilter;
use Application\Model\Repository\PlayerRepository;
use \Zend\Mvc\Controller\AbstractActionController;

use \Doctrine\ORM\EntityManager;

use \Application\Form\Player as PlayerForm;
use Application\Model\Entity\Player;

/**
 * Managing players
 */
class PlayerController extends AbstractActionController
{

    /**
     * @var PlayerRepository
     */
    protected $playerRepository;

    /**
     * @param PlayerRepository $playerRepository
     */
    public function __construct(PlayerRepository $playerRepository)
    {
        $this->playerRepository = $playerRepository;
    }

    /**
     * @return array
     */
    public function listAction()
    {
        $players = $this->playerRepository->findAll();
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

        $form->setInputFilter(new PlayerInputFilter($this->playerRepository));

        if ($this->request->isPost()) {
            $form->setData($this->request->getPost());
            if ($form->isValid()) {
                $this->playerRepository->persist($player);
                return $this->redirect()->toRoute('players');
            }
        }

        return array(
            'form' => $form
        );
    }

}
