/*
 * Thickbox 2.1 - jQuery plugin for displaying content in a box above the page
 * 
 * Copyright (c) 2006, 2007 Cody Lindley (http://www.codylindley.com)
 *
 * Licensed under the MIT License:
 *   http://www.opensource.org/licenses/mit-license.php
 */

// on page load call TB_init
$(document).ready(TB_init);
// add thickbox to href elements that have a class of .thickbox
function TB_init(){
	$("a.thickbox").click(function(event){
		// stop default behaviour
		event.preventDefault();
		// remove click border
		this.blur();
		
		// display the box for the elements href
		var page = this.href + '?' + this.name;
		TB_show(page);
	});
	// use different Close X icon for the accessories section popups
	$("li.sub a.thickbox,div.btn2 a.thickbox,div.btn3 a.thickbox").attr("name",function(){ return this.name + '&close2=true'; } );
}

function spaPopUp(whichOne) {
	if(whichOne.charAt(0) == 'j') {
		var theURL = "popup.php?p=" + whichOne + "?TB_iframe=true&height=474&width=460&close2=true";
		
		TB_show(theURL);
	}
}

function forwardFriend(href) {
	var theURL = href + "?TB_iframe=true&height=285&width=405&close2=true";
	TB_show(theURL);
	return false;
}

// called when the user clicks on a thickbox link
function TB_show(url) {
	// create iframe, overlay and box if non-existent
	if ( !$("#TB_HideSelect").length ) {
		$("body").append("<iframe id='TB_HideSelect'></iframe><div id='TB_overlay'></div><div id='TB_window'></div>");
		$("#TB_overlay").click(TB_remove);
	}
	
	TB_CENTERED = false;
	if((url.indexOf('close2') != -1) || (url.indexOf('images/accessories') != -1)) { 
		TB_CENTERED = true;
	}
	
	// TODO replace
	TB_overlaySize();
	
	// TODO create loader only once, hide and show on demand
	$("body").append("<div id='TB_load'><img src='/includes/loadingAnimation.gif' /></div>");
	TB_load_position();
	//replace flash
	TB_replaceFlash();
	
	var queryString = url.match(/\?(.+)/)[1];
	var params = TB_parseQuery( queryString );
	
	TB_WIDTH = (params['width']*1) ;
	TB_HEIGHT = (params['height']*1) ;

	var ajaxContentW = TB_WIDTH ; //- 30,
		ajaxContentH = TB_HEIGHT ; //- 45;
	
	if(url.indexOf('TB_iframe') != -1){
		urlNoQuery = url.split('?TB_');
		if(url.indexOf('images/accessories/') != -1) {
			$("#TB_window").addClass('imgd').append("<a href='' id='TB_closeWindowButton' title='Close'>close</a><img src='"+urlNoQuery[0]+"' onload='TB_showIframe()' />");
		} else {
			$("#TB_window").append("<a href='' id='TB_closeWindowButton' title='Close'>close</a><iframe frameborder='0' hspace='0' src='"+urlNoQuery[0]+"' id='TB_iframeContent' name='TB_iframeContent' style='width:"+ ajaxContentW +"px;height:"+ ajaxContentH +"px;' onload='TB_showIframe()'></iframe>");
		}
	} else {
		$("#TB_window").append("<div id='TB_title'><div id='TB_closeAjaxWindow'><a href='' id='TB_closeWindowButton' class='acc'>close</a></div></div><div id='TB_ajaxContent' style='width:"+ajaxContentW+"px;height:"+ajaxContentH+"px;'></div>");
	}
			
	$("#TB_closeWindowButton").click(TB_remove);
	if(TB_CENTERED && (url.indexOf('images/accessories') == -1)) { 
		$("#TB_closeWindowButton").attr("id","TB_closeWindowButton2");
	}
	if(url.indexOf('customer-showcase') != -1) {
		$("a").remove("#TB_closeWindowButton");
	}
	if(url.indexOf('TB_inline') != -1){	
		$("#TB_ajaxContent").html($('#' + params['inlineId']).html());
		TB_position();
		$("#TB_load").remove();
		$("#TB_window").css({display:"block"}); 
	}else if(url.indexOf('TB_iframe') != -1){
		TB_position();
		if(frames['TB_iframeContent'] == undefined){//be nice to safari
			$("#TB_load").remove();
			$("#TB_window").css({display:"block"});
			$(document).keyup( function(e){ var key = e.keyCode; if(key == 27){TB_remove()} });
		}
	}else{
		$("#TB_ajaxContent").load(url, function(){
			TB_position(centerWindow);
			$("#TB_load").remove();
			$("#TB_window").css({display:"block"}); 
		});
	}
	
	$(window).resize(TB_position);
	
	document.onkeyup = function(e){ 	
		if (e == null) { // ie
			keycode = event.keyCode;
		} else { // mozilla
			keycode = e.which;
		}
		if(keycode == 27){ // close
			TB_remove();
		}	
	}
	
	$(window).scroll(TB_position);
}
var flashIsOn = true;
var frame = false;
function TB_replaceFlash() {
	if(frame) {
		if(flashIsOn) { $('#'+frame).html(tbHolder); }
		else { foo.write(frame); }
	}
	flashIsOn = !flashIsOn;
}

//helper functions below

function TB_showIframe(){
	$("#TB_load").remove();
	$("#TB_window").css({display:"block"});
}

function TB_remove() {
 	$("#TB_imageOff").unbind("click");
	$("#TB_overlay").unbind("click");
	$("#TB_closeWindowButton").unbind("click");
	$("#TB_window").fadeOut("fast",function(){$('#TB_window,#TB_overlay,#TB_HideSelect').remove();});
	$("#TB_load").remove();
	TB_replaceFlash();
	return false;
}

function TB_position() {
	var pagesize = TB_getPageSize();	
	var arrayPageScroll = TB_getPageScrollTop();
	var style = {width: TB_WIDTH, left: (arrayPageScroll[0] + (pagesize[0] - TB_WIDTH)/2), top: arrayPageScroll[1]};
	if(TB_CENTERED) {
		style = {width: TB_WIDTH, left: (arrayPageScroll[0] + (pagesize[0] - TB_WIDTH)/2), top: (arrayPageScroll[1] + (pagesize[1] - TB_HEIGHT)/2)};
	}
	$("#TB_window").css(style);
}

function TB_overlaySize(){
	if (window.innerHeight && window.scrollMaxY || window.innerWidth && window.scrollMaxX) {	
		yScroll = window.innerHeight + window.scrollMaxY;
		xScroll = window.innerWidth + window.scrollMaxX;
		var deff = document.documentElement;
		var wff = (deff&&deff.clientWidth) || document.body.clientWidth || window.innerWidth || self.innerWidth;
		var hff = (deff&&deff.clientHeight) || document.body.clientHeight || window.innerHeight || self.innerHeight;
		xScroll -= (window.innerWidth - wff);
		yScroll -= (window.innerHeight - hff);
	} else if (document.body.scrollHeight > document.body.offsetHeight || document.body.scrollWidth > document.body.offsetWidth){ // all but Explorer Mac
		yScroll = document.body.scrollHeight;
		xScroll = document.body.scrollWidth;
	} else { // Explorer Mac...would also work in Explorer 6 Strict, Mozilla and Safari
		yScroll = document.body.offsetHeight;
		xScroll = document.body.offsetWidth;
  	}
	$("#TB_overlay").css({"height": yScroll, "width": xScroll});
	$("#TB_HideSelect").css({"height": yScroll,"width": xScroll});
}

function TB_load_position() {
	var pagesize = TB_getPageSize();
	var arrayPageScroll = TB_getPageScrollTop();
	
	var top_position = 200;
	if(TB_CENTERED) { top_position = arrayPageScroll[1] + (pagesize[1] - 100)/2; }
	
	$("#TB_load")
		.css({left: (arrayPageScroll[0] + (pagesize[0] - 100)/2), top: top_position })
		.css({display:"block"});
}

function TB_parseQuery ( query ) {
	// return empty object
	if( !query )
		return {};
	var params = {};
	
	// parse query
	var pairs = query.split(/[;&]/);
	for ( var i = 0; i < pairs.length; i++ ) {
		var pair = pairs[i].split('=');
		if ( !pair || pair.length != 2 )
			continue;
		// unescape both key and value, replace "+" with spaces in value
		params[unescape(pair[0])] = unescape(pair[1]).replace(/\+/g, ' ');
   }
   return params;
}

function TB_getPageScrollTop(){
	var yScrolltop;
	var xScrollleft;
	if (self.pageYOffset || self.pageXOffset) {
		yScrolltop = self.pageYOffset;
		xScrollleft = self.pageXOffset;
	} else if (document.documentElement && document.documentElement.scrollTop || document.documentElement.scrollLeft ){	 // Explorer 6 Strict
		yScrolltop = document.documentElement.scrollTop;
		xScrollleft = document.documentElement.scrollLeft;
	} else if (document.body) {// all other Explorers
		yScrolltop = document.body.scrollTop;
		xScrollleft = document.body.scrollLeft;
	}
	arrayPageScroll = new Array(xScrollleft,yScrolltop) 
	return arrayPageScroll;
}

function TB_getPageSize(){
	var de = document.documentElement;
	var w = window.innerWidth || self.innerWidth || (de&&de.clientWidth) || document.body.clientWidth;
	var h = window.innerHeight || self.innerHeight || (de&&de.clientHeight) || document.body.clientHeight
	arrayPageSize = new Array(w,h) 
	return arrayPageSize;
}
