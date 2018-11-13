function openMenu() {
    replaceFilename('menu.html', 'welcome.html');
};

function openPage(filename){
    replaceFilename(filename, 'menu.html');
}

function replaceFilename(newFile, oldFile) {
    var re = oldFile;
    var currnetUrl = window.location.href;
    var newUrl = currnetUrl.replace(re, newFile);
    window.open(newUrl, '_self');
}

function backToMenu(fileName) {
    replaceFilename('menu.html', fileName);
}
