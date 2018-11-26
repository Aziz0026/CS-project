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
        <script>
            document.write('<h3 id="name">' + 'Hello, ' + sessionStorage.getItem('name') + '</h3>');
            document.write('<div style="margin-left: 35px">');
            document.write('<h3>You just created room :)</h3>')
            document.write('<h3>------------------------------------</h3>');
            document.write('<b><h2">Room ID: ' + '<span style="color: red">3213</span>' + '</h3></b>');
            document.write('</div>\n');
        </script>
    </div>
</div>


<div class="split right">
    <div class="">
        <script>
            document.write('<div id="back"><h3 class="success" onclick="openPage(\'multiplayer.html\', \'room.html\')">Back to menu</h3></div>');

            drawGrid();

            document.write('<footer><button id="reset" onclick="reset()">Reset</button></footer>' + '</div>');

            drawScores();
        </script>
    </div>
</div>
</body>
</html>