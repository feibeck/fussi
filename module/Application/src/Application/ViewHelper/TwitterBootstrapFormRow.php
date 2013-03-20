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

namespace Application\ViewHelper;

use Zend\Form\Element;
use Zend\View\Helper\AbstractHelper;

class TwitterBootstrapFormRow extends AbstractHelper
{

    public function __invoke(Element $element)
    {

        $messages = $element->getMessages();

        $out = '<div class="control-group';
        if (count($messages)) {
            $out .= ' error';
        }
        $out .= '">';
        $element->setLabelAttributes(array('class' => 'control-label'));
        $out .= $this->view->formLabel($element);
        $out .= '<div class="controls">';
        if ($element instanceof \Zend\Form\Element\Radio) {
            $element->setLabelAttributes(array('class' => 'radio'));
        }
        $out .= $this->view->formElement($element);
        $out .= $this->view->formElementErrors()
            ->setMessageOpenFormat('<div class="help-inline">')
            ->setMessageSeparatorString('. ')
            ->setMessageCloseString('.</div>')
            ->render($element);
        $out .= '</div>';
        $out .= '</div>';

        return $out;

    }

}
