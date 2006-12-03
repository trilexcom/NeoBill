<?php
/**
 * UserTableWidget.class.php
 *
 * This file contains the definition of the UserTableWidget class.  
 *
 * @package SolidWorks
 * @author John Diamond <jdiamond@solid-state.org>
 * @copyright John Diamond <jdiamond@solid-state.org>
 * @license http://www.opensource.org/licenses/gpl-license.php GNU Public License
 */

/**
 * UserTableWidget
 *
 * @package SolidWorks
 * @author John Diamond <jdiamond@solid-state.org>
 */
class UserTableWidget extends TableWidget
{
  /**
   * Initialize the Table
   *
   * @param array $params Parameters from the {form_table} tag
   */
  public function init( $params ) 
  { 
    parent::init( $params );

    // Load the User Table
    if( null != ($users = load_array_UserDBO( $where )) )
      {
	// Build the table
	foreach( $users as $dbo )
	  {
	    // Put the row into the table
	    $this->data[] = 
	      array( "username" => $dbo->getUsername(),
		     "type" => $dbo->getType(),
		     "contactname" => $dbo->getContactName(),
		     "email" => $dbo->getEmail() );
	  }
      }
  }
}