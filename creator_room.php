<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Multiplayer</title>

    <link rel="stylesheet" href="/game/css/index.css">
    <link rel="stylesheet" href="/game/css/room.css">

    <script src="/game/js/events.js"></script>
    <script src="/game/js/game.js"></script>

    <script src="game/jQuery/jquery-3.3.1.js"></script>

    <?php include 'game/php/Database.php'; ?>
</head>

<?php

$db = new Database();

$room = null;
$creator = null;
$joiner = null;

if (isset($_POST["username"])) {
    $row = null;
    $creator_name = $_POST["username"];

    $creator = $creator_name;

    if (!$db->checkRoomForExisting($creator_name)) {
        $db->createRoom($creator_name);

        $room = $db->getElementFromResult($db->roomIdByName($creator_name), "id");

        for ($i = 0; $i < 9; $i++) {
            $db->createCell($room, $i);
        }
    }

    $room = $db->getElementFromResult($db->roomIdByName($creator_name), "id");

    $joiner = $db->getElementFromResult($db->getRoomById($room), "joiner_name");
}

?>

<body>

<div class="split left">
    <div class="">
        <h3 id="name">
            Hello,
            <span id="player_name">
                <?php
                echo $creator;
                ?>
            </span>
        </h3>

        <div style="margin-left: 35px">
            <h3>You just created room:)</h3>
            <h3>------------------------------------</h3>
            <b><h3>Room ID: <span style="color: red" id="room"><?php echo $room ?></span></h3>
            </b>
        </div>

        <form class="modal-content animate" method="post" action="multiplayer.php">
            <div class="container">
                <input type="hidden" name="room_id" value="<?php echo htmlspecialchars($room) ?>">
                <button class="button button3" name="finish" onclick="">Finish the game</button>
            </div>
        </form>


    </div>
</div>

<div class="split right">
    <div class="">
        <div class="text-center" id="box">
            <header><h1>Play Tic Tac Toe</h1></header>
            <ul id="gameBoard">
                <li class="tic" id="0" onclick="setShape(0)">#</li>
                <li class="tic" id="1" onclick="setShape(1)">#</li>
                <li class="tic" id="2" onclick="setShape(2)">#</li>
                <li class="tic" id="3" onclick="setShape(3)">#</li>
                <li class="tic" id="4" onclick="setShape(4)">#</li>
                <li class="tic" id="5" onclick="setShape(5)">#</li>
                <li class="tic" id="6" onclick="setShape(6)">#</li>
                <li class="tic" id="7" onclick="setShape(7)">#</li>
                <li class="tic" id="8" onclick="setShape(8)">#</li>
            </ul>

            <script>
                function setShape(index) {
                    let room_id = getTextById('room');
                    let player_name = getTextById('player_name').replace(/\s/g, '');
                    let shape = "X";

                    jQuery.ajax({
                        type: "POST",
                        url: 'add_shape.php',
                        dataType: 'json',
                        data: {functionname: 'add', arguments: [room_id, player_name, index, shape]},

                        success: function (obj, textstatus) {
                            if (!('error' in obj)) {
                                let grid = obj.result;

                                console.log(grid);
                                redraw(grid);
                            } else {
                                console.log(obj.error);
                            }
                        }
                    });

                }

                document.write('<footer><button id="reset" onclick="reset()">Reset</button></footer>' + '</div>');

            </script>
        </div>

        <div>
            <h1>Scores</h1>
            <header class="score">
                <h2><span id="user"><?php echo $creator . "(X)" ?></span></h2>
                <h2><span id="computer">Waiting for player... </span></h2>
                <h2 id="draw">Draw:</h2>
            </header>
        </div>
    </div>
</div>
</body>
</html>

<script>
    let timer = setInterval(myTimer, 1000);

    function myTimer() {
        jQuery.ajax({
            type: "POST",
            url: 'check_for_joiner.php',
            dataType: 'json',
            data: {functionname: 'check', arguments: [getTextById('room')]},

            success: function (obj, textstatus) {
                if (!('error' in obj)) {
                    yourVariable = obj.result;

                    if (yourVariable !== null) {
                        getElementById('computer').innerText = yourVariable + "(O)";

                        clearInterval(timer);
                    }

                    console.log(yourVariable);
                } else {
                    console.log(obj.error);
                }
            }
        });
    };
</script>