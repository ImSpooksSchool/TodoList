<?php
/**
 * Created by Nick on 19 feb. 2020.
 * Copyright © ImSpooks
 */

use objects\TodoStatus;

require_once "util/Enum.php";
require_once "objects/TodoStatus.php";

$status = TodoStatus::getFromId(2);