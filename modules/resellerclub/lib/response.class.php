<?php

/**
* This class is basically used to get formatted o/p.
*/

class Response
{
	/**
	* Holds an Error code.
	*
	* @access public
	* @var string
	*/
	var $errorCode;
	
	/**
	* Holds an Class which throws Error.
	*
	* @access public
	* @var string
	*/
	var $errorClass;
	
	/**
	* Holds an Error Description.
	*
	* @access public
	* @var string
	*/
	var $errorMsg;
	
	/**
	* Holds an Error Level.
	*
	* @access public
	* @var string
	*/
	var $errorLevel;
	
	/**
	* @access private
	*/
	var $seperator = "#~#";    // seperator used in Error string.

	/**
	* @access private
	*/
	var $data;	// Holds data.

	/**
	* @access private
	*/
	var $error = false;	//Holds error string.

	/**
	* The constructor which takes data to be analysed as a parameter.
	*
	* @param string data to be analysed
	*
	*/
        /*function Response($value,$extra)
        *{
        *  $this->data = $value;
        *} 
	*/
	function Response($value)
	{
                 
		$this->data = $value;
		if (is_array($this->data))
		{
			$this->errorAnalyse();
		}
	}

	/**
	* @access private
	*
	*/
	// This function analyse the data for error. 
	// If data consists of Error string it fills the variables $errorCode,$errorClass,$errorMsg $errorLevel and $error.

	function errorAnalyse()
	{
		foreach ($this->data as $key => $value)
		{
           //      print_r($key);
			if ($key == "faultstring")
			{
                          //    print_r("fault<br>"); 
				$error = array();
				$counter = 1;
				$start = 0;
				
				while($pos = strpos($value,$this->seperator,$start))
				{
					$error[$counter] = substr($value,$start,$pos-$start);
					$start = $pos+strlen($this->seperator);
					$counter = $counter+1;
				}
				$this->errorCode = $error[1];
				$this->errorClass = $error[2];
				$this->errorMsg = $error[3];
				$this->errorLevel = $error[4];
				$this->error = true;
			}
		}
	}
	/**
	* This function returns true/false depending upon whether data is an error string or not.
	*
	* @return boolean
	*
	*/
	function isError()
	{
		return $this->error;
	}

	/**
	* This function returns the data if no error occured . 
	*
	* @return Any
	*
	*/
	function getResult()
	{
		if (!$this->error)
		{
			return $this->data;
		}
		else
		{
			return "<b>Error Occured</b>.<br><br> Access Member Variables of the Response class for Error Description<br>";
		}
	}

	/**
	* This fuction print the Error in proper format.
	*
	* @return void
	*
	*/
	function printError()
	{
		if ($this->error)
		{
                 print" <table id=\"tblParams\" style=\"font-size: 11px; font-family: Verdana\" cellspacing=\"1\" cellpadding=\"1\" width=\"100%\" border=\"1\">";
			print "<tr><td><b>Error Code:</b></td><td><br>" . $this->errorCode . "<br></td></tr>";
			print "<tr><td><b>Error Class:</b></td><td><br>" . $this->errorClass. "<br></td></tr>";
			print "<tr><td><b>Error Description:</b></td><td><br>" . $this->errorMsg . "<br></td></tr>";
			print "<tr><td><b>Error Level:</b><br></td><td>" . $this->errorLevel . "<br></td></tr>";
                 print"</table>";
		}
		else
		{
			print "<b>No Error:</b> Call printData(\$dataToPrint) to print Result<br><br>";
		}
	}
	
	/**
	* This fuction print the passed data in proper format.
	*
	* @return void
	* @param string Data to print.
	*
	*/
               







	function printData($dataToPrint)
	{
		if (!$this->error)
		{
		 print" <table id=\"tblParams\" style=\"font-size: 11px; font-family: Verdana\" cellspacing=\"1\" cellpadding=\"1\"
                                        width=\"100%\" border=\"1\">";
               	if (is_array($dataToPrint))
			{
				foreach ($dataToPrint as $key => $value)
				{
					if (is_array($value))
					{
                                       /*    print" <table id=\"tblParams\" style=\"font-size: 11px; font-family: Verdana\" cellspacing=\"1\" cellpadding=\"1\"
                                        width=\"100%\" border=\"1\">";*/
					print "<tr><td>$key </td><td>";
                                        $this->printData($value);
                                        print"</td></tr>"; 
					}
					else
					{
                                                if (is_string($key))
                                                   {
                                                     if (empty($value))
                                                       {
                                                        $value="&nbsp;";
                                                       } 
						     print "<tr><td>$key</td><td>$value</td></tr>";
                                                   }
                                                 else
                                                   {
                                                     print "<tr><td>$value</td></tr>";
                                                   }
					}
				}
                      /*     print"</table>";  */
                           
			}
			else
			{
                               
				print "<tr><td>$dataToPrint</td><td></td></tr>";  
			}
                      print"</table>";

		}
		else
		{
			print "<b>Error Occured:</b> Call printError() to print Error<br><br>";
		}
	}







 function printData2($dataToPrint)
        {
                if (!$this->error)
                {
                 print"<form name=\"Form1\" method=\"post\" action=\"../examples/CustomerClient.php\" id=\"Form1\">"; 

                 print" <table id=\"tblParams\" style=\"font-size: 11px; font-family: Verdana\" cellspacing=\"1\" cellpadding=\"1\" width=\"100%\" border=\"1\">";
                if (is_array($dataToPrint))
                        {
                         foreach ($dataToPrint as $key => $value)
                                {
                                  if ($key=="customerid")
                                     {
                                        print"<tr><td><input type=\"hidden\" name=\"txtCustomerID\" value =\"$value\"></td></tr>";
                                        print "<tr><td style=\"width: 197px; height: 29px\">$key</td><td style=\"height: 29px\"><P>$value</P></td></tr>";
                                     } 
                                }
                                foreach ($dataToPrint as $key => $value)
                                {
                                        if (is_array($value))
                                        {
                                       /*    print" <table id=\"tblParams\" style=\"font-size: 11px; font-family: Verdana\" cellspacing=\"1\" cellpadding=\"1\"
                                        width=\"100%\" border=\"1\">";*/
                                        print "<tr><td>$key </td><td>";
                                        $this->printData2($value);
                                        print"</td></tr>";
                                        }
           
                                        else
                                        {
                                                if (is_string($key))
                                                   {
                                                     if (empty($value))
                                                       {
                                                        $value="&nbsp;";
                                                       }
                                         //            print "<tr><td>$key</td><td>$value</td></tr>";
                                        if ($key=="password"||$key=="totalreceipts"||$key=="creationdt"||$key=="customerstatus"||$key=="resellerid"||$key=="customerid")
                                           {
                                             continue;
                                           }
                                        print "<tr><td style=\"width: 197px; height: 29px\">$key</td><td style=\"height: 29px\"><P><input name=\"txt$key\" type=\"text\" id=\"txt$key\" value=\"$value\"/></P></td></tr>";

                                                   }
                                                 else
                                                   {
                                                     print "<tr><td>$value</td></tr>";
                                                   }
                                        }
                                }
                      /*     print"</table>";  */

                        }
                        else
                        {

                                print "<tr><td>$dataToPrint</td><td></td></tr>";
                        }
                      print"<tr><td align=\"center\" colSpan=\"2\"><input type=\"submit\" name=\"submitbtn\" value=\"ModDetails1\" id=\"btnModDetails2\" /></td></tr>";
              print"</table>";

                }
                else
                {
                        print "<b>Error Occured:</b> Call printError() to print Error<br><br>";
                }
        }



function printData3($dataToPrint)
        {
                if (!$this->error)
                {
                 print"<form name=\"Form1\" method=\"post\" action=\"http://image.local.webhosting.info/api/examples/domcontactclient.php\" id=\"Form1\">";



                 print" <table id=\"tblParams\" style=\"font-size: 11px; font-family: Verdana\" cellspacing=\"1\" cellpadding=\"1\" width=\"100%\" border=\"1\">";
                if (is_array($dataToPrint))
                        {
                                foreach ($dataToPrint as $key => $value)
                                {
                                  if ($key=="contactid")
                                     {
                                        print"<tr><td><input type=\"hidden\" name=\"txtContactID\" value =\"$value\"></td></tr>";

                                        print "<tr><td style=\"width: 197px; height: 29px\">$key</td><td style=\"height: 29px\"><P>$value</P></td></tr>";
                                     }
                                }
                                foreach ($dataToPrint as $key => $value)
                                {
                                        if (is_array($value))
                                        {
                                       /*    print" <table id=\"tblParams\" style=\"font-size: 11px; font-family: Verdana\" cellspacing=\"1\" cellpadding=\"1\"
                                        width=\"100%\" border=\"1\">";*/
                                        if ($key == "contacttype")
                                          continue;
                                        print "<tr><td>$key </td><td>";
                                        $this->printData3($value);
                                        print"</td></tr>";
                                        }

                                 else
                                        {
                                                if (is_string($key))
                                                   {
                                                     if (empty($value))
                                                       {
                                                        $value="&nbsp;";
                                                       }
                                         //            print "<tr><td>$key</td><td>$value</td></tr>";
                                        if ($key=="password"||$key=="totalreceipts"||$key=="creationdt"||$key=="customerstatus"||$key=="resellerid"||$key=="contactid"||$key=="eaqid"||$key=="classname"||$key=="parentkey"||$key=="actioncompleted"||$key=="customerid"||$key=="classkey"||$key=="entitytypeid"||$key=="currentstatus"||$key=="contacttype"||$key=="description"||$key=="entityid")
                                           {
                                             continue;
                                           }
                                        print "<tr><td style=\"width: 197px; height: 29px\">$key</td><td style=\"height: 29px\"><P><input name=\"txt$key\" type=\"text\" id=\"txt$key\" value=\"$value\"/></P></td></tr>";

                                                   }
                                                 else
                                                   {
                                                     print "<tr><td>$value</td></tr>";
                                                   }
                                        }
                                }
                      /*     print"</table>";  */

                        }
                        else
                        {

                                print "<tr><td>$dataToPrint</td><td></td></tr>";
                        }
                      print"<tr><td align=\"center\" colSpan=\"2\"><input type=\"submit\" name=\"submitbtn\" value=\"ModDetails2\" id=\"btnModDetails\" /></td></tr>";
              print"</table>";

                }
                else
                {
                        print "<b>Error Occured:</b> Call printError() to print Error<br><br>";
                }
        }


    function PrintCustomerData($dataToPrint)
	{
		?>
		<form name="Form1" method="post" action="../examples/CustomerClient.php" id="Form1">
			<table id="tblParams" style="font-size: 11px; font-family: Verdana" cellspacing="1" cellpadding="1"
				width="100%" border="1">
				<tr>
					<td colSpan="2">Customer Details</td>
				</tr>
				<tr>
					<td style="width: 197px; height: 26px">Customer ID</td>
					<td><?=$dataToPrint['customerid']?>
					<input name="txtCustomerID" value="<?=$dataToPrint['customerid']?>"type="hidden"/>
					</td>
				</tr>
				<tr>
					<td style="width: 197px; height: 26px">User Name</td>
					<td><input name="txtUserName" value="<?=$dataToPrint['username']?>"type="text" id="txtUsername" /></td>
				</tr>
				<tr>
					<td style="width: 197px">Name</td>
					<td>
						<P><input name="txtName" value="<?=$dataToPrint['name']?>" type="text" id="txtName" /></P>
					</td>
				</tr>
				<tr>
					<td style="width: 197px; height: 28px">Company</td>
					<td style="height: 28px">
						<P><input name="txtCompany" value="<?=$dataToPrint['company']?>" type="text" id="txtCompany" /></P>
					</td>
				</tr>
				<tr>
					<td style="width: 197px">Language Preference</td>
					<td>
						<P><input name="txtLangPref" value="<?=$dataToPrint['langpref']?>" type="text" id="txtLangPref" /></P>
					</td>
				</tr>
				<tr>
					<td style="width: 197px; height: 29px">Adderss1</td>
					<td style="height: 29px">
						<P><input name="txtAddress1" value="<?=$dataToPrint['address1']?>" type="text" id="txtAddress1" /></P>
					</td>
				</tr>
				<tr>
					<td style="width: 197px; height: 28px">Address2</td>
					<td style="height: 28px">
						<P><input name="txtAddress2" value="<?=$dataToPrint['address2']?>" type="text" id="txtAddress2" /></P>
					</td>
				</tr>
				<tr>
					<td style="width: 197px">Address3</td>
					<td><input name="txtAddress3" value="<?=$dataToPrint['address3']?>" type="text" id="txtAddress3" /></td>
				</tr>
				<tr>
					<td style="width: 197px">City</td>
					<td><input name="txtCity" value="<?=$dataToPrint['city']?>" type="text" id="txtCity" /></td>
				</tr>
				<tr>
					<td style="width: 197px; height: 28px">State</td>
					<td><input name="txtState" value="<?=$dataToPrint['state']?>" type="text" id="txtState" /></td>
				</tr>
				<tr>
					<td style="width: 197px">Country</td>
					<td><input name="txtCountry" value="<?=$dataToPrint['country']?>" type="text" id="txtCountry" /></td>
				</tr>
				<tr>
					<td style="width: 197px">Zip</td>
					<td><input name="txtZip" value="<?=$dataToPrint['zip']?>" type="text" id="txtZip" /></td>
				</tr>
				<tr>
					<td style="width: 197px">TelNo. Country code.</td>
					<td><input name="txtTelcc" value="<?=$dataToPrint['telnocc']?>" type="text" id="txtTelCc" /></td>
				</tr>
				<tr>
					<td style="width: 197px">TelNo.</td>
					<td><input name="txtTelNo" value="<?=$dataToPrint['telno']?>" type="text" id="txtTel" /></td>
				</tr>
				<tr>
					<td style="width: 197px">Alternate TelNo.Country code</td>
					<td><input name="txtAltTelCc" value="<?=$dataToPrint['alttelnocc']?>" type="text" id="txtAltTelCc" /></td>
				</tr>
				<tr>
					<td style="width: 197px">Alternate &nbsp;TelNo.</td>
					<td><input name="txtAltTelNo" value="<?=$dataToPrint['alttelno']?>" type="text" id="txtAltTel" /></td>
				</tr>
				<tr>
					<td style="width: 197px">FaxNo. Country code</td>
					<td><input name="txtFaxCc" value="<?=$dataToPrint['faxnocc']?>" type="text" id="txtFaxCc" /></td>
				</tr>
				<tr>
					<td style="width: 197px">FaxNo.</td>
					<td><input name="txtFaxNo" value="<?=$dataToPrint['faxno']?>" type="text" id="txtFax" /></td>
				</tr>
				<tr>
					<td align="center" colSpan="2"><input type="submit" name="btnModDetails" value="ModDetails" id="btnModDetails" />
					<input type="hidden" name="submitbtn" value="ModDetails1">
                                        </td>
				</tr>
			</table>
		</form>
		<?
	}

    function PrintContactData($dataToPrint)
	{
		?>
		<form name="Form1" method="post" action="../examples/DomainContactClient.php" >
			<table width="100%" border="1">
				<tr>
					<td colSpan="2">Contact&nbsp;Details</td>
				</tr>
                                <tr>
					<td>Contact ID</td>
                                        <td><?=$dataToPrint['contactid']?>
					<input name="txtContactID" value="<?=$dataToPrint['contactid']?>"type="hidden"/></td>
				</tr>
				<tr>
					<td>Name</td>
					<td><input name="txtName" value="<?=$dataToPrint['name']?>" type="text"  /></td>
				</tr>
				<tr>
					<td>Company</td>
					<td><input name="txtCompany" value="<?=$dataToPrint['company']?>" type="text"  /></td>
				</tr>
				<tr>
					<td style="width: 197px">Email Address</td>
					<td><input name="txtEmailAddr" value="<?=$dataToPrint['emailaddr']?>" type="text"  /></td>
				</tr>
				<tr>
					<td style="width: 197px">Adderss1</td>
					<td><input name="txtAddress1" value="<?=$dataToPrint['address1']?>" type="text"/></td>
				</tr>
				<tr>
					<td style="width: 197px">Address2</td>
					<td><input name="txtAddress2" value="<?=$dataToPrint['address2']?>" type="text"  /></td>
				</tr>
				<tr>
					<td style="width: 197px">Address3</td>
					<td><input name="txtAddress3" value="<?=$dataToPrint['address3']?>" type="text" /></td>
				</tr>
				<tr>
					<td style="width: 197px">City</td>
					<td><input name="txtCity" value="<?=$dataToPrint['city']?>" type="text" /></td>
				</tr>
				<tr>
					<td style="width: 197px">State</td>
					<td><input name="txtState" value="<?=$dataToPrint['state']?>" type="text" /></td>
				</tr>
				<tr>
					<td style="width: 197px">Country</td>
					<td><input name="txtCountry" value="<?=$dataToPrint['country']?>" type="text" /></td>
				</tr>
				<tr>
					<td style="width: 197px">Zip</td>
					<td><input name="txtZip" value="<?=$dataToPrint['zip']?>" type="text" /></td>
				</tr>
				<tr>
					<td style="width: 197px">TelNo. Country code.</td>
					<td><input name="txtTelcc" value="<?=$dataToPrint['telnocc']?>" type="text" /></td>
				</tr>
				<tr>
					<td style="width: 197px">TelNo.</td>
					<td><input name="txtTelNo" value="<?=$dataToPrint['telno']?>" type="text" /></td>
				</tr>
				<tr>
						<td style="width: 197px">FaxNo. Country code</td>
						<td><input name="txtFaxCc" value="<?=$dataToPrint['faxnocc']?>" type="text" id="txtFaxCc" /></td>
				</tr>
				<tr>
						<td style="width: 197px">FaxNo.</td>
						<td><input name="txtFaxNo" value="<?=$dataToPrint['faxno']?>" type="text" id="txtFaxNo" /></td>
				</tr>
				<tr>
					<td align="center" colSpan="2">
						<input type="submit" name="btnMod" value=" Mod "  />
						<input type="hidden" name="submitbtn" value="DomCnoMod">
					</td>
				</tr>
			</table>
		</form>
		<?
	}

}
?>