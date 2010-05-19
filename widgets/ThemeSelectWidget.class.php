<?php
/**
 * ThemeSelectWidget.class.php
 *
 * This file contains the definition of the ThemeSelectWidget class.
 *
 * @package SolidWorks
 * @author John Diamond <jdiamond@solid-state.org>
 * @copyright John Diamond <jdiamond@solid-state.org>
 * @license http://www.opensource.org/licenses/gpl-license.php GNU Public License
 */

/**
 * ThemeSelectWidget
 *
 * @package SolidWorks
 * @author John Diamond <jdiamond@solid-state.org>
 */
class ThemeSelectWidget extends SelectWidget {
	/**
	 * @var string The type of themes to display ("manager" or "order")
	 */
	protected $type = "manager";

	/**
	 * Get Data
	 *
	 * @param array $config Field configuration
	 * @return array value => description
	 */
	public function getData() {
		$themeDir = sprintf( "%s%s/themes", BASE_PATH, $this->type );
		if ( false == ($dh = @opendir( $themeDir )) ) {
			throw new SWException( "Could not open theme directory: " . $themeDir );
		}

		$results = array( "default" => "default" );
		while ( $file = readdir( $dh ) ) {
			if ( !($file == "." || $file == "..") && is_dir( $themeDir . "/" . $file ) ) {
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
	public function setType( $type ) {
		if ( !($type == "manager" || $type == "order") ) {
			throw new SWException( "Invalid type: " . $type );
		}

		$this->type = $type;
	}
}
?>