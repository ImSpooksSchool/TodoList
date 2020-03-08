<?php
/**
 * Created by Nick on 17 feb. 2020.
 * Copyright © ImSpooks
 */

namespace objects;

use MyCLabs\Enum\Enum;

/**
 * @method static self NOT_STARTED()
 * @method static self STARTED()
 * @method static self FINISHED()
 */
class TodoStatus extends Enum {
    const NOT_STARTED = 0;
    const STARTED = 1;
    const FINISHED = 2;

    public static function getFromId(int $id): TodoStatus {
        foreach (self::toArray() as $name => $value) {
            if ($id === $value) {
                return self::$name();
            }
        }
        return self::NOT_STARTED();
    }
}