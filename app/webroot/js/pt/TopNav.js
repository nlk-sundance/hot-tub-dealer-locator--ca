//-----------------------------------
//CORPORATE NAVIGATION:
//-----------------------------------
function goto_URL(object) {
    window.location.href = object.options[object.selectedIndex].value;
}

function printTopNav() {
	document.write('<TABLE WIDTH="760" CELLPADDING="0" CELLSPACING="0" BORDER="0"><TR><TD WIDTH="228" ALIGN="LEFT" VALIGN="TOP"><IMG SRC="' + BASEDIR + '/img/pt/Clear.gif" WIDTH="210" HEIGHT="42" HSPACE="18" VSPACE="0" BORDER="0" ALT="Sundance Spas"><BR><A HREF="http://pt.sundancespas.com"><IMG SRC="' + BASEDIR + '/img/Logo.gif" WIDTH="210" HEIGHT="30" HSPACE="18" VSPACE="0" BORDER="0" ALT="Sundance Spas"></A><BR></TD><TD WIDTH="532" ALIGN="LEFT" VALIGN="TOP"><DIV ALIGN="RIGHT" STYLE="padding-right: 6px; padding-top: 10px;"><FORM STYLE="margin-bottom: 0px;"><SELECT NAME="selectName" onChange="goto_URL(this.form.selectName)" ID="dropdown"><OPTION VALUE="#">&nbsp;&nbsp;Procurar por Idioma&nbsp;&nbsp;<OPTION VALUE="http://de.sundancespas.com">&nbsp;&nbsp;&nbsp;&nbsp;Deutsch</OPTION><OPTION VALUE="http://www.sundancespas.com">&nbsp;&nbsp;&nbsp;&nbsp;English</OPTION><OPTION VALUE="http://es.sundancespas.com">&nbsp;&nbsp;&nbsp;&nbsp;Español</OPTION><OPTION VALUE="http://ca.sundancespas.com">&nbsp;&nbsp;&nbsp;&nbsp;Français (Canadien)</OPTION><OPTION VALUE="http://fr.sundancespas.com">&nbsp;&nbsp;&nbsp;&nbsp;Français (Européen)</OPTION><OPTION VALUE="http://it.sundancespas.com">&nbsp;&nbsp;&nbsp;&nbsp;Italiano</OPTION><OPTION VALUE="http://nl.sundancespas.com">&nbsp;&nbsp;&nbsp;&nbsp;Nederlands</OPTION><OPTION VALUE="http://no.sundancespas.com">&nbsp;&nbsp;&nbsp;&nbsp;Norsk</OPTION><OPTION VALUE="http://pt.sundancespas.com">&nbsp;&nbsp;&nbsp;&nbsp;Português</OPTION><OPTION VALUE="http://se.sundancespas.com">&nbsp;&nbsp;&nbsp;&nbsp;Svenska</OPTION></SELECT>&nbsp;&nbsp;&nbsp;&nbsp;<INPUT TYPE="button" ID="Button" VALUE="Localizar um Revendedor" onClick="location.href=\'http://pt.sundancespas.com/Retailers\'"></DIV></FORM></TD></TR><TR><TD COLSPAN="2"><DIV ALIGN="RIGHT" STYLE="padding-right: 6px; padding-top: 0px;">');
	if (section == "AboutUs" ) {
		document.write('<b><A HREF="http://pt.sundancespas.com/AboutUs/AboutUs.html" CLASS="nav">QUEM SOMOS</A>&nbsp;&nbsp;&nbsp;&nbsp;</b>');
	}
	else {
		document.write('<A HREF="http://pt.sundancespas.com/AboutUs/AboutUs.html" CLASS="nav">QUEM SOMOS</A>&nbsp;&nbsp;&nbsp;&nbsp;');
	}	
	if (section == "RequestLit" ) {
		document.write('<b><A HREF="http://pt.sundancespas.com/RequestLiterature/RequestLiterature.html" CLASS="nav">SOLICITAR UMA BROCHURA</A>&nbsp;&nbsp;&nbsp;&nbsp;</b>');
	}
	else {
		document.write('<A HREF="http://pt.sundancespas.com/RequestLiterature/RequestLiterature.html" CLASS="nav">SOLICITAR UMA BROCHURA</A>&nbsp;&nbsp;&nbsp;&nbsp;');
	}
	if (section == "CustomerCare" ) {
		document.write('<b><A HREF="http://pt.sundancespas.com/CustomerCare/CustomerCare.html" CLASS="nav">ASSISTÊNCIA APÓS-VENDA</A>&nbsp&nbsp;&nbsp;</b>');
	}
	else {
		document.write('<A HREF="http://pt.sundancespas.com/CustomerCare/CustomerCare.html" CLASS="nav">ASSISTÊNCIA APÓS-VENDA</A>&nbsp&nbsp;&nbsp;&nbsp;');
	}
	if (section == "Contact" ) {
		document.write('<b><A HREF="http://pt.sundancespas.com/Contact/Contact.html" CLASS="nav">CONTACTO</A></b><BR></TD></TR></TABLE>');
	}
	else {
		document.write('<A HREF="http://pt.sundancespas.com/Contact/Contact.html" CLASS="nav">CONTACTO</A><BR></TD></TR></TABLE>');
	}
}
//END--------------------------------
