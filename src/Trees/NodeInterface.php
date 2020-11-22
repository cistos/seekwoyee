<?php

namespace Seekwoyee\Trees;

/**
 * Interface NodeInterface - единый интерфейс для нодов деревьев
 * @package Seekwoyee\Trees
 */
interface NodeInterface {
    public function getId(): int;
    public function setUserProperty(string $prop, $value): void;
}