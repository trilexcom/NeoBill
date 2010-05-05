<?php
/**
 * WidgetFactory.class.php
 *
 * This file contains the definition of the WidgetFactory class.
 *
 * @package SolidWorks
 * @author John Diamond <jdiamond@solid-state.org>
 * @copyright John Diamond <jdiamond@solid-state.org>
 * @license http://www.opensource.org/licenses/gpl-license.php GNU Public License
 */

//Widgets
require BASE_PATH . "solidworks/widgets/HTMLWidget.class.php";
require BASE_PATH . "solidworks/widgets/TextWidget.class.php";
require BASE_PATH . "solidworks/widgets/PasswordWidget.class.php";
require BASE_PATH . "solidworks/widgets/SubmitWidget.class.php";
require BASE_PATH . "solidworks/widgets/RadioButtonWidget.class.php";
require BASE_PATH . "solidworks/widgets/SelectWidget.class.php";
require BASE_PATH . "solidworks/widgets/CountrySelectWidget.class.php";
require BASE_PATH . "solidworks/widgets/TextAreaWidget.class.php";
require BASE_PATH . "solidworks/widgets/DateWidget.class.php";
require BASE_PATH . "solidworks/widgets/CurrencyWidget.class.php";
require BASE_PATH . "solidworks/widgets/CheckBoxWidget.class.php";
require BASE_PATH . "solidworks/widgets/TableWidget.class.php";

/**
 * WidgetFactory
 *
 * The WidgetFactory provides an interface for generating HTML for an extensible
 * set of form "widgets" such as text boxes and select menu's.  Each "widget type"
 * is implemented by a HTMLWidget object.  The WidgetFactory provides a common
 * interface for accessing HTMLWidget objects.
 *
 * @package SolidWorks
 * @author John Diamond <jdiamond@solid-state.org>
 */
class WidgetFactory {
	/**
	 * @var static WidgetFactory Singleton instance
	 */
	private static $instance = null;

	/**
	 * @var array HTMLWidget's
	 */
	private $widgets = array();

	/**
	 * Get WidgetFactory Instance
	 *
	 * The WidgetFactory class is a singleton.  You may only construct one WidgetFactory
	 * and it must be done by calling this static method.
	 *
	 * @return WidgetFactory WidgetFactory instance
	 */
	public static function getWidgetFactory() {
		global $page;

		if ( self::$instance == null ) {
			self::$instance = new WidgetFactory();
			self::$instance->registerWidget( "text", "TextWidget"  );
			self::$instance->registerWidget( "password", "PasswordWidget" );
			self::$instance->registerWidget( "submit", "SubmitWidget" );
			self::$instance->registerWidget( "radio", "RadioButtonWidget" );
			self::$instance->registerWidget( "select", "SelectWidget" );
			self::$instance->registerWidget( "country", "CountrySelectWidget" );
			self::$instance->registerWidget( "textarea", "TextAreaWidget" );
			self::$instance->registerWidget( "date", "DateWidget" );
			self::$instance->registerWidget( "currency", "CurrencyWidget" );
			self::$instance->registerWidget( "checkbox", "CheckBoxWidget" );
		}

		return self::$instance;
	}

	/**
	 * WidgetFactory Constructor
	 *
	 */
	protected function __construct() {

	}

	/**
	 * Get Widget
	 *
	 * @param string $widgetName The name of the widget
	 * @param string $formName The form this widget is being placed on
	 * @param string $fieldName The field this widget will represent
	 * @param array $fieldConfig The configuration for this field
	 * @return HTMLWidget A new widget
	 */
	public function getWidget( $widgetName, $formName, $fieldName, $fieldConfig ) {
		if ( !isset( $this->widgets[$widgetName] ) ) {
			throw new SWException( sprintf( "The widget does not exist: %s\n\tForm: %s\n\t: Field: %s\n ",
			$widgetName,
			$formName,
			$fieldName ) );
		}

		// If a filename was registered and has not been loaded yet, load it
		if ( $this->widgets[$widgetName]['file'] != null &&
			!$this->widgets[$widgetName]['loaded'] ) {
			require $this->widgets[$widgetName]['file'];
			$this->widgets[$widgetName]['loaded'] = true;
		}

		// Instantiate a widget and return
		return new $this->widgets[$widgetName]['class']( $formName, $fieldName, $fieldConfig );
	}

	/**
	 * Register Widget
	 *
	 * @param string $widgetName The name of the widget used by the config file
	 * @param string $className The name of the class that implements this widget
	 */
	public function registerWidget( $widgetName, $className, $fileName = null ) {
		$this->widgets[$widgetName]['class'] = $className;
		$this->widgets[$widgetName]['file'] = $fileName;
		$this->widgets[$widgetName]['loaded'] = false;
	}
}