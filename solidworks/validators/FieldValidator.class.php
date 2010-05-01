<?php
/**
 * FieldValidator.class.php
 *
 * This file contains the definition of the FieldValidator class.
 *
 * @package SolidWorks
 * @author John Diamond <jdiamond@solid-state.org>
 * @copyright John Diamond <jdiamond@solid-state.org>
 * @license http://www.opensource.org/licenses/gpl-license.php GNU Public License
 */

/**
 * FieldValidator
 *
 * @package SolidWorks
 * @author John Diamond <jdiamond@solid-state.org>
 */
class FieldValidator {
    /**
     * @var array Field configuration
     */
    protected $fieldConfig = array();

    /**
     * @var string Field name
     */
    protected $fieldName = null;

    /**
     * @var string Form name
     */
    protected $formName = null;

    /**
     * FieldValidator Constructor
     *
     * @param string $formName The name of the form this widget belongs to
     * @param string $fieldName The name of the field this widget represents
     * @param array $fieldConfig The configuration for this field
     */
    public function __construct( $formName, $fieldName, $fieldConfig ) {
        $this->formName = $formName;
        $this->fieldName = $fieldName;
        $this->fieldConfig = $fieldConfig;
    }

    /**
     * Validate Field Data
     *
     * @param string $data Data to be validated
     * @return string This function may alter data before validating it, if so this is the result
     * @throws FieldException
     */
    public function validate( $data ) {
        return $data;
    }
}
?>