<?php
/**
 * EnomInterface.class.php
 *
 * This file contains the definition of the EnomInterface class.
 *
 * Changes:
 *   Nov 14, 2006 - Cleaned up code style, integrated with SS (JD)
 *
 * @package enom
 * @author Enom (http://www.enom.com)
 */

class EnomInterface 
{
  var $PostString;
  var $RawData;
  var $Values;
	
  function NewRequest() 
  {
    // Clear out all previous values
    $this->PostString = "";
    $this->RawData = "";
    $this->Values = "";
  }

  function AddError( $error ) 
  {
    // Add an error to the result list
    $this->Values[ "ErrCount" ] = "1";
    $this->Values[ "Err1" ] = $error;
  }
	
  function ParseResponse( $buffer ) 
  {
    // Parse the string into lines
    $Lines = explode( "\r", $buffer );
    
    // Get # of lines
    $NumLines = count( $Lines );
    
    // Skip past header
    $i = 0;
    while ( trim( $Lines[ $i ] ) != "" ) 
      {
	$i = $i + 1;
      }
    
    $StartLine = $i;
    
    // Parse lines
    $GotValues = 0;
    for ( $i = $StartLine; $i < $NumLines; $i++ ) 
      {
	// Is this line a comment?
	if ( substr( $Lines[ $i ], 1, 1 ) != ";" ) 
	  {
	    // It is not, parse it
	    $Result = explode( "=", $Lines[ $i ] );
	    
	    // Make sure we got 2 strings
	    if ( count( $Result ) >= 2 ) 
	      {
		// Trim whitespace and add values
		$name = trim( $Result[0] );
		$value = trim( $Result[1] );
		$this->Values[ $name ] = $value;
		
		// Was it an ErrCount value?
		if ( $name == "ErrCount" ) 
		  {
		    // Remember this!
		    $GotValues = 1;
		  }
	      }
	  }
      }
    
    if ( $GotValues == 0 ) 
      {
	// We didn't, so add an error message
	$this->AddError( "Could not connect to Server -Please try again Later" );
      }
  }
  
  function AddParam( $Name, $Value ) 
  {
    // URL encode the value and add to PostString
    $this->PostString = $this->PostString . $Name . "=" . urlencode( $Value ) . "&";
  }
  
  function DoTransaction() 
  {
    // include ("sessions.php");
    // Clear values
    // global $UseSSL;
    // global $Server;
    $UseSSL = 0;
    $Server = 1;
    $Values = "";
    
    if($Server == '1')
      {
	$host = 'resellertest.enom.com';
      } 
    elseif($Server == '0')
      {
	$host = 'reseller.enom.com';
      } 
    else 
      {
	$host = 'resellertest.enom.com';
      }
			
    if($UseSSL == 1)
      {
	$port = 443;
	$address = gethostbyname( $host );
	$socket = fsockopen("ssl://".$host,$port);  
      } 
    else 
      {
	$port = 80;
	$address = gethostbyname( $host );
	$socket = fsockopen($host,$port);  
      }

    if ( !$socket ) 
      {
	function strerror()
	{
	  echo "Could not connect to Server -Please try again Later";
	}
	$this->AddError( "socket() failed: " . strerror( $socket ) );
      } 
    else 
      {
	// Send GET command with our parameters
	$in = "GET /interface.asp?" . $this->PostString . "HTTP/1.0\r\n\r\n";
	$out = '';
	
	fputs($socket,$in);
	
	// Read response
	while ( $out=fread ($socket,2048) ) 
	  {
	    // Save in rawdata
	    $this->RawData .= $out;
	  }

	// Close the socket
	fclose( $socket );
      
	// Parse the output for name=value pairs
	$this->ParseResponse( $this->RawData );
      }
  }
}
?>
