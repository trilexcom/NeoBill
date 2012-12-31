<?php


// Include the parent class
require BASE_PATH . "include/SolidStateAdminPage.class.php";


class ConfigureNewModulePage extends SolidStateAdminPage {

    function action( $action_name ) {
        switch ( $action_name ) {

		case "new_module":
	                $this->add_module();
	                break;
		
		default:
			parent::action( $action_name );
        }
    }

    /**
     * Initialize the Page
     */
    public function init() {
        parent::init();


    }

    function add_module() {
        
        $mod_dbo = new ModuleDBO();
        $mod_dbo->load( $this->post );
	
	

	add_ModuleDBO( $mod_dbo );
	
	$this->setTemplate( "finished" );

    }

}

?>
