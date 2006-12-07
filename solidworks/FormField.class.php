<?php
/**
 * FormField.class.php
 *
 * This file contains the definition of the FormField class.  
 *
 * @package SolidWorks
 * @author John Diamond <jdiamond@solid-state.org>
 * @copyright John Diamond <jdiamond@solid-state.org>
 * @license http://www.opensource.org/licenses/gpl-license.php GNU Public License
 */

/**
 * FormField
 *
 * Represents a single field that makes up a form.
 *
 * @package SolidWorks
 * @author John Diamond <jdiamond@solid-state.org>
 */
class FormField
{
  /**
   * @var array Configuration for this field
   */
  private $config = array();

  /**
   * @var string Form name
   */
  private $formName = null;

  /**
   * @var string Field name
   */
  private $name = null;

  /**
   * @var mixed The value that was submited for this field
   */
  private $rawValue = null;

  /**
   * @var FieldValidator A FieldValidator object that will validate this field
   */
  private $validator = null;

  /**
   * @var mixed The value of this field after processing
   */
  private $value = null;

  /**
   * @var HTMLWidget A Widget object that will render this field
   */
  private $widget = null;

  /**
   * FormField Constructor
   *
   * @param string $name The field name
   * @param string $widgetID The name of the widget configured for this field
   * @param string $validatorID The name of the FieldValidator configured for this field
   * @param array $config Field configuration
   */
  public function __construct( $formName, $name, $widgetID, $validatorID, $config )
  {
    // Set the field name and attributes
    $this->formName = $formName;
    $this->name = $name;
    $this->config = $config;

    // Configure the widget
    if( isset( $widgetID ) )
      {
	$wf = WidgetFactory::getWidgetFactory();
	$this->widget = $wf->getWidget( $widgetID,
					$this->formName,
					$this->name, 
					$this->config );
      }
    else
      {
	$this->widget = null;
      }
	
    // Configure the validator
    $vf = FieldValidatorFactory::getFieldValidatorFactory();
    $this->validator = $vf->getFieldValidator( $validatorID,
					       $this->formName,
					       $this->name,
					       $this->config );
  }

  /**
   * Is a Cancel Field
   *
   * Returns true if the "cancel" attribute is set to true
   *
   * @return boolean True if this field is a cancel field
   */
  public function isCancel() { return $this->config['cancel']; }

  /**
   * Is a Required Field
   *
   * @return boolean True if this field is required
   */
  public function isRequired() { return $this->config['required']; }

  /**
   * Get HTML
   *
   * Invokes getHTML() on the widget object
   *
   * @param array $params A list of parameters passed to the {form_field} tag
   * @return string HTML to render this field
   */
  function getHTML( $params ) { return $this->widget->getHTML( $params ); }

  /**
   * Get Field Name
   *
   * @return string Name of the field
   */
  function getName() { return $this->name; }

  /**
   * Get Field Validator
   *
   * Returns a reference to the field's Validator property
   *
   * @return FieldValidator A reference to the Validator property
   */
  public function &getValidator() { return $this->validator; }

  /**
   * Get Field Value
   *
   * Returns the after-processing value for this field.  If the field is marked
   * as required, but there is no value set, then a FieldMissingException is
   * thrown.
   *
   * @return mixed Field value, or null if not processed
   * @throws FieldMissingException
   */
  public function getValue()
  {
    if( $this->isRequired() && $this->value == null )
      {
	// This field is required and no value has been set
	$e = new FieldMissingException();
	$e->setField( $this->getName() );
	throw $e;
      }

    return $this->value;
  }

  /**
   * Get Field Widget
   *
   * Returns a reference to the field's Widget property
   *
   * @return HTMLWidget A reference to the Widget property
   */
  public function &getWidget()
  {
    return $this->widget;
  }

  /**
   * Set Field Value
   *
   * Attempts to set a value for this field.
   *
   * @param mixed $data The data submitted to this field
   * @return mixed The processed value
   * @throws FieldException FieldMissingException
   */
  public function set( $data )
  {
    // Verify that something has been posted to this field
    if( empty( $data ) )
      {
	if( $this->isRequired() )
	  {
	    // This field is required, but missing a value
	    throw new FieldMissingException();
	  }
	else
	  {
	    // There was no value submitted
	    $this->rawValue = $this->value = null;
	    return;
	  }
      }

    // Validate the data and store the result in value
    $this->rawValue = $data;
    if( is_array( $data ) )
      {
	// Handle an array submission
	if( !$this->config['array'] )
	  {
	    throw new FieldException( "Array Values Not Allowed" );
	  }

	$this->value = array();
	foreach( $data as $dataItem )
	  {
	    $this->value[] = $this->validator->validate( $dataItem );
	  }
      }
    else
      {
	$this->value = $this->config['array'] ?
	  array( $this->validator->validate( $data ) ) :
	  $this->validator->validate( $data );
      }

    // Return the value
    return $this->value;
  }
}