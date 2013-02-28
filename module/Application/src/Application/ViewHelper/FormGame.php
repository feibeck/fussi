<?php
/**
 * Definition of Application\ViewHelper\FormGame
 *
 * @copyright Copyright (c) 2013 The Fußi-Team
 * @license   THE BEER-WARE LICENSE (Revision 42)
 *
 * "THE BEER-WARE LICENSE" (Revision 42):
 * The Fußi-Team wrote this software. As long as you retain this notice you
 * can do whatever you want with this stuff. If we meet some day, and you think
 * this stuff is worth it, you can buy us a beer in return.
 */

namespace Application\ViewHelper;

use Application\Form\Fieldset\Game;
use Application\Entity\Game as GameEntity;
use Symfony\Component\Console\Application;
use Zend\Form\Element;
use Zend\Form\ElementInterface;
use Zend\Form\Element\Collection as CollectionElement;
use Zend\Form\View\Helper\AbstractHelper;

class FormGame extends AbstractHelper
{

    /**
     * Render a collection by iterating through all fieldsets and elements
     *
     * @param ElementInterface $element
     * @param int              $index
     *
     * @return string
     *
     */
    public function render(ElementInterface $element, $index = 0)
    {
        $renderer = $this->getView();
        if (!method_exists($renderer, 'plugin')) {
            // Bail early if renderer is not pluggable
            return '';
        }

        $markup = '';

        if ($element instanceof CollectionElement) {

            $match = $this->getMatch($element);
            if ($match == null) {
                $player1 = 'n/a';
                $player2 = 'n/a';
            } else if ($match instanceof \Application\Entity\DoubleMatch) {
                $player1 = 'Team 1';
                $player2 = 'Team 2';
            } else if ($match instanceof \Application\Entity\SingleMatch) {
                $player1 = $match->getPlayer1()->getName();
                $player2 = $match->getPlayer2()->getName();
            } else {
                $player1 = "Foo";
                $player2 = "Bar";
            }

            $markup = '<table id="matchform"><tr><th></th><th>%s</th><th>vs.</th><th>%s</th></tr>';
            $markup = sprintf(
                $markup,
                $player1,
                $player2
            );

            $index = 1;
            foreach ($element as $fieldsets) {
                $markup .= $this->render($fieldsets, $index++);
            }

            $markup .= '</table>';

        } else if ($element instanceof Game) {

            $markup .= '<tr class="game">'
                    . '<td>Game&nbsp;' . $index . '</td>'
                    . '<td>'
                    . $this->renderField($element->get('goalsTeamOne'))
                    . '</td>'
                    . '<td>:</td>'
                    . '<td>'
                    . $this->renderField($element->get('goalsTeamTwo'), 1)
                    . '</td>'
                    . '</tr>';

            return $markup;

        }

        return sprintf(
            '<div class="row"><div class="span5">%s</div></div>',
            $markup
        );
    }

    /**
     * @param $element
     *
     * @return \Application\Entity\Match
     */
    protected function getMatch($element)
    {
        foreach ($element as $fieldset) {
            if ($fieldset instanceof Game) {
                $object = $fieldset->getObject();
                if (is_object($object) && $object instanceof GameEntity) {
                    return $object->getMatch();
                }
            }
        }
    }

    protected function renderField($element, $game = 0)
    {
        $helper = $this->view->plugin('formElement');
        $element->setAttribute('class', "goals".$game);
        return $helper->render($element);
    }

    /**
     * Invoke helper as function
     *
     * Proxies to {@link render()}.
     *
     * @param  ElementInterface|null $element
     * @param  boolean $wrap
     *
     * @return string|FormGame
     */
    public function __invoke(ElementInterface $element = null, $wrap = true)
    {
        if (!$element) {
            return $this;
        }

        return $this->render($element);
    }

}

