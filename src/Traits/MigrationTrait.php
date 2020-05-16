<?php

namespace App\Traits;

/**
 * Вспомогательные методы для миграций
 *
 * @package App\Traits
 */
trait MigrationTrait
{
    /**
     * Возвращает значение константы
     *
     * @param mixed $constant
     *
     * @return mixed
     */
    private function getConstant($constant)
    {
        return $constant;
    }

    /**
     * Возвращает максимальное значение идентификатора
     *
     * @param int[] $values
     *
     * @return int
     */
    private function getMaxValueId(array $values) : int
    {
        array_walk($values, static function (&$val, $idx){ $val = (int) $val; });

        $values = array_filter($values);

        if (!$values) {
            return 1;
        }

        return max($values);
    }
}
