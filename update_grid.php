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
        case 'update':
            if (!is_array($_POST['arguments']) || (count($_POST['arguments']) < 2)) {
                $aResult['error'] = 'Error in arguments!';
            } else {
                $room = $_POST['arguments'][0];
                $player_name = $_POST['arguments'][1];

                $db = new Database();

                $player_turn = $db->getTurnByRoomId($room);

                if ($player_turn == $player_name) {
                    $aResult['result'][0] = "";
                    $aResult['result'][1] = $db->getPositionsOfGrid($room);
                } else {
                    $aResult['result'][0] = $db->getPositionsOfGrid($room);
                }
            }
            break;

        default:
            $aResult['error'] = 'Not found function ' . $_POST['functionname'] . '!';
            break;
    }

}

echo json_encode($aResult);