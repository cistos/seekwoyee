<?php

namespace Seekwoyee;

use Seekwoyee\Trees\AbstractTreeManager;


/**
 * Class Tree - класс-компоновщик для любых деревьев
 * @package Seekwoyee
 */
class Tree {
    private array $nodes = [];
    public AbstractTreeManager $manager;
    private int $rootId;
    private string $type;
    private array $treeTypes = ['Bst'];

    // @todo  реализовать фабрику
    public function __construct(string $type, int $maxHeight, array $nodeParams)
    {
        if (in_array($type, $this->treeTypes)) {

            $factoryName = 'Seekwoyee\Trees\Bst\FactoryTree'.$type;
            $factory = new $factoryName();
            $this->type = $type;
            // создать шаблон пользовательских полей
            $userPropsTemplate = $factory->createNodeValueTemplate($nodeParams);
            $this->manager = $factory->createTreeManager($maxHeight, $userPropsTemplate);
            $rootId = $this->manager->getRootId();
            $this->rootId = $rootId;
            $this->nodes[$rootId] = $factory->createRootNode($rootId, $nodeParams);
        }
        else {
            print 'Requested unknown type trees';
        }
    }
}
