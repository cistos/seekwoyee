<?php

namespace Seekwoyee\Trees;

/**
 * Class AbstractTreeManager - базовый класс для менеджеров деревьев
 * @package Seekwoyee\Trees
 */
abstract class AbstractTreeManager implements ExtTreeManagerInterface {
    protected NodeUserTemplate $userPropsTemplate;
    protected int $height;

    public function __construct(int $height, NodeUserTemplate $userPropsTemplate)
    {
        $this->userPropsTemplate = $userPropsTemplate;
        $this->height = $height;
    }

    /**
     * Установить пользовательские параметры для нода
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

    abstract public function getRootId():int;
}