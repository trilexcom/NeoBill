<?php
/**
 * FieldValidatorFactory.class.php
 *
 * This file contains the definition of the FieldValidatorFactory class.  
 *
 * @package SolidWorks
 * @author John Diamond <jdiamond@solid-state.org>
 * @copyright John Diamond <jdiamond@solid-state.org>
 * @license http://www.opensource.org/licenses/gpl-license.php GNU Public License
 */

// Exceptions
require_once BASE_PATH . "solidworks/exceptions/FieldException.class.php";
require_once BASE_PATH . "solidworks/exceptions/UndefinedFieldException.class.php";
require_once BASE_PATH . "solidworks/exceptions/FieldMissingException.class.php";
require_once BASE_PATH . "solidworks/exceptions/InvalidFormException.class.php";

// Validators
require_once BASE_PATH . "solidworks/validators/FieldValidator.class.php";
require_once BASE_PATH . "solidworks/validators/TextValidator.class.php";
require_once BASE_PATH . "solidworks/validators/PasswordValidator.class.php";
require_once BASE_PATH . "solidworks/validators/EmailValidator.class.php";
require_once BASE_PATH . "solidworks/validators/NumberValidator.class.php";
require_once BASE_PATH . "solidworks/validators/IntValidator.class.php";
require_once BASE_PATH . "solidworks/validators/ChoiceValidator.class.php";
require_once BASE_PATH . "solidworks/validators/CountryValidator.class.php";
require_once BASE_PATH . "solidworks/validators/TelephoneValidator.class.php";
require_once BASE_PATH . "solidworks/validators/DateValidator.class.php";
require_once BASE_PATH . "solidworks/validators/IPAddressValidator.class.php";
require_once BASE_PATH . "solidworks/validators/BooleanValidator.class.php";
require_once BASE_PATH . "solidworks/validators/CCNumberValidator.class.php";
require_once BASE_PATH . "solidworks/validators/CCExpireValidator.class.php";

/**
 * FieldValidatorFactory
 *
 * The FieldValidatorFactory is responsible for cataloging all the available
 * FieldValidators and instantiating them as requested.
 *
 * @package SolidWorks
 * @author John Diamond <jdiamond@solid-state.org>
 */
class FieldValidatorFactory
{
  /**
   * @var static FieldValidatorFactory Singleton instance
   */
  private static $instance = null;

  /**
   * @var array Field Validators
   */
  private $validators = array();

  /**
   * Get FieldValidatorFactory Instance
   *
   * The FieldValidatorFactory class is a singleton.  You may only construct one 
   * FieldValidatorFactory and it must be done by calling this static method.
   *
   * @return FormProcessor FormProcessor instance
   */
  public static function getFieldValidatorFactory()
  {
    if( self::$instance == null )
      {
	self::$instance = new FieldValidatorFactory();
	self::$instance->registerFieldValidator( "submit", "FieldValidator" );
	self::$instance->registerFieldValidator( "text", "TextValidator" );
	self::$instance->registerFieldValidator( "password", "PasswordValidator" );
	self::$instance->registerFieldValidator( "email", "EmailValidator" );
	self::$instance->registerFieldValidator( "int", "IntValidator" );
	self::$instance->registerFieldValidator( "float", "NumberValidator" );
	self::$instance->registerFieldValidator( "choice", "ChoiceValidator" );
	self::$instance->registerFieldValidator( "country", "CountryValidator" );
	self::$instance->registerFieldValidator( "telephone", "TelephoneValidator" );
	self::$instance->registerFieldValidator( "date", "DateValidator" );
	self::$instance->registerFieldValidator( "ipaddress", "IPAddressValidator" );
	self::$instance->registerFieldValidator( "boolean", "BooleanValidator" );
	self::$instance->registerFieldValidator( "ccnumber", "CCNumberValidator" );
	self::$instance->registerFieldValidator( "ccexpire", "CCExpireValidator" );
      }

    return self::$instance;
  }

  /**
   * Get Feild Validator
   *
   * @param string $type The type of validator you want to retrieve
   * @return FieldValidator A new validator
   */
  public function getFieldValidator( $type, $formName, $fieldName, $fieldConfig )
  {
    if( !isset( $this->validators[$type] ) )
      {
	// Validator does not exist
	throw new SWException( sprintf( "Unable to get field validator.  The validator does not exist: %s\n\tForm: %s\n\tField: %s",
					$type,
					$formName,
					$fieldName ) );
      }

    // Instantiate a field validator and return
    return new $this->validators[$type]( $formName, $fieldName, $fieldConfig );
  }

  /**
   * Register Field Validator
   *
   * @param string $typeName The name of the field type used by the config file
   * @param FieldValidator $validator FieldValidator object for this field type
   */
  public function registerFieldValidator( $typeName, $validator )
  {
    $this->validators[$typeName] = $validator;
  }
}