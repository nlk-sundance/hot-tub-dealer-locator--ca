//-----------------------------------
//CORPORATE NAVIGATION:
//-----------------------------------
function goto_URL(object) {
    window.location.href = object.options[object.selectedIndex].value;
}

function printTopNav() {
	document.write('<TABLE WIDTH="760" CELLPADDING="0" CELLSPACING="0" BORDER="0"><TR><TD WIDTH="250" ALIGN="LEFT" VALIGN="TOP"><IMG SRC="'+BASEDIR+'/img/retailer/Clear.gif" WIDTH="210" HEIGHT="42" HSPACE="18" VSPACE="0" BORDER="0"><BR><A HREF="http://www.sundancespas.com"><IMG SRC="'+BASEDIR+'/img/Logo.gif" WIDTH="210" HEIGHT="30" HSPACE="18" VSPACE="0" BORDER="0"></A><BR></TD><TD WIDTH="510" ALIGN="LEFT" VALIGN="TOP"><DIV ALIGN="RIGHT" STYLE="padding: 30px 6px 0 0; position: relative;"><form action="http://www.sundancespas.com/search/search.php" method="post" id="search"><input name="path" value="" type="hidden"><input name="refine" value="0" type="hidden"><input name="result_page" value="search.php" type="hidden"><input name="limite" value="10" type="hidden"><input name="option" value="start" type="hidden"><input name="site" value="" type="hidden"><input size="20" maxlength="50" name="query_string" value="Search Website" id="box" type="text"><span><input value="submit" src="http://www.sundancespas.com/2005Images/Nav/search-btn.gif" class="img" type="image"></span></form><FORM STYLE="margin: 14px 0 0;"><a href="http://retailer.sundancespas.com"><IMG SRC="'+BASEDIR+'/img/retailer/LocateDealerBTN.gif" WIDTH="116" HEIGHT="18" BORDER="0" HSPACE="0" VSPACE="0" ALT="Locate A Dealer"></a>&nbsp;&nbsp;&nbsp;&nbsp;<SELECT NAME="selectName" onChange="goto_URL(this.form.selectName)" ID="dropdown" STYLE="margin-bottom: 5px;"><OPTION VALUE="#">&nbsp;&nbsp;Language&nbsp;&nbsp;</OPTION><OPTION VALUE="http://de.sundancespas.com">&nbsp;&nbsp;&nbsp;&nbsp;Deutsch</OPTION><OPTION VALUE="http://www.sundancespas.com">&nbsp;&nbsp;&nbsp;&nbsp;English</OPTION><OPTION VALUE="http://es.sundancespas.com">&nbsp;&nbsp;&nbsp;&nbsp;Espa&ntilde;ol</OPTION><OPTION VALUE="http://ca.sundancespas.com">&nbsp;&nbsp;&nbsp;&nbsp;Fran&ccedil;ais (Canadien)</OPTION><OPTION VALUE="http://fr.sundancespas.com">&nbsp;&nbsp;&nbsp;&nbsp;Fran&ccedil;ais (Europ&eacute;en)</OPTION><OPTION VALUE="http://it.sundancespas.com">&nbsp;&nbsp;&nbsp;&nbsp;Italiano</OPTION><OPTION VALUE="http://nl.sundancespas.com">&nbsp;&nbsp;&nbsp;&nbsp;Nederlands</OPTION><OPTION VALUE="http://no.sundancespas.com">&nbsp;&nbsp;&nbsp;&nbsp;Norsk</OPTION><OPTION VALUE="http://pt.sundancespas.com">&nbsp;&nbsp;&nbsp;&nbsp;Portugu&ecirc;s</OPTION><OPTION VALUE="http://se.sundancespas.com">&nbsp;&nbsp;&nbsp;&nbsp;Svenska</OPTION></SELECT></FORM></DIV><DIV ALIGN="RIGHT" STYLE="padding-right: 6px;">');
	if (section == "AboutUs" ) {
		document.write('<b><A HREF="http://www.sundancespas.com/AboutUs/AboutUs.html" CLASS="nav">ABOUT US</A>&nbsp;&nbsp;&nbsp;&nbsp;</b>');
	}
	else {
		document.write('<A HREF="http://www.sundancespas.com/AboutUs/AboutUs.html" CLASS="nav">ABOUT US</A>&nbsp;&nbsp;&nbsp;&nbsp;');
	}
	if (section == "RequestLit" ) {
		document.write('<b><A HREF="http://www.sundancespas.com/RequestLiterature/RequestLiterature.html" CLASS="nav">REQUEST LITERATURE</A>&nbsp;&nbsp;&nbsp;&nbsp;</b>');
	}
	else {
		document.write('<A HREF="http://www.sundancespas.com/RequestLiterature/RequestLiterature.html" CLASS="nav">REQUEST LITERATURE</A>&nbsp;&nbsp;&nbsp;&nbsp;');
	}
	if (section == "CustomerCare" ) {
		document.write('<b><A HREF="http://www.sundancespas.com/CustomerCare/CustomerCare.html" CLASS="nav">CUSTOMER CARE</A>&nbsp&nbsp;&nbsp;&nbsp;</b>');
	}
	else {
		document.write('<A HREF="http://www.sundancespas.com/CustomerCare/CustomerCare.html" CLASS="nav">CUSTOMER CARE</A>&nbsp&nbsp;&nbsp;&nbsp;');
	}

	if (section == "BecomeADealer" ) {
		document.write('<b><A HREF="http://www.sundancespas.com/BecomeADealer/BecomeADealer.html" CLASS="nav">BECOME A DEALER</A>&nbsp;&nbsp;&nbsp;</b>');
	}
	else {
		document.write('<A HREF="http://www.sundancespas.com/BecomeADealer/BecomeADealer.html" CLASS="nav">BECOME A DEALER</A>&nbsp;&nbsp;&nbsp;&nbsp;');
	}
	if (section == "Contact" ) {
		document.write('<b><A HREF="http://www.sundancespas.com/Contact/Contact.html" CLASS="nav">CONTACT</A></b><BR></DIV></TD></TR></TABLE>');
	}
	else {
		document.write('<A HREF="http://www.sundancespas.com/Contact/Contact.html" CLASS="nav">CONTACT</A><BR></DIV></TD></TR></TABLE>');
	}
}
//END--------------------------------


//-----------------------------------
//FOOTER NAVIGATION:
//-----------------------------------
function printFooter() {
	document.write('<A HREF="http://www.sundancespas.com/Policies.html" onClick="window.open(\'http://www.sundancespas.com/Policies.html\', \'Policies\', \'width=580, height=500, location=no, menubar=no,resizeable=1,scrollbars=yes,toolbar=0,top=10,left=100\');return false;">POLICIES</A> &nbsp;&nbsp;&nbsp; Copyright &copy; 2007 Sundance Spas, Inc. All rights reserved.<IMG src="'+BASEDIR+'/img/retailer/Clear.gif" width="100" Height="14" ALIGN="ABSMIDDLE" border="0"><A HREF="http://www.sundancespas.com/Resources/Hot-Tub-Listing.html" class="nav">HOT TUB LISTING</A>&nbsp;&nbsp;&nbsp;&nbsp;<A HREF="http://www.sundancespas.com/SiteMap/SiteMap.html" class="nav">SITE MAP</A>&nbsp;&nbsp;&nbsp;&nbsp;<A HREF="http://www.sundancespas.com" CLASS="nav">HOME</A><BR><BR>');
}
//END--------------------------------
