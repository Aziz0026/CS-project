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

    openPage('room.html', 'multiplayer.html');

    sessionStorage.setItem('name', person);
}