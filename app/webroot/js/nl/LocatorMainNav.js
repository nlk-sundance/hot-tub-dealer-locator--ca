//rollovers
var iName=""; 
default1 = new Image(); default1.src = BASEDIR + "/img/nl/800Series_Off.gif";
changed1 = new Image(); changed1.src = BASEDIR + "/img/nl/800Series_On.gif";
default2 = new Image(); default2.src = BASEDIR + "/img/nl/700Series_Off.gif";
changed2 = new Image(); changed2.src = BASEDIR + "/img/nl/700Series_On.gif";
default3 = new Image(); default3.src = BASEDIR + "/img/nl/680Series_Off.gif";
changed3 = new Image(); changed3.src = BASEDIR + "/img/nl/680Series_On.gif";
default4 = new Image(); default4.src = BASEDIR + "/img/nl/Therapy_Off.gif";
changed4 = new Image(); changed4.src = BASEDIR + "/img/nl/Therapy_On.gif";
default5 = new Image(); default5.src = BASEDIR + "/img/nl/Ideas_Off.gif";
changed5 = new Image(); changed5.src = BASEDIR + "/img/nl/Ideas_On.gif";
default6 = new Image(); default6.src = BASEDIR + "/img/nl/Innovation_Off.gif";
changed6 = new Image(); changed6.src = BASEDIR + "/img/nl/Innovation_On.gif";
default7 = new Image(); default7.src = BASEDIR + "/img/nl/Features_Off.gif";
changed7 = new Image(); changed7.src = BASEDIR + "/img/nl/Features_On.gif";

function Ichange(p) {
    var pSrc=eval(p+ ".src");
    document[iName].src = pSrc;
}

//Writes the navigation to the page based on variable at the top of each page.
function printMainNav() { 
	if (section == "800Series" ) {
		document.write('<a href="http://nl.sundancespas.com/800Series/800Series.html"><IMG SRC= "' + BASEDIR + '/img/nl/800Series_On2.gif" width="77" height="34" alt="800 SERIE" border="0"></A>');
	} 
	else {
		document.write('<a href="http://nl.sundancespas.com/800Series/800Series.html" onMouseOver="iName=\'image1\'; Ichange(\'changed1\')" onMouseOut="Ichange(\'default1\')"><IMG SRC= "' + BASEDIR + '/img/nl/800Series_Off.gif" width="77" height="34" alt="800 SERIE" border="0" name="image1"></A>');
	}
	if (section == "700Series" ) {
		document.write('<a href="http://nl.sundancespas.com/700Series/700Series.html"><IMG SRC= "' + BASEDIR + '/img/nl/700Series_On2.gif" width="81" height="34" alt="700 SERIE" border="0"></A>');
	} 
	else {
		document.write('<a href="http://nl.sundancespas.com/700Series/700Series.html" onMouseOver="iName=\'image2\'; Ichange(\'changed2\')" onMouseOut="Ichange(\'default2\')"><IMG SRC= "' + BASEDIR + '/img/nl/700Series_Off.gif" width="81" height="34" alt="700 SERIE" border="0" name="image2"></A>');
	}
	if (section == "680Series" ) {
		document.write('<a href="http://nl.sundancespas.com/6800Series/680Series.html"><IMG SRC= "' + BASEDIR + '/img/nl/680Series_On2.gif" width="81" height="34" alt="680 SERIE" border="0"></A>');
	} 
	else {
		document.write('<a href="http://nl.sundancespas.com/680Series/680Series.html" onMouseOver="iName=\'image3\'; Ichange(\'changed3\')" onMouseOut="Ichange(\'default3\')"><IMG SRC= "' + BASEDIR + '/img/nl/680Series_Off.gif" width="81" height="34" alt="680 SERIE" border="0" name="image3"></A>');
	}
	if (section == "Therapy" ) {
		document.write('<a href="http://nl.sundancespas.com/Therapy/Therapy.html"><IMG SRC= "' + BASEDIR + '/img/nl/Therapy_On2.gif" width="83" height="34" alt="THERAPIE" border="0"></A>');
	} 
	else {
		document.write('<a href="http://nl.sundancespas.com/Therapy/Therapy.html" onMouseOver="iName=\'image4\'; Ichange(\'changed4\')" onMouseOut="Ichange(\'default4\')"><IMG SRC= "' + BASEDIR + '/img/nl/Therapy_Off.gif" width="83" height="34" alt="THERAPIE" border="0" name="image4"></A>');
	}
	if (section == "Ideas" ) {
		document.write('<a href="http://nl.sundancespas.com/BackyardIdeas/BackyardIdeas.html"><IMG SRC= "' + BASEDIR + '/img/nl/Ideas_On2.gif" width="160" height="34" alt="IDEËEN VOOR DE TUIN " border="0"></A>');
	} 
	else {
		document.write('<a href="http://nl.sundancespas.com/BackyardIdeas/BackyardIdeas.html" onMouseOver="iName=\'image5\'; Ichange(\'changed5\')" onMouseOut="Ichange(\'default5\')"><IMG SRC= "' + BASEDIR + '/img/nl/Ideas_Off.gif" width="160" height="34" alt="IDEËEN VOOR DE TUIN " border="0" name="image5"></A>');	
	}
	if (section == "Innovation" ) {
		document.write('<a href="http://nl.sundancespas.com/Innovation/Innovation.html"><IMG SRC= "' + BASEDIR + '/img/nl/Innovation_On2.gif" width="91" height="34" alt="INNOVATIE" border="0"></A>');
	} 
	else {
		document.write('<a href="http://nl.sundancespas.com/Innovation/Innovation.html" onMouseOver="iName=\'image6\'; Ichange(\'changed6\')" onMouseOut="Ichange(\'default6\')"><IMG SRC= "' + BASEDIR + '/img/nl/Innovation_Off.gif" width="91" height="34" alt="INNOVATIE" border="0" name="image6"></A>');
	}
	if (section == "Features" ) {
		document.write('<a href="http://nl.sundancespas.com/FeaturesOptions/Features.html"><IMG SRC= "' + BASEDIR + '/img/nl/Features_On2.gif" width="187" height="34" alt="EIGENSCHAPPEN EN OPTIESEIGENSCHAPPEN EN OPTIES" border="0"></A>');
	} 
	else {
		document.write('<a href="http://nl.sundancespas.com/FeaturesOptions/Features.html" onMouseOver="iName=\'image7\'; Ichange(\'changed7\')" onMouseOut="Ichange(\'default7\')"><IMG SRC= "' + BASEDIR + '/img/nl/Features_Off.gif" width="187" height="34" alt="EIGENSCHAPPEN EN OPTIES" border="0" name="image7"></A>');
	}
	document.write();
} 

//-----------------------------------
//FOOTER NAVIGATION:
//-----------------------------------
function printFooter() {
	document.write('&copy; 2005 Sundance Spas, Inc. Alle rechten voorbehouden.<IMG SRC="' + BASEDIR + '/img/Clear.gif" WIDTH="200" HEIGHT="18" HSPACE="0" VSPACE="0" BORDER="0" ALT="Sundance Spas" ALIGN="ABSMIDDLE"><A HREF="http://nl.sundancespas.com/SiteMap/SiteMap.html" CLASS="nav">OVERZICHT VAN DE SITE</A>&nbsp;&nbsp;&nbsp; <A HREF="http://nl.sundancespas.com/" CLASS="nav">HOME</A>');
}
//END--------------------------------
