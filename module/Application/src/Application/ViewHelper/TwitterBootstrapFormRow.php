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

        $out = '<div class="form-group';
        if (count($messages)) {
            $out .= ' has-error';
        }
        $out .= '">';

        if ($element instanceof \Zend\Form\Element\Radio) {
            $out .= $this->renderRadioElement($element);
        } else {
            $out .= $this->renderTextElement($element);
        }

        $out .= '</div>';

        return $out;

    }

    protected function renderRadioElement(Element $element)
    {
        $element->setLabelAttributes(array('class' => 'col-sm-2 control-label'));
        $out = $this->view->formLabel($element);
        $element->setLabelAttributes(array('class' => ''));
        $out .= '<div class="col-sm-10"><div class="radio">';

        $helper = $this->view->plugin('formRadio');
        $helper->setSeparator('</div><div class="radio">');

        $out .= $helper->render($element);

        $out .= '</div></div>';
        $out .= $this->view->formElementErrors()
            ->setMessageOpenFormat('<span class="help-block">')
            ->setMessageSeparatorString('. ')
            ->setMessageCloseString('.</span>')
            ->render($element);

        return $out;
    }

    protected function renderTextElement(Element $element)
    {
        $element->setLabelAttributes(array('class' => 'col-sm-2 control-label'));
        $out = $this->view->formLabel($element);
        $out .= '<div class="col-sm-10">';
        $element->setAttribute('class', 'form-control');
        $out .= $this->view->formElement($element);
        $out .= $this->view->formElementErrors()
            ->setMessageOpenFormat('<span class="help-block">')
            ->setMessageSeparatorString('. ')
            ->setMessageCloseString('.</span>')
            ->render($element);
        $out .= '</div>';

        return $out;
    }

}
