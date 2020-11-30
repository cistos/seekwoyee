<?php

namespace Seekwoyee\Trees;

/**
 * Interface ExtTreeManagerInterface - позволяет использовать менеджер дерева в функциях общего значения
 * @package Seekwoyee\Trees
 */
interface ExtTreeManagerInterface {
    public function getLastError(): string;
}