<?php
/**
 * Email.class.php
 *
 * This file contains the definition for the Email class
 *
 * @package SolidWorks
 * @author John Diamond <jdiamond@solid-state.org>
 * @copyright John Diamond <jdiamond@solid-state.org>
 * @license http://www.opensource.org/licenses/gpl-license.php GNU Public License
 */

/**
 * Email
 *
 * This class sends an email using the PHP mail() function.  All the necessary
 * headers are added by this class.  The user only needs to supply the To:, the
 * Subject:, From:, and the body.
 *
 * @package SolidWorks
 * @author John Diamond <jdiamond@solid-state.org>
 */
class Email {
	/**
	 * @var string To Address(es)
	 */
	var $to;

	/**
	 * @var string Subject
	 */
	var $subject;

	/**
	 * @var string From
	 */
	var $from;

	/**
	 * @var string Body
	 */
	var $body;

	/**
	 * Set Subject
	 *
	 * Set the Subject: field
	 *
	 * @param string $subject Subject
	 */
	function setSubject( $subject ) {
		$this->subject = $subject;
	}

	/**
	 * Set From
	 *
	 * Set the From: field
	 *
	 * @param string $email Email address
	 * @param string $name Name of sender
	 */
	function setFrom( $email, $name ) {
		$this->from = $this->formatAddress( $email, $name );
	}

	/**
	 * Set Body
	 *
	 * Set the message body
	 *
	 * @param string $body Message body
	 */
	function setBody( $body ) {
		// Limit lines to 70 chars
		$this->body = wordwrap( $body, 70 );
	}

	/**
	 * Add Recipient
	 *
	 * Add a recipient to the To: field
	 *
	 * @param string $email Email address
	 * @param string $name Name of recipient
	 */
	function addRecipient( $email, $name = null ) {
		// Format the recipient
		$recipient = $this->formatAddress( $email, $name );

		// Add address to To: field
		if ( !isset( $this->to ) ) {
			// First recipient
			$this->to = $recipient;
		}
		else {
			// Append this recipient to the To: field
			$this->to .= ", " . $recipient;
		}
	}

	/**
	 * Format Address
	 *
	 * Format the name and email address like so: Full Name <email@address.com>
	 *
	 * @param string $email Email address
	 * @param string $name Name
	 */
	function formatAddress( $email, $name = null ) {
		if ( isset( $name ) ) {
			$address = $name . " <";
		}
		else {
			$address = "<";
		}
		$address .= $email . ">";

		return $address;
	}

	/**
	 * Send
	 *
	 * Attempts to send the email using the PHP mail() function.  Returns true
	 * for success and false on failure.
	 *
	 * @return bool
	 */
	function send() {
		// Tells sendmail to parse the message for recipients in the To: field
		$options = "-t";

		// Set some extra headers
		$headers = "From: " . $this->from;

		return @mail( $this->to,
				$this->subject,
				$this->body,
				$headers,
				$options );
	}
}

?>