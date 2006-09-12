<?php
/**
 * PostNuke Application Framework
 *
 * @copyright (c) 2001, PostNuke Development Team
 * @link http://www.postnuke.com
 * @version $Id: function.installtypes.php 19171 2006-05-30 12:06:21Z markwest $
 * @license GNU/GPL - http://www.gnu.org/copyleft/gpl.html
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
 *   <!--[installtypes name=installtype]-->
 *
 *
 * @author       Mark West
 * @since        13 August 2005
 * @param        array       $params      All attributes passed to this function from the template
 * @param        object      &$smarty     Reference to the Smarty object
 * @return       string      the value of the last status message posted, or void if no status message exists
 */
function smarty_function_installtypes($params, &$smarty)
{
    extract($params);

    unset($params['name']);
    unset($params['all']);

    if (!isset($name)) {
        $smarty->trigger_error("languagelist:  parameter 'name' required");
        return false;
    }

    if (!isset($all)) {
        $all = true;
    }

    $installtypesdropdown = '<select name="'.pnVarPrepForDisplay($name).'">'."\n";

    $handle = opendir('install/pninstalltypes/');
    $installtypes = array();
    while ($f = readdir($handle)) {
        if ($f != '.' && $f != '..' && $f != 'CVS' & $f != '.svn' && $f != 'index.html') {
            $f = str_replace('.php', '', $f);
            $installtypes["$f"] = constant('_INSTALLER'.strtoupper($f));
        }
    }
    closedir($handle);
    foreach($installtypes as $installtype => $installlabel) {
        $installtypesdropdown .= '<option value="'.pnVarPrepForDisplay($installtype).'">'.pnVarPrepForDisplay($installlabel).'</option>'."\n";
    }
    $installtypesdropdown .= '<option value="complete">'.pnVarPrepForDisplay(_INSTALLERCOMPLETE).'</option>'."\n";
    $installtypesdropdown .= '</select>'."\n";

    if (isset($assign)) {
        $smarty->assign($assign, $installtypesdropdown);
    } else {
        return $installtypesdropdown;
    }
}

?>