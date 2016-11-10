<?php
namespace CEmerson\TranslatorTwigExtension\Nodes;

use CEmerson\TranslatorTwigExtension\TranslatorExtension;
use Twig_Extensions_Node_Trans;

class TranslatorNode extends Twig_Extensions_Node_Trans
{
    /**
     * @param bool $plural Return plural or singular function to use
     *
     * @return string
     */
    protected function getTransFunction($plural)
    {
        return
            '$this->env->getExtension(\''
            . TranslatorExtension::class
            . '\')->getTranslator()->'
            . ($plural ? 'ngettext' : 'gettext');
    }
}
