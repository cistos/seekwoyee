<?php

namespace Seekwoyee\Trees;

/**
 * Class AbstractNode - базовый класс для всех классов нода деревьев
 * @package Seekwoyee\Trees
 */
abstract class AbstractNode implements NodeInterface {
    protected int $id;
    protected array $userProps; // массив пользовательских параметров

    public function __construct(int $id, array $params)
    {
        $this->id = $id;
        foreach ($params as $param => $value) {
            $this->userProps[$param] = $value; // @todo сейчас так чуть позже следует создать метод setParams c верификаией по шаблону типа
        }
    }

    /**
     * get id this node
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }
}