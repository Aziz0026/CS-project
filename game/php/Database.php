<?php

class Database
{
    private $db = null;
    private $host = "localhost:3306", $username = "root", $password = "Standart1", $db_name = "tic";

    function __construct()
    {
        $this->db = mysqli_connect($this->host, $this->username, $this->password, $this->db_name);

        if ($this->db != false) {
            echo "<script>console.log('works');</script>";
        }

    }

    public function createPlayer($player_name)
    {
        $query = "INSERT INTO player(name) VALUES ('$player_name');";
        $this->db->query($query);
    }

    public function createRoom($creator_id)
    {
        $query = "INSERT INTO room (creator_id) VALUES ('$creator_id');";
        $this->db->query($query);
    }

    public function searchRoomByCreator($creator_id)
    {
        $query = "SELECT id ,creator_id from room WHERE creator_id IN ($creator_id);";
        return $this->db->query($query);
    }

    public function searchPlayerByName($player_name)
    {
        $query = "SELECT id , name from player WHERE name IN ('$player_name');";
        return $this->db->query($query);
    }
}