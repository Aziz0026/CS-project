let game = {
    user: '',
    computer: '',
    currentPlayer: '',
    moves: 0,
    status: 'on',
    turn: 'computer'
};

const winMoves = [
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
    getDrawScore();
}

function getDrawScore() {
    getElementById('draw').textContent = "Draw: " + score.draw;
}

function setCurrentPlayer(currentPlayer) {
    game.currentPlayer = currentPlayer;
}

function startOfTheGame() {
    game.status = 'on';
    setFigure();
    if(game.turn === 'computer'){
        let randomCellId = Math.floor(Math.random() * 9);
        getElementById(randomCellId).textContent = game.computer;
        game.moves++;
        setCurrentPlayer('user');
    }
    setScore();
}

function move(cellId) {
    if (getTextById(cellId) === '#' && game.status === 'on') {
        if (game.currentPlayer === 'user') {
            gameProgress(game.user, 'computer', cellId);
        } else if (game.currentPlayer === 'computer') {
            gameProgress(game.computer, 'user', cellId)
        }

        game.moves++;
        checkForDraw();

        if (game.currentPlayer === 'computer' && game.status === 'on') {
            compThinking();
        }
    }
}

function gameProgress(curPlayer, nextPlayer, cellId) {
    getElementById(cellId).textContent = curPlayer;
    gameStatus();
    checkForDraw();
    setCurrentPlayer(nextPlayer);
}

function redraw(array){
    let counter = 0;
    while(counter <= 8){
        let element = getElementById(counter);
        element.textContent = array[counter];
        counter++;
    }
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
        game.status = 'off';
        getDrawScore();
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
    game.moves = 0;
    if(game.turn === 'computer'){
        game.turn = 'user'
    }else{
        game.turn = 'computer';
    }
    startOfTheGame();
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
    move(minimax(getCurrentBoard(), game.computer).index);
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
    let counter = 0;
    let winMove;
    while (counter <= 7) {
        winMove = winMoves[counter];

        if(board[winMove[0]] === playerChar && board[winMove[1]] === playerChar && board[winMove[2]] === playerChar) {
            return true;
        }
        counter++;
    }
      return false;
}
