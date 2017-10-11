var CountUp=function(target,startVal,endVal,decimals,duration,options){
var lastTime=0;
var vendors=['webkit','moz','ms','o'];

for(var x=0;x<vendors.length&&!window.requestAnimationFrame;++x){
window.requestAnimationFrame=window[vendors[x]+'RequestAnimationFrame'];
window.cancelAnimationFrame=window[vendors[x]+'CancelAnimationFrame']||window[vendors[x]+'CancelRequestAnimationFrame'];
}
if(!window.requestAnimationFrame){
window.requestAnimationFrame=function(callback,element){var currTime=new Date().getTime();
var timeToCall=Math.max(0,16-(currTime- lastTime));
var id=window.setTimeout(function(){callback(currTime+ timeToCall);},timeToCall);lastTime=currTime+ timeToCall;return id;};

}

if(!window.cancelAnimationFrame){
window.cancelAnimationFrame=function(id){clearTimeout(id);};
}

this.easeOutExpo=function(t,b,c,d){
	return c*(-Math.pow(2,-10*t/d)+ 1)*1024/1023+ b;};
	this.options={useEasing:true,useGrouping:true,separator:',',decimal:'.',postFormatter:null,easingFn:null,formattingFn:null};
	for(var key in options){
		if(options.hasOwnProperty(key)){
			this.options[key]=options[key];
		}
}
if(this.options.separator==='')
this.options.useGrouping=false;

if(!this.options.prefix)this.options.prefix='';

if(!this.options.suffix)this.options.suffix='';
this.options.easingFn=!this.options.easingFn?this.easeOutExpo:this.options.easingFn;

this.d=(typeof target==='string')?document.getElementById(target):target;

this.startVal=Number(startVal);

this.endVal=Number(endVal);

this.countDown=(this.startVal>this.endVal);

this.frameVal=this.startVal;this.decimals=Math.max(0,decimals||0);

this.dec=Math.pow(10,this.decimals);

this.duration=Number(duration)*1000||2000;

var self=this;this.version=function(){return'1.7.0';};

this.printValue=function(value){
if(self.options.formattingFn){var result=self.options.formattingFn(value);}
else{var result=(!isNaN(value))?self.formatNumber(value):'--';}

if(self.d.tagName=='INPUT'){this.d.value=result;}
else if(self.d.tagName=='text'|| self.d.tagName=='tspan'){this.d.textContent=result;}
else{this.d.innerHTML=result;}
};

this.count=function(timestamp){
if(!self.startTime)self.startTime=timestamp;
self.timestamp=timestamp;
var progress=timestamp- self.startTime;
self.remaining=self.duration- progress;
if(self.options.useEasing){
if(self.countDown){self.frameVal=self.startVal- self.options.easingFn.call(self,progress,0,self.startVal- self.endVal,self.duration);}
else{self.frameVal=self.options.easingFn.call(self,progress,self.startVal,self.endVal- self.startVal,self.duration);}
}
else{
if(self.countDown){self.frameVal=self.startVal-((self.startVal- self.endVal)*(progress/self.duration));}
else{self.frameVal=self.startVal+(self.endVal- self.startVal)*(progress/self.duration);}
}
if(self.countDown){self.frameVal=(self.frameVal<self.endVal)?self.endVal:self.frameVal;}
else{self.frameVal=(self.frameVal>self.endVal)?self.endVal:self.frameVal;}
self.frameVal=Math.round(self.frameVal*self.dec)/self.dec;
self.printValue(self.frameVal);

if(progress<self.duration){self.rAF=requestAnimationFrame(self.count);}
else{if(self.callback)self.callback();}};
this.start=function(callback){
self.callback=callback;
self.rAF=requestAnimationFrame(self.count);
return false;};
this.pauseResume=function(){
if(!self.paused){
self.paused=true;
cancelAnimationFrame(self.rAF);}
else{self.paused=false;
delete self.startTime;
self.duration=self.remaining;
self.startVal=self.frameVal;
requestAnimationFrame(self.count);}
};
this.reset=function(){
self.paused=false;
delete self.startTime;
self.startVal=startVal;
self.frameVal=startVal;
cancelAnimationFrame(self.rAF);
self.printValue(self.startVal);};
this.update=function(newEndVal){
cancelAnimationFrame(self.rAF);
self.paused=false;
delete self.startTime;
self.startVal=self.frameVal;
self.endVal=Number(newEndVal);
self.countDown=(self.startVal>self.endVal);
self.rAF=requestAnimationFrame(self.count);};
this.formatNumber=function(nStr){
nStr=nStr.toFixed(self.decimals);nStr+='';
var x,x1,x2,rgx;x=nStr.split('.');
x1=x[0];x2=x.length>1?self.options.decimal+ x[1]:'';
rgx=/(\d+)(\d{3})/;
if(self.options.useGrouping){
while(rgx.test(x1)){x1=x1.replace(rgx,'$1'+ self.options.separator+'$2');}
}

var value=self.options.prefix+ x1+ x2+ self.options.suffix;
if(self.options.postFormatter!=null){value=self.options.postFormatter(value);}
return value;
};

self.printValue(self.startVal);};