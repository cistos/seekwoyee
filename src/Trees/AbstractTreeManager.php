<?php

namespace Seekwoyee\Trees;

/**
 * Class AbstractTreeManager - базовый класс для менеджеров деревьев
 * @package Seekwoyee\Trees
 */
abstract class AbstractTreeManager implements ExtTreeManagerInterface {
    private NodeUserTemplate $userPropsTemplate;
    private int $height;

    public function __construct(int $height, NodeUserTemplate $userPropsTemplate)
    {
        $this->userPropsTemplate = $userPropsTemplate;
        $this->height = $height;
    }

    abstract public function getRootId():int;
}