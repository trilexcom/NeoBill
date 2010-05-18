<?php
/**
 * AddIPAddressPage.class.php
 *
 * This file contains the definition for the AddIPAddressPage class
 *
 * @package Pages
 * @author John Diamond <jdiamond@solid-state.org>
 * @copyright John Diamond <jdiamond@solid-state.org>
 * @license http://www.opensource.org/licenses/gpl-license.php GNU Public License
 */

require_once BASE_PATH . "include/SolidStateAdminPage.class.php";

/**
 * AddIPAddressPage
 *
 * Add IP Addresses Page
 *
 * @package Pages
 * @author John Diamond <jdiamond@solid-state.org>
 */
class AddIPAddressPage extends SolidStateAdminPage {
    /**
     * Initialize AddIPAddress Page
     */
    function init() {
        parent::init();

        // Set URL Fields
        $this->setURLField( "server", $this->get['server']->getID() );

        // Store Server DBO in session
        $this->session['server_dbo'] =& $this->get['server'];
    }

    /**
     * Action
     *
     * Actions handled by this page:
     *  add_ip_address (form)
     *  add_ip_confirm (form)
     *
     * @param string $action_name Action
     */
    function action( $action_name ) {
        switch ( $action_name ) {
            case "add_ip_address":
                if ( isset( $this->post['continue'] ) ) {
                    // Confirm step
                    $this->confirm();
                }
                else {
                    $this->goback();
                }
                break;

            case "add_ip_confirm":
                if ( isset( $this->post['continue'] ) ) {
                    // Add IP addresses
                    $this->add_ip_addresses();
                }
                else {
                    $this->goback();
                }
                break;

            default:
				// No matching action, refer to base class
                parent::action( $action_name );
        }
    }

    /**
     * Confirm
     *
     * Verify that the IP's do not already exist in the pool, then confirm
     * the new IP address with the user before continuing.
     */
    function confirm() {
        $begin_ip = ip2long( $this->post['begin_address'] );
        $end_ip = ip2long( $this->post['end_address'] );

        if ( $end_ip == 0 || $end_ip < $begin_ip ) {
            // If the beginning IP is not less than the ending IP, then only the
            // beginning IP is going to be added to the database.
            $end_ip = $begin_ip;
        }

        // Verify that there will be no duplicates
        for ( $ip = $begin_ip; $ip <= $end_ip; $ip++ ) {
            try {
                load_IPAddressDBO( $ip );
                throw new SWUserException( "[DUPLICATE_IP]" );
            }
            catch( DBNoRowsFoundException $e ) {
            
            }
        }

        // Store the IP's to be added to the database in the session
        for ( $ip = $begin_ip; $ip <= $end_ip; $ip++ ) {
            $ip_dbo = new IPAddressDBO();
            $ip_dbo->setIP( $ip );
            $ip_dbo->setServerID( $this->get['server']->getID() );
            $this->session['ip_dbo_array'][] = $ip_dbo;
        }
        $this->session['begin_ip'] = new IPAddressDBO();
        $this->session['begin_ip']->setIP( $begin_ip );
        $this->session['end_ip'] = new IPAddressDBO();
        $this->session['end_ip']->setIP( $end_ip );

        // Show the confirmation page
        $this->setTemplate( "confirm" );
    }

    /**
     * Add IP Addresses
     *
     * Add the IP addresses to the database
     */
    function add_ip_addresses() {
        // Add IP Addresses to database
        foreach ( $this->session['ip_dbo_array'] as $ip_dbo ) {
            add_IPAddressDBO( $ip_dbo );
        }

        // Done
        $this->setMessage( array( "type" => "[IP_ADDED]" ) );
        $this->gotoPage( "services_view_server",
                null,
                sprintf( "server=%d&action=ips", $this->get['server']->getID() ) );
    }
}
?>