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

class EndOfTableException extends SWException {

}
class TableEmptyException extends SWException {

}

function array_shift2( &$array ) {
    reset( $array );
    $key = key( $array );
    $removed = $array[$key];
    unset( $array[$key] );
    return $removed;
}

/**
 * TableWidget
 *
 * @package SolidWorks
 * @author John Diamond <jdiamond@solid-state.org>
 */
class TableWidget extends HTMLWidget {
    /**
     * @var integer A count of the number of columns generated
     */
    protected $colCount = 0;

    /**
     * @var array The current row
     */
    protected $currentRow = array();

    /**
     * @var array Table data (keyfield => array( column id => column data )
     */
    protected $data = array();

    /**
     * @var string Content to be placed in the table footer HTML
     */
    protected $footerContent = null;

    /**
     * @var array Parameters provided to the {form_table} tag
     */
    protected $parameters = array();

    /**
     * @var integer A count of the number of rows generated
     */
    protected $rowCount = 0;

    /**
     * @var integer The size of the table (number of rows), null = infinite
     */
    protected $size = null;

    /**
     * @var boolean Show headers flag
     */
    protected $showHeadersFlag = true;

    /**
     * Do Not Show Headers
     *
     * Turns the showHeaders flag off
     */
    public function doNotShowHeaders() {
        $this->showHeadersFlag = false;
    }

    /**
     * Get Column Header HTML
     *
     * @param string $columnid The column ID
     * @param string $header The column header
     */
    public function getColumnHeaderHTML( $columnID, $header ) {
        global $page;

        // Increment the column count
        $this->colCount++;

        // Set the sort direction to the opposite of what we're sorting on already,
        // or just default to ascending
        $sortDir = "ASC";
        if ( $this->getSortCol() == $columnID ) {
            $sortDir = $this->getSortDir() == "ASC" ? "DESC" : "ASC";
        }
        $sortURL = sprintf( "%s&action=swtablesort&swtablename=%s&swtableform=%s&swtablesortcol=%s&swtablesortdir=%s",
                $page->getURL(),
                $this->fieldName,
                $this->formName,
                $columnID,
                $sortDir );

        return sprintf( "\t\t<th><a href=\"%s\">%s</a></th>\n", $sortURL, $header );
    }

    /**
     * Get Data
     *
     * @return array Table data
     */
    protected function getData() {
        return $this->data;
    }

    /**
     * Get Widget HTML
     *
     * Returns HTML code for this widget
     *
     * @param array $params Parameters passed from the template
     * @return string HTML code for this widget
     */
    public function getHTML( $params ) {
        return "You must use {form_table} to render this widget.";
    }

    /**
     * Get Checkbox HTML
     *
     * @param mixed $value The value for the checkbox widget
     * @return string HTML for the key checkbox column
     */
    public function getCheckboxHTML( $value ) {
        $checked = $this->determineValue( array( "option" => $value ) ) == $value ?
                "checked" : null;

        return sprintf( '<input type="checkbox" name="%s[]" value="%s" %s/>',
                $this->fieldName,
                $value,
                $checked );
    }

    /**
     * Get Search Criteria
     *
     * @return array An array of columns to search and the values to search for
     */
    public function getSearchCriteria() {
        global $page;
        $session = $page->getPageSession();

        return $session['tables'][$this->formName][$this->fieldName]['search'];
    }

    /**
     * Get Sort Column
     *
     * @return string The column to sort on
     */
    public function getSortCol() {
        global $page;
        $session = $page->getPageSession();

		$sortColumn = $_GET[ 'swtablesortcol' ];
		if (!preg_match('/^[A-Za-z][A-Za-z0-9_]+$/', $sortColumn)) {
			$sortColumn = '';
		}
        return $sortColumn;
    }

    /**
     * Get Sort Direction
     *
     * @return string The direction to sort in (ASC or DESC)
     */
    public function getSortDir() {
        global $page;
        $session = $page->getPageSession();

		if (!preg_match('/^(asc|desc)$/i', $sortColumn)) {
			$sortColumn = '';
		}
		return $sortColumn;
    }

    /**
     * Get Starting Index
     *
     * @return integer The index of the first row to be displayed
     */
    public function getStartIndex() {
        global $page;
        $session = $page->getPageSession();

		return intval($_GET[ 'swtablestart' ]);
    }

    /**
     * Get Table Header HTML
     *
     * Returns HTML code for the beginning of the table
     *
     * @return string HTML code for the beginning of the table
     */
    public function getTableHeaderHTML() {
        // Start the table
        $startIndex = $this->getStartIndex();
        if ( isset( $this->size ) ) {
            $endIndex = count( $this->data ) < ($startIndex + $this->size) ?
                    count( $this->data ) : $startIndex + $this->size;
        }
        else {
            $endIndex = count( $this->data );
        }

        $html = !empty( $this->data )
                ? sprintf("<p>%s (%d - %d [OF] %d)</p>\n",
					$this->fieldConfig['description'],
					$startIndex + 1,
					$endIndex,
					count( $this->data ) )
				: sprintf("<p>%s ([EMPTY])</p>\n", $this->fieldConfig['description'] );
        $html .= sprintf( "\n<table %s>\n\t<tr>\n",
                $this->buildParams( $this->parameters, $myParams ) );

        return $html;
    }

    /**
     * Get Table Empty HTML
     *
     * @return string HTML code for an empty table row
     */
    public function getTableEmptyHTML() {
        // Display the "empty" message
        $emptyMessage = isset( $this->parameters['empty'] ) ?
                $this->parameters['empty'] : "No Data";
        $html = sprintf( "\t<tr>\n\t\t<td colspan=%d>%s</td>\n",
                $this->colCount+1,
                $emptyMessage );

        return $html;
    }

    /**
     * Get Table Footer HTML
     *
     * Returns HTML code for the end of the table
     *
     * @return string HTML code for the end of the table
     */
    public function getTableFooterHTML() {
        global $page;

        $startIndex = $this->getStartIndex();
        $endIndex = isset( $this->size ) ?
                $startIndex + $this->size : count( $this->data );

        // End of table
        $html = "\t</tr>\n\t<tr class=\"footer\">\n";

        // Display begin, prev, next, and end links
        $html .= sprintf( "\t\t<td colspan=\"%d\">\n", $this->colCount + 1 );
        $html .= "\t\t\t" . $this->footerContent;
        if ( $startIndex > 0 ) {
            // "Begin" and "Prev" links
            $startVal = ($startIndex - $this->size) > 0 ? ($startIndex - $this->size) : 0;
            $html .= sprintf( "(<a href=\"%s&action=swtablescroll&swtableform=%s&swtablename=%s&swtablestart=%d\">[BEGIN]</a>) ",
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
        else {
			// remove this placeholder, adds unncessary clutter to the table
            // $html .= "([BEGIN]) [PREV] | ";
        }
        if ( $startIndex + $this->size < count( $this->data ) ) {
            // "Next" and "End" links
            $html .= sprintf( "<a href=\"%s&action=swtablescroll&swtableform=%s&swtablename=%s&swtablestart=%d\">[NEXT]</a> ",
                    $page->getURL(),
                    $this->formName,
                    $this->fieldName,
                    $startIndex + $this->size );
            $html .= sprintf( "(<a href=\"%s&action=swtablescroll&swtableform=%s&swtablename=%s&swtablestart=%d\">[END]</a>)",
                    $page->getURL(),
                    $this->formName,
                    $this->fieldName,
                    count( $this->data ) - $this->size );
        }
        else {
			// remove this placeholder, adds unncessary clutter to the table
            // $html .= sprintf( "[NEXT] ([END])" );
        }
        $html .= "\t\t</td>\n\t</tr>\n";
        $html .= "</table>\n\n";

        return $html;
    }

    /**
     * Initialize the Table
     *
     * @param array $params Parameters from the {form_table} tag
     */
    public function init( $params ) {
        $this->colCount = 0;
        $this->rowCount = 0;
        $this->data = array();
        $this->parameters = $params;
        $this->size = isset( $params['size'] ) ? intval( $params['size'] ) : 20;
        $this->showHeadersFlag = true;
    }

    /**
     * Is To be Sortable
     *
     * @return boolean True if this table is to be sorted
     */
    protected function isToBeSorted() {
        global $page;
        $session = $page->getPageSession();

        return $session['tables']['sortform'] == $this->formName &&
                $session['tables']['sorttable'] == $this->fieldName;
    }

    /**
     * Process the Next Row
     */
    public function next() {
        global $smarty;

        if ( $this->rowCount == 0 ) {
            // Start processing the table
            if ( empty( $this->data ) ) {
                // Nothing to do
                throw new TableEmptyException();
            }

            // Search the table if necessary
            $this->search();

            // Sort the table if necessary
            $this->sort();

            // Make a copy of all the rows to be displayed in the table
            $rowIndex = 0;
            $rowCount = 0;
            foreach( $this->data as $key => $rowData ) {
                if ( $rowIndex < $this->getStartIndex() ) {
                    // Skip this row
                    $rowIndex++;
                    continue;
                }

                // This row will be displayed
                $this->tableRows[$key] = $rowData;
                $rowIndex++;
                $rowCount++;
                if ( isset( $this->size ) && $rowCount >= $this->size ) {
                    // Do not process anymore rows
                    break;
                }
            }
        }

        // Assign all the row data to a Smarty array
        $this->rowCount++;
        if ( null == ($this->currentRow = array_shift( $this->tableRows )) ) {
            throw new EndOfTableException();
        }
        return $this->currentRow;
    }

    /**
     * Search the Table
     */
    public function search() {
        $filteredTable = array();
        $criteria = $this->getSearchCriteria();
        foreach( $this->data as $row ) {
            foreach( $row as $columnid => $value ) {
                // Should we filter this column?
                if ( isset( $criteria[$columnid] ) ) {
                    // Strings and numbers are handled differently
                    if ( is_numeric( $value ) ) {
                        if ( $value != $criteria[$columnid] ) {
                            // Skip this row
                            continue( 2 );
                        }
                    }
                    else {
                        if ( stristr( $value, (string)$criteria[$columnid] ) === false ) {
                            // Skip this row
                            continue( 2 );
                        }
                    }
                }
            }

            // Row matches the search criteria
            $filteredTable[] = $row;
        }

        $this->data = $filteredTable;
    }

    /**
     * Set Footer Content
     *
     * @param string $footerContent Footer content
     */
    public function setFooterContent( $footerContent ) {
        $this->footerContent = $footerContent;
    }

    /**
     * Set Sort Column
     *
     * @param string $columnName The column to sort on
     */
    public function setSortCol( $columnName ) {
        global $page;
        $session = $page->getPageSession();

        $session['tables'][$this->formName][$this->fieldName]['col'] = $columnName;
    }

    /**
     * Set Search Criteria
     *
     * Sets up a search criteria on a specified column
     *
     * @param string $columnid The column to match in
     * @param string $search The string to math
     */
    public function setSearchCriteria( $columnid, $search ) {
        global $page;
        $session = $page->getPageSession();

        $session['tables'][$this->formName][$this->fieldName]['search'][$columnid] = $search;
    }

    /**
     * Set Sort Direction
     *
     * @param string $direction The direction to sort in (ASC or DESC)
     */
    public function setSortDir( $direction ) {
        global $page;
        $session = $page->getPageSession();

        $session['tables'][$this->formName][$this->fieldName]['dir'] = $direction;
    }

    /**
     * Set Starting Index
     *
     * @param integer $startIndex The index of the first row to be displayed
     */
    public function setStartIndex( $startIndex ) {
        global $page;
        $session = $page->getPageSession();

        $session['tables'][$this->formName][$this->fieldName]['start'] = $startIndex;
    }

    /**
     * Show Headers
     *
     * @return boolean The show headers flag
     */
    public function showHeaders() {
        return $this->showHeadersFlag;
    }

    /**
     * Sort Table Data (if necessary)
     */
    protected function sort() {
        if ( !$this->isToBeSorted() ) {
            // Do not sort
            return;
        }

        // Obtain the sort column values
        foreach( $this->data as $key => $row ) {
            $sortColumn[$key] = $row[$this->getSortCol()];
        }

        // No sort the table data
        array_multisort( $sortColumn,
                $this->getSortDir() == "ASC" ? SORT_ASC : SORT_DESC,
                $this->data );
    }
}