<?php
/**
 * Created by Nick on 17 feb. 2020.
 * Copyright © ImSpooks
 */

namespace controller;

interface IController {

    /**
     * @param array $data
     * @return mixed
     */
    function generateContent(array $data);
}