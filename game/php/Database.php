<?php

class Database
{
    private $sql_string;
    private $db, $host = "localhost", $username = "root", $password = "", $db_name = "tic-tac-toe";

    function __construct()
    {
        $this->db = new  mysqli($this->host, $this->username, $this->password, $this->db_name);
    }

    public function createPlayer($player_name){

    }
}

