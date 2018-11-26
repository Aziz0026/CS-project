<?php

class Database
{
    private $db = null;
    private $host = "localhost:3306", $username = "root", $password = "Standart1", $db_name = "tic";

    function __construct()
    {
        $this->db = mysqli_connect($this->host, $this->username, $this->password, $this->db_name);
    }

    public function createRoom($creator_name)
    {
        $query = "INSERT INTO room (creator_name) VALUES ('$creator_name');";
        $this->db->query($query);
    }

    public function addJoinerToRoom($joiner_name, $room_id)
    {
        $first_query = "SET SQL_SAFE_UPDATES = 0;";
        $second_query = "UPDATE room SET joiner_name = '${joiner_name}' WHERE id = '${room_id}';";
        $this->db->query($first_query);
        $this->db->query($second_query);
    }

    public function roomIdByName($creator_name)
    {
        $query = "SELECT id from room WHERE creator_name IN ('$creator_name');";
        return $this->db->query($query);
    }

    public function getRoomById($room_id)
    {
        return $this->db->query("SELECT creator_name, joiner_name from room WHERE id = $room_id;");
    }

    public function getElementFromResult($result, $element)
    {
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                return $row["$element"];
            }
        } else {
            echo "0 results";
        }
    }
}