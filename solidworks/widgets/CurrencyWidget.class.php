<?php
/**
 * CurrencyWidget.class.php
 *
 * This file contains the definition of the CurrencyWidget class.  
 *
 * @package SolidWorks
 * @author John Diamond <jdiamond@solid-state.org>
 * @copyright John Diamond <jdiamond@solid-state.org>
 * @license http://www.opensource.org/licenses/gpl-license.php GNU Public License
 */

/**
 * CurrencyWidget
 *
 * @package SolidWorks
 * @author John Diamond <jdiamond@solid-state.org>
 */
class CurrencyWidget extends TextWidget
{
  /**
   * Get Widget HTML
   *
   * Returns HTML code for this widget
   *
   * @param array $params Parameters passed from the template
   * @return string HTML code for this widget
   */
  function getHTML( $params ) 
  {
    global $conf;
    return $conf['locale']['currency_symbol'] . 
      parent::getHTML( $params );
  }
}
?>