<?php
/**
 * Form.class.php
 *
 * This file contains the definition of the Form class.
 *
 * @package SolidWorks
 * @author John Diamond <jdiamond@solid-state.org>
 * @copyright John Diamond <jdiamond@solid-state.org>
 * @license http://www.opensource.org/licenses/gpl-license.php GNU Public License
 */

require BASE_PATH . "solidworks/FieldValidatorFactory.class.php";
require BASE_PATH . "solidworks/WidgetFactory.class.php";
require BASE_PATH . "solidworks/FormField.class.php";

// Exceptioncs
require BASE_PATH . "solidworks/exceptions/FormCanceledException.class.php";

/**
 * Form
 *
 * Represents a form and handles rendering, validating, and processing the fields
 * that make up the form.
 *
 * @package SolidWorks
 * @author John Diamond <jdiamond@solid-state.org>
 */
class Form {
    /**
     * @var array FormFields that belong to this form
     */
    private $fields = array();

    /**
     * @var string Form name
     */
    private $name = null;

    /**
     * Form Constructor
     *
     * @param string $name The name of the form
     * @param array $config Form configuration
     */
    public function __construct( $name, $config ) {
        // Set the form name
        $this->name = $name;

        // Configure all the fields
        foreach ( $config['fields'] as $fieldName => $fieldConfig ) {
            // Create and add a new Field to the form
            $field = new FormField( $this->name,
                    $fieldName,
                    $fieldConfig['widget'],
                    $fieldConfig['validator'],
                    $fieldConfig );
            $this->addFormField( $field );
        }
    }

    /**
     * Add a FormField
     *
     * @param FormField $formField FormField object to add
     */
    public function addFormField( FormField $formField ) {
        if ( isset( $this->fields[$formField->getName()] ) ) {
            throw new SWException( sprintf( "Field already exists.\n\tForm: %s\n\tField name: ",
            $this->name,
            $formField->getName() ) );
        }

        $this->fields[$formField->getName()] = $formField;
    }

    /**
     * Get Field
     *
     * Returns a reference to a form field
     *
     * @param string $fieldName The name of the field
     * @return FormField A reference to the FormField object
     */
    public function &getField( $fieldName ) {
        if ( !isset( $this->fields[$fieldName] ) ) {
            throw new SWException( "Field not found: " . $fieldName );
        }

        return $this->fields[$fieldName];
    }

    /**
     * Get Field HTML
     *
     * Returns the HTML for a specific field
     *
     * @param string $fieldName Field name
     * @param array $params A list of parameters passed to the {form_field} tag
     * @return string Field HTML
     */
    public function getFieldHTML( $fieldName, $params ) {
        return $this->getField( $fieldName )->getHTML( $params );
    }

    /**
     * Get Form Name
     *
     * @return string Form name
     */
    function getName() {
        return $this->name;
    }

    /**
     * Process the Form
     *
     * Processes raw form data.  If any invalid data is found an InvalidFormException
     * is thrown.  Otherwise, this function returns the form data as an array
     * of field names => values.
     *
     * @param array $form Form data (should be straight from the _GET or _POST variables)
     * @return array Processed form data
     * @throws SWException, InvalidFormException, UndefinedFieldException
     */
    public function process( $form ) {
        // Start with an empty result set
        $formData = array();

        // Validate every field
        $vExceptions = array();
        foreach( $form as $fieldName => $fieldValue ) {
            try {
                // Verify that this field is configured
                if ( !isset( $this->fields[$fieldName] ) ) {
                    throw new UndefinedFieldException();
                }

                // Bail out if this is a cancel field
                if ( $this->fields[$fieldName]->isCancel() ) {
                    throw new FormCanceledException();
                }

                // Attempt to set the field
                $this->fields[$fieldName]->set( $fieldValue );
            }
            catch ( FieldException $e ) {
                // Add this field to the list of exceptions
                $e->setField( $fieldName );
                $e->setValue( $fieldValue );
                $vExceptions[] = $e;
            }
            catch ( FormCanceledException $e ) {
                // The form was cancelled.  Return just the cancel field as true.
                return array( $fieldName => true );
            }
        }

        // Compile the form results into an array
        $results = array();
        foreach ( $this->fields as $fieldName => $field ) {
            try {
                $results[$fieldName] = $field->getValue();
            }
            catch ( FieldMissingException $e ) {
                // A field is missing
                $vExceptions[] = $e;
            }
        }

        // If there were any validation exceptions then the form is invalid
        if ( !empty( $vExceptions ) ) {
            // This form is invalid
            throw new InvalidFormException( $vExceptions, $results );
        }

        // Return the form results as an array: field name => value
        return $results;
    }
}
?>