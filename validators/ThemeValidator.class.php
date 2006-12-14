<?php
/**
 * ThemeValidator.class.php
 *
 * This file contains the definition of the ThemeValidator class.  
 *
 * @package SolidWorks
 * @author John Diamond <jdiamond@solid-state.org>
 * @copyright John Diamond <jdiamond@solid-state.org>
 * @license http://www.opensource.org/licenses/gpl-license.php GNU Public License
 */

require_once BASE_PATH . "solidworks/validators/ChoiceValidator.class.php";

/**
 * ThemeValidator
 *
 * @package SolidWorks
 * @author John Diamond <jdiamond@solid-state.org>
 */
class ThemeValidator extends ChoiceValidator
{
  /**
   * @var string The type of themes to display ("manager" or "order")
   */
  protected $type = "manager";

  /**
   * Get Valid Choices
   *
   * Returns all the valid themes
   *
   * @return array An array of valid theme choices
   */
  function getValidChoices()
  {
    $themes = array();
    
    $themeDir = sprintf( "%s%s/themes", BASE_PATH, $this->type );
    if( false == ($dh = @opendir( $themeDir )) )
      {
	throw new SWException( "Could not open theme directory: " . $themeDir );
      }

    $results = array( "default" => "default" );
    while( $file = readdir( $dh ) )
      {
	if( !($file == "." || $file == "..") && is_dir( $themeDir . "/" . $file ) )
	  {
	    // Add this theme
	    $name = basename( $file );
	    $results[$name] = $name;
	  }
      }

    return $results;
  }

  /**
   * Set Type Filter
   *
   * @param string $type The type of theme to select ("manager" or "order", "manager" is default)
   */
  public function setType( $type ) 
  { 
    if( !($type == "manager" || $type == "order") )
      {
	throw new SWException( "Invalid type: " . $type );
      }

    $this->type = $type; 
  }
}
?>