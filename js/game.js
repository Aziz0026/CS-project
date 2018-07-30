var game = {
  user: '',
  computer: '',
  currentPlayer: '',
  moves: 1,
  status: 'on'
};

var score = {
  user: 0,
  computer: 0
};

function setFigure(){
  random = Math.floor(Math.random() * 2);
  if(random == 0){
    game.user = 'X';
    game.computer =  'O';
  }else{
    game.user = 'O';
    game.computer = 'X';
  }
}

function getPlayersFigures(player){
  if(player == 'computer'){
    document.getElementById('computer').textContent = "AI(" + game.computer + "): 0";
  }else {
    document.getElementById('user').textContent = "You(" + game.user + "): 0";
  }
}

function setCurrentPlayer(currentPlayer){
  game.currentPlayer = currentPlayer;
}

function initMove(){
  game.status = 'on';
  setFigure();
  randomCellId = Math.floor(Math.random() * 9);
  getElementById(randomCellId).textContent = game.computer;
  getElementById(randomCellId).onClick = null;
  setCurrentPlayer('user');
  getPlayersFigures('computer');
  getPlayersFigures('user');
}

function play(cellId){
  if(getTextById(cellId) == '#' && game.status == 'on'){
    if(game.currentPlayer == 'user'){
      progress(game.user, 'computer', cellId);
    }else if(game.currentPlayer == 'computer'){
      progress(game.computer, 'user', cellId)
    }

    if(game.currentPlayer == 'computer'){
      compThinking();
    }
  }
}

function progress(curPlayer, nextPlayer, cellId){
    getElementById(cellId).textContent = curPlayer;
    getTextById(cellId).onClick = null;
    game.moves++;
    gameStatus();
    setCurrentPlayer(nextPlayer);
}

function gameStatus(){
  var currentPlayerChar;

  if(game.currentPlayer == 'user'){
    currentPlayerChar = game.user;
  }else{
    currentPlayerChar = game.computer;
  }

  if(getTextById(0) == currentPlayerChar && getTextById(1) == currentPlayerChar && getTextById(2) == currentPlayerChar){
    changeCellsBackground(0, 1, 2);
    game.status = 'off';
  }else if (getTextById(3) == currentPlayerChar && getTextById(4) == currentPlayerChar && getTextById(5) == currentPlayerChar) {
    changeCellsBackground(3, 4, 5);
    game.status = 'off';
  }else if (getTextById(6) == currentPlayerChar && getTextById(7) == currentPlayerChar && getTextById(8) == currentPlayerChar) {
    changeCellsBackground(6, 7, 8);
    game.status = 'off';
  }else if (getTextById(0) == currentPlayerChar && getTextById(3) == currentPlayerChar && getTextById(6) == currentPlayerChar) {
    changeCellsBackground(0, 3, 6);
    game.status = 'off';
  }else if (getTextById(1) == currentPlayerChar && getTextById(4) == currentPlayerChar && getTextById(7) == currentPlayerChar) {
    changeCellsBackground(1, 4, 7);
    game.status = 'off';
  }else if (getTextById(2) == currentPlayerChar && getTextById(5) == currentPlayerChar && getTextById(8) == currentPlayerChar) {
    changeCellsBackground(2, 5, 8);
    game.status = 'off';
  }else if (getTextById(0) == currentPlayerChar && getTextById(4) == currentPlayerChar && getTextById(8) == currentPlayerChar) {
    changeCellsBackground(0, 4, 8);
    game.status = 'off';
  }else if (getTextById(2) == currentPlayerChar && getTextById(4) == currentPlayerChar && getTextById(6) == currentPlayerChar) {
    changeCellsBackground(2, 4, 6);
    game.status = 'off';
  }else if (game.moves == 9) {
    game.status = 'off';
  }
}

function reset(){
  counter = 0;
  while (counter != 9) {
    document.getElementById(counter).textContent = '#';
    document.getElementById(counter).style.backgroundColor = 'black';
    counter++;
  }
  initMove();
}

function changeCellsBackground(x, y, z){
  var xId = document.getElementById(x),
      yId = document.getElementById(y),
      zId = document.getElementById(z);

  xId.style.backgroundColor = '#14e715';
  yId.style.backgroundColor = '#14e715';
  zId.style.backgroundColor = '#14e715';
}

function compThinking(){
  if(getTextById(0) != game.user && getTextById(0) != game.computer ){
    play(0);
  }else if (getTextById(1) != game.user && getTextById(1) != game.computer) {
    play(1);
  }else if (getTextById(2) != game.user && getTextById(2) != game.computer) {
    play(2);
  }else if (getTextById(3) != game.user && getTextById(3) != game.computer) {
    play(3);
  }else if(getTextById(4) != game.user && getTextById(4) != game.computer){
    play(4);
  }else if(getTextById(5) != game.user && getTextById(5) != game.computer){
    play(5);
  }else if (getTextById(6) != game.user && getTextById(6) != game.computer) {
    play(6);
  }else if (getTextById(7) != game.user && getTextById(7) != game.computer) {
    play(7);
  }else if (getTextById(8) != game.user && getTextById(8) != game.computer) {
    play(8);
  }
}

function getElementById(id){
  return document.getElementById(id)
}

function getTextById(id){
  return document.getElementById(id).textContent
}
