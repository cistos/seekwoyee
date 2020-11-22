<?php

namespace Seekwoyee\Trees\Bst;
    use InvalidArgumentException;
    use Seekwoyee\Trees\AbstractTreeManager;
    use Seekwoyee\Trees\NodeUserTemplate;

    /**
     * Class TreeManagerBst - класс упрвления структурой дерева типа BST
     * @package Seekwoyee\Trees\Bst
     */
    final class TreeManagerBst extends AbstractTreeManager {
        protected NodeUserTemplate $userPropsTemplate;
        protected int $height;
        private int $heightLimit = 32; // предел для 32-разрядных систем для int, да вряд ли кому нужно большое количество нод
        private int $inheritLimit = 2; // максимальное количество поддеркевьев у каждого нода

        public function __construct(int $height, NodeUserTemplate $userPropsTemplate)
        {
            if ($height > $this->heightLimit) {
                throw new InvalidArgumentException();
            }
            parent::__construct($height, $userPropsTemplate);
        }




        /**
         * Получить идентификатор корневого нода
         * @return int
         */
        public function getRootId(): int {
            return 2**($this->height - 1) - 1;
        }
    }
