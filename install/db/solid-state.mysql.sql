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
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=51 ;

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
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=45 ;

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
  `term` enum('1 year','2 year','3 year','4 year','5 year','6 year','7 year','8 year','9 year','10 year') NOT NULL default '1 year',
  `domainname` varchar(255) NOT NULL default '',
  `date` datetime NOT NULL default '0000-00-00 00:00:00',
  `expiredate` datetime NOT NULL default '0000-00-00 00:00:00',
  `accountname` varchar(255) default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=22 ;

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
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=22 ;

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
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=157 ;

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
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=419 ;

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
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1667 ;

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
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=146 ;

-- --------------------------------------------------------

-- 
-- Table structure for table `note`
-- 

CREATE TABLE `note` (
  `id` int(11) NOT NULL auto_increment,
  `date` datetime NOT NULL default '0000-00-00 00:00:00',
  `updated` datetime NOT NULL default '0000-00-00 00:00:00',
  `accountid` int(11) NOT NULL default '0',
  `username` varchar(10) NOT NULL default '',
  `text` blob NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

-- 
-- Table structure for table `order`
-- 

CREATE TABLE `order` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `datecreated` datetime NOT NULL default '0000-00-00 00:00:00',
  `datecompleted` datetime default NULL,
  `datefulfilled` datetime default NULL,
  `remoteip` int(11) NOT NULL default '0',
  `businessname` varchar(255) NOT NULL default '',
  `contactname` varchar(255) NOT NULL default '',
  `contactemail` varchar(255) NOT NULL default '',
  `address1` varchar(255) NOT NULL default '',
  `address2` varchar(255) default NULL,
  `city` varchar(255) NOT NULL default '',
  `state` varchar(255) NOT NULL default '',
  `country` char(3) NOT NULL default '',
  `postalcode` varchar(255) NOT NULL default '',
  `phone` varchar(255) NOT NULL default '',
  `mobilephone` varchar(255) default NULL,
  `fax` varchar(255) default NULL,
  `username` varchar(10) NOT NULL default '',
  `password` varchar(32) NOT NULL default '',
  `status` enum('Incomplete','Pending','Fulfilled') NOT NULL default 'Incomplete',
  `accountid` int(10) unsigned default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=47 ;

-- --------------------------------------------------------

-- 
-- Table structure for table `orderdomain`
-- 

CREATE TABLE `orderdomain` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `orderid` int(10) unsigned NOT NULL default '0',
  `orderitemid` int(10) unsigned NOT NULL default '0',
  `type` enum('New','Transfer','Existing') NOT NULL default 'Existing',
  `status` enum('Rejected','Pending','Accepted','Fulfilled') NOT NULL default 'Pending',
  `tld` varchar(255) default NULL,
  `domainname` varchar(255) NOT NULL default '',
  `term` enum('1 year','2 year','3 year','4 year','5 year','6 year','7 year','8 year','9 year','10 year') default '1 year',
  `transfersecret` varchar(255) default NULL,
  `admincontactid` int(10) unsigned NOT NULL,
  `billingcontactid` int(10) unsigned NOT NULL,
  `techcontactid` int(10) unsigned NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=31 ;

-- --------------------------------------------------------

-- 
-- Table structure for table `orderhosting`
-- 

CREATE TABLE `orderhosting` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `orderid` int(10) unsigned NOT NULL default '0',
  `orderitemid` int(10) unsigned NOT NULL default '0',
  `status` enum('Rejected','Pending','Accepted','Fulfilled') NOT NULL default 'Pending',
  `serviceid` int(10) unsigned NOT NULL default '0',
  `term` enum('1 month','3 month','6 month','12 month') NOT NULL default '1 month',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=23 ;

-- --------------------------------------------------------

-- 
-- Table structure for table `payment`
-- 

CREATE TABLE `payment` (
  `id` int(11) NOT NULL auto_increment,
  `invoiceid` int(11) unsigned default NULL,
  `orderid` int(10) unsigned default NULL,
  `date` datetime NOT NULL default '0000-00-00 00:00:00',
  `amount` decimal(10,2) NOT NULL default '0.00',
  `transaction1` varchar(255) default NULL,
  `transaction2` varchar(255) default NULL,
  `type` enum('Credit','Cash','Check','Module','Other') NOT NULL default 'Cash',
  `module` varchar(255) default NULL,
  `status` enum('Declined','Completed','Pending','Authorized','Refunded','Reversed','Voided') NOT NULL default 'Completed',
  `statusmessage` varchar(255) default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=47 ;

-- --------------------------------------------------------

-- 
-- Table structure for table `product`
-- 

CREATE TABLE `product` (
  `id` int(11) NOT NULL auto_increment,
  `name` varchar(255) NOT NULL default '',
  `description` blob,
  `price` decimal(10,2) NOT NULL default '0.00',
  `taxable` enum('Yes','No') NOT NULL default 'No',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

-- --------------------------------------------------------

-- 
-- Table structure for table `productpurchase`
-- 

CREATE TABLE `productpurchase` (
  `id` int(11) NOT NULL auto_increment,
  `productid` int(11) NOT NULL default '0',
  `accountid` int(11) NOT NULL default '0',
  `date` datetime NOT NULL default '0000-00-00 00:00:00',
  `note` varchar(255) default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

-- --------------------------------------------------------

-- 
-- Table structure for table `server`
-- 

CREATE TABLE `server` (
  `id` int(11) NOT NULL auto_increment,
  `hostname` varchar(255) NOT NULL default '',
  `location` varchar(255) default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

-- --------------------------------------------------------

-- 
-- Table structure for table `settings`
-- 

CREATE TABLE `settings` (
  `setting` varchar(255) NOT NULL default '',
  `value` text,
  PRIMARY KEY  (`setting`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

-- 
-- Table structure for table `taxrule`
-- 

CREATE TABLE `taxrule` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `country` char(2) NOT NULL default '',
  `state` varchar(255) default NULL,
  `rate` decimal(4,2) NOT NULL default '0.00',
  `allstates` enum('Yes','Specific') NOT NULL default 'Yes',
  `description` varchar(255) NOT NULL default 'Tax',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=36 ;

-- --------------------------------------------------------

-- 
-- Table structure for table `user`
-- 

CREATE TABLE `user` (
  `username` varchar(10) NOT NULL default '',
  `accountid` int(10) unsigned default NULL,
  `password` varchar(32) NOT NULL default '',
  `type` enum('Account Manager','Administrator','Client') NOT NULL default 'Client',
  `firstname` varchar(30) default NULL,
  `lastname` varchar(30) default NULL,
  `email` varchar(30) default NULL,
  `language` varchar(255) default NULL,
  PRIMARY KEY  (`username`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

INSERT INTO `settings` VALUES ('welcome_subject', 'Welcome to Web Hosting Company!');
INSERT INTO `settings` VALUES ('welcome_email', 'This is the welcome email that can be sent to your new \r\ncustomers.');
INSERT INTO `settings` VALUES ('invoice_text', 'Invoice #{invoice_id}\r\n\r\n===================================================================\r\nItem                                    Price     Qty  Total\r\n===================================================================\r\n{invoice_items}===================================================================\r\n\r\nSub-Total: {invoice_subtotal}\r\nTaxes: {invoice_taxtotal}\r\nInvoice Total: {invoice_total}\r\nPayments Received: {invoice_payments}\r\nBalance: {invoice_balance}\r\nDate Due: {invoice_due}\r\n\r\nIf you have any questions about this Invoice, please contact\r\nbilling@example.com.  Thank you!\r\n\r\nWeb Hosting Company\r\n');
INSERT INTO `settings` VALUES ('payment_gateway_default_module', '');
INSERT INTO `settings` VALUES ('payment_gateway_order_method', 'Authorize Only');
INSERT INTO `settings` VALUES ('order_confirmation_email', '{contact_name},\r\n\r\nThank you for choosing SolidState!\r\n\r\nYour order has been received and we will contact you after one of our account representatives has reviewed it.\r\n\r\nOrder ID: {order_id}\r\nReceived from: {order_ip}');
INSERT INTO `settings` VALUES ('order_confirmation_subject', 'Thank you for your order!');
INSERT INTO `settings` VALUES ('order_notification_subject', 'SolidState Order Received');
INSERT INTO `settings` VALUES ('order_notification_email', 'A new order from {contact_name} has been received.\r\n\r\nRemote IP: ({order_ip})\r\nTimestamp: {order_datestamp}');
INSERT INTO `settings` VALUES ('invoice_subject', 'Your {company_name} Invoice for {period_begin_date} - {period_end_date}');