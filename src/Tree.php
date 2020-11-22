<?php

namespace Seekwoyee;

use Seekwoyee\Trees\AbstractTreeManager;
use Seekwoyee\Trees\NodeInterface;


/**
 * Class Tree - класс-компоновщик для любых деревьев
 * @package Seekwoyee
 */
class Tree {
    private array $nodes = []; // в ключах айдишники нодов
    public AbstractTreeManager $manager;
    private int $rootId; // откуда в случае чего начинать поиск
    private string $type;
    private array $treeTypes = ['Bst'];


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

    /**
     * Получить нод по айдишнику
     * @param int $id
     * @return NodeInterface
     */
    public function getNode(int $id): ?NodeInterface {
        $node = null;
        if (key_exists($id, $this->nodes)) {
            $node = $this->nodes[$id];
        }

        return $node;
    }
}
