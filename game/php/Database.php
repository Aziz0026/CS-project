<?php

class Database
{
    private $db = null;
    private $host = "127.0.0.1:3306", $username = "root", $password = "Standart1", $db_name = "tic";

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

    public function getElementFromQuery($result, $element)
    {
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                return $row["$element"];
            }
        } else {
            return "0 results";
        }
    }

    public function destroyRoom($room_id)
    {
        $first_query = "SET SQL_SAFE_UPDATES = 0;";
        $second_query = "DELETE FROM room WHERE id = '$room_id';";
        $this->db->query($first_query);
        $this->db->query($second_query);
    }


    public function checkRoomForExisting($creator_id)
    {

        $query = "SELECT id from room WHERE creator_name = '$creator_id';";
        $result = $this->getElementFromResult($this->db->query($query), "id");

        if ($result != "") {
            return true;
        }
        return false;
    }

    public function removeJoiner($room_id)
    {
        $query = "UPDATE room set joiner_name =  null where id = $room_id;";
        $this->db->query($query);
    }

    public function createCell($room_id, $index_id)
    {
        $query = "INSERT INTO cell (room_id, index_id) VALUES (${room_id}, ${index_id});";
        $this->db->query($query);
    }

    public function deleteCellsByRoom($room_id)
    {
        $query = "DELETE FROM cell WHERE room_id = $room_id;";
        $this->db->query($query);
    }

    public function getJoinerByRoomId($room_id)
    {
        $query = "SELECT joiner_name from room where id =  $room_id;";
        $result = $this->getElementFromResult($this->db->query($query), "joiner_name");

        if ($result != "") {
            return $result;
        }
        return null;
    }

    public function updateCell($room_id, $player_name, $index, $shape)
    {
        $query = "UPDATE cell set player_name = '$player_name', shape = '$shape' where room_id = $room_id and index_id = $index;";
        $this->db->query($query);
    }

    public function getPositionsOfGrid($room_id)
    {
        $result = [];

        for ($i = 0; $i < 9; $i++) {
            $shape = $this->getShapeByIndex($i, $room_id);

            if ($shape == null) {
                $result[$i] = "#";
            } else {
                $result[$i] = $shape;
            }
        }

        return $result;
    }

    public function checkForName($name)
    {
        $query = "SELECT id from room  where creator_name = '$name' or joiner_name = '$name';";
        $result = $this->getElementFromResult($this->db->query($query), "id");

        if ($result !== null) {
            //will return true if it is exists
            return true;
        }

        //will return false if it is not exists
        return false;
    }

    public function getShapeByIndex($index_id, $room_id)
    {
        $query = "SELECT shape FROM cell where index_id = $index_id and room_id =  $room_id;";
        return $this->getElementFromResult($this->db->query($query), 'shape');
    }

    public function addTurn($room_id, $whose_turn)
    {
        $query = "INSERT INTO turn (room_id, whose_turn) values ($room_id, '$whose_turn');";
        $this->db->query($query);
    }

    public function getTurnByRoomId($room_id)
    {
        $query = "SELECT whose_turn from turn where room_id = $room_id;";
        return $this->getElementFromQuery($this->db->query($query), 'whose_turn');
    }

    public function getCreatorByRoomId($room_id){
        $query = "SELECT creator_name from room where id =  $room_id;";
        $result = $this->getElementFromResult($this->db->query($query), "creator_name");

        if ($result != "") {
            return $result;
        }
        return null;
    }

    public function deleteTurnByRoomId($room_id)
    {
        $query = "DELETE from turn where room_id = $room_id;";
        $this->db->query($query);
    }

    public function updateTurn($room_id, $whose_turn){
        $query = "UPDATE turn set whose_turn = '$whose_turn' where room_id = $room_id;";
        $this->db->query($query);
    }
}