<?php

namespace Seekwoyee\Trees;

/**
 * Interface NodeInterface - единый интерфейс для нодов деревьев
 * @package Seekwoyee\Trees
 */
interface NodeInterface {
    public function getId(): int;
    public function setId(int $id): void;
    public function setUserProperty(string $prop, $value): void;
    public function getUserProperty(string $prop);
    public function setParentId(int $id): bool;
    public function getParentId(): ?int;
    public function setUserPropsNoNull(): int; //  возвращает количество обнуленных свойств
}