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

<body>

<div class="split left">
    <div class="">
        <h3 id="name">
            Hello,
            <?php

            $db = new Database();

            $room = null;
            $creator = null;
            $joiner = null;

            $greeting = "You jus created room :)";


            if (isset($_POST["username"])) {
                $row = null;
                $creator_name = $_POST["username"];

                $creator = $creator_name;

                echo $creator_name;


                $db->createRoom($creator_name);

                $room = $db->getElementFromResult($db->roomIdByName($creator_name), "id");

                $joiner = $db->getElementFromResult($db->getRoomById($room), "joiner_name");

            } else if (isset($_POST["joiner_name"])) {

                $room = $_POST["room_id"];

                $creator = $db->getElementFromResult($db->getRoomById($room), "creator_name");

                $joiner = $_POST["joiner_name"];

                $greeting = "You just joined room:)";


                $db->addJoinerToRoom($_POST["joiner_name"], $room);

                echo $_POST["joiner_name"];
            }

            ?>
        </h3>


        <div style="margin-left: 35px">
            <h3><?php echo $greeting ?></h3>
            <h3>------------------------------------</h3>
            <b><h3>Room ID: <span style="color: red"><?php echo $room ?></span></h3>
            </b>
        </div>
    </div>
</div>


<div class="split right">
    <div class="">
        <script>
            document.write('<div id="back"><h3 class="success" onclick="openPage(\'multiplayer.html\', \'room.php\')">Back to menu</h3></div>');

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


