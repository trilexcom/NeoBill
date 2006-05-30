<?php
/**
 * services.php
 *
 * This file contains functions useful for the Products and Services Page
 *
 * @package Utilities
 * @author John Diamond <jdiamond@solid-state.org>
 * @copyright John Diamond <jdiamond@solid-state.org>
 * @license http://www.opensource.org/licenses/gpl-license.php GNU Public License
 */

require_once $base_path . "DBO/HostingServiceDBO.class.php";
require_once $base_path . "DBO/DomainServiceDBO.class.php";
require_once $base_path . "DBO/ProductDBO.class.php";

/**
 * Services Stats
 *
 * Returns Web Hosting Service statistics in a hash containing the following keys:
 *   count - Number of web hosting services in the database
 *
 * @return array Stats
 */
function services_stats()
{
  $stats['count'] = count_all_HostingServiceDBO();

  return $stats;
}

/**
 * Domain Service Stats
 *
 * Returns Domains Service statistics in a hash containing the following keys:
 *   count - Number of domain services in the database
 *
 * @return array Domain service stats
 */
function domain_services_stats()
{
  $stats['count'] = count_all_DomainServiceDBO();

  return $stats;
}

/**
 * Product Stats
 *
 * Returns Product statistics in a hash containing the following keys:
 *   count - Number of domain services in the database
 *
 * @return array Product stats
 */
function products_stats()
{
  $stats['count'] = count_all_ProductDBO();

  return $stats;
}

?>
