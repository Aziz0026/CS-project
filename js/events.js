function openMenu() {
    replaceFilename('menu.html', 'welcome.html');
};

function openSingleplayerGame(filename) {
    replaceFilename('index.html', 'menu.html');
};

function replaceFilename(newFile, oldFile) {
    var re = oldFile;
    var currnetUrl = window.location.href;
    var newUrl = currnetUrl.replace(re, newFile);
    window.open(newUrl, '_self');
}

function backToMenu() {
    replaceFilename('menu.html', 'index.html');
}
