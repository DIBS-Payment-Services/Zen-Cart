<?php
/*
$Id$

DIBS module for ZenCart

DIBS Payment Systems
http://www.dibs.dk

Copyright (c) 2011 DIBS A/S

Released under the GNU General Public License
 
*/

define('MODULE_PAYMENT_DIBSFLEX_TEXT_TITLE_MODULES',      'DIBS FlexWin');
define('MODULE_PAYMENT_DIBSFLEX_TEXT_PUBLIC TITLE',       'DIBS FlexWin');
define('MODULE_PAYMENT_DIBSFLEX_TEXT_ADMIN_TITLE',        'DIBS FlexWin');
define('MODULE_PAYMENT_DIBSFLEX_TEXT_DESCRIPTION',        'DIBS FlexWin | Secure Payment Services<br /><p>Detailed description of configuration parameters can be found on our <a href="http://tech.dibs.dk" target="_blank">Tech site</a>.</p>');
define('MODULE_PAYMENT_DIBSFLEX_TEXT_PUBLIC_DESCRIPTION', 'Secure payment.');
define('MODULE_PAYMENT_DIBSFLEX_ERROR_MID',               'Please specify DIBS Merchant Id in module configuration.');
define('MODULE_PAYMENT_DIBSFLEX_TEXT_EMAIL_FOOTER',       'DIBS Transaction Reference: ');
define('MODULE_PAYMENT_DIBSFLEX_SETUP_ERROR_TITLE',       'Setup Error');
define('MODULE_PAYMENT_DIBSFLEX_ERROR_TITLE',             'Payment Cancelled');
define('MODULE_PAYMENT_DIBSFLEX_ERROR_DEFAULT',           'Your payment did not complete successfully. 
                                                           Please try again, or chose another payment option. 
                                                           If any problem persists, please contact the store owner.');
define('MODULE_PAYMENT_DIBSFLEX_TEXT_PROCESSING_PAYMENT', 'Processing your payment...');
define('MODULE_PAYMENT_DIBSFLEX_HEADING_TITLE',           'Online payment');
define('MODULE_PAYMENT_DIBSFLEX_STATUS_PAYMENT',          'Transaction');
define('TITLE_CONTINUE_CHECKOUT_PROCEDURE',               'Process online payment transaction');
define('TEXT_CONTINUE_CHECKOUT_PROCEDURE',                'and finish the order process');
define('NAVBAR_TITLE_1',                                  'Checkout');
define('NAVBAR_TITLE_2',                                  'Transaction');
define('CHECKOUT_BAR_ONLINE_PAYMENT',                     'Transaction');
define('MODULE_PAYMENT_DIBSFLEX_MSG_TOSHOP',              'Return to shop');
define('MODULE_PAYMENT_DIBSFLEX_MSG_TODIBS',              'Securely proceed with DIBS ->');
define('MODULE_PAYMENT_DIBSFLEX_MSG_REDIR_TOSHOP',        'If your browser didn\'t redirect you to shop automatically, please click the button bellow:');
define('MODULE_PAYMENT_DIBSFLEX_MSG_REDIRTITLE_TOSHOP',   'Redirecting to shop...');
define('MODULE_PAYMENT_DIBSFLEX_MSG_REDIR_TODIBS',        'If your browser didn\'t redirect you to DIBS automatically, please click the button bellow:');
define('MODULE_PAYMENT_DIBSFLEX_MSG_REDIRTITLE_TODIBS',   'Redirecting to DIBS...');
define('MODULE_PAYMENT_DIBSFLEX_MSG_ERRCODE',             "Error code:");
define('MODULE_PAYMENT_DIBSFLEX_MSG_ERRMSG',              "Error message:");
define('MODULE_PAYMENT_DIBSFLEX_ERR_0',                   "Error has occurred during payment verification");
define('MODULE_PAYMENT_DIBSFLEX_ERR_2',                   "Unknown orderid was returned from DIBS payment gateway.");
define('MODULE_PAYMENT_DIBSFLEX_ERR_1',                   "No orderid was returned from DIBS payment gateway.");
define('MODULE_PAYMENT_DIBSFLEX_ERR_4',                   "The amount received from DIBS payment gateway 
                                                          differs from original order amount.");
define('MODULE_PAYMENT_DIBSFLEX_ERR_3',                   "No amount was returned from DIBS payment gateway.");
define('MODULE_PAYMENT_DIBSFLEX_ERR_6',             "The currency type received from DIBS payment gateway 
                                                     differs from original order currency type.");
define('MODULE_PAYMENT_DIBSFLEX_ERR_5',             "No currency type was returned from DIBS payment 
                                                      gateway.");
define('MODULE_PAYMENT_DIBSFLEX_ERR_7',             "The fingerprint key does not match.");
define('MODULE_PAYMENT_DIBSFLEX_ERR_8',             "No curl or socket connection available with your PHP configuration.");
define('MODULE_PAYMENT_DIBSFLEX_ERR_9',             "Empty API credentials.");
define('MODULE_PAYMENT_DIBSFLEX_ERR_10',             "Transaction ID is empty.");
define('MODULE_PAYMENT_DIBSFLEX_ERR_11',             "Incorrect API credentials. Please, add correct and try again in 30 minutes.");
define('MODULE_PAYMENT_DIBSFLEX_ERR_12',             "Error during CGI API request. Can't receive order status.");
define('MODULE_PAYMENT_DIBSFLEX_MSG_BUTTON_CAPTURE',          'Capture');
define('MODULE_PAYMENT_DIBSFLEX_MSG_BUTTON_CANCEL',          'Cancel');
define('MODULE_PAYMENT_DIBSFLEX_MSG_BUTTON_REFUND',          'Refund');
define('MODULE_PAYMENT_DIBSFLEX_LBL_CGISTATUS',               'Status:');
define('MODULE_PAYMENT_DIBSFLEX_LBL_CGIACTIONS',               'Actions:');
define('MODULE_PAYMENT_DIBSFLEX_STS_0', 'Transaction inserted (not approved)');
define('MODULE_PAYMENT_DIBSFLEX_STS_1', 'Declined');
define('MODULE_PAYMENT_DIBSFLEX_STS_2', 'Authorization approved');
define('MODULE_PAYMENT_DIBSFLEX_STS_3', 'Capture sent to acquirer');
define('MODULE_PAYMENT_DIBSFLEX_STS_4', 'Capture declined by acquirer');
define('MODULE_PAYMENT_DIBSFLEX_STS_5', 'Capture completed');
define('MODULE_PAYMENT_DIBSFLEX_STS_6', 'Canceled');
define('MODULE_PAYMENT_DIBSFLEX_STS_9', 'Refund shipped');
define('MODULE_PAYMENT_DIBSFLEX_STS_10', 'Refund rejected');
define('MODULE_PAYMENT_DIBSFLEX_STS_11', 'Refund approved');

define('MODULE_PAYMENT_DIBSFLEX_CONTROLS_TITLE',          'DIBS Controls:');
?>