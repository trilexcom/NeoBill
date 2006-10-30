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
    global $page;

    // Get and sort (if necessary) table data
    $tableData = $this->getData();
    $this->sort( $tableData );

    // Start the table
    $startIndex = $this->getStartIndex();
    $endIndex = isset( $params['size'] ) ? 
      $startIndex + $params['size'] : count( $tableData );
    $html = !empty( $tableData ) ?
      sprintf("<p>%s (%d - %d [OF] %d)</p>\n", 
	      $this->fieldConfig['description'],
	      $startIndex + 1,
	      $endIndex,
	      count( $tableData ) ) :
      sprintf("<p>%s ([EMPTY])</p>\n", $this->fieldConfig['description'] );
    $html .= sprintf( "\n<table %s>\n", $this->buildParams( $params, $myParams ) );

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
	// Set the sort direction to the opposite of what we're sorting on already,
	// or just default to ascending
	$sortDir = "ASC";
	if( $this->getSortCol() == $columnName )
	  {
	    $sortDir = $this->getSortDir() == "ASC" ? "DESC" : "ASC";
	  }

	$sortURL = sprintf( "%s&action=swtablesort&swtablename=%s&swtableform=%s&swtablesortcol=%s&swtablesortdir=%s",
			    $page->getURL(),
			    $this->fieldName,
			    $this->formName,
			    $columnName,
			    $sortDir );
	$html .= sprintf( "\t\t<th><a href=\"%s\">%s</a></th>\n", $sortURL, $header );
      }
    $html .= "\t<tr>\n";

    // Create table rows
    if( empty( $tableData ) )
      {
	$html .= sprintf( "\t\t<td colspan=\"%d\">%s</td>\n", 
			  count( $headers ) + 1,
			  "[NO_DATA]" );
      }
    $rowIndex = 0;
    $rowCount = 0;
    foreach( $tableData as $key => $rowData )
      {
	if( $rowIndex < $startIndex )
	  {
	    // Skip this row
	    $rowIndex++;
	    continue;
	  }

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

	// Increment row count and index
	$rowCount++;
	$rowIndex++;
	if( isset( $params['size'] ) && $rowCount >= $params['size'] )
	  {
	    // Do not display anymore rows
	    break;
	  }
      }

    // End of table - display begin, prev, next, and end links
    $html .= "\t<tr class=\"footer\">\n";
    $html .= sprintf( "\t\t<td colspan=\"%d\">\n", count( $headers )+1 );
    if( $startIndex > 0 )
      {
	// "Begin" and "Prev" links
	$startVal = ($startIndex - $params['size']) > 0 ?
	  ($startIndex - $params['size']) : 0;
	$html .= sprintf( "\t\t\t(<a href=\"%s&action=swtablescroll&swtableform=%s&swtablename=%s&swtablestart=%d\">[BEGIN]</a>) ", 
			  $page->getURL(),
			  $this->formName,
			  $this->fieldName,
			  0 );
	$html .= sprintf( "\t\t\t<a href=\"%s&action=swtablescroll&swtableform=%s&swtablename=%s&swtablestart=%d\">[PREV]</a> | ", 
			  $page->getURL(),
			  $this->formName,
			  $this->fieldName,
			  $startVal );
      }
    else
      {
	$html .= "([BEGIN]) [PREV] | ";
      }
    if( $start + $size < count( $tableData ) )
      {
	// "Next" and "End" links
	$html .= sprintf( "<a href=\"%s&action=swtablescroll&swtableform=%s&swtablename=%s&swtablestart=%d\">[NEXT]</a> ",
			  $page->getURL(),
			  $this->formName,
			  $this->fieldName,
			  $startIndex + $params['size'] );
	$html .= sprintf( "(<a href=\"%s&action=swtablescroll&swtableform=%s&swtablename=%s&swtablestart=%d\">[END]</a>)",
			  $page->getURL(),
			  $this->formName,
			  $this->fieldName,
			  count( $tableData ) - $params['size'] );
      }
    else
      {
	$html .= sprintf( "[NEXT] ([END])" );
      }
    $html .= "\t\t</td>\n";
    $html .= "</table>\n\n";

    return $html;
  }

  /**
   * Get Sort Column
   *
   * @return string The column to sort on
   */
  public function getSortCol()
  {
    global $page;
    $session =& $page->getPageSession();

    return $session['tables'][$this->formName][$this->fieldName]['col'];
  }

  /**
   * Get Sort Direction
   *
   * @return string The direction to sort in (ASC or DESC)
   */
  public function getSortDir()
  {
    global $page;
    $session =& $page->getPageSession();

    return $session['tables'][$this->formName][$this->fieldName]['dir'];
  }

  /**
   * Get Starting Index
   *
   * @return integer The index of the first row to be displayed
   */
  public function getStartIndex()
  {
    global $page;
    $session =& $page->getPageSession();

    return $session['tables'][$this->formName][$this->fieldName]['start'];
  }

  /**
   * Is To be Sortable
   *
   * @return boolean True if this table is to be sorted
   */
  protected function isToBeSorted()
  {
    global $page;
    $session =& $page->getPageSession();

    return $session['tables']['sortform'] == $this->formName &&
      $session['tables']['sorttable'] == $this->fieldName;
  }

  /**
   * Set Sort Column
   *
   * @param string $columnName The column to sort on
   */
  public function setSortCol( $columnName )
  {
    global $page;
    $session =& $page->getPageSession();

    $session['tables'][$this->formName][$this->fieldName]['col'] = $columnName;
  }

  /**
   * Set Sort Direction
   *
   * @param string $direction The direction to sort in (ASC or DESC)
   */
  public function setSortDir( $direction )
  {
    global $page;
    $session =& $page->getPageSession();

    $session['tables'][$this->formName][$this->fieldName]['dir'] = $direction;
  }

  /**
   * Set Starting Index
   *
   * @param integer $startIndex The index of the first row to be displayed
   */
  public function setStartIndex( $startIndex )
  {
    global $page;
    $session =& $page->getPageSession();

    $session['tables'][$this->formName][$this->fieldName]['start'] = $startIndex;
  }

  /**
   * Sort Table Data
   *
   * @param array $tableData Table data to sort
   * @return array Sorted table data
   */
  protected function sort( &$tableData )
  {
    if( !$this->isToBeSorted() )
      {
	// Do not sort
	return;
      }

    // Obtain the sort column values
    foreach( $tableData as $key => $row )
      {
	$sortColumn[$key] = $row[$this->getSortCol()];
      }

    // No sort the table data
    array_multisort( $sortColumn,
		     $this->getSortDir() == "ASC" ? SORT_ASC : SORT_DESC,
		     $tableData );
  }
}