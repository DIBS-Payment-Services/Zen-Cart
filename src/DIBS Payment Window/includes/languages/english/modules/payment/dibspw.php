<?php
/*
  $Id$

  DIBS module for ZenCart

  DIBS Payment Systems
  http://www.dibs.dk

  Copyright (c) 2011 DIBS A/S

  Released under the GNU General Public License
 
*/

  define('MODULE_PAYMENT_DIBSPW_TEXT_TITLE_MODULES',      'DIBS Payment Window');
  define('MODULE_PAYMENT_DIBSPW_TEXT_PUBLIC TITLE',       'DIBS FlexWin');
  define('MODULE_PAYMENT_DIBSPW_TEXT_ADMIN_TITLE',        'DIBS Payment Window');
  define('MODULE_PAYMENT_DIBSPW_TEXT_DESCRIPTION',        'DIBS | Secure Payment Services');
  define('MODULE_PAYMENT_DIBSPW_TEXT_PUBLIC_DESCRIPTION', 'Secure payment');
  define('MODULE_PAYMENT_DIBSPW_ERROR_MID',               'Please specify DIBS Merchant Id in module configuration.');
  define('MODULE_PAYMENT_DIBSPW_TEXT_EMAIL_FOOTER',       'DIBS Transaction Reference: ');
  define('MODULE_PAYMENT_DIBSPW_SETUP_ERROR_TITLE',       'Setup Error');
  define('MODULE_PAYMENT_DIBSPW_ERROR_TITLE',             'Payment Cancelled');
  define('MODULE_PAYMENT_DIBSPW_ERROR_DEFAULT',           'Your payment did not complete successfully. 
                                                         Please try again, or chose another payment option. 
                                                         If any problem persists, please contact the store owner.');
  define('MODULE_PAYMENT_DIBSPW_TEXT_PROCESSING_PAYMENT', 'Processing your payment...');
  define('MODULE_PAYMENT_DIBSPW_HEADING_TITLE',           'Online payment');
  define('MODULE_PAYMENT_DIBSPW_STATUS_PAYMENT',          'Transaction');
  define('MODULE_PAYMENT_DIBSPW_MSG_TOSHOP',             'Return to shop');
  define('MODULE_PAYMENT_DIBSPW_MSG_REDIR',              'If your browser didn\'t redirect you to shop automatically, please click the button bellow:');
  define('MODULE_PAYMENT_DIBSPW_MSG_REDIRTITLE',        'Redirecting to shop...');
  define('MODULE_PAYMENT_DIBSPW_MSG_ERRCODE',             "Error code:");
  define('MODULE_PAYMENT_DIBSPW_MSG_ERRCODE',             "Error message:");
  define('MODULE_PAYMENT_DIBSPW_ERR_0',             "Error has occurred during payment verification");
  define('MODULE_PAYMENT_DIBSPW_ERR_2',             "Unknown orderid was returned from DIBS payment gateway.");
  define('MODULE_PAYMENT_DIBSPW_ERR_1',             "No orderid was returned from DIBS payment gateway.");
  define('MODULE_PAYMENT_DIBSPW_ERR_4',             "The amount received from DIBS payment gateway 
                                                        differs from original order amount.");
  define('MODULE_PAYMENT_DIBSPW_ERR_3',             "No amount was returned from DIBS payment gateway.");
  define('MODULE_PAYMENT_DIBSPW_ERR_6',             "The currency type received from DIBS payment gateway 
                                                       differs from original order currency type.");
  define('MODULE_PAYMENT_DIBSPW_ERR_5',             "No currency type was returned from DIBS payment 
                                                        gateway.");
  define('MODULE_PAYMENT_DIBSPW_ERR_7',             "The fingerprint key does not match.");

  // Only load overrides at checkout confirmation page when DIBS is selected
  if ($_GET['main_page'] == 'checkout_confirmation') {
    define('TITLE_CONTINUE_CHECKOUT_PROCEDURE',           'Process online payment transaction');
    define('TEXT_CONTINUE_CHECKOUT_PROCEDURE',            'and finish the order process');
    /*define('NAVBAR_TITLE_1',                              'Checkout');
    define('NAVBAR_TITLE_2',                              'Transaction');
    define('CHECKOUT_BAR_ONLINE_PAYMENT',                 'Transaction');*/
  }
