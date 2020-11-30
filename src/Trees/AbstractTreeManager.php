<?php

namespace Seekwoyee\Trees;

/**
 * Class AbstractTreeManager - базовый класс для менеджеров деревьев
 * @package Seekwoyee\Trees
 */
abstract class AbstractTreeManager implements ExtTreeManagerInterface {
    protected NodeUserTemplate $userPropsTemplate;
    protected int $height;
    private string $lastError = '';

    public function __construct(int $height, NodeUserTemplate $userPropsTemplate)
    {
        $this->userPropsTemplate = $userPropsTemplate;
        $this->height = $height;
    }

    /**
     * Установка пользовательских свойств с проверкой типов
     * @see AbstractNode::setUserProperty() - здесь можно установить свойства без проверки типов
     * @param NodeInterface $node
     * @param $params
     * @return void
     */
    public function setParams(NodeInterface $node, $params): void {
        $userPropsTemplate = $this->userPropsTemplate;
        $verify = $userPropsTemplate->verifyParams($params);
        foreach ($verify as $key => $value) {
            if ($value === false) {
                trigger_error('Попытка установить значение в поле '.$key. ' значение несоотвествующего шаблону типа', E_USER_WARNING);
            } elseif ($value === null) {
                trigger_error('В шаблоне пользовательских данных нет поля - '.$key, E_USER_NOTICE);
            } else {
                $node->setUserProperty($key, $params[$key]);
            }
        }
    }

    /**
     * Get Tree Manager last error
     * @return string
     */
    public function getLastError(): string
    {
        return $this->lastError;
    }

    /**
     * set Tree Manager error
     * @param string $error
     */
    public function setLastError(string $error): void
    {
        $this->lastError = $error;
    }

    /**
     * Создает новый нод на основе старого
     * @param ?int $parentId - идентификатор нода к котрому привязать новый нод, если null то привязывается к блжайшему в зависимости от $fromLeft,
     * если нода нет в списке, то возвращает null
     * @param array $nodes <NodeInterface> - list nodes Tree, where keys - it`s node ids
     * @param bool $allowRecursive - allow recursive add node, if node with $parentId node yet have max count subtrees
     * @param bool $fromLeft - direction add node, true - add node with id less, than $parentId node, else vice versa
     * @return NodeInterface|null - return created NodeInterface object, otherwise null
     */
    abstract public function prototypeNode(?int $parentId, array $nodes, bool $allowRecursive = false, bool $fromLeft = true): ?NodeInterface;
    abstract public function getRootId():int;
}