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
     * @return NodeInterface|null - возвратить объект нода, либо null, если нод не найден
     */
    public function getNode(int $id): ?NodeInterface {
        $node = null;
        if (key_exists($id, $this->nodes)) {
            $node = $this->nodes[$id];
        }

        return $node;
    }

    /**
     * @todo может здесь добавить и изменение пользовательских парметров
     * По id создать копию нода parentId и дорбавить в дерево
     * @param int|null $parentId - идентификатор нода на основе которого будет создаваться новый, если null то основе первого попавшегося
     * @param bool $recursive - наследники $parentId, рекурсивно найти место для вставки
     * @param bool $fromLeft - с какой стороны добавлять, слева - true, справа - false
     * @return int|null - если успешно идентификатор нода, если нет то null
     */
    public function addNode(?int $parentId, bool $recursive = false, bool $fromLeft = true): ?int {
        $node = $this->manager->prototypeNode($parentId, $this->nodes, $recursive, $fromLeft);
        $nodeId = null;
        if ($node !== null) {
            $nodes[] = $node;
            $nodeId = $node->getId();
        }

        return $nodeId;
    }
}
