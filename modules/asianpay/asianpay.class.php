<?php
/**
 * AsianPayAIM.class.php
 *
 *
 */

// Base class
require_once BASE_PATH . "modules/PaymentProcessorModule.class.php";


/*
 * Class to do all asianpay
 * asianpay Version 1.0
 */
class AsianPay extends PaymentProcessorModule
{
	/**
	 * @var string Long description
	 */
	var $description = "AsianPay Payment Processor Module";	
	var $sDescription = "AsianPay";
	var $name = "Asianpay";	
	
	var $configPage = "asianpay_config";	
	var $send_method = "POST";	

	var $receiverid = 0;	
	var $accountid = 0;
	var $secretcode = 0;
	var $receiveremail = "a@a.com";
	var $pay_url = "https://asianpay.com/users/single_item/make_payment.php";
	
	/**
	 * Initialize Module
	 *
	 * Invoked when the module is loaded.  Call the parent method first, then
	 * load settings.
	 *
	 * @return boolean True for success
	 */
	function init() {
		parent::init();	 
		
		// Load settings
		$this->setReceiverid( $this->moduleDBO->loadSetting( "receiverid" ) );
		$this->setAccountid( $this->moduleDBO->loadSetting( "accountid" ) );
		$this->setSecretcode( $this->moduleDBO->loadSetting( "secretcode" ) );
		$this->setReceiveremail( $this->moduleDBO->loadSetting( "receiveremail" ) );
	}
	
	/* getters setters */
	function setReceiverid($input){
		$this->receiverid = $input;		
	}	
	function setAccountid($input){
		$this->accountid = $input;		
	}	
	function setSecretcode($input){
		$this->secretcode = $input;		
	}	
	function setReceiveremail($input){
		$this->receiveremail = $input;		
	}
	
	function getReceiverid(){
		return $this->receiverid;		
	}	
	function getAccountid(){
		return $this->accountid;		
	}	
	function getSecretcode(){
		return $this->secretcode;		
	}	
	function getReceiveremail(){
		return $this->receiveremail;		
	}

	function saveSettings() {
		// Save settings
		
		$this->moduleDBO->saveSetting( "accountid", $this->getAccountid() );
		$this->moduleDBO->saveSetting( "receiverid", $this->getReceiverid() );
		$this->moduleDBO->saveSetting( "receiveremail", $this->getReceiveremail() );
		$this->moduleDBO->saveSetting( "secretcode", $this->getSecretcode() );
	}	
	
	
	function install() {
		parent::install();
		//$this->saveSettings();
	}

	/*
	 * Constructor
	 */
	function asianpay($demo_mode= 0)
	{
		$this->demo_mode = $demo_mode;
		$this->pay_url   = "https://asianpay.com/users/single_item/make_payment.php";
	}
	/*
	 * Function to send variables
	 */
	function sendVariables($path_url, $pp_vals)
	{
		$this->_POST1               = array ();
		$this->_POST1['receiver']   = $pp_vals['ap_receiver'];
		$this->_POST1['receiverid'] = $pp_vals['ap_receiverid'];
		$this->_POST1['account_id'] = $pp_vals['ap_account_id'];
		$this->_POST1['prod_name']  = $_POST['desc'];
		$this->_POST1['prod_price'] = number_format($_POST['gross_amount'],2);
        
		$this->_POST1['notifyurl']  = $path_url."/ipn.php";
		$this->_POST1['successurl'] = $path_url."/OK.php";
		$this->_POST1['cancelurl']  = $path_url."/NOK.php";
        
		$this->_POST1['item_number']= time().rand(0, 1000);
		if (isset ($_POST['force_inv_no']))
        {
			$this->_POST1['item_number'] = $_POST['force_inv_no'];
        }
            
		$this->_POST1['custom_1'] = $this->_POST1['item_number'];
		$this->_POST1['custom_2'] = "AsianPay";
	}
	/*
	 * IPN=Internet Payment Notifier
	 */
	function ipn(& $BL)
	{
		$this->item_number    = $_POST['custom_1'];
		$this->transaction_id = $_POST['batch'];
		$this->payment_status = $_POST['status'];

        $sqlSELECT = "SELECT  * FROM {$BL->props->tbl_payment_processors} WHERE `pp_name` ='asianpay'";
        $temp      = $BL->dbL->executeSELECT($sqlSELECT);
        $pp_vals   = $temp[0]; 
        
		if (!empty ($this->item_number) && ($this->payment_status == 1 || $this->payment_status == 0)  && $_POST['custom_2'] == "AsianPay" && $_POST['receiverid']==$pp_vals['ap_receiverid'] && $_POST['secretcode']==$pp_vals['ap_ecretcode'])
		{
            if($this->payment_status == 0)
            {
                $_POST['skip_auto_creation'] = 1;
            }
			$BL->processTransaction($this->item_number, $this->transaction_id);
			return true;
		}
		return false;
	}
}
?>
