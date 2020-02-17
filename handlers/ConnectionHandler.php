<?php
/**
 * Created by Nick on 17 feb. 2020.
 * Copyright © ImSpooks
 */

namespace handlers;

use PDO;

class ConnectionHandler {

    private PDO $connection;

    public function __construct(string $host, string $db_name, string $user, string $password) {
        $options = array(PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC, PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING);

        $connection = new PDO(sprintf("mysql:host=%s;dbname=%s;charset=%s", $host, $db_name, "utf8"), $user, $password, $options);
        $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }

    /**
     * @return PDO
     */
    public function getConnection(): PDO {
        return $this->connection;
    }


}