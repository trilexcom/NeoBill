<?php
/*
 * @(#)install/templates/menu.php
 *
 *    Version: 0.50.20090326
 * Written by: John Diamond <mailto:jdiamond@solid-state.org>
 * Written by: Yves Kreis <mailto:yves.kreis@hosting-skills.org>
 *
 * Copyright (C) 2006-2008 by John Diamond
 * Copyright (C) 2009 by Yves Kreis
 *
 * This program is free software; you can redistribute it and/or modify it under the terms of the GNU General Public License 
 * as published by the Free Software Foundation; either version 2 of the License, or (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied warranty 
 * of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License along with this program; if not, write to the 
 * Free Software Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA 02111-1307 USA
 *
 */
?>

          <ul id="navlist">
            <li><?php if(isset($_POST['install_step']) && $_POST['install_step'] > '0') { echo '<span style="color: green; font-weight: 700;">&radic;</span>'; } else { echo '&nbsp;&nbsp;&nbsp;';} ?> <?php echo _INSTALLERSTEP0; ?></li>
            <li><?php if(isset($_POST['install_step']) && $_POST['install_step'] > '1') { echo '<span style="color: green; font-weight: 700;">&radic;</span>'; } else { echo '1.';} ?> <?php echo _INSTALLERSTEP1; ?></li>
            <li><?php if(isset($_POST['install_step']) && $_POST['install_step'] > '2') { echo '<span style="color: green; font-weight: 700;">&radic;</span>'; } else { echo '2.';} ?> <?php echo _INSTALLERSTEP2; ?></li>
            <li><?php if(isset($_POST['install_step']) && $_POST['install_step'] > '3') { echo '<span style="color: green; font-weight: 700;">&radic;</span>'; } else { echo '3.';} ?> <?php echo _INSTALLERSTEP3; ?></li>
            <li><?php if(isset($_POST['install_step']) && $_POST['install_step'] > '4') { echo '<span style="color: green; font-weight: 700;">&radic;</span>'; } else { echo '4.';} ?> <?php echo _INSTALLERSTEP4; ?></li>
            <li><?php if(isset($_POST['install_step']) && $_POST['install_step'] > '5') { echo '<span style="color: green; font-weight: 700;">&radic;</span>'; } else { echo '5.';} ?> <?php echo _INSTALLERSTEP5; ?></li>
            <li><?php if(isset($_POST['install_step']) && $_POST['install_step'] > '6') { echo '<span style="color: green; font-weight: 700;">&radic;</span>'; } else { echo '6.';} ?> <?php echo _INSTALLERSTEP6; ?></li>
          </ul>
