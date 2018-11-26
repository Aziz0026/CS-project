function openPage(filename, from) {
    replaceFilename(filename, from);
}

function replaceFilename(newFile, oldFile) {
    let re = oldFile;
    let currentUrl = window.location.href;
    let newUrl = currentUrl.replace(re, newFile);
    window.open(newUrl, '_self');
}

function getName() {
    let person = prompt('Please, enter your name:');

    if (person != null){
        if (person !== "") {
            openPage('room.php', 'multiplayer.html');

            sessionStorage.setItem('name', person);
        } else {
            alert("Firstly, you should enter your name!");

        }
    }
}

function getRoomId() {
    let room = prompt('Please, enter the room ID that you want to join :)');

    if(room != null){

    }
}