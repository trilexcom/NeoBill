<?php
/**
 * ConfigureNewUserPage.class.php
 *
 * This file contains the definition for the ConfigureNewUserPage class
 *
 * @package Pages
 * @author John Diamond <jdiamond@solid-state.org>
 * @copyright John Diamond <jdiamond@solid-state.org>
 * @license http://www.opensource.org/licenses/gpl-license.php GNU Public License
 */

// Include the parent class
require BASE_PATH . "include/SolidStateAdminPage.class.php";

/**
 * ConfigureNewUserPage
 *
 * Add a new Solid-State user
 *
 * @package Pages
 * @author John Diamond <jdiamond@solid-state.org>
 */
class ConfigureNewUserPage extends SolidStateAdminPage {
    /**
     * Action
     *
     * Actions handled by this page:
     *   new_user_action (form)
     *   new_user (form)
     *   new_user_confirm (form)
     *
     * @param string $action_name Action
     */
    function action( $action_name ) {
        switch ( $action_name ) {
            case "new_user_action":
                if ( isset( $this->session['new_user_action']['add'] ) ) {
                    $this->gotoPage( "config_new_user" );
                }
                elseif ( isset( $this->session['new_user_action']['view'] ) ) {
                    $this->gotoPage( "config_users" );
                }
                break;

            case "new_user":
            // Client submited a new_user form - process it
                $this->process_new_user();
                break;

            case "new_user_confirm":
                if ( isset( $this->session['new_user_confirm']['continue'] ) ) {
                    // Go ahead
                    $this->add_user();
                }
                else {
                    // Go back
                    $this->setTemplate( "default" );
                }
                break;

            default:
				// No matching action, refer to base class
                parent::action( $action_name );
        }
    }

    /**
     * Initialize the Page
     */
    public function init() {
        parent::init();

        // Setup the theme preference field
        $tpField = $this->forms['new_user']->getField( "theme" );
        $tpField->getWidget()->setType( "manager" );
        $tpField->getValidator()->setType( "manager" );
    }

    /**
     * Process New User
     *
     * Verify the username requested does not already exist, then
     * ask the client to confirm the new User.
     */
    function process_new_user() {
        if ( $this->post['password'] != $this->post['repassword'] ) {
            // Destroy the password values so they're not echoed to the form
            unset( $this->session['new_user']['password'] );
            unset( $this->session['new_user']['repassword'] );

            // Password not entered correctly
            throw new SWUserException( "[PASSWORD_MISMATCH]" );
        }

        // Verify this username does not already exist
        try {
            load_UserDBO( $this->post['username'] );

            // Username already exists
            throw new SWUserException( "[DB_USER_EXISTS]" );
        }
        catch( DBNoRowsFoundException $e ) {

        }

        // Prepare UserDBO for database insertion
        $user_dbo = new UserDBO();
        $user_dbo->load( $this->post );
        $user_dbo->setPassword( $this->post['password'] );

        // Place DBO in the session for the confirm & receipt page
        $this->session['new_user_dbo'] = $user_dbo;

        // Ask client to confirm
        $this->setTemplate( "confirm" );
    }

    /**
     * Add User
     *
     * Create a new UserDBO and add it to the database
     */
    function add_user() {
        // Extract UserDBO from session
        $user_dbo = $this->session['new_user_dbo'];

        if ( !isset( $user_dbo ) ) {
            // UserDBO is not in the session!
            fatal_error( "ConfigureNewUserPage::add_user()",
                    "UserDBO not found!" );
        }

        // Insert UserDBO into database
        add_UserDBO( $user_dbo );

        // User added
        // Clear new_user data from the session
        unset( $this->session['new_user'] );

        // Show receipt
        $this->setTemplate( "receipt" );
    }
}

?>