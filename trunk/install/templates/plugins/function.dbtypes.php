<?php
// $Id: function.dbtypes.php 18222 2006-03-17 15:21:50Z markwest $
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
 * @version      $Id: function.dbtypes.php 18222 2006-03-17 15:21:50Z markwest $
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
 *   - name:     Name for the control
 *   - selected: Selected value
 *   - installed: if set only show languages existing in languages folder
 *
 * Example
 *   <!--[dbtypes name=dbtype]-->
 *
 *
 * @author       Mark West
 * @since        17 March 2006
 * @param        array       $params      All attributes passed to this function from the template
 * @param        object      &$smarty     Reference to the Smarty object
 * @return       string      the value of the last status message posted, or void if no status message exists
 */
function smarty_function_dbtypes($params, &$smarty)
{
    extract($params);

    unset($params['name']);

    if (!isset($name)) {
        $smarty->trigger_error("dbtypes:  parameter 'name' required");
        return false;
    }

    $dbtypesdropdown = '<select name="'.pnVarPrepForDisplay($name).'">'."\n";
    if (function_exists('mysql_connect')) {
        $dbtypesdropdown .= '<option value="mysql">MySQL</option>'."\n";
    }
    if (function_exists('mysqli_connect')) {
        $dbtypesdropdown .= '<option value="mysqli">MySQL Improved</option>'."\n";
    }
    if (function_exists('pg_connect')) {
        $dbtypesdropdown .= '<option value="postgres">Postgres</option>'."\n";
    }
    $dbtypesdropdown .= '</select>'."\n";

    if (isset($assign)) {
        $smarty->assign($assign, $dbtypesdropdown);
    } else {
        return $dbtypesdropdown;
    }
}

?>