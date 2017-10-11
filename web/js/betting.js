//login thing
//onclick placebet -> is time up? sorry try in next roll: place bet
//place bet go ahead - enter amount, submit -> ,show on listing below bet,get a success or failure message.
var betplace= function(betcontent){
$('#betplace').html('<div class="placebet-window toast1"  >'+ betcontent +'</div>');
//do green background;
}

var betplaceKill= function(){
$('#betplace').html('');		
//kill green background;
}

var requestBet= function(){
//ajax request to place bet

//return what to display
}

var betform= function(){
//do spinner
$('#toast-container').html('<div class="toast toast-notification" style="touch-action: pan-y; -webkit-user-drag: none; -webkit-tap-highlight-color: rgba(0, 0, 0, 0); top: 0px; opacity: 1;">Requesting betting mother ship...</div>');
//request form from server betform action
$.ajax().done(function(){
return betformrR;
})
//return form
}

var placeBet= function(selection){
   betrequestresult=array(0,'No server request made');
	if(!loggedIn){
		$('#toast-container').html('<div class="toast toast-notification" style="touch-action: pan-y; -webkit-user-drag: none; -webkit-tap-highlight-color: rgba(0, 0, 0, 0); top: 0px; opacity: 1;">Please login to bet.</div>');
	}
	else{	
		//show bet amount field 
		betform=betform();
		betplace(betform);
		//on submit to place bet-> issue an Ajax call to place bet.
		$('#requestBet').click(betrequestresult=requestBet(););		
		//receive reply -> return array[betcode,relevant display]
		//betcode: 1=> successsful, 2=>time over,3->no skins, buy!!, 4=> 
		
		//if not logged in -> request them to login.
		// if successful -> inform the one who bet and add them in the relevant list.
	}
}