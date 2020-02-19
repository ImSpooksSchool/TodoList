<?php
/**
 * Created by Nick on 17 feb. 2020.
 * Copyright © ImSpooks
 */

namespace controller;

use handlers\ConnectionHandler;

abstract class IController {

    protected ConnectionHandler $connectionHandler;
    public function __construct() {
        $this->connectionHandler = new ConnectionHandler("localhost", "todolist", "php", "3cpTo9ctDX0HZU2g");
    }


    /**
     * @param object $instance
     * @param string $function
     * @param array $data
     * @return mixed
     */
    public function generateContent(object $instance, string $function, array $data): bool {
        return $instance::$function($data);
    }

    public abstract function index(array $data): bool;


}