function gtabber_submit()
{
	if(document.gtabber_form.gtabber_group.value == "")
	{
		alert(GTabber_adminscripts.gtabber_group);
		document.gtabber_form.gtabber_group.focus();
		return false;
	}
	else if(document.gtabber_form.gtabber_text.value == "")
	{
		alert(GTabber_adminscripts.gtabber_text);
		document.gtabber_form.gtabber_text.focus();
		return false;
	}
}

function gtabber_delete(id)
{
	if(confirm(GTabber_adminscripts.gtabber_delete))
	{
		document.frm_gtabber_display.action="options-general.php?page=wp-tabber-widget&ac=del&did="+id;
		document.frm_gtabber_display.submit();
	}
}	

function gtabber_group_load(val)
{
	if(val != "")
	{
		document.gtabber_form.gtabber_group.value = val;
	}
	else
	{
		document.gtabber_form.gtabber_group.value = "";
	}
}

function gtabber_redirect()
{
	window.location = "options-general.php?page=wp-tabber-widget";
}

function gtabber_help()
{
	window.open("http://www.gopiplus.com/work/2012/11/10/tabber-widget-plugin-for-wordpress/");
}