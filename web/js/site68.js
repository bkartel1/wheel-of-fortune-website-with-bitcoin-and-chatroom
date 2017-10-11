//0=>dot, 1=>ring 
var dotORrings=['.plane.main .circle::before, .plane.main .circle::after','.plane.main .circle'];
//0=>gray,1=>green, 2=>blue, 3=>orange
var rainbow=['#666','#32cd32','#45B5DA ','#FFC870 '];
// gobal server data
var whereWeAt;
var timeout=false;
var lastlistid;
var loggedIn=false;

var doResults=function(){
	//contact server to complete 
	//
	}

var randomInt = function(min,max)
{
    return Math.floor(Math.random()*(max-min+1)+min);
};

var changetimes=randomInt(50,100);

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

var changeColor= function(runwidth){
	color1 = randomRainbow();
	runwidth=runwidth+'px';
	
	$('.plane').css({width: runwidth, height: runwidth});
	//ring colour change
	$(dotORrings[1]).css({'box-shadow': '0 0 60px '+ color1 +',  inset 0 0 60px  '+ color1 });
};

var closeroll=function(rollid){
	$.ajax({
			"url":"site/closeroll",
			"data":"activeroll="+whereWeAt.rollid,
			"success":function(data){
			// do new roll
			data = $.parseJSON(data);
				popupcent(data.message);
				option=["#all-bets-2x","#all-bets-3x","#all-bets-5x","#all-bets-50x"];
				optiontotal=["#all-bets-2x-total","#all-bets-3x-total","#all-bets-5x-total","#all-bets-50x-total"];
	
				$(option[0]).html('');
				$(option[1]).html('');
				$(option[2]).html('');
				$(option[3]).html('');
				
				$(optiontotal[0]).html('0');
				$(optiontotal[1]).html('0');
				$(optiontotal[2]).html('0');
				$(optiontotal[3]).html('0');
				
				rollLoop();
				}
		});
	};

var endRoll= function(){
	color1= rainbow[whereWeAt.gameover];
	$(dotORrings[1]).css({'box-shadow': '0 0 60px '+ color1 +',  inset 0 0 60px  '+ color1 });
	// declare winner
	//do server allocation
	closeroll(whereWeAt.rollid);
	
};

var rollStart=function(){
	timeout=true;
	$.ajax({
			"url":"site/rollstart",
			"success":function(data){
				whereWeAt= $.parseJSON(data);
				console.log(whereWeAt);
				}
		});
	}

var doRool=function(){
	rollStart();
	
	//var timeNo=600;
	var runwidth=300;
	var downup=true;
	
	var startroller= setInterval(function(){
	
	if(runwidth==301){		
		clearInterval(startroller);
		endRoll();		
		}
	else {
			if(downup){
				runwidth--;
			}
			else{
				runwidth++;
				}
			if(runwidth<=0){
			downup=false;
			}
			changeColor(runwidth);
		}		
	//console.log(runwidth);
},100);

};


//++++++++++++++++++++++++start of place bet++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
//var timeout= false;
//login thing
//onclick placebet -> is time up? sorry try in next roll: place bet
//place bet go ahead - enter amount, submit -> ,show on listing below bet,get a success or failure message.
var popupcent= function(windocont){
	//check status: 
$('#betplace').html('<div class="placebet-window toast1"  ><div href=""  id="closebetplace">close</div>'+windocont+'</div> <script>$("#closebetplace").click(function(){ $("#betplace").html("");}); </script>');
//do green background;
};

var popupcentclose= function(){
	//check status: 
$('#betplace').html('');
//listbetters();
//do green background;
};

	
var changepage= function(windocont){
	//check status: 
	$('#content-wrapper').html(windocont);
	//do green background;
};

var betplace= function(betselection){
	if(!loggedIn){
		$('#toast-container').html('<div class="toast toast-notification" style="touch-action: pan-y; -webkit-user-drag: none; -webkit-tap-highlight-color: rgba(0, 0, 0, 0); top: 0px; opacity: 1;">Please login to bet.</div>');
	}
	else{
		if(timeout){
				$('#toast-container').html('<div class="toast toast-notification" style="touch-action: pan-y; -webkit-user-drag: none; -webkit-tap-highlight-color: rgba(0, 0, 0, 0); top: 0px; opacity: 1;">UPS!!<br> Time is up, you are cannot place your bet now.<br>Wait for next roll.</div>');
		}
		else{
			popupcent('Just a moment...we are checking with bet master... o_O');
			$.ajax({
				url:"site/placebet",
				type:"GET",
				data:'betselection='+betselection,
				success:function(data){
					//console.log(data);					
					popupcent(data);			
					},
				});
		}
	}
	
};

var loadpagenav= function(requesturl){
	popupcent('Loading...');
	$.ajax({
		url:requesturl,
		success:function(data){
			//console.log(data);
			popupcentclose();
			changepage(data);
			},
		}	
	);
	
};

var betplaceKill= function(){
$('#betplace').html('');		
//kill green background;
};

var requestBet= function(){
//ajax request to place bet

//return what to display
};

var timup=function(){
	$('#toast-container').html('<div class="toast toast-notification" style="touch-action: pan-y; -webkit-user-drag: none; -webkit-tap-highlight-color: rgba(0, 0, 0, 0); top: 0px; opacity: 1;">UPS!!<br> You are cannot place your bet now.<br>Wait for next roll.</div>');
	};
	
	
var betform= function(){
//do spinner
$('#toast-container').html('<div class="toast toast-notification" style="touch-action: pan-y; -webkit-user-drag: none; -webkit-tap-highlight-color: rgba(0, 0, 0, 0); top: 0px; opacity: 1;">Requesting betting mother ship...</div>');
//request form from server betform action
$.ajax().done(function(){
return betformrR;
})
//return form
};

var placeBet= function(selection){
	var betrequestresult;
   
	if(!loggedIn){
		$('#toast-container').html('<div class="toast toast-notification" style="touch-action: pan-y; -webkit-user-drag: none; -webkit-tap-highlight-color: rgba(0, 0, 0, 0); top: 0px; opacity: 1;">Please login to bet.</div>');
	}
	else{
		if(timeout){
			$('#toast-container').html('<div class="toast toast-notification" style="touch-action: pan-y; -webkit-user-drag: none; -webkit-tap-highlight-color: rgba(0, 0, 0, 0); top: 0px; opacity: 1;">UPS!!<br> Time is up, you are cannot place your bet now.<br>Wait for next roll.</div>');
			}
		else{
			//show bet amount field 
			//betform=betform();
			//betplace(betform);
			//on submit to place bet-> issue an Ajax call to place bet.
			//$('#requestBet').click(betrequestresult=requestBet(););		
			//receive reply -> return array[betcode,relevant display]
			//betcode: 1=> successsful, 2=>time over,3->no skins, buy!!, 4=> 
			
			//if not logged in -> request them to login.
			// if successful -> inform the one who bet and add them in the relevant list.
		}
	}
}

//+++++++++++++++++++++++++++++++++++++++++++++end of place bet+++++++++++++++++++++++++++++++++++++++++++++++

var WS;

function connect() {
    console.log('Connecting to API...');
    $.ajax({
        url: 'http://localhost/aclumsy/web/site/token',
        success: function (data) {
            if (data == "nologin") {
                console.log('You have to be logged in');
            } else {
                console.log('Connecting to server...');

                WS = new WebSocket("ws://localhost:8080/aclumsy/web" + data);

                WS.onopen = function (e) {
                    console.log('Connected!');
                };
                WS.onerror = function (e) {
                    console.log('Error');
                };
                WS.onclose = function (e) {
                    WS = null;
                    console.log('Connection lost');
                };
                WS.onmessage = function (e) {
                    data = JSON.parse(e.data);
                    console.log(data);

                    var source   = $("#chat-post").html();
                    var template = Handlebars.compile(source);
                    var html    = template(data);

                    $(html).appendTo('#chat');

                    scrollToBottom();
                };
            }
        }
    });
}

function scrollToBottom() {
    var wtf    = $('.chat .panel-body');
    var height = wtf[0].scrollHeight;
    wtf.scrollTop(height);
}

var countDown68 = function (){

var setNumber = function(digit, number, on) {
  var segments = digit.querySelectorAll('.segment');
  var current = parseInt(digit.getAttribute('data-value'));

  // only switch if number has changed or wasn't set
  if (!isNaN(current) && current != number) {
    // unset previous number
    digitSegments[current].forEach(function(digitSegment, index) {
      setTimeout(function() {
        segments[digitSegment-1].classList.remove('on');
      }, index*45)
    });
  }
  
  if (isNaN(current) || current != number) {
    // set new number after
    setTimeout(function() {
      digitSegments[number].forEach(function(digitSegment, index) {
        setTimeout(function() {
          segments[digitSegment-1].classList.add('on');
        }, index*45)
      });
    }, 250);
    digit.setAttribute('data-value', number);
  }
};


  var _hours = document.querySelectorAll('.hours');
  var _minutes = document.querySelectorAll('.minutes');
  var _seconds = document.querySelectorAll('.seconds');
  
  Ttime=whereWeAt.time;
  
  if(Ttime>=1){
	  var minutes = Ttime;	  
	  }
	else{
		 var minutes = 00;		   
	  } 
	  
  var hours = 00 , seconds = 60;
  
 var digitSegments = [
    [1,2,3,4,5,6],
    [2,3],
    [1,2,7,5,4],
    [1,2,7,3,4],
    [6,7,2,3],
    [1,6,7,3,4],
    [1,6,5,4,3,7],
    [1,2,3], 
    [1,2,3,4,5,6,7],
    [1,2,7,3,6]	
]

  boom= setInterval(function() { 
	//var nbs= parseInt($('#timeremaining').html());    
	 seconds= seconds-1;
	 
	 if(seconds==00){
	 
		 if(0==minutes){
			clearInterval(boom);
			timeout = true ;
			justloaded= false;
			$('#toast-container').html('');		
			doRool();		
		 }
		 else{
			 if(minutes===10 ){
				//request to bet
				$('#toast-container').html('<div class="toast toast-notification" style="touch-action: pan-y; -webkit-user-drag: none; -webkit-tap-highlight-color: rgba(0, 0, 0, 0); top: 0px; opacity: 1;">HURRY!! <br>Place your bet right now by select the one of the colours below. <br>Time is running out!</div>');
			 }
				minutes =minutes-1;
				seconds=60;
		 }
		 
	 }
	
    setNumber(_hours[0], Math.floor(hours/10), 1);
    setNumber(_hours[1], hours%10, 1);

    setNumber(_minutes[0], Math.floor(minutes/10), 1);
    setNumber(_minutes[1], minutes%10, 1);

    setNumber(_seconds[0], Math.floor(seconds/10), 1);
    setNumber(_seconds[1], seconds%10, 1);
	
	/*nbs=nbs-1;
	$('#timeremaining').html('');
	$('#timeremaining').html(nbs);
	
	nbs=''; */
  },100); 
 };
 
var  whereWeAtF=function(){
	/*
		if time is up- get into roll with the time remaining for roll ==> do roll should receive time remaining
		if roll not started do countdown to time remaining ==> count down should receive time remaining
		   when roll is going on -> get the results
	*/
	// stage:1->countdown, 2-> do roll   // time:remaining seconds // if roll ?results:''
	$.ajax({
		url:'site/whereweat',
		type:'GET',
		success:function(data){
			 whereWeAt = data;
			}
		});
};

var rollLoop= function(){
	$.ajax({
		url:'site/whereweat',
		success:function(data){
			
			whereWeAt = $.parseJSON(data);
			
			console.log(whereWeAt);
			loggedIn=whereWeAt.loggedIn;
			
			 if(whereWeAt.stage==1){
			 timeout=false;
				//ichange accept bet status
				countDown68();
				}
			else if(whereWeAt.stage==2){
					timeout=false;
					doRoll();
					}
			else{
					console.log('noshow');
					}
				
			}
		});
};
		
var listbetters=function(){
	function prependlistbetter(userdata){
	option=["#all-bets-2x","#all-bets-3x","#all-bets-5x","#all-bets-50x"];
	optiontotal=["#all-bets-2x-total","#all-bets-3x-total","#all-bets-5x-total","#all-bets-50x-total"];
	
	betoptiontotal = $(optiontotal[userdata.betoption]).val();
	betoptiontotal=betoptiontotal+userdata.skinamount;
	$(optiontotal[userdata.betoption]).html(betoptiontotal);
		
	$(option[userdata.betoption]).prepend('<div class="all-bets-content">	<div class="all-bets-content-user">		<img class="all-bets-content-avatar" src="'+userdata.imageurl+'">[Lvl '+userdata.level+'] '+userdata.username+'</div>	<div class="all-bets-content-bet">	<img src="./CSGO500 - Wheel of Fortune_files/x2.png" class="bet-icon"><span class="bet-amount">'+userdata.skinamount+'</span>	</div></div>');
	}
		
	$.ajax({
		"url":"site/listbetters",//still to b done
		"data":"lastlistid=0",
		"success":function(data){
			//returned from server-imageurl, username,bet option , skinamount
			
			//append to top of appropriate list
			if(data.status>0){
			listbetterdata= $.parseJSON(data);
			console.log(listbetterdata);
				betuserinfoarrayrows=listbetterdata.length;
				for(i=0;i>betuserinfoarrayrows;i++){
					prependlistbetter(listbetterdata[i]);
				}
			}
			}
		});
}; 
 
$(document).ready(function () {	
  	rollLoop();
		
    connect();

	listbetters();
	
    $('form#send').on('submit', function (event) {
        event.preventDefault();

        var message = $('#message').val();

        if (message !== '') {
            WS.send(message);

            $('#message').val('');
        }
    });

    //scrollToBottom();
	
	/*setInterval(function(){
		listbetters();
	},1000); */
		
	 $('#bet-btn-2x').click(function(){
		betplace(1);
   });
	$('#bet-btn-3x').click(function(){
		betplace(2);
   });
	$('#bet-btn-5x').click(function(){
		betplace(3);
   });
	$('#bet-btn-50x').click(function(){
		betplace(4);
	}); 		
	
//---------------------------------------------------------------------------------
	   
   $('#btn-double-skins').click(function(){
		sknval=$("#userbets-skins").value();  
		sknval=sknval*2;
		$("#userbets-skins").value(sknval);  
   });
   $('#btn-triple-skins').click(function(){
		sknval=$("#userbets-skins").value();  
		sknval=sknval*3;
		$("#userbets-skins").value(sknval);
   });
  
//--------------------left navigation-----------------------------------------------------


$('#nav-wheel-roll').click(function(){
		loadpagenav("site/index?option=2");
		//set new roll variables
		rollLoop();
   });
$('#nav-how-it-works').click(function(){
		loadpagenav("site/howitworks");
   });
$('#nav-faq').click(function(){
		loadpagenav("site/faq");
   });
$('#nav-skins').click(function(){
		loadpagenav("skins/index?sort=time");
   });
   
  $('#nav-admin').click(function(){
		loadpagenav("skins/admin");
   });
   
//-------------------------------------------------------------------------------------------
});