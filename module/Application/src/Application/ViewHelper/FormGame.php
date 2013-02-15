<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/zf2 for the canonical source repository
 * @copyright Copyright (c) 2005-2012 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 * @package   Zend_Form
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

            $markup = '<table><tr><th></th><th>%s</th><th>vs.</th><th>%s</th></tr>';
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

            $markup .= '<tr>'
                    . '<td>Game&nbsp;' . $index . '</td>'
                    . '<td>'
                    . $this->renderField($element->get('goalsTeamOne'))
                    . '</td>'
                    . '<td>:</td>'
                    . '<td>'
                    . $this->renderField($element->get('goalsTeamTwo'))
                    . '</td>'
                    . '</tr>';

            return $markup;

        }

        return sprintf(
            '<div class="row"><div class="span5"><table class="table" id="matchform">%s</table></div></div>',
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

    protected function renderField($element)
    {
        $helper = $this->view->plugin('formElement');
        $markup = ''
                . '<div class="input-prepend input-append">'
                . '<a class="btn" id=""><i class="icon-arrow-left"></i></a>'
                . $helper->render($element)
                . '<a class="btn" id=""><i class="icon-arrow-right"></i></a>'
                . '</div>';
        return $markup;
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

