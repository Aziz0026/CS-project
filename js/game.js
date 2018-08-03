let game = {
    user: '',
    computer: '',
    currentPlayer: '',
    moves: 1,
    status: 'on',
    turn: 'user'
};

let winMoves = [
    [0, 1, 2],
    [3, 4, 5],
    [6, 7, 8],
    [0, 3, 6],
    [1, 4, 7],
    [2, 5, 8],
    [0, 4, 8],
    [2, 4, 6]
];

let score = {
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

    return getTextById(array[0]) === currentPlayerChar && getTextById(array[1]) === currentPlayerChar && getTextById(array[2]) === currentPlayerChar;

}

function reset() {
    let counter = 0;
    while (counter !== 9) {
        document.getElementById(counter.toString()).textContent = '#';
        document.getElementById(counter.toString()).style.backgroundColor = 'black';
        counter++;
    }
    game.moves = 1;
    initMove();
}

function changeCellsBackground(array) {
    let counter = 0;
    while (counter !== 3) {
        let element = getElementById(array[counter]);
        element.style.backgroundColor = '#14e715';
        counter++;
    }
}

function compThinking() {
    /*let counter = 0;
    while (counter !== 9) {
        if (checkingForEmptyCell(counter)) {
            play(counter);
            break;
        }
        counter++;
    }*/

    play(minimax(getCurrentBoard(), game.computer).index);
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
        if (getTextById(counter) === "#") {
            currentBoard.push(counter);
        } else {
            currentBoard.push(getTextById(counter));
        }
        counter++;
    }
    return currentBoard;
}

function checkingForEmptyCells(board) {
    return board.filter(s => s !== "O" && s !== "X");

    /*let cellText = getTextById(cellId)
    if (cellText !== game.user && cellText !== game.computer) {
        return true;
    }
    return false;*/
}

function getElementById(id) {
    return document.getElementById(id)
}

function getTextById(id) {
    return document.getElementById(id).textContent
}

function minimax(newBoard, player) {

    let availSpots = checkingForEmptyCells(newBoard);

    if (winning(newBoard, game.user)) {
        return {score: -10};
    }
    else if (winning(newBoard, game.computer)) {
        return {score: 10};
    }
    else if (availSpots.length === 0) {
        return {score: 0};
    }

    let moves = [];

    for (let i = 0; i < availSpots.length; i++) {
        let move = {};
        move.index = newBoard[availSpots[i]];

        newBoard[availSpots[i]] = player;

        if (player === game.computer) {
            let result = minimax(newBoard, game.user);
            move.score = result.score;
        }
        else {
            let result = minimax(newBoard, game.computer);
            move.score = result.score;
        }

        newBoard[availSpots[i]] = move.index;

        moves.push(move);
    }

    let bestMove;
    if (player === game.computer) {
        let bestScore = -10000;
        for (let i = 0; i < moves.length; i++) {
            if (moves[i].score > bestScore) {
                bestScore = moves[i].score;
                bestMove = i;
            }
        }
    } else {

        let bestScore = 10000;
        for (let i = 0; i < moves.length; i++) {
            if (moves[i].score < bestScore) {
                bestScore = moves[i].score;
                bestMove = i;
            }
        }
    }

    return moves[bestMove];
}

function winning(board, playerChar) {
    return (board[0] === playerChar && board[1] === playerChar && board[2] === playerChar) ||
        (board[3] === playerChar && board[4] === playerChar && board[5] === playerChar) ||
        (board[6] === playerChar && board[7] === playerChar && board[8] === playerChar) ||
        (board[0] === playerChar && board[3] === playerChar && board[6] === playerChar) ||
        (board[1] === playerChar && board[4] === playerChar && board[7] === playerChar) ||
        (board[2] === playerChar && board[5] === playerChar && board[8] === playerChar) ||
        (board[0] === playerChar && board[4] === playerChar && board[8] === playerChar) ||
        (board[2] === playerChar && board[4] === playerChar && board[6] === playerChar);
}
