<?php

	include_once("nusoapw.php");

	/**
	* @access private
	*/
	$debugfunction = $DEBUG;

	/**
	* Fund class contains Transaction related functions.
	*/
	class Website
	{
		/**
		* @access private
		* @var object
		*/
		var $s;	// This will hold an instance of soapclientw class in nusoapw.php
		
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
		function Website($wsdlurl="wsdl/Website.wsdl")
		{
			$this->wsdl = $wsdlurl;
			$this->s = new soapclientw($this->wsdl,"wsdl");
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
		 *
		 * @param entityId The entityid which has to be moved
		 * @param newCustomerId The new customer id under which the entity has to be moved
		 * @param newResellerId The new reseller id under which the entity has to be moved
		 * @return
		 */
		function moveWebsite($userName,$password,$role,$langpref,$parentid,$websiteName,$newCustomerId,$defaultContact)
		{
			$para = array($userName,$password,$role,$langpref,$parentid,$websiteName,$newCustomerId,$defaultContact);
			$return = $this->s->call("moveWebsite",$para);
			$this->debugfunction();
			return $return;
		}		 
	}

?>