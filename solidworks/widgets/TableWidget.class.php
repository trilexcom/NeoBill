<?php
/**
 * TableWidget.class.php
 *
 * This file contains the definition of the TableWidget class.  
 *
 * @package SolidWorks
 * @author John Diamond <jdiamond@solid-state.org>
 * @copyright John Diamond <jdiamond@solid-state.org>
 * @license http://www.opensource.org/licenses/gpl-license.php GNU Public License
 */

// Base class
require_once BASE_PATH . "solidworks/widgets/HTMLWidget.class.php";

/**
 * TableWidget
 *
 * @package SolidWorks
 * @author John Diamond <jdiamond@solid-state.org>
 */
class TableWidget extends HTMLWidget
{
  /**
   * @var array Column headers (column id => description)
   */
  protected $columnHeaders = array();

  /**
   * @var array Table data (keyfield => array( column id => column data )
   */
  protected $data = array();

  /**
   * Get Column Headers
   *
   * @return array Column headers
   */
  protected function getColumnHeaders() { return $this->columnHeaders; }

  /**
   * Get Data
   *
   * @return array Table data
   */
  protected function getData() { return $this->data; }

  /**
   * Get Widget HTML
   *
   * Returns HTML code for this widget
   *
   * @param array $params Parameters passed from the template
   * @return string HTML code for this widget
   */
  public function getHTML( $params ) 
  {
    // Start table
    $html = sprintf( "\n<table %s>\n", $this->buildParams( $params, $myParams ) );

    // Create column headers
    $headers = $this->getColumnHeaders();
    if( empty( $headers ) )
      {
	throw new SWExceptions( "You must supply column headers for this table!" );
      }
    $html .= "\t<tr>\n";
    $html .= "\t\t<th></th>\n"; // This is for the checkbox column
    foreach( $headers as $columnName => $header )
      {
	$html .= sprintf( "\t\t<th>%s</th>\n", $header );
      }
    $html .= "\t<tr>\n";

    // Create table rows
    $tableData = $this->getData();
    if( empty( $tableData ) )
      {
	$html .= sprintf( "\t\t<td colspan=\"%d\">%s</td>\n", 
			  count( $headers ) + 1,
			  "[NO_DATA]" );
      }
    foreach( $tableData as $key => $rowData )
      {
	$html .= "\t<tr>\n";

	// Checkbox column
	$html .= sprintf( "\t\t<td><input type=\"checkbox\" name=\"%s[]\" value=\"%d\"/></td>\n",
			  $params['field'],
			  $key );

	// Every other column
	foreach( $headers as $columnName => $header )
	  {
	    $html .= sprintf( "\t\t<td>%s</td>\n", $rowData[$columnName] );
	  }

	$html .= "\t</tr>\n";
      }

    // End table
    $html .= "</table>\n\n";

    return $html;
  }
}