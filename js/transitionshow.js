//Random Transitions Slideshow- By JavaScript Kit (http://www.javascriptkit.com)
//Created: Nov 3rd, 2008

var global_transitions=[ //array of IE transition strings
	"progid:DXImageTransform.Microsoft.Barn()",
	"progid:DXImageTransform.Microsoft.Blinds()",
	"progid:DXImageTransform.Microsoft.CheckerBoard()",
	"progid:DXImageTransform.Microsoft.Fade()",
	"progid:DXImageTransform.Microsoft.GradientWipe()",
	"progid:DXImageTransform.Microsoft.Inset()",
	"progid:DXImageTransform.Microsoft.Iris()",
	"progid:DXImageTransform.Microsoft.Pixelate(maxSquare=15)",
	"progid:DXImageTransform.Microsoft.RadialWipe()",
	"progid:DXImageTransform.Microsoft.RandomBars()",
	"progid:DXImageTransform.Microsoft.RandomDissolve()",
	"progid:DXImageTransform.Microsoft.Slide()",
	"progid:DXImageTransform.Microsoft.Spiral()",
	"progid:DXImageTransform.Microsoft.Stretch()",
	"progid:DXImageTransform.Microsoft.Strips()",
	"progid:DXImageTransform.Microsoft.Wheel()",
	"progid:DXImageTransform.Microsoft.Zigzag()"
]

function flashyslideshow(setting){
	this.wrapperid=setting.wrapperid
	this.imagearray=setting.imagearray
	this.pause=setting.pause
	this.transduration=setting.transduration/1000 //convert from miliseconds to seconds unit to pass into el.filters.play()
	this.currentimg=0
	var preloadimages=[] //temp array to preload images
	for (var i=0; i<this.imagearray.length; i++){
		preloadimages[i]=new Image()
		preloadimages[i].src=this.imagearray[i][0]
	}
	document.write('<div id="'+this.wrapperid+'" class="'+setting.wrapperclass+'"><div id="'+this.wrapperid+'_inner" style="width:100%">'+this.getSlideHTML(this.currentimg)+'</div></div>')
	var effectindex=Math.floor(Math.random()*global_transitions.length) //randomly pick a transition to utilize
	var contentdiv=document.getElementById(this.wrapperid+"_inner")
	if (contentdiv.filters){ //if the filters[] collection is defined on element (only in IE)
		contentdiv.style.filter=global_transitions[effectindex] //define transition on element
		this.pause+=setting.transduration //add transition time to pause
	}
	this.filtersupport=(contentdiv.filters && contentdiv.filters.length>0)? true : false //test if element supports transitions and has one defined
	var slideshow=this
	flashyslideshow.addEvent(contentdiv, function(){slideshow.isMouseover=1}, "mouseover")
	flashyslideshow.addEvent(contentdiv, function(){slideshow.isMouseover=0}, "mouseout")
	setInterval(function(){slideshow.rotate()}, this.pause)
}

flashyslideshow.addEvent=function(target, functionref, tasktype){
	if (target.addEventListener)
		target.addEventListener(tasktype, functionref, false);
	else if (target.attachEvent)
		target.attachEvent('on'+tasktype, function(){return functionref.call(target, window.event)});
},

flashyslideshow.setopacity=function(el, degree){ //sets opacity of an element (FF and non IE browsers only)
	if (typeof el.style.opacity!="undefined")
		el.style.opacity=degree
	else
		el.style.MozOpacity=degree
	el.currentopacity=degree
},

flashyslideshow.prototype.getSlideHTML=function(index){
	var slideHTML=(this.imagearray[index][1])? '<a href="'+this.imagearray[index][1]+'" target="'+this.imagearray[index][2]+'">\n' : '' //hyperlink slide?
	slideHTML+='<img src="'+this.imagearray[index][0]+'" />'
	slideHTML+=(this.imagearray[index][1])? '</a><br />' : '<br />'
	slideHTML+=(this.imagearray[index][3])? this.imagearray[index][3] : '' //text description?
	return slideHTML //return HTML for the slide at the specified index
}

flashyslideshow.prototype.rotate=function(){
	var contentdiv=document.getElementById(this.wrapperid+"_inner")
	if (this.isMouseover){ //if mouse is over slideshow
		return
	}
	this.currentimg=(this.currentimg<this.imagearray.length-1)? this.currentimg+1 : 0
	if (this.filtersupport){
		contentdiv.filters[0].apply()
	}
	else{
		flashyslideshow.setopacity(contentdiv, 0)
	}
	contentdiv.innerHTML=this.getSlideHTML(this.currentimg)
	if (this.filtersupport){
		contentdiv.filters[0].play(this.transduration)
	}
	else{
		contentdiv.fadetimer=setInterval(function(){
			if (contentdiv.currentopacity<1)
				flashyslideshow.setopacity(contentdiv, contentdiv.currentopacity+0.1)
			else
				clearInterval(contentdiv.fadetimer)
		}, 50) //end setInterval
	}
}


///Sample call on your page
/*
var flashyshow=new flashyslideshow({ //create instance of slideshow
	wrapperid: "myslideshow", //unique ID for this slideshow
	wrapperclass: "flashclass", //desired CSS class for this slideshow
	imagearray: [
		["summer.jpg", "http://en.wikipedia.org/wiki/Summer", "_new", "Such a nice Summer getaway."],
		["winter.jpg", "http://en.wikipedia.org/wiki/Winter", "", "Winter is nice, as long as there's snow right?"],
		["spring.jpg", "", "", "Flowers spring back to life in Spring."],
		["autumn.jpg", "", "", "Ah the cool breeze of autumn."]
	],
	pause: 2000, //pause between slides (milliseconds)
	transduration: 1000 //transition duration (milliseconds)
})
*/