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

if (isset($_POST["joiner_name"])) {
    if (!$db->checkForName($_POST["joiner_name"])) {
        $room = $_POST["room_id"];

        $creator = $db->getElementFromResult($db->getRoomById($room), "creator_name");

        $joiner = $_POST["joiner_name"];

        $db->addJoinerToRoom($_POST["joiner_name"], $room);
    } else {
        echo "<script>openPage('multiplayer.php','joiner_room.php'); alert('Please, choose another name. This name is already in usage. Create a new one :)');</script>";
    }
}

?>

<body>

<div class="split left">
    <div class="">
        <h3 id="name">
            Hello,
            <span id="player_name">
                <?php
                echo $joiner;
                ?>
            </span>
        </h3>


        <div style="margin-left: 35px">
            <h3>You just joined room:)</h3>
            <h3>------------------------------------</h3>
            <b><h3>Room ID: <span style="color: red" id="room"><?php echo $room ?></span></h3>
            </b>
        </div>
    </div>
</div>

<div class="split right">
    <div class="">

        <form class="modal-content animate" method="post" action="http://127.0.0.1:3000/multiplayer.php">
            <div class="container">
                <input type="hidden" name="room_id" value="<?php echo htmlspecialchars($room) ?>">
                <button class="button button5"><b>Back to multiplayer</b></button>
            </div>
        </form>


        <div class="text-center" id="box">
            <header><h1>Play Tic Tac Toe</h1></header>
            <ul id="gameBoard">
                <li class="tic" id="0" onclick="setShape(0, 'O')">#</li>
                <li class="tic" id="1" onclick="setShape(1, 'O')">#</li>
                <li class="tic" id="2" onclick="setShape(2, 'O')">#</li>
                <li class="tic" id="3" onclick="setShape(3, 'O')">#</li>
                <li class="tic" id="4" onclick="setShape(4, 'O')">#</li>
                <li class="tic" id="5" onclick="setShape(5, 'O')">#</li>
                <li class="tic" id="6" onclick="setShape(6, 'O')">#</li>
                <li class="tic" id="7" onclick="setShape(7, 'O')">#</li>
                <li class="tic" id="8" onclick="setShape(8, 'O')">#</li>
            </ul>
            <script>
                blockCells();

                document.write('<footer><button id="reset" onclick="reset()">Reset</button></footer>' + '</div>');
            </script>
        </div>

        <div>
            <h1>Scores</h1>
            <header class="score">
                <h2><span id="user"><?php echo $creator . "(X)" ?></span></h2>
                <h2><span id="computer"><?php echo $joiner . "(O)" ?></span></h2>
                <h2 id="draw">Draw:</h2>
            </header>
        </div>
    </div>
</div>
</body>
</html>

<script>
    setInterval(myTimer, 500);

    let player_name = getTextById('player_name').replace(/\s/g, '');

    function myTimer() {
        jQuery.ajax({
                type: "POST",
                url: 'update_grid.php',
                dataType: 'json',
                data: {functionname: 'update', arguments: [getTextById('room'), player_name]},

                success: function (obj, textstatus) {
                    if (!('error' in obj)) {
                        yourVariable = obj.result[0];

                        if (yourVariable !== "") {
                            if (checkForBothWin(yourVariable)) {
                                console.log("Win");

                                blockCells();
                            } else {
                                checkForMoves(getTextById('room'));
                            }
                            redraw(yourVariable);
                        } else {
                            redraw(obj.result[1]);

                            if (checkForBothWin(obj.result[1])) {
                                console.log("Win");

                                blockCells();
                            } else {
                                reloadOnClickMethods('O');

                                checkForMoves(getTextById('room'));
                            }
                        }


                    } else {
                        console.log(obj.error);
                    }
                }
            }
        );
    };
</script>