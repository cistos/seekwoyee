<?php

namespace Seekwoyee\Trees;

/**
 * Class AbstractNode - базовый класс для всех классов нода деревьев
 * @package Seekwoyee\Trees
 */
abstract class AbstractNode implements NodeInterface {
    protected int $id;
    protected array $userProps = []; // массив пользовательских параметров
    protected ?int $parentId = null; // по умолчанию для корневого элемента

    public function __construct(int $id, array $params)
    {
        $this->id = $id;

        foreach ($params as $param => $value) {
            $this->userProps[$param] = $value; // @todo сейчас так чуть позже следует создать метод setParams c верификаией по шаблону типа
        }
    }

    /**
     * @param string $property
     * @param $value
     * @todo - сделать верификацию через getType
     * Изменить значение пользовательского свойства
     */
    public function setUserProperty(string $property, $value): void {
        $this->userProps[$property] = $value;
    }

    /**
     * Получение идентификатор родительского элемента
     * @return int|null
     */
    public function getParentId(): ?int
    {
        return $this->parentId;
    }

    /**
     * Контроль о корректности устанавливаемого parentId 
     * @param int $parentId
     * @return bool
     */
    public function setParentId(int $parentId): bool
    {
        return $this->parentId = $parentId;
    }

    /**
     * Обнуляет все пользовательские поля для нода
     * @return int - количество обнуленных показателей, сейчас это кличество всех пользовательских полей
     */
    public function setUserPropsNoNull(): int
    {
        $nulled = 0;
        foreach ($this->userProps as $property => $val) {
            $nulled++;
            $this->userProps[$property] = null;
        }

        return $nulled;
    }

    /**
     * Вовзращает значение пользовательского свойства, если оно есть
     * @param string $property
     * @return mixed|null - либо значение поля, либо null
     */
    public function getUserProperty(string $property)
    {
        $value = null;
        if ($this->existUserProperty($property)) {
            $value = $this->userProps[$property];
        }
        return $value;
    }

    /**
     * @param string $property
     * @return bool - есть ли данное пользовательское свойство
     */
    public function existUserProperty(string $property): bool {
        return key_exists($property, $this->userProps);
    }

    /**
     * get id this node
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId(int $id): void
    {
        $this->id = $id;
    }

}