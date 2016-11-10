<?php
namespace CEmerson\TranslatorTwigExtension\TokenParsers;

use CEmerson\TranslatorTwigExtension\Nodes\TranslatorNode;
use LogicException;
use Twig_Extensions_TokenParser_Trans;
use Twig_Parser;
use Twig_Token;
use Twig_TokenParser;

class TranslatorTokenParserDecorator extends Twig_TokenParser
{
    /** @var Twig_Extensions_TokenParser_Trans */
    private $tokenParser;

    public function __construct(Twig_Extensions_TokenParser_Trans $tokenParser)
    {
        $this->tokenParser = $tokenParser;
    }

    public function parse(Twig_Token $token)
    {
        $node = $this->tokenParser->parse($token);

        $nodes = [];

        foreach (['body', 'plural', 'count', 'notes'] as $nodeName) {
            try {
                $nodes[$nodeName] = $node->getNode($nodeName);
            } catch (LogicException $ex) {
                $nodes[$nodeName] = null;
            }
        }

        return new TranslatorNode(
            $nodes['body'],
            $nodes['plural'],
            $nodes['count'],
            $nodes['notes'],
            $node->getTemplateLine(),
            $node->getNodeTag()
        );
    }

    public function setParser(Twig_Parser $parser)
    {
        $this->tokenParser->setParser($parser);
    }

    public function decideForFork(Twig_Token $token)
    {
        return $this->tokenParser->decideForFork($token);
    }

    public function decideForEnd(Twig_Token $token)
    {
        return $this->tokenParser->decideForEnd($token);
    }

    public function getTag()
    {
        return $this->tokenParser->getTag();
    }
}
