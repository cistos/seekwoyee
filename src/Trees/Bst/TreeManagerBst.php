<?php

namespace Seekwoyee\Trees\Bst;
    use Seekwoyee\Trees\NodeUserTemplate;

    /**
     * Class TreeManagerBst - класс упрвления структурой дерева типа BST
     * @package Seekwoyee\Trees\Bst
     */
    final class TreeManagerBst extends \Seekwoyee\Trees\AbstractTreeManager {
        private NodeUserTemplate $userPropsTemplate;
        private int $height;
        private int $heightLimit = 33; // предел для 32-разрядных систем для int, да вряд ли кому нужно большое количество нод
        private int $inheritLimit = 2; // максимальное количество поддеркевьев у каждого нода

        public function __construct(int $height, NodeUserTemplate $userPropsTemplate)
        {
            $this->userPropsTemplate = $userPropsTemplate;
            if ($height > $this->heightLimit) {
                throw new \InvalidArgumentException();
            }
            $this->height = $height;
        }

        /**
         * Получить идентификатор корневого нода
         * @return int
         */
        public function getRootId(): int {
            return 2**($this->height - 1) - 1;
        }
    }
