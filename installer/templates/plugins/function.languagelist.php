<?php
/**
 * PostNuke Application Framework
 *
 * @copyright (c) 2001, PostNuke Development Team
 * @link http://www.postnuke.com
 * @version $Id: function.languagelist.php 18169 2006-03-16 02:17:22Z drak $
 * @license GNU/GPL - http://www.gnu.org/copyleft/gpl.html
 * @package      Xanthia_Templating_Environment
 * @subpackage   pnRender
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
 *   <!--[languagelist name=language selected=eng]-->
 *
 *
 * @author       Mark West
 * @since        25 April 2004
 * @param        array       $params      All attributes passed to this function from the template
 * @param        object      &$smarty     Reference to the Smarty object
 * @return       string      the value of the last status message posted, or void if no status message exists
 */
function smarty_function_languagelist($params, &$smarty)
{
    extract($params);

    unset($params['name']);
    unset($params['selected']);
    unset($params['all']);
    unset($params['installed']);// itevo, MNA: added param to show only installed languages in pulldown

    if (!isset($name)) {
        $smarty->trigger_error("languagelist:  parameter 'name' required");
        return false;
    }

    if (!isset($all)) {
        $all = true;
    }

    $languagelist = languagelist();

    $languagedropdown = '<select name="'.pnVarPrepForDisplay($name)."\">\n";
    if ($all) {
        $languagedropdown .= '<option value="">'.pnVarPrepForDisplay(_ALL)."</option>\n";
    }
    foreach ($languagelist as $code => $text) {
        if (isset($selected) && $code == $selected) {
            $selectedtext = ' selected="selected"';
        } else {
            $selectedtext = '';
        }
        // itevo, MNA: added param to show only installed languages in pulldown
        if (($installed && is_dir("language/$code")) || empty($installed)) {
            $languagedropdown .= '<option value="'.pnVarPrepForDisplay($code)."\"$selectedtext>".pnVarPrepForDisplay($text)."</option>\n";
        }
        // /itevo
    }
    $languagedropdown .= "</select>";

    if (isset($assign)) {
        $smarty->assign($assign, $languagedropdown);
    } else {
        return $languagedropdown;
    }
}
?>