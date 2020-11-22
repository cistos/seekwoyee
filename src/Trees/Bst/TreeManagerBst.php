<?php

namespace Seekwoyee\Trees\Bst;
    use Seekwoyee\Trees\NodeUserTemplate;

    /**
     * Class TreeManagerBst - класс упрвления структурой дерева типа BST
     * @package Seekwoyee\Trees\Bst
     */
    final class TreeManagerBst extends \Seekwoyee\Trees\AbstractTreeManager {
        private NodeUserTemplate $userPropsTemplate;
        private int $height; // @todo - наверное стоит поставить ограничение на высоту, а то int и память не резиновые
        private int $inheritLimit = 2; // максимальное количество поддеркевьев у каждого нода

        public function __construct(int $height, NodeUserTemplate $userPropsTemplate)
        {
            $this->userPropsTemplate = $userPropsTemplate;
            $this->height = $height;
        }

        /**
         * Получить идентификатор корневого нода
         * @return int
         */
        public function getRootId(): int {
            return 2**($this->height - 1);
        }
    }
