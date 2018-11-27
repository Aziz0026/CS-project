<!DOCTYPE html>
<html>
<head>
    <title>Multiplayer</title>
    <link rel="stylesheet" href="/game/css/index.css">
    <link rel="stylesheet" href="/game/css/general.css">
    <link rel="stylesheet" href="/game/css/name_form.css">

    <?php include 'game/php/Database.php'; ?>

    <script src="/game/js/events.js"></script>
</head>

<?php
$db = new Database();

if (isset($_POST["finish"])) {
    $room_id = $_POST["room_id"];


    $db->destroyRoom($room_id);

    $db->deleteCellsByRoom($room_id);
} else if ($_POST["room_id"]) {
    $db->removeJoiner($_POST["room_id"]);
}

?>

<script>
    document.write('<div id="back"><h3 class="success" onclick="openPage(\'menu.html\', \'multiplayer.php\')">Back to menu</h3></div>');
</script>

<div id="header">
    <h1>Multiplayer</h1>
    <hr>
</div>

<div id="buttons">
    <div class="button_cont" align="center" onclick="document.getElementById('id02').style.display='block'"
         style="width: 95px">
        <a id="join_room" target="_blank" rel="nofollow noopener">Join</a>
    </div>
    <div class="button_cont" align="center" onclick="document.getElementById('id01').style.display='block'">
        <a id="create_room" target="_blank" rel="nofollow noopener">Create</a>
    </div>
</div>

<div id="id01" class="modal">

    <form class="modal-content animate" method="post" action="http://localhost:3000/creator_room.php">
        <div class="container">
            <label><b>Please, enter your name :)</b></label>
            <input type="text" placeholder="Name" name="username" required>
            <button type="submit">Submit</button>
        </div>
    </form>
</div>

<div id="id02" class="modal">

    <form class="modal-content animate" method="post" action="http://localhost:3000/joiner_room.php">
        <div class="container">
            <label><b>Please, enter room that you want to join :)</b></label>
            <input type="text" placeholder="room ID" name="room_id" required>
            <label><b>Please, enter your name :)</b></label>
            <input type="text" placeholder="name" name="joiner_name" required>
            <button type="submit">Submit</button>
        </div>
    </form>
</div>


</body>

<script>
    // Get the modal
    let modal = document.getElementById('id01');
    let modal2 = document.getElementById('id02');

    // When the user clicks anywhere outside of the modal, close it
    window.onclick = function (event) {
        if (event.target === modal) {
            modal.style.display = "none";
        } else if (event.target === modal2) {
            modal2.style.display = "none";
        }
    }
</script>
</html>


