<?php

class Database
{
    private $db, $host = "127.0.0.1:3306", $username = "root", $password = "Standart1", $db_name = "tic-tac-toe";

    function __construct()
    {
        $this->db = new  mysqli($this->host, $this->username, $this->password, $this->db_name);
    }

    public function createPlayer($player_name)
    {
        $this->db->query("INSERT INTO player(name) VALUES (" . $player_name . ");");
    }

    public function createRoom($creator_id)
    {
        $this->db->query("INSERT INTO room (creator_id) VALUES (" . $creator_id . ");");
    }

    public function searchRoomByCreator($creator_id)
    {
        return $this->db->query("SELECT id ,creator_id from room WHERE creator_id IN (" . $creator_id . ");");
    }

    public function searchPlayerByName($player_name)
    {
        return $this->db->query("SELECT id, name from player WHERE name IN (" . $player_name . ")");
    }
}