<?php

namespace Seekwoyee\Trees;

/**
 * Управление и нормирование пользовательских полей нодов
 * Class NodeUserTemplate
 */
class NodeUserTemplate {
    private array $props = [];
    /**
     * Осуществляется динамическое создание свойств шаблона
     * NodeUserTemplate constructor.
     * @param array $params
     */
    public function __construct(array $params)
    {
        foreach ($params as $param => $value) {
            $this->props[$param] = $this->getType($value);
        }
    }

    /**
     * @param $value
     * @return string
     */
    private function getType($value): string
    {
        // @todo пока оставим так, но потом будем использовать get_class, главная проблема тут с анонимными классами
        $type = getType($value);
        if ($type == "NULL" || $type == "unknown type") {
            $type = "string";
        }

        return $type;
    }

    /**
     * Будет использваться при установке пользовательских параметров для нового нода
     * @param array $params - список параметров со значениями которые надо верифицировать
     * @return array - в ключах - название парметра, в значениях true - соотвествует типу, false - не соответствует, null - такого параметра нет
     */
    public function verifyParams(array $params): array
    {
        $arrResult = [];
        foreach ($params as $param => $value) {
            $type = $this->getPropertyType($param);
            if ($type === null) {
                $arrResult[$param] = null;
            } else {
                $arrResult[$param] = $this->props[$param] == $this->getType($value);
            }
        }

        return $arrResult;
    }

    /**
     * Получить тип пользовательского свойства
     * @param string $param
     * @return mixed|null - если null, то параметра не существут, иначе mixed
     */
    private function getPropertyType(string $param) {
        $property = null;
        if (key_exists($param, $this->props)) {
            $property = $this->props[$param];
        }
        return $property;
    }
}