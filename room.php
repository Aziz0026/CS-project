<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Multiplayer</title>

    <link rel="stylesheet" href="/game/css/index.css">
    <link rel="stylesheet" href="/game/css/room.css">

    <script src="/game/js/events.js"></script>
    <script src="/game/js/game.js"></script>
</head>

<body>

<div class="split left">
    <div class="">
        <h3 id="name">
            Hello,
            <?php

            $row = null;
            $creator_name = $_POST["username"];

            echo $creator_name;

            $db = new Database();

            $db->createPlayer($creator_name);

            $result = $db->searchPlayerByName($creator_name);

            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();

                $db->createRoom($row["id"]);
            }

            ?>
        </h3>

        <div style="margin-left: 35px">
            <h3>You just created room :)</h3>
            <h3>------------------------------------</h3>
            <b><h3>Room ID: <span style="color: red"><?php $room = $db->searchRoomByCreator($row["id"]); echo $room["id"]?></span></h3>
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
                <h2><span id="user"><?php echo $_POST['username'] . '(X):' ?></span></h2>
                <h2><span id="computer">Second user:</span></h2>
                <h2 id="draw">Draw:</h2>
            </header>
        </div>
    </div>
</div>
</body>
</html>


