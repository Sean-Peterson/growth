function Game() {
    this.board = new Board(100,100)
}

Game.prototype.playerClick = function(canvas) {
    var game = this;
    $('canvas').click(function(e){
        var bb = canvas.getBoundingClientRect();
        var x = e.clientX - bb.left;
        var y = e.clientY - bb.top;
        console.log(x+", "+y);
        x = Math.floor(x/(500/game.board.x));
        y = Math.floor(y/(500/game.board.y));
        game.board.grid[x][y].active = true;
    });
}


function Board(x,y) {
    this.x = x,
    this.y = y,
    this.grid = createArray(this.x,this.y);
}


Board.prototype.grow = function() {
    var coords = [];
    for (var i=0;i<this.x;i++) {
        for (var j=0;j<this.y;j++) {
            if(this.grid[i][j].active){
                this.grid[i][j].age ++;
                if(i>0){
                    if(!(this.grid[i-1][j].active)){
                        coords.push([i-1,j]);
                    }
                }
                if(i<this.x-1){
                    if(!(this.grid[i+1][j].active)){
                        coords.push([i+1,j]);
                    }
                }
                if(j>0){
                    if(!(this.grid[i][j-1].active)){
                        coords.push([i,j-1]);
                    }
                }
                if(j<this.y-1){
                    if(!(this.grid[i][j+1].active)){
                        coords.push([i,j+1]);
                    }
                }
            }
        }
    }
    this.spread(coords);
}
Board.prototype.spread = function(coords) {
    for (var i=0;i<coords.length;i++) {
        this.grid[coords[i][0]][coords[i][1]].active = true;
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
}

Tile.prototype.draw = function(ctx) {
    ctx.beginPath();
    ctx.rect(this.xPos,this.yPos,this.width,this.height);
    ctx.fillStyle = "rgba(0,60,0,"+this.age/100+")";
    if(this.active) {
        ctx.fill();
    }
    // ctx.stroke();
    ctx.closePath();
}




$(document).ready(function(){
    var canvas = document.getElementById("canvas");
    var ctx = canvas.getContext("2d");


    var game = new Game;
    game.board.fill();

    game.playerClick(canvas);

    function draw(){
        ctx.clearRect(0,0,canvas.width,canvas.height);
        game.board.grow();
        game.board.draw(ctx);
    }
    drawInterval = setInterval(draw, 10);
})
