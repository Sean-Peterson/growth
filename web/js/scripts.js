function Game() {
    this.board = new Board(5,5)
}

function Board(x,y) {
    this.x = x,
    this.y = y,
    this.grid = createArray(this.x,this.y);
}

Board.prototype.fill = function() {
    for (var i=0;i<this.x;i++) {
        for (var j=0;j<this.y;j++) {
            this.grid[i][j] = new Tile(i,j);
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

function Tile(x,y) {
    this.xPos=50*x,
    this.yPos=50*y,
    this.height=50,
    this.width=50,
    this.active = false;
}

Tile.prototype.draw = function(ctx) {

    ctx.beginPath();
    ctx.rect(this.xPos,this.yPos,this.width,this.height);
    ctx.stroke();
    ctx.fillStyle = "green";
    ctx.fill();
    ctx.closePath();
}

function playerClick(canvas) {
    $('canvas').click(function(e){
        var bb = canvas.getBoundingClientRect();
        var x = e.clientX - bb.left;
        var y = e.clientY - bb.top;
        console.log(x+", "+y);
        
    });
}


$(document).ready(function(){
    var canvas = document.getElementById("canvas");
    var ctx = canvas.getContext("2d");


    var game = new Game;
    game.board.fill();

    playerClick(canvas);

    function draw(){
        ctx.clearRect(0,0,canvas.width,canvas.height);
        game.board.draw(ctx);
    }
    drawInterval = setInterval(draw, 10);
})
