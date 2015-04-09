//rollovers
var iName=""; 
default1 = new Image(); default1.src = BASEDIR + "/img/se/800Series_Off.gif";
changed1 = new Image(); changed1.src = BASEDIR + "/img/se/800Series_On.gif";
default2 = new Image(); default2.src = BASEDIR + "/img/se/700Series_Off.gif";
changed2 = new Image(); changed2.src = BASEDIR + "/img/se/700Series_On.gif";
default3 = new Image(); default3.src = BASEDIR + "/img/se/680Series_Off.gif";
changed3 = new Image(); changed3.src = BASEDIR + "/img/se/680Series_On.gif";
default4 = new Image(); default4.src = BASEDIR + "/img/se/Therapy_Off.gif";
changed4 = new Image(); changed4.src = BASEDIR + "/img/se/Therapy_On.gif";
default5 = new Image(); default5.src = BASEDIR + "/img/se/Ideas_Off.gif";
changed5 = new Image(); changed5.src = BASEDIR + "/img/se/Ideas_On.gif";
default6 = new Image(); default6.src = BASEDIR + "/img/se/Innovation_Off.gif";
changed6 = new Image(); changed6.src = BASEDIR + "/img/se/Innovation_On.gif";
default7 = new Image(); default7.src = BASEDIR + "/img/se/Features_Off.gif";
changed7 = new Image(); changed7.src = BASEDIR + "/img/se/Features_On.gif";

function Ichange(p) {
    var pSrc=eval(p+ ".src");
    document[iName].src = pSrc;
}

//Writes the navigation to the page based on variable at the top of each page.
function printMainNav() { 
	if (section == "800Series" ) {
		document.write('<a href="http://se.sundancespas.com/800Series/800Series.html"><IMG SRC= "' + BASEDIR + '/img/se/800Series_On2.gif" width="69" height="34" alt="SERIE 800" border="0"></A>');
	} 
	else {
		document.write('<a href="http://se.sundancespas.com/800Series/800Series.html" onMouseOver="iName=\'image1\'; Ichange(\'changed1\')" onMouseOut="Ichange(\'default1\')"><IMG SRC= "' + BASEDIR + '/img/se/800Series_Off.gif" width="69" height="34" alt="SERIE 800" border="0" name="image1"></A>');
	}
	if (section == "700Series" ) {
		document.write('<a href="http://se.sundancespas.com/700Series/700Series.html"><IMG SRC= "' + BASEDIR + '/img/se/700Series_On2.gif" width="66" height="34" alt="SERIE 700" border="0"></A>');
	} 
	else {
		document.write('<a href="http://se.sundancespas.com/700Series/700Series.html" onMouseOver="iName=\'image2\'; Ichange(\'changed2\')" onMouseOut="Ichange(\'default2\')"><IMG SRC= "' + BASEDIR + '/img/se/700Series_Off.gif" width="66" height="34" alt="SERIE 700" border="0" name="image2"></A>');
	}
	if (section == "680Series" ) {
		document.write('<a href="http://se.sundancespas.com/680Series/680Series.html"><IMG SRC= "' + BASEDIR + '/img/se/680Series_On2.gif" width="66" height="34" alt="SERIE 680" border="0"></A>');
	} 
	else {
		document.write('<a href="http://se.sundancespas.com/680Series/680Series.html" onMouseOver="iName=\'image3\'; Ichange(\'changed3\')" onMouseOut="Ichange(\'default3\')"><IMG SRC= "' + BASEDIR + '/img/se/680Series_Off.gif" width="66" height="34" alt="SERIE 680" border="0" name="image3"></A>');
	}
	if (section == "Therapy" ) {
		document.write('<a href="http://se.sundancespas.com/Therapy/Therapy.html"><IMG SRC= ' + BASEDIR + '/img/se/Therapy_On2.gif" width="51" height="34" alt="TERAPI" border="0"></A>');
	} 
	else {
		document.write('<a href="http://se.sundancespas.com/Therapy/Therapy.html" onMouseOver="iName=\'image4\'; Ichange(\'changed4\')" onMouseOut="Ichange(\'default4\')"><IMG SRC= "' + BASEDIR + '/img/se/Therapy_Off.gif" width="51" height="34" alt="TERAPI" border="0" name="image4"></A>');
	}
	if (section == "Ideas" ) {
		document.write('<a href="http://se.sundancespas.com/BackyardIdeas/BackyardIdeas.html"><IMG SRC= "' + BASEDIR + '/img/se/Ideas_On2.gif" width="158" height="34" alt="IDÉER FÖR TRÄDGÄRDEN" border="0"></A>');
	} 
	else {
		document.write('<a href="http://se.sundancespas.com/BackyardIdeas/BackyardIdeas.html" onMouseOver="iName=\'image5\'; Ichange(\'changed5\')" onMouseOut="Ichange(\'default5\')"><IMG SRC= "' + BASEDIR + '/img/se/Ideas_Off.gif" width="158" height="34" alt="IDÉER FÖR TRÄDGÄRDEN" border="0" name="image5"></A>');	
	}
	if (section == "Innovation" ) {
		document.write('<a href="http://se.sundancespas.com/Innovation/Innovation.html"><IMG SRC= "' + BASEDIR + '/img/se/Innovation_On2.gif" width="151" height="34" alt="UPPFINNINGSRIKEDOM" border="0"></A>');
	} 
	else {
		document.write('<a href="http://se.sundancespas.com/Innovation/Innovation.html" onMouseOver="iName=\'image6\'; Ichange(\'changed6\')" onMouseOut="Ichange(\'default6\')"><IMG SRC= "' + BASEDIR + '/img/se/Innovation_Off.gif" width="151" height="34" alt="UPPFINNINGSRIKEDOM" border="0" name="image6"></A>');
	}
	if (section == "Features" ) {
		document.write('<a href="http://se.sundancespas.com/FeaturesOptions/Features.html"><IMG SRC= "' + BASEDIR + '/img/se/Features_On2.gif" width="199" height="34" alt="FUNKTIONER OCH ALTERNATIV" border="0"></A>');
	} 
	else {
		document.write('<a href="http://se.sundancespas.com/FeaturesOptions/Features.html" onMouseOver="iName=\'image7\'; Ichange(\'changed7\')" onMouseOut="Ichange(\'default7\')"><IMG SRC= "' + BASEDIR + '/img/se/Features_Off.gif" width="199" height="34" alt="FUNKTIONER OCH ALTERNATIV" border="0" name="image7"></A>');
	}
	document.write();
} 

//-----------------------------------
//FOOTER NAVIGATION:
//-----------------------------------
function printFooter() {
	document.write('&copy; 2005 Sundance Spas, Inc. Alla rättigheter förbehålles.<IMG SRC="' + BASEDIR + '/img/se/Clear.gif" WIDTH="200" HEIGHT="18" HSPACE="0" VSPACE="0" BORDER="0" ALT="Sundance Spas" ALIGN="ABSMIDDLE"><A HREF="http://se.sundancespas.com/SiteMap/SiteMap.html" CLASS="nav">WEBBPLATSKARTA</A>&nbsp;&nbsp;&nbsp; <A HREF="http://se.sundancespas.com/" CLASS="nav">STARTSIDA</A>');
}
//END--------------------------------
