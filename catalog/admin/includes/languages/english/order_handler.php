<?php
/*
  Advanced Order Handler 2.3.3 Rev2
  Created by Dr. Rolex - 2014-04-30
  Updated by Dr. Rolex - 2014-05-06
  Added Top Navbar With Select2 Ajax Search - 2014-05-11
*/

@define('HEADING_TITLE', 'Order Handler');
@define('HEADING_TITLE_SEARCH', 'Order #:');
@define('HEADING_TITLE_SEARCH_ORDERS', 'Email Address, etc:');
@define('HEADING_TITLE_STATUS', 'Status:');

@define('TABLE_HEADING_COMMENTS', 'Comments');
@define('TABLE_HEADING_CUSTOMERS', 'Customers');
@define('TABLE_HEADING_ORDER_NUMBER', 'Order #');
@define('TABLE_HEADING_ORDER_TOTAL', 'Order Total');
@define('TABLE_HEADING_DATE_PURCHASED', 'Date Purchased');
@define('TABLE_HEADING_STATUS', 'Status');
@define('TABLE_HEADING_ACTION', 'Action');
@define('TABLE_HEADING_QUANTITY', 'Quantity');
@define('TABLE_HEADING_PRODUCTS_MODEL', 'Model');
@define('TABLE_HEADING_PRODUCTS', 'Products &nbsp; <a id="addProduct" href="#">Add Product</a>');
@define('TABLE_HEADING_PRODUCT', 'Products');
@define('TABLE_HEADING_TAX', 'VAT');
@define('TABLE_HEADING_TOTAL', 'Total');
@define('TABLE_HEADING_PRICE_EXCLUDING_TAX', 'Price (excl. VAT)');
@define('TABLE_HEADING_PRICE_INCLUDING_TAX', 'Price (incl. VAT)');
@define('TABLE_HEADING_TOTAL_EXCLUDING_TAX', 'Total (excl. VAT)');
@define('TABLE_HEADING_TOTAL_INCLUDING_TAX', 'Total (incl. VAT)');

@define('TABLE_HEADING_CUSTOMER_NOTIFIED', 'Customer notified');
@define('TABLE_HEADING_DATE_ADDED', 'Date added');

@define('TOOLTIP_DELETE_ORDERS', 'Delete Orders');
@define('TOOLTIP_DISABLE_POLLING', 'Disable AJAX Long-Polling');
@define('TOOLTIP_DO_NOT', 'Do not ');
@define('TOOLTIP_EDIT_ORDERS', 'Edit Orders');
@define('TOOLTIP_UPDATE_STATUS', 'Update Orders Status');
@define('TOOLTIP_DUPLICATE_ORDER', 'Duplicate Order');
@define('TOOLTIP_ENABLE_POLLING', 'Enable AJAX Long-Polling');
@define('TOOLTIP_EXPAND_ORDER', 'Expand Order');
@define('TOOLTIP_MAIL_CONFIRMATION', 'E-Mail Order Confirmation');
@define('TOOLTIP_TIMEOUT', 'Time in Seconds to next New Order Poll');

@define('ENTRY_ADD_FIELD', 'Add a field');
@define('ENTRY_CUSTOMER', 'Customer:');
@define('ENTRY_SOLD_TO', 'SOLD TO:');
@define('ENTRY_DELIVERY_TO', 'DELIVER TO:');
@define('ENTRY_SHIP_TO', 'SHIP TO:');
@define('ENTRY_SHIPPING_ADDRESS', 'Delivery address:');
@define('ENTRY_BILLING_ADDRESS', 'Billing address:');
@define('ENTRY_PAYMENT_METHOD', 'Payment method:');
@define('ENTRY_CREDIT_CARD_TYPE', 'Credit Card Type:');
@define('ENTRY_CREDIT_CARD_OWNER', 'Credit Card Owner:');
@define('ENTRY_CREDIT_CARD_NUMBER', 'Credit Card Number:');
@define('ENTRY_CREDIT_CARD_EXPIRES', 'Credit Card Expires:');
@define('ENTRY_ENVELOPE', 'Envelope');
@define('ENTRY_INVOICE', 'Invoice');
@define('ENTRY_IPADDRESS', 'IP-Address:');
@define('ENTRY_IPISP', 'ISP:');
@define('ENTRY_ORDER_NUMBER', 'Order Number');
@define('ENTRY_SUB_TOTAL', 'Sub-Total:');
@define('ENTRY_TAX', 'VAT:');
@define('ENTRY_SHIPPING', 'Shipping:');
@define('ENTRY_TOTAL', 'Total:');
@define('ENTRY_DATE_PURCHASED', 'Date Purchased:');
@define('ENTRY_STATUS', 'Status:');
@define('ENTRY_DATE_LAST_UPDATED', 'Last Updated:');
@define('ENTRY_NOTIFY_CUSTOMER', 'Notify Customer: ');
@define('ENTRY_NOTIFY_COMMENTS', 'Append Comments:');
@define('ENTRY_PRINTABLE', 'Print Invoice');
@define('ENTRY_PRINT_DATE', 'Print Date:');
@define('ENTRY_EXPORT', ' Export');
@define('ENTRY_UPDATE_STATUS', 'Update status');
@define('ENTRY_SELECTED', 'Invoice:');
@define('ENTRY_LABELS', '  Labels:');
@define('ENTRY_NOTIFY', 'Notify Customer: Yes');
@define('ENTRY_NOTIFY_NO', 'No');
@define('ENTRY_NOTIFY_YES', 'Yes');

@define('TEXT_INFO_HEADING_DELETE_ORDER', 'Delete Order');
@define('TEXT_INFO_DELETE_INTRO', 'Do you really want delete this order?');
@define('TEXT_INFO_ORDER_DELETED', 'Thank you, the orders have been deleted, you can close this window.');

@define('TEXT_INFO_RESTOCK_PRODUCT_QUANTITY', 'Restock Products');
@define('TEXT_INFO_ORDER_BY_PRODUCTS_QUANTITY', 'Sort by Products Quantity');
@define('TEXT_DATE_ORDER_CREATED', 'Date Created:');
@define('TEXT_DATE_ORDER_LAST_MODIFIED', 'Last modified:');
@define('TEXT_INFO_PAYMENT_METHOD', 'Payment method:');

@define('TEXT_ALL_ORDERS', 'All Orders');
@define('TEXT_NO_ORDER_HISTORY', 'No Order History Available');

@define('TOOLTIP_ADMIN_MENU', 'Close Admin Menu');
@define('TOOLTIP_SORT_STATUS', 'Sort Orders by Status');

@define('EMAIL_SEPARATOR', '------------------------------------------------------');
@define('EMAIL_TEXT_BILLING_ADDRESS', 'Billing Address');
@define('EMAIL_TEXT_DELIVERY_ADDRESS', 'Delivery Address');
@define('EMAIL_TEXT_SUBJECT', 'Order Status');
@define('EMAIL_TEXT_ORDER_NUMBER', 'Order Number:');
@define('EMAIL_TEXT_INVOICE_URL', 'Detailed Invoice:');
@define('EMAIL_TEXT_PAYMENT_METHOD', 'Payment Method');
@define('EMAIL_TEXT_PRODUCTS', 'Products');
@define('EMAIL_TEXT_DATE_ORDERED', 'Date Ordered:');
@define('EMAIL_TEXT_STATUS_UPDATE', 'Your order has been updated to the following status.' . "\n\n" . 'New status: %s' . "\n\n" . 'Please reply to this email if you have any questions.' . "\n\n" . '------------------------------------------------------<br/>');
@define('EMAIL_TEXT_COMMENTS_UPDATE', 'Comments for your order:' . "\n\n%s\n\n");

@define('ERROR_ORDER_DOES_NOT_EXIST', 'Order does not exist.');
@define('ERROR_NO_ORDERS_SELECTED', 'No orders selected.');
@define('SUCCESS_ORDER_UPDATED', 'Success: Order has been successfully updated.');
@define('WARNING_ORDER_NOT_UPDATED', 'Warning: Nothing to change. The order was not updated.');
//begin PayPal_Shopping_Cart_IPN
@define('TABLE_HEADING_PAYMENT_STATUS', 'Status');
//end PayPal_Shopping_Cart_IPN

@define('TEXT_INFO_CUSTOMER_SERVICE_ID','Added by:');
?>
