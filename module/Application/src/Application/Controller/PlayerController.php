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
use Application\Model\Repository\PointLogPlayerRepository;
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
     * @var PointLogPlayerRepository
     */
    protected $pointLogPlayerRepository;

    /**
     * @param PlayerRepository         $playerRepository
     * @param PointLogPlayerRepository $pointLogPlayerRepository
     */
    public function __construct(PlayerRepository $playerRepository, PointLogPlayerRepository $pointLogPlayerRepository)
    {
        $this->playerRepository         = $playerRepository;
        $this->pointLogPlayerRepository = $pointLogPlayerRepository;
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

    public function editAction() {
        $form = new PlayerForm();

        $id = $this->params()->fromRoute('id');
        $player = $this->playerRepository->find($id);

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

    public function viewAction()
    {
        $id = $this->params()->fromRoute('id');
        $player = $this->playerRepository->find($id);
        $pointLogs = $this->pointLogPlayerRepository->getForPlayer($player);
        return array('player' => $player, 'logs' => $pointLogs);
    }

}
