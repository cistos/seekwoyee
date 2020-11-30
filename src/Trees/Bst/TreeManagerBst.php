<?php

namespace Seekwoyee\Trees\Bst;
    use InvalidArgumentException;
    use Seekwoyee\Trees\AbstractTreeManager;
    use Seekwoyee\Trees\NodeInterface;
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
         * Создает новый нод на основе другого элемента, пока пользовательские данные менять надо отдельно
         * @param ?int $parentId - на основе человека создается новый нод, если есть параметр рекурсиновсти, то на основе из нода из этого поддерева
         * @param array $nodes <NodeBst> - список нодов из Tree
         * @param bool $allowRecursive - искать место рекурсивно если true и false, если среди непосредственных наследников
         * @param bool $fromLeft - c какой стороны осуществляется добавление нода
         * @return NodeInterface|null - return created NodeBst object, otherwise null
         */
        public function prototypeNode(?int $parentId, array $nodes, bool $allowRecursive = false, bool $fromLeft = true): ?NodeBst
        {
            $createdNode = null;
            $parentId = $parentId === null ? $this->getRootId() : $parentId;
            if (!key_exists($parentId, $nodes)) {
                $this->setLastError("Parent node not found");
            } elseif ($allowRecursive === false && $this->getCountNodeSubtrees($parentId, $nodes) == $this->inheritLimit) {
                $this->setLastError("It node yet have maximum childes");
            } elseif ($this->getCountNodeSubtrees($parentId, $nodes) < $this->inheritLimit) {
                $createdNode = clone $nodes[$parentId];
                $level = $this->getLevel($parentId);
                $leftItem = $parentId - 2**($level - 1);
                $rightItem = $parentId + 2**($level - 1);
                if (!key_exists($rightItem, $nodes) || (key_exists($leftItem, $nodes) && key_exists($rightItem, $nodes) && $fromLeft === true)) {
                    $createdNode->setId($leftItem);
                } else {
                    $createdNode->setId($rightItem);
                }
                $createdNode->setParentId($parentId);
            } else {
                // @todo использовать итератор
                $level = $this->getLevel($parentId);
                if ($level == $this->height) {
                    $this->setLastError("It parent id can`t have childes, cause arranged in lowest level");
                } else {
                    $freeId = $this->getFreeTreeId($nodes, $level, $parentId, $fromLeft);
                    if ($freeId === null) {
                        $this->setLastError('Haven`t space in Tree for node');
                    } else {
                        $createdNode = clone $nodes[$parentId];
                        $createdNode->setId($freeId);
                        $parentId = $this->calcParentId($freeId);
                        $createdNode->setParentId($parentId);
                    }
                }
            }

            return $createdNode;
        }

        /**
         * @todo - использовать в будущем итератор
         * Get count node subtrees
         * @param int $parentId - target node
         * @param array $nodes <NodeBst>
         * @return int - subtree count
         */
        private function getCountNodeSubtrees(int $parentId, array $nodes): int  {
            $count = 0;
            foreach ($nodes as $node) {
                if ($node->getParentId() === $parentId) {
                    $count++;
                }
            }
            return $count;
        }

        /**
         * Вычисляется id родительского элемента
         * @param int $id
         * @return int
         */
        private function calcParentId(int $id): int {
            $level = $this->getLevel($id);
            $shift = 2**($this->height - $level);
            if (intdiv($id - $shift, 2**($this->height - $level - 2)) === 0) { // если делится это id элемента на 2 уровня выше
                $parentId = $id - $shift;
            } else {
                $parentId = $id + $shift;
            }

            return $parentId;
        }

        /**
         * Определить ярус дерева
         * @param int $id - идентикатор нода
         * @return int чем ниже число тем выше ярус
         */
        private function getLevel(int $id): int {
            $level = 1;
            for ($i = 1; $i <= $this->height;$i++) {
                if (intdiv($id + 1, $this->height - $i) != 0) {
                    $level = $i;
                    break;
                }
            }
            return $level;
        }

        /**
         *
         * @todo Это всё должно улететь в итератор
         * Рекурсивная функция обхода дерева в глубину, ищется место в дерева куда можно добавить нод
         * @param array $nodes - список нодов с айдишнеиками в ключах, так как в php используется CoW принцип при передаче парметров, то нет затрат по времени и памяти
         * @param int $level - ярус дерева на  котром ведется поиск
         * @param int $parentId - родительский нод, находится на одину ярус выше
         * @param bool $left - сторона с которой ведется обход, true - слева, false - справа
         * @return int|null - int - идектификатора места куда можно вставить нод, null - если такого места нет
         */
        private function getFreeTreeId(array $nodes, int $level, int $parentId, bool $left): ?int {
            $freeId = null;
            $shift = 2**($this->height - $level);
            $firstId = $left ? $parentId - $shift : $parentId + $shift;
            if (!key_exists($firstId, $nodes)) {
                $freeId = $firstId;
            } elseif ($level != $this->height) {
                $freeId = $this->getFreeTreeId($nodes, $level + 1, $firstId, $left);
            }

            // Если не найдено свободных в одном поддереве, то будем искать в другом
            if ($freeId === null) {
                $secondId = !$left ? $parentId - $shift : $parentId + $shift;
                if (!key_exists($secondId, $nodes)) {
                    $freeId = $secondId;
                } elseif ($level != $this->height) {
                    $freeId = $this->getFreeTreeId($nodes, $level + 1, $secondId, $left);
                }
            }

            return $freeId;
        }

        /**
         * Получить идентификатор корневого нода
         * @return int
         */
        public function getRootId(): int {
            return 2**($this->height - 1) - 1;
        }
    }
