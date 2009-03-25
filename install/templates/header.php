<?php
/*
 * @(#)install/templates/header.php
 *
 *    Version: 0.50.20090325
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
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">
<head>
  <link rel="stylesheet" href="style/style.css" type="text/css" />
  <meta http-equiv="content-type" content="text/html; charset=utf-8" />
  <meta name="description" content="Open Source Customer Management and Billing Software for Web Hosts" />
  <meta name="robots" content="index, follow" />
  <meta name="resource-type" content="document" />
  <meta http-equiv="expires" content="0" />
  <meta name="author" content="John Diamond" />
  <meta name="author" content="Yves Kreis" />
  <meta name="copyright" content="Copyright (C) 2006-2008 by John Diamond" />
  <meta name="copyright" content="Copyright (C) 2009 by Yves Kreis" />
  <meta name="revisit-after" content="1 days" />
  <meta name="distribution" content="global" />
  <meta name="rating" content="general" />
  <title>SolidState :: Open Source Customer Management and Billing Software for Web Hosts</title>
</head>
<body>
  <div id="content1">
    <div id="content2">
      <div class="leftnav">
        <div id="navcontainer">
          <h1><?php echo _INSTALLERSTEPS; ?></h1><?php include "templates/menu.php"; ?>
        </div>
        <div class="helpbox"><?php include "templates/help.php"; ?>
        </div>
      </div>
      <div id="maincolumn">
        <div class="header">                               
          <div id="logo">
            <img src="images/logo.gif" alt="SolidState" />
          </div>
          <div style="clear: both;">
          </div>
        </div><?php include "templates/graph.php"; ?>