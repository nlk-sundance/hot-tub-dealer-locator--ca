function toggle(togglewhat) {
	var dropdown = document.getElementById(togglewhat);
	if(dropdown.style.display == 'block') { dropdown.style.display = 'none'; }
	else { dropdown.style.display = 'block'; }
	return false;
}

var Dropdowns = {
	current: null,
	timeout: null,
	keepit: false,
	howlong: 100,
	register: function(trigger, what){
		$(trigger).mouseover(function(){
			Dropdowns.show(what)
		})
		$(what).mouseover(function(){
			Dropdowns.noHideLast();
			Dropdowns.timeoutTime(100);
		})
		$(what).mouseout(function(){
			Dropdowns.timeoutHide()
		})
		
	},
	show: function(what){
		this.hideLast()
		$(what).show()
		this.current = what
	},
	timeoutHide: function(){
		clearTimeout(this.timeout)
		this.keepit = false
		this.timeout = setTimeout(function(){
			Dropdowns.hideLast()
		}, this.howlong)
	},
	hideLast: function(){
		if(this.current == null) return //first time around
		if(this.keepit == false) {
			$(this.current).hide()
			this.howlong = 100;
		}
		this.keepit = false
	},
	noHideLast: function(){
		this.keepit = true;
	},
	timeoutTime: function(length){
		this.howlong = length;
	}
}

function writeDropdowns(where) {
	var preFx='';
	if(where == 1) { preFx='../'; }
	if(where == 2) { preFx='../../'; }
	if(where == 8) { preFx='/'; }
	document.write('<ul id="talk-dropdown">' +
			'<li><a href="'+preFx+'contact/support.html"><img src="'+preFx+'images/nav/talk-drop-support.gif" /></a></li>' +
			'<li><a href="'+preFx+'contact/dealer-contact.html"><img src="'+preFx+'images/nav/talk-drop-contact.gif" /></a></li>' +
			'</ul><ul id="download-dropdown">'+
			'<li><a href="'+preFx+'request-brochure/download-brochure.html"><img src="'+preFx+'images/nav/request-drop-brochure.gif" /></a></li>' +
			'<li><a href="'+preFx+'request-brochure/download-manuals.html"><img src="'+preFx+'images/nav/request-drop-tech.gif" /></a></li>' +
			'</ul><div id="j400" class="mainDrop">' +
			'<a href="'+preFx+'j-400/index.html"><img src="'+preFx+'images/nav/j400-top.jpg" /></a><br />' +
			'<img src="'+preFx+'images/nav/j400-hdr.gif" />' +
			'<ul><li>&bull; Elevated waterfall</li>' +
			'<li>&bull; iPod&reg; Docking Station</li>' +
			'<li>&bull; New NX2 Neck Jets</li>' +
			'<li>&bull; Illuminating IX Jets</li>' +
			'<li>&bull; BX Bubbler Jets</li>' +
			'</ul><ul><li><a href="'+preFx+'j-400/index.html"><img src="'+preFx+'images/nav/view-j400-collection.gif" /></a></li>' +
			'<li><a href="'+preFx+'j-400/gallery.html" name="TB_iframe=true&height=488&width=703" class="thickbox">' +
			'<img src="'+preFx+'images/nav/view-more.gif" /></a></li>' +
			'</ul></div><div id="j300" class="mainDrop">' +
			'<a href="'+preFx+'j-300/index.html"><img src="'+preFx+'images/nav/j300-top.jpg" /></a><br />' +
			'<img src="'+preFx+'images/nav/j300-hdr.gif" />' +
			'<ul><li>&bull; Auxiliary MP3 input jack</li>' +
			'<li>&bull; ProLites LED lighting package</li>' +
			'<li>&bull; Water Rainbow waterfall</li>' +
			'<li>&bull; ProAir Lounge</li>' +
			'<li>&bull; Lighted beverage coasters</li>' +
			'</ul><ul><li><a href="'+preFx+'j-300/index.html"><img src="'+preFx+'images/nav/view-j300-collection.gif" /></a></li>' +
			'<li><a href="'+preFx+'j-300/gallery.html" name="TB_iframe=true&height=488&width=703" class="thickbox">' +
			'<img src="'+preFx+'images/nav/view-more.gif" /></a></li>' +
			'</ul></div><div id="j200" class="mainDrop">' +
			'<a href="'+preFx+'j-200/index.html"><img src="'+preFx+'images/nav/j200-top.jpg" /></a><br />' +
			'<img src="'+preFx+'images/nav/j200-hdr.gif" />' +
			'<ul><li>&bull; Easy-to-reach controls</li>' +
			'<li>&bull; Built-in beverage holders</li>' +
			'<li>&bull; Pillow headrests</li>' +
			'<li>&bull; Full lounge seat</li>' +
			'<li>&bull; Whirlpool jets</li>' +
			'</ul><ul><li><a href="'+preFx+'j-200/index.html"><img src="'+preFx+'images/nav/view-j200-collection.gif" /></a></li>' +
			'<li><a href="'+preFx+'j-200/gallery.html" name="TB_iframe=true&height=488&width=703" class="thickbox">'+ 
			'<img src="'+preFx+'images/nav/view-more.gif" /></a></li></ul></div>');
}
/*** script to randomize header images on spa overview & full specs pages ***/
function writeSpaHeader(section) {
	var num = Math.random()*5;
	if(section == 3) { num = Math.random()*6; }
	else if(section == 4.6) { section = 4; num = num * 0.8; }
	num = Math.ceil(num);
	document.write('<img src="../images/j-'+section+'00/hdr-'+section+'00-overview-'+num+'.jpg" />');
}

/*** script for rollovers on J-400/300/200 landing pages ***/
function rollovers() {
	$("ul#roll a").click(function(){
		return false;
	});
	$("ul#roll a").mouseover(function(){
		$("ul#roll a[@class='on']").removeClass();
		$(this).attr("class","on");
		$("img#thm").attr("src",$(this).attr("href"));
	});
}

function goto_URL(object) {
    window.location.href = object.options[object.selectedIndex].value;
}

function writeCompareSelect() {
	document.write('<option value="480">J-480</option><option value="470">J-470</option><option value="465">J-465</option>' +
		'<option value="460">J-460</option><option value="375">J-375</option><option value="365">J-365</option><option value="355">J-355</option>' +
		'<option value="345">J-345</option><option value="335">J-335</option><option value="325">J-325</option>' +
		'<option value="315">J-315</option><option value="280">J-280</option><option value="270">J-270</option>' +
		'<option value="230">J-230</option><option value="220">J-220</option><option value="210">J-210</option></select><br /><br />');
}
function compareDropdown(thisOne) {
	$("#content").append('<div id="compare-dropdown"><img src="../images/compare/j-'+thisOne+'.jpg" />' +
	'<img src="../images/compare/select-1-model.gif" /><br /><form action="compare.php" method="post">' +
	'<input type="hidden" name="here" value="'+this.location+'" />'+
	'<input type="hidden" name="p1" value="'+thisOne+'" /><select name="p2"><option value="" selected="selected">Select a Model</option>'+
	'<option value="480">J-480</option><option value="470">J-470</option><option value="465">J-465</option>' +
		'<option value="460">J-460</option><option value="375">J-375</option><option value="365">J-365</option><option value="355">J-355</option>' +
		'<option value="345">J-345</option><option value="335">J-335</option><option value="325">J-325</option>' +
		'<option value="315">J-315</option><option value="280">J-280</option><option value="270">J-270</option>' +
		'<option value="230">J-230</option><option value="220">J-220</option><option value="210">J-210</option></select><br /><br />' +
		'<img src="../images/compare/select-third-model.gif" width="156" height="11" /><br />' +
	'<select name="p3"><option value="" selected="selected">Select a Model</option>' +
	'<option value="480">J-480</option><option value="470">J-470</option><option value="465">J-465</option>' +
		'<option value="460">J-460</option><option value="375">J-375</option><option value="365">J-365</option><option value="355">J-355</option>' +
		'<option value="345">J-345</option><option value="335">J-335</option><option value="325">J-325</option>' +
		'<option value="315">J-315</option><option value="280">J-280</option><option value="270">J-270</option>' +
		'<option value="230">J-230</option><option value="220">J-220</option><option value="210">J-210</option></select><br /><br />' +
		'<img src="../images/compare/line.gif" /><br /><input type="submit" value=""class="sbmt" /></form></div>');
}

function resizeFrame() {
	var frameid = $("iframe").attr("id");
	var frame = document.getElementById(frameid);
	if (frame.contentDocument && frame.contentDocument.body.offsetHeight) //ns6 syntax
	frame.height = frame.contentDocument.body.offsetHeight+20; 
	else if (frame.Document && frame.Document.body.scrollHeight) //ie5+ syntax
	frame.height = frame.Document.body.scrollHeight;
}

function goGalleryImg(number) {
	number = parseInt(number);
	// set the '# of #' text
	$("span").html(number+" of "+numOfThms);
	// set the Prev & Next links
	pNum = number - 1;
	nNum = number + 1;
	if(pNum ==0) { pNum = 12; }
	if(nNum ==13) { nNum = 1; }
	
	var newSrc = "../images/" + thisGallery + "/gallery-" + number + "-lrg.jpg";
	var oldImg = document.getElementById('singleImg');
	var oldExtent = { x: oldImg.width, y: oldImg.height };
	oldImg.src = '../includes/transparent.gif';
	oldImg.width = oldExtent.x;
	oldImg.height = oldExtent.y;
	$("#footer p").empty();
	var newImg = document.createElement('img');
	newImg.id = oldImg.id;
	newImg.onload = function(){	
		if(oldImg.parentNode) { oldImg.parentNode.replaceChild(newImg, oldImg); }
		var imgText = $("#gallery a:eq("+(number-1)+")").children().attr("title");
		$("#footer p").html(imgText);
	}
	newImg.src = newSrc;
	
	$("div#single").show();
}
function goToImg(num) {
	goGalleryImg(num);
	return false;
}

$(function(){
	if($("#nav400")) { Dropdowns.register('#nav400', '#j400'); }
	if($("#nav300")) { Dropdowns.register('#nav300', '#j300'); }
	if($("#nav200")) { Dropdowns.register('#nav200', '#j200'); }
	if($("#download")) { Dropdowns.register('#download', '#download-dropdown'); }
	if($("#talk")) { Dropdowns.register('#talk', '#talk-dropdown'); }
	if($("#compare")) { 
		Dropdowns.register('#compare', '#compare-dropdown');
		var selectCheck = false;

		$("#compare-dropdown select").click(function() {
			if(selectCheck) {
				Dropdowns.timeoutTime(4000);
				selectCheck = false;
			} else {
				Dropdowns.timeoutTime(10000);
				selectCheck = true;
			}
		});
	}
	if($("#box")) { $("#box").click(function() { if(this.value == 'Search Jacuzzi') { this.value = ''; } }); }
	$("#topNav select").change( function() { goto_URL(this.form.selectName); });	
	// add coupon to spa & accessories pages
	/* if(((window.location.href).indexOf('j-') > 0) || ((window.location.href).indexOf('accessories') > 0)) {
		$("#sidenav ul li:last").before('<li style="margin-bottom: -58px;"><a href="../financing/money-saving-offer.html"><img src="../images/promo/btn-coupon.gif" alt="Save $500! Limited Time Offer! Click to Learn More" /></a></li>');
	} */
});