<?php header("Content-type:text/xml"); print("<?xml version=\"1.0\"?>");
    sleep(2);
?>
<content tab="b<?=$_GET['num']?>">
    <![CDATA[
	<?=(isset($_GET['step'])?"<hr/>Reloaded<hr/>":"")?>
    <h3>This is content for tab <?=$_GET['num']?></h3>
<center>
<table border="0" cellpadding="0" cellspacing="0" width="100%" height="100%">
  <tr valign="top">
	<td width="100%" align="center">

<table border="0" cellpadding="0" cellspacing="0" width=100%>
  <tr>
    <td width="20%"></td>
    <td width="60%" align="center">
      <a href="http://scbr.com/docs/company.shtml" onFocus="blur();">
      <img src="http://scbr.com/img/globe1.gif" border="0" width="369" height="368" alt="">
      </a>
    </td>
    <td width=20%></td>
  </tr>
  <tr>
    <td align="center" colspan="3">
<p><font size="4" color="#53A9CF">Effective e-Migration</font></p>

<p>
<a href="http://scbr.com/docs/company.shtml" class="ho">
Scand LLC is a software development company based in Eastern Europe (Minsk, Belarus).</a>
</p>
<p>
We are 90 IT engineers specializing in software development: J2EE, .NET, C++, PHP and other.
</p>
<p>
<a href="http://scbr.com/docs/services.shtml" class=ho>
We help companies to achieve competitive advantage in the internet age.
</a>
</p>

    </td>
  </tr>
</table>

	</td>
    <td width=30%></td>
  </tr>
</table>

</center>
    ]]>
</content>
