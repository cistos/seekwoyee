<?php

namespace Seekwoyee\Trees\Bst;

use Seekwoyee\Trees as Trees;
use Seekwoyee\Trees\NodeUserTemplate;

/**
 * Class FactoryTreeBst - конструирует класс Tree для бинарного несбалансированного дерева
 * @package Seekwoyee\Trees\Bst
 */
class FactoryTreeBst implements Trees\FactoryTreeInterface {
    /**
     * Добавить шаблон нода
     * @param int $maxHeight
     * @param NodeUserTemplate $userPropsTemplate
     * @return TreeManagerBst
     */
    public function createTreeManager(int $maxHeight,  $userPropsTemplate): TreeManagerBst
    {
        return new TreeManagerBst($maxHeight, $userPropsTemplate);
    }

    /**
     * Создает коэффциент балансировки, по высоте определяет индекс поиска в дереве, создание по шаблону пользовательского класса, parentId
     * @param int $id
     * @param array $params - не требуется проверка по шаблону типов, потомуч то на основе этих параметров создан шаблон
     * @return NodeBst
     */
    public function createRootNode (int $id, array $params): NodeBst
    {
        return new NodeBst($id, $params);
    }

    /**
     * Создавать и менять пользовательские свойства можно только внутри родной фабрики
     * @param array $params
     * @return NodeUserTemplate
     */
    public function createNodeValueTemplate(array $params): NodeUserTemplate
    {
        return new NodeUserTemplate($params);
    }
}