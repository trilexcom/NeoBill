function showDomainBox()
{
	options = document.purchasehosting.domainoption;
	if ( options[0].checked )
	{
		document.getElementById( "newdomain" ).style.display="block";
		document.getElementById( "transferdomain" ).style.display="none";
		document.getElementById( "incartdomain" ).style.display = "none";
		document.getElementById( "existingdomain" ).style.display = "none";
	}
	else if ( options[1].checked )
	{
		document.getElementById( "newdomain" ).style.display="none";
		document.getElementById( "transferdomain" ).style.display="block";
		document.getElementById( "incartdomain" ).style.display = "none";
		document.getElementById( "existingdomain" ).style.display = "none";
	}
	else if ( options[2].checked )
	{
		document.getElementById( "newdomain" ).style.display="none";
		document.getElementById( "transferdomain" ).style.display="none";
		document.getElementById( "incartdomain" ).style.display = "block";
		document.getElementById( "existingdomain" ).style.display = "none";
	}
	else if ( options[3].checked )
	{
		document.getElementById( "newdomain" ).style.display="none";
		document.getElementById( "transferdomain" ).style.display="none";
		document.getElementById( "incartdomain" ).style.display = "none";
		document.getElementById( "existingdomain" ).style.display = "block";
	}
}
