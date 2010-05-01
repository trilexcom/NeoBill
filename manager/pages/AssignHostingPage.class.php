<?php
/**
 * AssignHostingPage.class.php
 *
 * This file contains the definition for the AssignHostingPage class
 *
 * @package Pages
 * @author John Diamond <jdiamond@solid-state.org>
 * @copyright John Diamond <jdiamond@solid-state.org>
 * @license http://www.opensource.org/licenses/gpl-license.php GNU Public License
 */

// Include the parent class
require BASE_PATH . "include/SolidStatePage.class.php";

/**
 * AssignHostingPage
 *
 * Assign a hosting service purchase to an account.
 *
 * @package Pages
 * @author John Diamond <jdiamond@solid-state.org>
 */
class AssignHostingPage extends SolidStatePage {
    /**
     * Action
     *
     * Actions handled by this page:
     *   assign_hosting (form)
     *
     * @param string $action_name Action
     */
    function action( $action_name ) {
        switch( $action_name ) {
            case "assign_hosting":
                if( isset( $this->post['continue'] ) ) {
                    // Add service to account
                    $this->assign_service();
                }
                elseif( isset( $this->post['cancel'] ) ) {
                    // Cancel
                    $this->goback();
                }
                elseif( isset( $this->post['service'] ) ) {
                    $this->updatePrices( $this->post['service'] );
                }
                break;

            default:
            // No matching action - refer to base class
                parent::action( $action_name );
        }
    }

    /**
     * Assign Service
     *
     * Create a HostingServicePurchaseDBO and add it to the database
     */
    function assign_service() {
        // If this HostingService requires a unique IP, make sure the user selected one
        if( $this->post['service']->getUniqueIP() == "Required" &&
                !isset( $this->post['ipaddress'] ) ) {
            throw new FieldMissingException( "ipaddress" );
        }

        // If this HostingService requires a domain, make sure the user selected one
        if( $this->post['service']->isDomainRequired() &&
                !isset( $this->post['domainname'] ) ) {
            throw new FieldMissingException( "domainname" );
        }

        // Create new HostingServicePurchase DBO
        $serverID = isset( $this->post['server'] ) ? $this->post['server']->getID() : null;

        $purchase_dbo = new HostingServicePurchaseDBO();
        $purchase_dbo->setAccountID( $this->get['account']->getID() );
        $purchase_dbo->setPurchasable( $this->post['service'] );
        $purchase_dbo->setTerm( isset( $this->post['term'] ) ?
                $this->post['term']->getTermLength() : null );
        $purchase_dbo->setServerID( $serverID );
        $purchase_dbo->setDate( DBConnection::format_datetime( $this->post['date'] ) );
        $purchase_dbo->setDomainName( $this->post['domainname'] );
        $purchase_dbo->setNote( $this->post['note'] );

        // Save purchase
        add_HostingServicePurchaseDBO( $purchase_dbo );

        // If an IP address was selected, assign that IP address to this purchase
        if( isset( $this->post['ipaddress'] ) ) {
            if( $this->post['ipaddress']->getServerID() != $serverID ) {
                // Roll-back
                delete_HostingServicePurchaseDBO( $purchase_dbo );
                throw new SWUserException( "[IP_MISMATCH]" );
            }

            // Update IP Address record
            $this->post['ipaddress']->setPurchaseID( $purchase_dbo->getID() );
            try {
                update_IPAddressDBO( $this->post['ipaddress'] );
            }
            catch( DBException $e ) {
                // Roll-back
                delete_HostingServicePurchaseDBO( $purchase_dbo );
                throw new SWUserException( "[DB_IP_UPDATE_FAILED]" );
            }
        }

        // Success
        $this->setMessage( array( "type" => "[HOSTING_ASSIGNED]" ) );
        $this->gotoPage( "accounts_view_account",
                null,
                "action=services&account=" . $this->get['account']->getID() );
    }

    /**
     * Initialize Assign Hosting Page
     */
    function init() {
        parent::init();

        // Set URL Fields
        $this->setURLField( "account", $this->get['account']->getID() );

        // Store service DBO in session
        $this->session['account_dbo'] =& $this->get['account'];

        try {
            $services = load_array_HostingServiceDBO();
        }
        catch( DBNoRowsFoundException $e ) {
            throw new SWUserException( "[THERE_ARE_NO_HOSTING_SERVICES]" );
        }

        if( !isset( $this->post['service'] ) ) {
            $this->updatePrices( array_shift( $services ) );
        }
    }

    /**
     * Update Prices Box
     *
     * @param HostingServiceDBO The hosting service to show prices for
     */
    protected function updatePrices( HostingServiceDBO $serviceDBO ) {
        // Update the service terms box
        $widget = $this->forms['assign_hosting']->getField( "term" )->getWidget();
        $widget->setPurchasable( $serviceDBO );

        // Indicate if this hosting service requires a domainname
        $this->smarty->assign( "domainIsRequired", $serviceDBO->isDomainRequired() );
    }
}