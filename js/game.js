let
    game = {
        user: '',
        computer: '',
        currentPlayer: '',
        moves: 1,
        status: 'on'
    };

let
    winMoves = [
        [0, 1, 2],
        [3, 4, 5],
        [6, 7, 8],
        [0, 3, 6],
        [1, 4, 7],
        [2, 5, 8],
        [0, 4, 8],
        [2, 4, 6]
    ];

let
    score = {
        user: 0,
        computer: 0,
        draw: 0
    };

function setFigure() {
    let random = Math.floor(Math.random() * 2);
    if (random === 0) {
        game.user = 'X';
        game.computer = 'O';
    } else {
        game.user = 'O';
        game.computer = 'X';
    }
}

function setScore() {
    getElementById('computer').textContent = "AI(" + game.computer + "): " + score.computer;
    getElementById('user').textContent = "You(" + game.user + "): " + score.user;
    refreshDrawScore();
}

function refreshDrawScore() {
    getElementById('draw').textContent = "Draw: " + score.draw;
}

function setCurrentPlayer(currentPlayer) {
    game.currentPlayer = currentPlayer;
}

function initMove() {
    game.status = 'on';
    setFigure();
    let randomCellId = Math.floor(Math.random() * 9);
    getElementById(randomCellId).textContent = game.computer;
    getElementById(randomCellId).onClick = null;
    setCurrentPlayer('user');
    setScore();
}

function play(cellId) {
    if (getTextById(cellId) === '#' && game.status === 'on') {
        if (game.currentPlayer === 'user') {
            progress(game.user, 'computer', cellId);
        } else if (game.currentPlayer === 'computer') {
            progress(game.computer, 'user', cellId)
        }

        game.moves++;
        checkForDraw();

        if (game.currentPlayer === 'computer') {
            compThinking();
        }
    }
}

function progress(curPlayer, nextPlayer, cellId) {
    getElementById(cellId).textContent = curPlayer;
    getTextById(cellId).onClick = null;
    gameStatus();
    checkForDraw();
    setCurrentPlayer(nextPlayer);
}

function gameStatus() {
    let counter = 0;
    while (counter !== 8) {
        if (checkForWin(winMoves[counter])) {
            changeCellsBackground(winMoves[counter]);
            incrementScore();
            setScore();
            game.status = 'off';
            game.moves--;
            break;
        }
        counter++;
    }
}

function checkForDraw() {
    if (game.moves === 9) {
        score.draw++;
        refreshDrawScore();
    }
}

function checkForWin(array) {
    let currentPlayerChar;

    if (game.currentPlayer === 'user') {
        currentPlayerChar = game.user;
    } else {
        currentPlayerChar = game.computer;
    }

    if (getTextById(array[0]) === currentPlayerChar && getTextById(array[1]) === currentPlayerChar && getTextById(array[2]) === currentPlayerChar) {
        return true;
    }
    return false;
}

function reset() {
    let counter = 0;
    while (counter !== 9) {
        document.getElementById(counter).textContent = '#';
        document.getElementById(counter).style.backgroundColor = 'black';
        counter++;
    }
    game.moves = 1;
    initMove();
}

function changeCellsBackground(array) {
    let counter = 0;
    while (counter !== 3) {
        let element = getElementById(array[counter])
        element.style.backgroundColor = '#14e715';
        counter++;
    }
}

function compThinking() {
    let counter = 0;
    while (counter !== 9) {
        if (checkingForEmptyCell(counter)) {
            play(counter);
            break;
        }
        counter++;
    }
}

function incrementScore() {
    if (game.currentPlayer === 'user') {
        score.user++;
    } else {
        score.computer++;
    }
}

function getCurrentBoard() {
    let currentBoard = [];
    let counter = 0;
    while (counter !== 9) {
        currentBoard.push(getTextById(counter));
        counter++;
    }
    return currentBoard;
}

function checkingForEmptyCell(cellId) {
    let cellText = getTextById(cellId)
    if (cellText !== game.user && cellText !== game.computer) {
        return true;
    }
    return false;
}

function getElementById(id) {
    return document.getElementById(id)
}

function getTextById(id) {
    return document.getElementById(id).textContent
}

