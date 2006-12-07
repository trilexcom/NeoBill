#!/bin/bash
mysqldump --compact --no-data --quote-names --quick --force solid_solidstate -u solid -p > solid-state.mysql.sql
echo "INSERT INTO \`settings\` VALUES ('welcome_subject', 'Welcome to Web Hosting Company!');" >> solid-state.mysql.sql
echo "INSERT INTO \`settings\` VALUES ('welcome_email', 'This is the welcome email that can be sent to your new \r\ncustomers.');" >> solid-state.mysql.sql
echo "INSERT INTO \`settings\` VALUES ('invoice_text', 'Invoice #{invoice_id}\r\n\r\n===================================================================\r\nItem                                    Price     Qty  Total\r\n===================================================================\r\n{invoice_items}===================================================================\r\n\r\nSub-Total: {invoice_subtotal}\r\nTaxes: {invoice_taxtotal}\r\nInvoice Total: {invoice_total}\r\nPayments Received: {invoice_payments}\r\nBalance: {invoice_balance}\r\nDate Due: {invoice_due}\r\n\r\nIf you have any questions about this Invoice, please contact\r\nbilling@example.com.  Thank you!\r\n\r\nWeb Hosting Company\r\n');" >> solid-state.mysql.sql
echo "INSERT INTO \`settings\` VALUES ('payment_gateway_default_module', '');" >> solid-state.mysql.sql
echo "INSERT INTO \`settings\` VALUES ('payment_gateway_order_method', 'Authorize Only');" >> solid-state.mysql.sql
echo "INSERT INTO \`settings\` VALUES ('order_confirmation_email', '{contact_name},\r\n\r\nThank you for choosing SolidState!\r\n\r\nYour order has been received and we will contact you after one of our account representatives has reviewed it.\r\n\r\nOrder ID: {order_id}\r\nReceived from: {order_ip}');" >> solid-state.mysql.sql
echo "INSERT INTO \`settings\` VALUES ('order_confirmation_subject', 'Thank you for your order!');" >> solid-state.mysql.sql
echo "INSERT INTO \`settings\` VALUES ('order_notification_subject', 'SolidState Order Received');" >> solid-state.mysql.sql
echo "INSERT INTO \`settings\` VALUES ('order_notification_email', 'A new order from {contact_name} has been received.\r\n\r\nRemote IP: ({order_ip})\r\nTimestamp: {order_datestamp}');" >> solid-state.mysql.sql
echo "INSERT INTO \`settings\` VALUES ('invoice_subject', 'Your {company_name} Invoice for {period_begin_date} - {period_end_date}');" >> solid-state.mysql.sql
echo "INSERT INTO \`settings\` VALUES ('order_accept_checks', '0');" >> solid-state.mysql.sql
