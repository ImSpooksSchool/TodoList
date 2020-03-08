<?php
/**
 * Created by Nick on 08 Mar 2020.
 * Copyright © ImSpooks
 */


namespace view\init;


interface IVieuw {
    function render($account, $data): void;
}