<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Multiplayer</title>

    <link rel="stylesheet" href="/game/css/index.css">
    <link rel="stylesheet" href="/game/css/room.css">

    <script src="/game/js/events.js"></script>
    <script src="/game/js/game.js"></script>

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
            <?php
            echo $creator;
            ?>
        </h3>


        <div style="margin-left: 35px">
            <h3>You just created room:)</h3>
            <h3>------------------------------------</h3>
            <b><h3>Room ID: <span style="color: red"><?php echo $room ?></span></h3>
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
        <script>
            drawGrid();

            document.write('<footer><button id="reset" onclick="reset()">Reset</button></footer>' + '</div>');

        </script>

        <div>
            <h1>Scores</h1>
            <header class="score">
                <h2><span id="user"><?php echo $creator ?></span></h2>
                <h2><span id="computer"><?php echo $joiner ?></span></h2>
                <h2 id="draw">Draw:</h2>
            </header>
        </div>
    </div>
</div>
</body>
</html>