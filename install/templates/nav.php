<ul id="navlist">
	<li <?php if($_REQUEST['install_step'] >= "0"){ echo 'class="active"><span style="color:green;font-weight:700;">&radic;</span>'; }else{ echo '>';} ?> Welcome</li>
	<li <?php if($_REQUEST['install_step'] >= "1"){ echo 'class="active"><span style="color:green;font-weight:700;">&radic;</span>'; }else{ echo '>1.';} ?> Licence</li>
	<li <?php if($_REQUEST['install_step'] >= "2"){ echo 'class="active"><span style="color:green;font-weight:700;">&radic;</span>'; }else{ echo '>2.';} ?> Requirements</li>
	<li <?php if($_REQUEST['install_step'] >= "3"){ echo 'class="active"><span style="color:green;font-weight:700;">&radic;</span>'; }else{ echo '>3.';} ?> Database</li>
	<li <?php if($_REQUEST['install_step'] >= "4"){ echo 'class="active"><span style="color:green;font-weight:700;">&radic;</span>'; }else{ echo '>4.';} ?> Create Admin</li>
	<li <?php if($_REQUEST['install_step'] >= "5"){ echo 'class="active"><span style="color:green;font-weight:700;">&radic;</span>'; }else{ echo '>5.';} ?> Company Info.</li>
	<li <?php if($_REQUEST['install_step'] >= "6"){ echo 'class="active"><span style="color:green;font-weight:700;">&radic;</span>'; }else{ echo '>6.';} ?> Complete!</li>
</ul>