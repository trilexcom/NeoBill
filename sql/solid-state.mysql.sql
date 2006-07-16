-- Database: `solidstate`
-- 

-- --------------------------------------------------------

-- 
-- Table structure for table `account`
-- 

CREATE TABLE `account` (
  `id` int(11) NOT NULL auto_increment,
  `type` enum('Individual Account','Business Account') NOT NULL default 'Business Account',
  `status` enum('Active','Inactive','Pending') NOT NULL default 'Active',
  `billingstatus` enum('Bill','Do Not Bill') NOT NULL default 'Bill',
  `billingday` int(11) NOT NULL default '0',
  `businessname` varchar(255) default NULL,
  `contactname` varchar(255) NOT NULL default '',
  `contactemail` varchar(255) NOT NULL default '',
  `address1` varchar(255) default NULL,
  `address2` varchar(255) default NULL,
  `city` varchar(255) default NULL,
  `state` varchar(255) default NULL,
  `country` varchar(255) default NULL,
  `postalcode` varchar(255) default NULL,
  `phone` varchar(255) default NULL,
  `mobilephone` varchar(255) default NULL,
  `fax` varchar(255) default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=50 ;

-- --------------------------------------------------------

-- 
-- Table structure for table `authorizeaim`
-- 

CREATE TABLE `authorizeaim` (
  `transid` varchar(10) NOT NULL,
  `lastdigits` varchar(4) NOT NULL,
  PRIMARY KEY  (`transid`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

-- 
-- Table structure for table `contact`
-- 

CREATE TABLE `contact` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `name` varchar(255) NOT NULL,
  `businessname` varchar(255) default NULL,
  `email` varchar(255) default NULL,
  `address1` varchar(255) default NULL,
  `address2` varchar(255) default NULL,
  `address3` varchar(255) default NULL,
  `city` varchar(255) default NULL,
  `state` varchar(255) default NULL,
  `country` varchar(255) default NULL,
  `postalcode` varchar(255) default NULL,
  `phone` varchar(255) default NULL,
  `mobilephone` varchar(255) default NULL,
  `fax` varchar(255) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=24 ;

-- --------------------------------------------------------

-- 
-- Table structure for table `domainservice`
-- 

CREATE TABLE `domainservice` (
  `tld` varchar(255) NOT NULL default '',
  `modulename` varchar(255) default NULL,
  `description` blob,
  `price1yr` decimal(10,2) NOT NULL default '0.00',
  `price2yr` decimal(10,2) NOT NULL default '0.00',
  `price3yr` decimal(10,2) NOT NULL default '0.00',
  `price4yr` decimal(10,2) NOT NULL default '0.00',
  `price5yr` decimal(10,2) NOT NULL default '0.00',
  `price6yr` decimal(10,2) NOT NULL default '0.00',
  `price7yr` decimal(10,2) NOT NULL default '0.00',
  `price8yr` decimal(10,2) NOT NULL default '0.00',
  `price9yr` decimal(10,2) NOT NULL default '0.00',
  `price10yr` decimal(10,2) NOT NULL default '0.00',
  `taxable` enum('Yes','No') NOT NULL default 'No',
  PRIMARY KEY  (`tld`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

-- 
-- Table structure for table `domainservicepurchase`
-- 

CREATE TABLE `domainservicepurchase` (
  `id` int(11) NOT NULL auto_increment,
  `accountid` int(11) NOT NULL default '0',
  `tld` varchar(255) NOT NULL default '',
  `term` enum('1 year','2 year','3 year','4 year','5 year','6 year','7 year','8 year','9 year','10 year') NOT 
NULL default '1 year',
  `domainname` varchar(255) NOT NULL default '',
  `date` datetime NOT NULL default '0000-00-00 00:00:00',
  `expiredate` datetime NOT NULL default '0000-00-00 00:00:00',
  `accountname` varchar(255) default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=19 ;

-- --------------------------------------------------------

-- 
-- Table structure for table `hostingservice`
-- 

CREATE TABLE `hostingservice` (
  `id` int(11) NOT NULL auto_increment,
  `title` varchar(255) NOT NULL default '',
  `description` blob,
  `setupprice1mo` decimal(10,2) NOT NULL default '0.00',
  `price1mo` decimal(10,2) NOT NULL default '0.00',
  `setupprice3mo` decimal(10,2) NOT NULL default '0.00',
  `price3mo` decimal(10,2) NOT NULL default '0.00',
  `setupprice6mo` decimal(10,2) NOT NULL default '0.00',
  `price6mo` decimal(10,2) NOT NULL default '0.00',
  `setupprice12mo` decimal(10,2) NOT NULL default '0.00',
  `price12mo` decimal(10,2) NOT NULL default '0.00',
  `uniqueip` enum('Required','Not Required') NOT NULL default 'Not Required',
  `taxable` enum('Yes','No') NOT NULL default 'No',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

-- --------------------------------------------------------

-- 
-- Table structure for table `hostingservicepurchase`
-- 

CREATE TABLE `hostingservicepurchase` (
  `id` int(11) NOT NULL auto_increment,
  `accountid` int(11) NOT NULL default '0',
  `hostingserviceid` int(11) NOT NULL default '0',
  `serverid` int(11) default NULL,
  `term` enum('1 month','3 month','6 month','12 month') NOT NULL default '1 month',
  `date` datetime NOT NULL default '0000-00-00 00:00:00',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=16 ;

-- --------------------------------------------------------

-- 
-- Table structure for table `invoice`
-- 

CREATE TABLE `invoice` (
  `id` int(11) NOT NULL auto_increment,
  `accountid` int(11) NOT NULL default '0',
  `date` datetime NOT NULL default '0000-00-00 00:00:00',
  `periodbegin` datetime NOT NULL default '0000-00-00 00:00:00',
  `periodend` datetime NOT NULL default '0000-00-00 00:00:00',
  `note` blob,
  `terms` int(11) NOT NULL default '1',
  `outstanding` enum('yes','no') NOT NULL default 'yes',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=84 ;

-- --------------------------------------------------------

-- 
-- Table structure for table `invoiceitem`
-- 

CREATE TABLE `invoiceitem` (
  `id` int(11) NOT NULL auto_increment,
  `invoiceid` int(11) NOT NULL default '0',
  `taxitem` enum('No','Yes') NOT NULL default 'No',
  `quantity` int(11) default NULL,
  `unitamount` decimal(10,2) NOT NULL default '0.00',
  `text` varchar(255) NOT NULL default '',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=113 ;

-- --------------------------------------------------------

-- 
-- Table structure for table `ipaddress`
-- 

CREATE TABLE `ipaddress` (
  `ipaddress` int(11) NOT NULL default '0',
  `serverid` int(11) NOT NULL default '0',
  `purchaseid` int(11) default NULL,
  PRIMARY KEY  (`ipaddress`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

-- 
-- Table structure for table `log`
-- 

CREATE TABLE `log` (
  `id` int(11) NOT NULL auto_increment,
  `type` enum('notice','warning','error','critical','security') NOT NULL default 'notice',
  `module` varchar(255) NOT NULL default '',
  `text` varchar(255) NOT NULL default '',
  `username` varchar(255) NOT NULL default '0',
  `remoteip` int(11) NOT NULL default '0',
  `date` datetime NOT NULL default '0000-00-00 00:00:00',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1374 ;

-- --------------------------------------------------------

-- 
-- Table structure for table `module`
-- 

CREATE TABLE `module` (
  `name` varchar(255) NOT NULL default '',
  `enabled` enum('Yes','No') NOT NULL default 'No',
  `type` varchar(255) NOT NULL default '',
  `shortdescription` varchar(32) default NULL,
  `description` varchar(255) NOT NULL default '',
  PRIMARY KEY  (`name`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

-- 
-- Table structure for table `modulesetting`
-- 

CREATE TABLE `modulesetting` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `name` varchar(255) NOT NULL default '',
  `value` text,
  `modulename` varchar(255) NOT NULL default '',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=145 ;

-- -------
-- Admin 
password is 'temp'
INSERT INTO `user` (`username`, `password`, `type`, `firstname`, `lastname`, `email`) VALUES ('admin', '3d801aa532c1cec3ee82d87a99fdf63f', 'Administrator', 'Default', 'Administrator', '');

INSERT INTO `settings` VALUES ('company_name', 'SolidState v0.4');
INSERT INTO `settings` VALUES ('company_email', 'demo@solid-state.org');
INSERT INTO `settings` VALUES ('welcome_subject', 'Welcome to Web Hosting Company!');
INSERT INTO `settings` VALUES ('welcome_email', 'This is the welcome email that can be sent to your new \r\ncustomers.');
INSERT INTO `settings` VALUES ('nameservers_ns1', 'ns1.example.com');
INSERT INTO `settings` VALUES ('nameservers_ns2', 'ns2.example.com');
INSERT INTO `settings` VALUES ('nameservers_ns3', 'ns3.example.com');
INSERT INTO `settings` VALUES ('nameservers_ns4', 'ns4.example.com');
INSERT INTO `settings` VALUES ('invoice_text', 'Invoice #{invoice_id}\r\n\r\n===================================================================\r\nItem                                    Price     Qty  Total\r\n===================================================================\r\n{invoice_items}===================================================================\r\n\r\nSub-Total: {invoice_subtotal}\r\nTaxes: {invoice_taxtotal}\r\nInvoice Total: {invoice_total}\r\nPayments Received: {invoice_payments}\r\nBalance: {invoice_balance}\r\nDate Due: {invoice_due}\r\n\r\nIf you have any questions about this Invoice, please contact\r\nbilling@example.com.  Thank you!\r\n\r\nWeb Hosting Company\r\n');
INSERT INTO `settings` VALUES ('locale_language', 'english');
INSERT INTO `settings` VALUES ('locale_currency_symbol', '$');
INSERT INTO `settings` VALUES ('payment_gateway_default_module', '');
INSERT INTO `settings` VALUES ('payment_gateway_order_method', 'Authorize Only`);
