<?php
// $Id: function.themelist.php 18650 2006-04-04 20:48:50Z markwest $
// ----------------------------------------------------------------------
// PostNuke Content Management System
// Copyright (C) 2002 by the PostNuke Development Team.
// http://www.postnuke.com/
// ----------------------------------------------------------------------
// LICENSE
//
// This program is free software; you can redistribute it and/or
// modify it under the terms of the GNU General Public License (GPL)
// as published by the Free Software Foundation; either version 2
// of the License, or (at your option) any later version.
//
// This program is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
//
// To read the license please visit http://www.gnu.org/copyleft/gpl.html
// ----------------------------------------------------------------------
/**
 * pnRender plugin
 *
 * This file is a plugin for pnRender, the PostNuke implementation of Smarty
 *
 * @package      Xanthia_Templating_Environment
 * @subpackage   pnRender
 * @version      $Id: function.themelist.php 18650 2006-04-04 20:48:50Z markwest $
 * @author       The PostNuke development team
 * @link         http://www.postnuke.com  The PostNuke Home Page
 * @copyright    Copyright (C) 2002 by the PostNuke Development Team
 * @license      http://www.gnu.org/copyleft/gpl.html GNU General Public License
 */


/**
 * Smarty function to display a drop down list of languages
 *
 * Available parameters:
 *   - assign:   If set, the results are assigned to the corresponding variable instead of printed out
 *   - selected: Selected value
 *
 * Example
 *   <!--[languagelist name=language selected=eng]-->
 *
 *
 * @author       Mark West
 * @since        25 April 2004
 * @param        array       $params      All attributes passed to this function from the template
 * @param        object      &$smarty     Reference to the Smarty object
 * @return       string      the value of the last status message posted, or void if no status message exists
 */
function smarty_function_themelist($params, &$smarty)
{
    extract($params);

    if (!isset($selected)) {
        $selected = 'ExtraLite';
    }

    $handle = opendir('themes');
    while (false !== ($f = readdir($handle))) {
        if (is_dir("themes/$f") && file_exists("themes/$f/images/preview_large.png")) {
            $themelist[$f] = "themes/$f/images/preview_large.png";
        }
    }
    closedir ($handle);
    
    $themestring = '<table width="100%">';
    foreach ($themelist as $theme => $imagepath) {
        $themestring .= '<tr>';
        $themestring .= '<td><label for="' . pnVarPrepForDisplay($theme). '">' . pnVarPrepForDisplay($theme) . '</label></td>';
        $themestring .= '<td><input id="' . pnVarPrepForDisplay($theme) . '" type="radio" name="defaulttheme" value="' . pnVarPrepForDisplay($theme) . '"';
        if ($theme == $selected) $themestring .= ' checked="checked"';
        $themestring .= ' /></td>';
        $themestring .= '<td><img src="' . pnVarPrepForDisplay($imagepath) . '" alt="" /></td>';
        $themestring .= '</tr>';
        $i++;
    }
    $themestring .= '</table>';

    if (isset($assign)) {
        $smarty->assign($assign, $themestring);
    } else {
        return $themestring;
    }
}
?>