<?php
namespace Php2js;

use Php2js\Scalar\ScalarDispatcher;
use Php2js\Statement\StatementDispatcher;
use PhpParser\Node;

class NodeDispatcher
{
    /** @var  Node */
    private $node;

    /**
     * @param $node
     */
    public function __construct(Node $node)
    {
        $this->node = $node;
    }

    /**
     * @return string
     * @throws \Exception
     */
    public function dispatch()
    {
        $type = explode('_', $this->node->getType());
        switch ($type[0]) {
            case 'Stmt':
                $dispatcher = new StatementDispatcher();
                break;
            case 'Scalar':
                $dispatcher = new ScalarDispatcher();
                break;
            default:
                throw new \Exception('Not implemented: ' . $type[0]);
                break;
        }

        $dispatcher->setNode($this->node);
        $dispatcher->setType(array_pop($type));
        return $dispatcher->dispatch();
    }
}
