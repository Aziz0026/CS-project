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
        case 'check_for':
            if (!is_array($_POST['arguments']) || (count($_POST['arguments']) < 1)) {
                $aResult['error'] = 'Error in arguments!';
            } else {
                $room_id = $_POST['arguments'][0];

                $db = new Database();

                $number = $db->getNumberOfMoves($room_id);

                if ($number == 9) {
                    $aResult['result'] = true;
                }

                $aResult['result'] = false;
            }
            break;

        default:
            $aResult['error'] = 'Not found function ' . $_POST['functionname'] . '!';
            break;
    }

}

echo json_encode($aResult);


