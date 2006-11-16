<?php
/**
 * domains.php
 *
 * This file contains functions useful for the Domains Summary Page
 *
 * @package Utilities
 * @author John Diamond <jdiamond@solid-state.org>
 * @copyright John Diamond <jdiamond@solid-state.org>
 * @license http://www.opensource.org/licenses/gpl-license.php GNU Public License
 */

/**
 * Gather stats on active & expired domains
 *
 * Returns domain statistics in a hash containing the following keys:
 *   domains_count - Number of active domains in the database
 *   expired_domains_count - Number of expired domains in the database
 *
 * @return array Domain stats
 */
function domain_stats()
{
  $stats['domains_count'] = 
    count_all_DomainServicePurchaseDBO( "UNIX_TIMESTAMP(expiredate) > UNIX_TIMESTAMP(NOW())" );

  $stats['expired_domains_count'] = 
    count_all_DomainServicePurchaseDBO( "UNIX_TIMESTAMP(expiredate) < UNIX_TIMESTAMP(NOW())" );

  return $stats;
}
?>