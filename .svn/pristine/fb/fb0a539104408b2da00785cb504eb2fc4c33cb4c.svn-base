<!DOCTYPE html>
<html>
<body>

<canvas id="beerBottle" width="300" height="600"></canvas>

<script>
// get the canvas element
var canvas = document.getElementById('beerBottle');

// get the 2d drawing context
var ctx = canvas.getContext('2d');

// draw the bottle
ctx.beginPath();
ctx.moveTo(140, 50);
ctx.lineTo(160, 50);
ctx.lineTo(170, 550);
ctx.lineTo(130, 550);
ctx.closePath();

// set the color and fill the bottle
ctx.fillStyle = 'brown';
ctx.fill();

// draw the neck of the bottle
ctx.beginPath();
ctx.moveTo(140, 50);
ctx.lineTo(160, 50);
ctx.lineTo(160, 30);
ctx.lineTo(140, 30);
ctx.closePath();

// set the color and fill the neck
ctx.fillStyle = 'gray';
ctx.fill();

// draw the beer inside the bottle
ctx.beginPath();
ctx.moveTo(140, 70);
ctx.lineTo(160, 70);
ctx.lineTo(160, 550);
ctx.lineTo(140, 550);
ctx.closePath();

// set the color and fill the beer
ctx.fillStyle = 'gold';
ctx.fill();

</script>

</body>
</html>
