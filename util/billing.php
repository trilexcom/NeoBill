<?php
/**
 * billing.php
 *
 * This file contains utility functions related to Billing & Invoicing
 *
 * @package Utilities
 * @author John Diamond <jdiamond@solid-state.org>
 * @copyright John Diamond <jdiamond@solid-state.org>
 * @license http://www.opensource.org/licenses/gpl-license.php GNU Public License
 */

/**
 * Payment Stats
 *
 * Retrieve stats associated with Payments
 *
 * @return array Payment stats
 */
function payments_stats()
{
  // Count payments for the current month
  $payments_this_month = 0;
  
  // ... and total them
  $total_payments_this_month = 0.00;

  // Get all payments for this month
  $now = getDate( time() );
  $first_of_month = mktime( 0, 0, 1, $now['mon'], 1, $now['year']);
  $paymentdbo_array = load_array_PaymentDBO( "UNIX_TIMESTAMP(date) > " . 
					     $first_of_month );

  // Iterate through the payments
  if( isset( $paymentdbo_array ) )
    {
      foreach( $paymentdbo_array as $payment )
	{
	  // Add payment to totals
	  $payments_this_month++;
	  $total_payments_this_month += $payment->getAmount();
	}
    }
  return array( "count" => $payments_this_month,
		"total" => $total_payments_this_month );
}

/**
 * Outstanding Invoices Stats
 *
 * Gather stats for outstanding invoices
 *
 * @return array Outstanding Invoices stats
 */
function outstanding_invoices_stats()
{
  // Load invoices
  $invoicedbo_array = load_array_InvoiceDBO();

  // Count the outstanding invoices
  $count = 0;

  // Total the balance on all outstanding invoices
  $total_balance = 0.00;

  // Count the number of past-due invoices
  $count_past_due = 0;

  // ... and total
  $total_balance_past_due = 0.00;

  // Count the number of 30+ day past-due invoices
  $count_past_due_30 = 0;

  // ... and total
  $total_balance_past_due_30 = 0.00;

  // Iterate through all the invoices
  if( isset( $invoicedbo_array ) )
    {
      foreach( $invoicedbo_array as $invoice )
	{
	  if( ($invoice_balance = $invoice->getBalance()) >= 0.01 )
	    {
	      // Invoice has not been paid in full, 
	      $count++;
	      $total_balance += $invoice_balance;
	      
	      if( time() > $invoice->getDueDate() )
		{
		  // Invoice is past due
		  $count_past_due++;
		  $total_balance_past_due += $invoice_balance;
		}
	      
	      if( time() > ($invoice->getDueDate() + (30*24*60*60)) )
		{
		  // Invoice is more than 30 days past due
		  $count_past_due_30++;
		  $total_balance_past_due_30 += $invoice_balance;
		}
	    }
	}
    }

  // Stuff array with stats and return
  return array( "count" => $count,
		"total" => $total_balance,
		"count_past_due" => $count_past_due,
		"total_past_due" => $total_balance_past_due,
		"count_past_due_30" => $count_past_due_30,
		"total_past_due_30" => $total_balance_past_due_30 );
}

?>