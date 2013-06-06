<?php
/*
  $Id$

  DIBS module for ZenCart

  DIBS Payment Systems
  http://www.dibs.dk

  Copyright (c) 2011 DIBS A/S

  Released under the GNU General Public License
 
*/

  define('MODULE_PAYMENT_DIBSPW_TEXT_TITLE_MODULES',      'DIBS Betalingsvindu');
  define('MODULE_PAYMENT_DIBSPW_TEXT_PUBLIC TITLE',       'Kredittkort (DIBS)');
  define('MODULE_PAYMENT_DIBSPW_TEXT_ADMIN_TITLE',        'DIBS Betalingsvindu.');
  define('MODULE_PAYMENT_DIBSPW_TEXT_DESCRIPTION',        'DIBS Internet - Sikker betaling gjennom DIBS Payment Services');
  define('MODULE_PAYMENT_DIBSPW_TEXT_PUBLIC_DESCRIPTION', 'Sikker betaling via DIBS Internet');
  define('MODULE_PAYMENT_DIBSPW_ERROR_MID',               'Vennligst angi \'DIBS Merchant Id\' i modulens konfigurasjon.');
  define('MODULE_PAYMENT_DIBSPW_TEXT_EMAIL_FOOTER',       'DIBS transaksjonreferanse: ');
  define('MODULE_PAYMENT_DIBSPW_SETUP_ERROR_TITLE',       'Installasjonsfeil');
  define('MODULE_PAYMENT_DIBSPW_ERROR_TITLE',             'Betaling avbrutt');
  define('MODULE_PAYMENT_DIBSPW_ERROR_DEFAULT',           'Din betaling ble ikke fullført. 
                                                         Vennligst forsøk igjen, eller velg annen betalingsmåte. 
                                                         Kontakt butikkeier om problemer vedvarer.');
  define('MODULE_PAYMENT_DIBSPW_TEXT_PROCESSING_PAYMENT', 'Behandler din betaling ...');
  define('MODULE_PAYMENT_DIBSPW_HEADING_TITLE',           'Nettbetaling');
  define('MODULE_PAYMENT_DIBSPW_STATUS_PAYMENT',          'Transaksjon');
  define('MODULE_PAYMENT_DIBSPW_MSG_TOSHOP',             'Returner til butikken');
  define('MODULE_PAYMENT_DIBSPW_MSG_REDIR',              'If your browser didn\'t redirect you to shop automatically, please click the button bellow:');
  define('MODULE_PAYMENT_DIBSPW_MSG_REDIRTITLE',        'Redirecting to shop...');
  define('MODULE_PAYMENT_DIBSPW_MSG_ERRCODE',             "Error code:");
  define('MODULE_PAYMENT_DIBSPW_MSG_ERRCODE',             "Error message:");
  define('MODULE_PAYMENT_DIBSPW_ERR_0',             "Error has occurred during payment verification");
  define('MODULE_PAYMENT_DIBSPW_TEXT_ERR_2',        "En ukjent ordre-id ble returnert fra DIBS.");
  define('MODULE_PAYMENT_DIBSPW_TEXT_ERR_1',        "Ingen ordre-id ble returnert fra DIBS.");
  define('MODULE_PAYMENT_DIBSPW_TEXT_ERR_4',        "Beløp som ble returnert fra DIBS avviker fra det opprinnelige ordrebeløpet.");
  define('MODULE_PAYMENT_DIBSPW_TEXT_ERR_3',        "Ingen beløp ble returnert fra DIBS.");
  define('MODULE_PAYMENT_DIBSPW_TEXT_ERR_6',        "Valuta som ble returnert fra DIBS avviker fra opprinnelig valuta for ordre.");
  define('MODULE_PAYMENT_DIBSPW_TEXT_ERR_5',        "Ingen valuta ble returnert fra DIBS.");
  define('MODULE_PAYMENT_DIBSPW_TEXT_ERR_7',        "\'Fingerprint\'-nøkkel stemmer ikke.");
/*  define('TITLE_CONTINUE_CHECKOUT_PROCEDURE',           'Process online payment transaction');
  define('TEXT_CONTINUE_CHECKOUT_PROCEDURE',            'and finish the order process');
  define('NAVBAR_TITLE_1',                              'Checkout');
  define('NAVBAR_TITLE_2',                              'Transaction');
  define('CHECKOUT_BAR_ONLINE_PAYMENT',                 'Transaction');*/
?>