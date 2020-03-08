<?php
/**
 * Created by Nick on 17 feb. 2020.
 * Copyright © ImSpooks
 */

namespace controller;

class MainController extends AbstractController {

    public function __construct() {
        parent::__construct();
    }

    public function index(array $data): bool {
        echo json_encode($this->connectionHandler->sendQuery("SELECT * FROM members WHERE id=:id", ["id" => 1])) . "<br>";
        return true;
    }


    public function test(array $data): bool {
        return true;
    }


}