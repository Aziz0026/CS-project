<?php

class Database
{
    private $serverName = "localhost";
    private $dbName = "tic-tac-toe";
    private $userName = "root";
    private $password = "";
    private $connection;

    private function __construct()
    {
        $this->connection = new mysqli($this->serverName, $this->userName, $this->password, $this->dbName);
    }


    private function createPlayer($player_name)
    {
        $queryString = "INSERT INTO player (name) VALUES (" . $player_name . ");";

        $this->checkForResult($queryString);
    }

    private function createRoom($player_id)
    {
        $queryString = "INSERT INTO room (creator_id) VALUES (" . $player_id . ");";

        $this->checkForResult($queryString);

    }

    private function createCells($room_id)
    {
        for ($i = 0; $i < 10; $i++) {

            $queryString = "INSERT INTO cell (room_id, index_id) VALUES (${room_id}, ${i});";
            $this->checkForResult($queryString);
        }
    }

    private function checkForResult($queryString)
    {
        if ($this->connection->query($queryString) === TRUE) {
            echo 'alert("Record was successfully created")';
        } else {
            echo "Error: " . $queryString;
        }
    }
}

