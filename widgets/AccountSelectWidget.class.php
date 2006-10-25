<?php
/**
 * AccountSelectWidget.class.php
 *
 * This file contains the definition of the AccountSelectWidget class.  
 *
 * @package SolidWorks
 * @author John Diamond <jdiamond@solid-state.org>
 * @copyright John Diamond <jdiamond@solid-state.org>
 * @license http://www.opensource.org/licenses/gpl-license.php GNU Public License
 */

// Base class
require_once BASE_PATH . "solidworks/widgets/SelectWidget.class.php";

// Account DBO
require_once BASE_PATH . "DBO/AccountDBO.class.php";

/**
 * AccountSelectWidget
 *
 * @package SolidWorks
 * @author John Diamond <jdiamond@solid-state.org>
 */
class AccountSelectWidget extends SelectWidget
{
  /**
   * Get Data
   *
   * @param array $config Field configuration
   * @return array value => description
   */
  function getData()
  {
    // Query AccountDBO's
    $accountDBOs = load_array_AccountDBO();
    if( empty( $accountDBOs ) )
      {
	return array();
      }

    // Convery to an array: account ID => account name
    $accounts = array();
    foreach( $accountDBOs as $accountDBO )
      {
	$accounts[$accountDBO->getID()] = $accountDBO->getAccountName();
      }

    return $accounts;
  }
}
?>