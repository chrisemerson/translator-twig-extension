<?php
namespace CEmerson\TranslatorTwigExtension;

use CEmerson\TranslatorTwigExtension\TokenParsers\TranslatorTokenParserDecorator;
use Gettext\TranslatorInterface;
use Twig_Extensions_Extension_I18n;
use Twig_SimpleFilter;

class TranslatorExtension extends Twig_Extensions_Extension_I18n
{
    private $translator;

    public function __construct(TranslatorInterface $translator)
    {
        $this->translator = $translator;
    }

    public function getTranslator()
    {
        return $this->translator;
    }

    /**
     * {@inheritdoc}
     */
    public function getTokenParsers()
    {
        return array_map(
            function ($tokenParser) {
                return new TranslatorTokenParserDecorator($tokenParser);
            },
            parent::getTokenParsers()
        );
    }

    /**
     * {@inheritdoc}
     */
    public function getFilters()
    {
        return array(
            new Twig_SimpleFilter('trans', function ($original) {
                return $this->translator->gettext($original);
            })
        );
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'translator';
    }
}
