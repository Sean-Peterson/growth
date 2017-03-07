function Game() {
    this.board = new Board(100,100)
    this.log = [];
    this.playerArray = [new Player(0,"string"), new Player(1,"potato")];
    this.activePlayer = 0;
    this.run = false;
    this.historyArray = [[],[]];
    this.winner = 0;
    this.steps = 0;

}
Game.prototype.endGame = function() {
    if((this.board.x * this.board.y) === (this.playerArray[0].score + this.playerArray[1].score)){
        if(this.playerArray[0].score > this.playerArray[1].score) {
            this.winner = 0;
        } else {
            this.winner = 1;
        }
        $("#end-game").text("GAME OVER Player 1 score: "+this.playerArray[0].score+" player2score: "+this.playerArray[1].score);

    }
}

Game.prototype.playerClick = function(canvas) {
    var game = this;
    $('canvas').click(function(e){
        var bb = canvas.getBoundingClientRect();
        var x = e.clientX - bb.left;
        var y = e.clientY - bb.top;
        x = Math.floor(x/(500/game.board.x));
        y = Math.floor(y/(500/game.board.y));
        game.board.grid[x][y].active = true;
        game.board.grid[x][y].seed = [x,y];
        game.board.grid[x][y].player = game.activePlayer;
        game.playerArray[game.board.grid[x][y].player].score ++;
        game.historyArray[game.board.grid[x][y].player].push([x,y]);
    });
};


function Player(id,style) {
    this.id = id,
    this.style = "linear",
    this.score = 0,
    this.active = false
    // this.history =
}

function Board(x,y) {
    this.x = x,
    this.y = y,
    this.grid = createArray(this.x,this.y);
}


Board.prototype.grow = function(game) {
    var coords = [];
    for (var i=1;i<this.x-1;i++) {
        for (var j=1;j<this.y-1;j++) {
            if((this.grid[i][j+1].active && this.grid[i][j-1].active && this.grid[i+1][j].active && this.grid[i-1][j].active) && (this.grid[i][j+1].player === this.grid[i][j-1].player && this.grid[i+1][j].player === this.grid[i-1][j].player)) {
                this.grid[i][j].active = true;
                this.grid[i][j].player = this.grid[i][j+1].player;
            }
            if(this.grid[i][j].active){
                this.grid[i][j].age ++;
                // if(i>0 && i < this.x-1 && j>0 && j<this.y-1) {
                //     var direction = Math.floor(Math.random()*4);
                //     if (direction === 3) {
                //         coords.push([i-1,j]);
                //         this.grid[i-1][j].player = this.grid[i][j].player;
                //         this.grid[i-1][j].seed = this.grid[i][j].seed;
                //         this.grid[i][j].active = false;
                //     } else if (direction === 2) {
                //         coords.push([i+1,j]);
                //         this.grid[i+1][j].player = this.grid[i][j].player;
                //         this.grid[i+1][j].seed = this.grid[i][j].seed;
                //         this.grid[i][j].active = false;
                //
                //     } else if (direction === 1) {
                //         coords.push([i,j-1]);
                //         this.grid[i][j-1].player = this.grid[i][j].player;
                //         this.grid[i][j-1].seed = this.grid[i][j].seed;
                //         this.grid[i][j].active = false;
                //
                //     } else if (direction === 0) {
                //         coords.push([i,j+1]);
                //         this.grid[i][j+1].player = this.grid[i][j].player;
                //         this.grid[i][j+1].seed = this.grid[i][j].seed;
                //         this.grid[i][j].active = false;
                //
                //     }
                // }
                if(i>0){
                    if(!(this.grid[i-1][j].active)){
                        if((Math.random()-this.grid[this.grid[i][j].seed[0]][this.grid[i][j].seed[1]].age/100)>.5){
                            coords.push([i-1,j]);
                            this.grid[i-1][j].player = this.grid[i][j].player;
                            this.grid[i-1][j].seed = this.grid[i][j].seed;
                        }
                    }
                }
                if(i<this.x-1){
                    if(!(this.grid[i+1][j].active)){
                        if((Math.random()-this.grid[this.grid[i][j].seed[0]][this.grid[i][j].seed[1]].age/100)>.5){
                            coords.push([i+1,j]);
                            this.grid[i+1][j].player = this.grid[i][j].player;
                            this.grid[i+1][j].seed = this.grid[i][j].seed;
                        }
                    }
                }
                if(j>0){
                    if(!(this.grid[i][j-1].active)){
                        if((Math.random()-this.grid[this.grid[i][j].seed[0]][this.grid[i][j].seed[1]].age/100)>.5){
                            coords.push([i,j-1]);
                            this.grid[i][j-1].player = this.grid[i][j].player;
                            this.grid[i][j-1].seed = this.grid[i][j].seed;
                        }
                    }
                }
                if(j<this.y-1){
                    if(!(this.grid[i][j+1].active)){
                        if((Math.random()-this.grid[this.grid[i][j].seed[0]][this.grid[i][j].seed[1]].age/100)>.5){
                            coords.push([i,j+1]);
                            this.grid[i][j+1].player = this.grid[i][j].player;
                            this.grid[i][j+1].seed = this.grid[i][j].seed;
                        }
                    }
                }
            }
        }
    }
    this.spread(coords, game);
}
Board.prototype.spread = function(coords, game) {
    for (var i=0;i<coords.length;i++) {
        if(!(this.grid[coords[i][0]][coords[i][1]].active)){
            this.grid[coords[i][0]][coords[i][1]].active = true;
            game.playerArray[this.grid[coords[i][0]][coords[i][1]].player].score ++;

        }

    }
}

Board.prototype.fill = function() {
    for (var i=0;i<this.x;i++) {
        for (var j=0;j<this.y;j++) {
            this.grid[i][j] = new Tile(this.x,this.y,i,j);
        }
    }
}

Board.prototype.draw = function(ctx) {
    for (var i=0;i<this.x;i++) {
        for (var j=0;j<this.y;j++) {
            this.grid[i][j].draw(ctx);
        }
    }
}

function createArray(length) {
    var arr = new Array(length || 0),
    i = length;

    if (arguments.length > 1) {
        var args = Array.prototype.slice.call(arguments, 1);
        while(i--) arr[length-1 - i] = createArray.apply(this, args);
    }

    return arr;
}

function Tile(xWidth,yWidth,xPos,yPos) {
    this.xPos=(500/xWidth)*xPos,
    this.yPos=(500/yWidth)*yPos,
    this.height=(500/xWidth)
    this.width=(500/yWidth),
    this.active = false;
    this.age = 0;
    this.player = 0;
    this.seed = [0,0]
}

Tile.prototype.draw = function(ctx) {
    ctx.beginPath();
    ctx.rect(this.xPos,this.yPos,this.width,this.height);
    if(this.player === 0){
        ctx.fillStyle = "rgba(0,60,0,1)";
    } else {
        ctx.fillStyle = "rgba(30,0,30,1)";
    }
    if(this.active) {
        ctx.fill();
    }
    ctx.stroke();
    ctx.closePath();
}




$(document).ready(function(){
    var canvas = document.getElementById("canvas");
    var ctx = canvas.getContext("2d");
    var steps = 110;
    var game = new Game;
    game.board.fill();

    game.playerClick(canvas);

    function draw(){
        ctx.clearRect(0,0,canvas.width,canvas.height);
        if (game.run){
            game.board.grow(game);
            steps += 1;
        }
        console.log(steps);
        if (steps > 20) {
            game.run = false;
            steps = 0;
            console.log(game.historyArray);
        }
        game.board.draw(ctx);
        game.endGame();
        // debugger;
    }

    $('#player1').click(function(){
        game.activePlayer = 0;
    })

    $('#player2').click(function(){
        game.activePlayer = 1;
    })

    drawInterval = setInterval(draw, 100);

    $('#start').click(function(){
        game.run = true;
    })
})
