<?php
/**
 * Created by Nick on 17 feb. 2020.
 * Copyright © ImSpooks
 */

namespace objects;

interface Serializable {

    public function serialize(): array;
    public static function deserialize(array $input): self;
}