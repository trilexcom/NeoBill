<?php

	include_once("nusoap.php");

	/**
	* @access private
	*/
	$debugfunction = $DEBUG;
	
	/**
	* This class consist of functions related to Domain Forward Service.
	*/
	class DomainFwd
	{
		/**
		* @access private
		* @var object
		*/
		var $s;	// This will hold an instance of soapclient class in nusoap.php
		
		/**
		* @access private
		* @var string
		*/
		var $wsdl; // wsdl URL

		/**
		* The constructor which takes soap-url as a parameter.
		*
		* @param string url of wsdl
		*
		* wsdlurl can be passed explicitly.
		* <br>By default wsdl in wsdl dir is used.
		*
		*/
		function DomainFwd($wsdlurl="wsdl/DomainFwd.wsdl")
		{
			$this->wsdl = $wsdlurl;
			$this->s = new soapclient($this->wsdl,"wsdl");
		}

		/**
		* @access private
		*/
		//This function is to diaplay xml Request/Response.
		function debugfunction()
		{
			global $debugfunction;
			if($debugfunction)
			{
				print "<b>XML Sent:</b><br><br>";
				print "<xmp>" . $this->s->request . "</xmp>";
				print "<br><b>XML Received:</b><br><br>";
				print "<xmp>" . $this->s->response . "</xmp>";
				print "<br>";
			}

		}

		/**
		 * Returns a list of Domain Names that match the specified search criteria.
		 * If you do not want to specify a particular criteria, pass null for object
		 * parameters and 0 for numeric parameters
		 *
		 * @return AssociativeArray
		 * @param orderId Array of OrderIds for listing Specific Orders
		 * @param resellerId Array of ResellerIds for listing Orders under specific Sub-Reseller(s)
		 * @param customerId Array of CustomerIds for listing Orders belonging to specific Customer(s)
		 * @param showChildOrders boolean value to indicate whether to list sub-resellers/ customers orders
		 * @param currentStatus Array for listing Orders having specific Current Status
		 * Valid values are: Active, Suspended, Pending, Deleted
		 *
		 * @param domainname Domainname for listing Orders under specific Domain
		 * @param forward String for listing Order having specific forward URL
		 * @param checkUrlMasking String to indicate whether to check for URL masking enabled Domains
		 * Valid values are: true, false
		 * null value will indicates that URL Masking is not to be considered
		 *
		 * @param checkPathForwarding String to indicate whether to check for Path Forwarding enabled Domains
		 * Valid values are: true, false
		 * null value will indicates that Path Forwarding is not to be considered
		 *
		 * @param checkSubDomainForwarding String to indicate whether to check for SubDomain Forwarding enabled Domains
		 * Valid values are: true, false
		 * null value will indicates that SubDomain Forwarding is not to be considered
		 *
		 * @param creationDTRangStart UNIX TimeStamp (epoch) for listing Orders created after
		 * creationDTRangStart
		 *
		 * @param creationDTRangEnd UNIX TimeStamp (epoch) for listing Orders created before
		 * creationDTRangEnd
		 *
		 * @param endTimeRangStart UNIX TimeStamp (epoch) for listing Orders ending after
		 * endTimeRangStart
		 *
		 * @param endTimeRangEnd UNIX TimeStamp (epoch) for listing Orders ending before
		 * endTimeRangEnd
		 *
		 * @param numOfRecordPerPage No. of Records to be returned. The maximum valoue allowed is 50
		 * @param pageNum Page Number for which records are required
		 * @param orderBy Array of Field names for sorting Listing of Orders.
		 *	Default sorting is by orderId.
		 *
		 * <br><br><b>Returns:</b>
		 * <br>An Associative Array with the list of orders matching the search criteria
		 *	The Keys for the HashMap are values from 1 to n. The Value is another HashMap
		 *	which contains key-value pairs of domain information.
		 *	The outer HashMap also contains two additional parameters -
		 *	<pre>
		 *	recsonpage = The no of records returned in this HashMap
		 *	recsindb = The total no of records available that match the search criteria
		 *	</pre>
		 *
		 *	Keys in the inner HashMap per order:
		 *	<pre>
		 *  entity.entityid
		 *  orders.orderid
		 *  entity.customerid
		 *  entity.entitytypeid
		 *  entity.currentstatus
		 *  entity.description
		 *  orders.endtime
		 *  orders.creationtime
		 *  orders.creationdt
		 *  orders.timestamp
		 *  entitytype.entitytypename
		 *  entitytype.entitytypekey
		 * 	</pre>
		 */
		function listOrder($userName, $password, $role, $langpref, $parentid,
					  $orderId, $resellerId, $customerId, $showChildOrders,$currentStatus,
					  $domainname, $forward, $checkUrlMasking, $checkPathForwarding,
					  $checkSubDomainForwarding, $creationDTRangStart, $creationDTRangEnd,
					  $endTimeRangStart, $endTimeRangEnd, $numOfRecordPerPage, $pageNum, $orderBy)
		{
			$param = array($userName, $password, $role, $langpref, $parentid,
					  $orderId, $resellerId, $customerId, $showChildOrders,$currentStatus,
					  $domainname, $forward, $checkUrlMasking, $checkPathForwarding,
					  $checkSubDomainForwarding, $creationDTRangStart, $creationDTRangEnd,
					  $endTimeRangStart, $endTimeRangEnd, $numOfRecordPerPage, $pageNum, $orderBy);
			$return = $this->s->call("list",$param);
                        $this->debugfunction(); 
			return $return;
		}


		/**
		 * Attempts to Add the specified domain name(s) for Domain Forward Service
		 *
		 * @return AssociativeArray
		 * @param domainHash This should contain the domain name(s) which are to be added. The HashMap
		 * should have the domainname as the key, and the no of Years as the value
		 * @param customerId The customer under whom the orders should be added
		 * @param invoiceOption This parameter will decide how the Customer Invoices will be handled.
		 *	NoInvoice If this value is passed, then no customer invoice will be generated for the domains.
		 *	PayInvoice - If this value is passed, then a customer invoice will be generated for the domains in the
		 *	first step. If there is sufficient balance in the Customer's Debit Account, then the invoices will be paid
		 *	and the domains will be registered. If a customer has less balance than required, then as many domains
		 *	as possible will be registered with the existing funds. All other orders will remain pending in the system.
		 *	KeepInvoice - If this value is passed, then a customer invoice will be generated for the domains.
		 *	However, these invoices will not be paid. They will be kept pending, while the orders will be executed.
		* <br><br><b>Returns:</b>
		* <br>An Associative Array with the result of the Addition. The Associative Array  has the
		  *	domainnames as the key, and a HashMap as the value. The inner Associative Array will have key-values
		  *	as follows:
		  *	<pre>
		  *	entityid=435
		  *	description=apitest04.com
		  *	actiontype=RenewDomain
		  *	actiontypedesc=Renewal of apitest04.com for 1 years
		  *	actionstatus=Success
		  *	actionstatusdesc=Domain renewed successully
		  *	status=Success
		  *	eaqid=1169
		  *	</pre>
		  *
		  *	Incase you have chosen "KeepInvoice" or "PayInvoice", the return HashMap will
		  *	also contain the following data:
		  *	<pre>
		  *	customerid=8
		  *	invoiceid=727
		  *	sellingcurrencysymbol=INR
		  *	sellingamount=-500.000
		  *	unutilisedsellingamount=-500.000
		  *	</pre>
		  *	invoiceid is the Id that you will need to pass to Fund.payCustomerTransaction if you wish to pay
		  *	the invoice at a later date.
		  *	selllingamount is the Invoice amount in your Selling Currency
		  *	unutilisedselllingamount is the Pending Invoice amount in your Selling Currency.
		  *	In case of "KeepInvoice", the pending amount will always be equal to the invoice amount.
		  *	In case of "PayInvoice", if the Customer does not have sufficient funds to pay the entire
		  *	invoice amount, unutilisedsellingamount will reflect the balance amount that is pending.
		  *	If the invoice has been completely paid, the unutilisedsellingamount will be 0.
		 */
		function addService($userName, $password, $role, $langpref, $parentid,
									$domainHash, $customerId, $invoiceOption)
		{
			$param = array($userName, $password, $role, $langpref, $parentid,
									$domainHash, $customerId, $invoiceOption);
			$return = $this->s->call("addService",$param);
                        $this->debugfunction();
			return $return;
		}

		  /**
		  * Attempts to Renew the specified domain name(s)
		  *
		  * This method performs the action in two steps - 1. It adds an action for the Renewal of the Domain.
		  * 2. It attempts to renew the domainname in the Registry. Your Reseller account must have sufficient
		  * funds to register the domain names since this is a billable action.
		  *
		  * @return AssociativeArray
		  * @param domainHash This should contain the domain name(s) which are to be renewed.
		  * In domainHash one has to send HashMap containing Inside one more HashMap.
		  * It contains following info.
		  * <pre>
		  * {
		  *  domain name =
		  *              {
		  *                  entityid = orderId,
		  *                  noofyears = No ofyears,
		  *                  expirydate = expiry date in seconds
		  *              }
		  * }
		  * e.g.
		  * {
		  *  directi.com =
		  *              {
		  *                  entityid = 123,
		  *                  noofyears = 1,
		  *                  expirydate = 2000
		  *              }
		  * }
		  * {
		  *  reseller.com =
		  *              {
		  *                  entityid = 125,
		  *                  noofyears = 4,
		  *                  expirydate = 4000
		  *              }
		  * }
		  * </pre>
		  *
		  * @param invoiceOption This parameter will decide how the Customer Invoices will be handled.
		  *	NoInvoice If this value is passed, then no customer invoice will be generated for the domains.
		  *	PayInvoice - If this value is passed, then a customer invoice will be generated for the domains in the
		  *	first step. If there is sufficient balance in the Customer's Debit Account, then the invoices will be paid
		  *	and the domains will be registered. If a customer has less balance than required, then as many domains
		  *	as possible will be registered with the existing funds. All other orders will remain pending in the system.
		  *	KeepInvoice - If this value is passed, then a customer invoice will be generated for the domains.
		  *	However, these invoices will not be paid. They will be kept pending, while the orders will be executed.
		  * <br><br><b>Returns:</b>
		  * <br>An Associative Array with the result of the Renwwal. The Associative Array has the
		  *	domainnames as the key, and a Associative Array as the value. The inner Associative Array will have key-values
		  *	as follows:
		  *	<pre>
		  *	entityid=435
		  *	description=apitest04.com
		  *	actiontype=RenewDomain
		  *	actiontypedesc=Renewal of apitest04.com for 1 years
		  *	actionstatus=Success
		  *	actionstatusdesc=Domain renewed successully
		  *	status=Success
		  *	eaqid=1169
		  *	</pre>
		  *
		  *	Incase you have chosen "KeepInvoice" or "PayInvoice", the return HashMap will
		  *	also contain the following data:
		  *	<pre>
		  *	customerid=8
		  *	invoiceid=727
		  *	sellingcurrencysymbol=INR
		  *	sellingamount=-500.000
		  *	unutilisedsellingamount=-500.000
		  *	</pre>
		  *	invoiceid is the Id that you will need to pass to Fund.payCustomerTransaction if you wish to pay
		  *	the invoice at a later date.
		  *	selllingamount is the Invoice amount in your Selling Currency
		  *	unutilisedselllingamount is the Pending Invoice amount in your Selling Currency.
		  *	In case of "KeepInvoice", the pending amount will always be equal to the invoice amount.
		  *	In case of "PayInvoice", if the Customer does not have sufficient funds to pay the entire
		  *	invoice amount, unutilisedsellingamount will reflect the balance amount that is pending.
		  *	If the invoice has been completely paid, the unutilisedsellingamount will be 0.
		  */
		function renewService($userName, $password, $role, $langpref, $parentid,
									  $domainHash, $invoiceOption)
		{
			$param = array($userName, $password, $role, $langpref, $parentid,
									  $domainHash, $invoiceOption);
			$return = $this->s->call("renewService",$param);
                        $this->debugfunction();
			return $return;
		}

		/**
		 * Attempts to manage the Domain forward service
		 *
		 * @return AssociativeArray
		 * @param entityId  The entityId under which the service to be modifed is created
		 * @param forward The url forward String that need to be set
		 * @param urlMasking Boolean value indicating whether to avail urlMasking
		 * @param subdomainForwarding Boolean value indicating whether to avail subdomainForwarding
		 * @param noframes No of frames to be set
		 * @param headerTags The headerTag to be set
		 * <br><br><b>Returns:</b>
		 * <br>An Associative Array with the result of the modification.
		 */
		function manage($userName, $password, $role, $langpref, $parentid,
								$entityId, $forward, $urlMasking,
								$subdomainForwarding,$noframes,$headerTags)
		{
			$param = array($userName, $password, $role, $langpref, $parentid,
								$entityId, $forward, $urlMasking,
								$subdomainForwarding,$noframes,$headerTags);
			$return = $this->s->call("manage",$param);
                        $this->debugfunction();
			return $return;
		}

		/**
		 *  Attempts to delete the Domain Forward Service for the specified domain
		 *
		 * @return AssociativeArray
		 * @param entityId The entityId under which the service is to be deleted
		 * <br><br><b>Returns:</b>
		 * <br>An Associative Array with the result of the deletion.
		 */
		function deleteService($userName, $password, $role, $langpref, $parentid,
									   $entityId)
		{
			$param = array($userName, $password, $role, $langpref, $parentid,
									   $entityId);
			$return = $this->s->call("deleteService",$param);
                        $this->debugfunction();
			return $return;
		}

		/** Gets the Details of the specified order based on given option
		 *
		 * @return AssociativeArray
		 * @param orderId The orderId under which the details is to be listed
		 * @param option Vector for listing Orders with various options
		 * <br> Valid values are: All,OrderDetails,PricingDetails
		 * <br><br><b>Returns:</b>
		 * <br>An Associative Array with the result
		 * Values returned by the HashMap are
		 * domainname=
		 * forward=
		 * urlmasking=
		 * pathforwarding=
		 * subdomainforwarding=
		 * noframes=
		 * headertags=
		 * productName=
		 */	
		function getDetails($userName, $password, $role, $langpref, $parentid,
									$orderid, $option)
		{
			$param = array($userName, $password, $role, $langpref, $parentid,
									$orderid, $option);
			$return = $this->s->call("getDetails",$param);
                        $this->debugfunction();
			return $return;
		}

	}

?>