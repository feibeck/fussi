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

use Zend\Form\Form;
use Zend\View\Helper\AbstractHelper;

class TwitterBootstrapFormError extends AbstractHelper
{

    public function __invoke(Form $form)
    {

        $out = "";

        if ($form->hasValidated() && !$form->isValid()) {

            $out .= '<div class="alert alert-danger" role="alert">';
            $out .= '<strong>Validation problems:</strong> Please check your form input';
            $out .= '</div>';

        }

        return $out;

    }

}
