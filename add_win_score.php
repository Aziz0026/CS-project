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
            if (!is_array($_POST['arguments']) || (count($_POST['arguments']) < 2)) {
                $aResult['error'] = 'Error in arguments!';
            } else {
                $room_id = $_POST['arguments'][0];
                $who = $_POST['arguments'][1];

                $db = new Database();

                if ($who == "creator") {
                    $db->addWinScore($room_id, "X");

                    $aResult['result'] = true;
                } else if ($who == "joiner") {
                    ;
                    $db->addWinScore($room_id, "O");

                    $aResult['result'] = true;
                }
            }
            break;

        default:
            $aResult['error'] = 'Not found function ' . $_POST['functionname'] . '!';
            break;
    }

}

echo json_encode($aResult);


