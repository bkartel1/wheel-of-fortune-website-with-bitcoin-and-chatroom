//0=>dot, 1=>ring 
var dotORrings=['.plane.main .circle::before, .plane.main .circle::after','.plane.main .circle'];
//0=>gray,1=>green, 2=>blue, 3=>orange
var rainbow=array('#666','#32cd32','#45B5DA ','#FFC870 ');

var randomInt = function(min,max)
{
    return Math.floor(Math.random()*(max-min+1)+min);
};

var randomWidth = function(){
	randomWidth = randomInt(30,200);
	randomWidth=randomWidth+'px';

	return randomWidth;
};

var randomRainbow = function(){
	randomness = randomInt(0,3);

	return rainbow[randomness];
};

var randomDotORring = function(){
	randomNo = randomInt(0,1); 

	return dotORrings[randomNo];
};

var startRoll= function(){
	//change roll widthsto 20 do colour thing
	color1 = randomRainbow();
	color2 = randomRainbow();
	//dot 
	$(dotORrings[0]).css('background: '. color2 .' ; box-shadow: 0 0 60px 2px '. color2 .';');
	//ring
	$(dotORrings[1]).css('box-shadow: 0 0 60px '. color1.' , inset 0 0 60px  '. color1 .';');
};

var changeColor= function(){
rDotORring = randomDotORring();
rRainbow = randomRainbow();
//randomly change colours - either dot or ring
$(rDotORring).css(rRainbow);
//change dot width randomly
rpercentage= randomInt(2,100);
$(dotORrings[0]).css('width: '. rpercentage .'%;  height: '. rpercentage .'%;');
};

var endRoll= function(result){
//gradually change hebu suguka to 300px
$('.plane').css(' width: 300px; height: 300px;');
//change to final result colour - both ring and dot
fcolor = rainbow[result];
//1.  for dots
$(dotORrings[0]).css('background: '. fcolor .' ; box-shadow: 0 0 60px 2px '. fcolor .';');
$(dotORrings[0]).css('width: 10%;  height: 10%;');
//2.  for rings
$(dotORrings[1]).css('box-shadow: 0 0 60px '. fcolor.' , inset 0 0 60px  '. fcolor .';');
};

var doRool=function(){
startroll(); 
setInterval(function(){
changeColor();
},500);
endRoll();
};