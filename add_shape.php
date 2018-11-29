<?php
header('Content-Type: application/json');

include 'game/php/Database.php';

$aResult = array();

if (!isset($_POST['functionname'])) {
    $aResult['error'] = 'No function name!';
}

if (!isset($_POST['arguments'])) {
    $aResult['error'] = 'No function arguments!';
}

if (!isset($aResult['error'])) {
    switch ($_POST['functionname']) {
        case 'add':
            if (!is_array($_POST['arguments']) || (count($_POST['arguments']) < 4)) {
                $aResult['error'] = 'Error in arguments!';
            } else {
                $room_id = $_POST['arguments'][0];
                $player_name = $_POST['arguments'][1];
                $index = $_POST['arguments'][2];
                $shape = $_POST['arguments'][3];

                $db = new Database();

                $db->updateCell($room_id, $player_name, $index, $shape);

                if ($shape == "X") {
                    $db->updateTurn($room_id, $db->getJoinerByRoomId($room_id));
                } else if ($shape == "O") {
                    $db->updateTurn($room_id, $db->getCreatorByRoomId($room_id));
                }

                $result = $db->getPositionsOfGrid($room_id);

                $aResult['result'] = $result;
            }
            break;

        default:
            $aResult['error'] = 'Not found function ' . $_POST['functionname'] . '!';
            break;
    }

}

echo json_encode($aResult);


