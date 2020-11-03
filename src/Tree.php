<?php

namespace Seekwoyee;

use Seekwoyee\Trees\AbstractTreeManager;

/**
 * Class Tree - класс-компоновщик для любых деревьев
 * @package Seekwoyee
 */
class Tree {
    private array $nodes = [];
    public AbstractTreeManager $treeManager;
    private int $rootId;
    private string $type;

    public function __construct(string $type, array $nodeParams)
    {
    }
}
