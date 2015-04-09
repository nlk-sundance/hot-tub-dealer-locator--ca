//-----------------------------------
//CORPORATE NAVIGATION:
//-----------------------------------
function goto_URL(object) {
    window.location.href = object.options[object.selectedIndex].value;
}

function printCorpNav() {
	document.write('<A HREF="/HotTubs/HotTubs.html"><IMG SRC="/2005Images/Nav/HotTubs.gif" WIDTH="155" HEIGHT="22" HSPACE="0" VSPACE="0" BORDER="0" ALT="Hot Tubs"></A><BR><A HREF="/Transformations/Transformations.html"><IMG SRC="/2005Images/Nav/Transformations.gif" WIDTH="155" HEIGHT="22" HSPACE="0" VSPACE="0" BORDER="0" ALT="Transformations"></A><BR><A HREF="/RequestInformation/RequestInformation.php"><IMG SRC="/2005Images/Nav/Request.gif" WIDTH="155" HEIGHT="22" HSPACE="0" VSPACE="0" BORDER="0" ALT="Request Information"></A><BR><A HREF="/About/About.html"><IMG SRC="/2005Images/Nav/About.gif" WIDTH="155" HEIGHT="22" HSPACE="0" VSPACE="0" BORDER="0" ALT="About Jacuzzi"></A><BR><A HREF="/About/History.html"><IMG SRC="/2005Images/Nav/History.gif" WIDTH="155" HEIGHT="22" HSPACE="0" VSPACE="0" BORDER="0" ALT="Jacuzzi History"></A><BR><A HREF="/RequestInformation/Manuals.html"><IMG SRC="/2005Images/Nav/Manuals.gif" WIDTH="155" HEIGHT="22" HSPACE="0" VSPACE="0" BORDER="0" ALT="Manuals / Warranty"></A><BR>');
	
}

function printSubNav() {
	document.write('<A HREF="/HotTubs/400Series.shtml"><IMG SRC="/2005Images/Nav/400Series.gif" WIDTH="155" HEIGHT="23" HSPACE="0" VSPACE="0" BORDER="0" ALT="400 Series"></A><BR><A HREF="/HotTubs/300Series.shtml"><IMG SRC="/2005Images/Nav/300Series.gif" WIDTH="155" HEIGHT="23" HSPACE="0" VSPACE="0" BORDER="0" ALT="J-300&trade; Collection"></A><BR><A HREF="/HotTubs/200Series.shtml"><IMG SRC="/2005Images/Nav/200Series.gif" WIDTH="155" HEIGHT="23" HSPACE="0" VSPACE="0" BORDER="0" ALT="J-200&trade; Collection"></A><BR><A HREF="/HotTubs/Accessories/Accessories.html"><IMG SRC="/2005Images/Nav/Accessories.gif" WIDTH="155" HEIGHT="23" HSPACE="0" VSPACE="0" BORDER="0" ALT="Accessories"></A><BR>');
	
}

function printSubNavTransformations() {
	document.write('<A HREF="/Transformations/HotTubSelectionGuide.html"><IMG SRC="/2005Images/Nav/HotTubSelection.gif" WIDTH="155" HEIGHT="23" HSPACE="0" VSPACE="0" BORDER="0" ALT="Hot Tub Selection Guide"></A><BR><A HREF="/Transformations/Articles.html"><IMG SRC="/2005Images/Nav/Articles.gif" WIDTH="155" HEIGHT="23" HSPACE="0" VSPACE="0" BORDER="0" ALT="Articles"></A><BR>');
	
}

//-----------------------------------
//CORPORATE BREADCRUMB:
//-----------------------------------
function printBreadcrumb() {

if (section == "HotTubsIntro" ) {
		document.write('<DIV STYLE="margin-bottom: 3px;"><A HREF="/index.html" CLASS="crumb">HOME</A> > HOT TUBS<BR></DIV>');
	} 
	else {
		document.write('');
	}

if (section == "HotTubs" ) {
		document.write('<DIV STYLE="margin-bottom: 3px;"><A HREF="/index.html" CLASS="crumb">HOME</A> > <A HREF="/HotTubs/HotTubs.html" CLASS="crumb">HOT TUBS</A> >');
	} 
	else {
		document.write('');
	}
if (section == "HotTubs400" ) {
		document.write('<DIV STYLE="margin-bottom: 3px;"><A HREF="/index.html" CLASS="crumb">HOME</A> > <A HREF="/HotTubs/HotTubs.html" CLASS="crumb">HOT TUBS</A> > <A HREF="/HotTubs/400Series.shtml" CLASS="crumb">J-400&trade; COLLECTION</A> >');
	} 
	else {
		document.write('');
	}
		
if (section == "HotTubs300" ) {
		document.write('<DIV STYLE="margin-bottom: 3px;"><A HREF="/index.html" CLASS="crumb">HOME</A> > <A HREF="/HotTubs/HotTubs.html" CLASS="crumb">HOT TUBS</A> > <A HREF="/HotTubs/300Series.shtml" CLASS="crumb">J-300&trade; COLLECTION</A> >');
	} 
	else {
		document.write('');
	}
	
if (section == "HotTubs200" ) {
		document.write('<DIV STYLE="margin-bottom: 3px;"><A HREF="/index.html" CLASS="crumb">HOME</A> > <A HREF="/HotTubs/HotTubs.html" CLASS="crumb">HOT TUBS</A> > <A HREF="/HotTubs/200Series.shtml" CLASS="crumb">J-200&trade; COLLECTION</A> >');
	} 
	else {
		document.write('');
	}

if (section == "Difference" ) {
		document.write('<DIV STYLE="margin-bottom: 3px;"><A HREF="/index.html" CLASS="crumb">HOME</A> > <A HREF="/HotTubs/HotTubs.html" CLASS="crumb">HOT TUBS</A> > THE JACUZZI DIFFERENCE<BR></DIV>');
	} 
	else {
		document.write('');
	}
	
if (section == "Features300" ) {
		document.write('<DIV STYLE="margin-bottom: 3px;"><A HREF="/index.html" CLASS="crumb">HOME</A> > <A HREF="/HotTubs/HotTubs.html" CLASS="crumb">HOT TUBS</A> > <A HREF="/HotTubs/Features/Features300.html" CLASS="crumb">J-300&trade; COLLECTION FEATURES</A> >');
	} 
	else {
		document.write('');
	}

if (section == "Features200" ) {
		document.write('<DIV STYLE="margin-bottom: 3px;"><A HREF="/index.html" CLASS="crumb">HOME</A> > <A HREF="/HotTubs/HotTubs.html" CLASS="crumb">HOT TUBS</A> > <A HREF="/HotTubs/Features/Features200.html" CLASS="crumb">J-200&trade; COLLECTION  FEATURES</A> >');
	} 
	else {
		document.write('');
	}
	
if (section == "Transformations" ) {
		document.write('<DIV STYLE="margin-bottom: 3px;"><A HREF="/index.html" CLASS="crumb">HOME</A> > TRANSFORMATIONS<BR></DIV>');
	} 
	else {
		document.write('');
	}
	
if (section == "Selection" ) {
		document.write('<DIV STYLE="margin-bottom: 3px;"><A HREF="/index.html" CLASS="crumb">HOME</A> > <A HREF="/Transformations/Transformations.html" CLASS="crumb">TRANSFORMATIONS</A> > HOT TUB SELECTION GUIDE<BR></DIV>');
	} 
	else {
		document.write('');
	}
	
if (section == "ArticlesIntro" ) {
		document.write('<DIV STYLE="margin-bottom: 3px;"><A HREF="/index.html" CLASS="crumb">HOME</A> > <A HREF="/Transformations/Transformations.html" CLASS="crumb">TRANSFORMATIONS</A> > ARTICLES<BR></DIV>');
	} 
	else {
		document.write('');
	}
	
if (section == "Articles" ) {
		document.write('<DIV STYLE="margin-bottom: 3px;"><A HREF="/index.html" CLASS="crumb">HOME</A> > <A HREF="/Transformations/Transformations.html" CLASS="crumb">TRANSFORMATIONS</A> > <A HREF="/Transformations/Articles.html" CLASS="crumb">ARTICLES</A> >');
	} 
	else {
		document.write('');
	}
	
if (section == "Info" ) {
		document.write('<DIV STYLE="margin-bottom: 3px;"><A HREF="/index.html" CLASS="crumb">HOME</A> > REQUEST INFORMATION<BR></DIV>');
	} 
	else {
		document.write('');
	}
	
if (section == "Manuals" ) {
		document.write('<DIV STYLE="margin-bottom: 3px;"><A HREF="/index.html" CLASS="crumb">HOME</A> > MANUALS / WARRANTY<BR></DIV>');
	} 
	else {
		document.write('');
	}
	
if (section == "About" ) {
		document.write('<DIV STYLE="margin-bottom: 3px;"><A HREF="/index.html" CLASS="crumb">HOME</A> > ABOUT JACUZZI<BR></DIV>');
	} 
	else {
		document.write('');
	}
	
if (section == "History" ) {
		document.write('<DIV STYLE="margin-bottom: 3px;"><A HREF="/index.html" CLASS="crumb">HOME</A> > HISTORY OF JACUZZI<BR></DIV>');
	} 
	else {
		document.write('');
	}
	
}