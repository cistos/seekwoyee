<?php

namespace Seekwoyee\Trees;


interface FactoryTreeInterface {
    /**
     * Создание менеджера через которого осуществляется управление структурой дерева
     * @param int $maxHeight
     * @param NodeUserTemplate $userPropsTemplate
     * @return AbstractTreeManager
     */
    public function createTreeManager(int $maxHeight, NodeUserTemplate $userPropsTemplate): ExtTreeManagerInterface;

    /**
     * Создание корневого нода
     * @param int $id
     * @param array $params
     * @return NodeInterface
     */
    public function createRootNode (int $id, array $params): NodeInterface;

    /**
     * Создание объекта шаблона набора пользовательских данных с типами и ограничением изменения через рефлексию
     * Не нарушаетсмя DRY принци, потому что для по краней мере красно-черного дерева метод будет отличаться от оных в других деревьях
     * @param array $params
     * @return NodeUserTemplate
     */
    public function createNodeValueTemplate (array $params): NodeUserTemplate;
}