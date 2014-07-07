<?php
/*
  $Id$

  DIBS module for ZenCart

  DIBS Payment Systems
  http://www.dibs.dk

  Copyright (c) 2011 DIBS A/S

  Released under the GNU General Public License
 
*/

  define('MODULE_PAYMENT_DIBSPW_TEXT_TITLE_MODULES', 'DIBS Betalingsvindu');
  define('MODULE_PAYMENT_DIBSPW_TEXT_PUBLIC TITLE', 'Kredittkort (DIBS Betalingsvindu)');
  define('MODULE_PAYMENT_DIBSPW_TEXT_ADMIN_TITLE', 'DIBS Betalingsvindu');
  define('MODULE_PAYMENT_DIBSPW_TEXT_DESCRIPTION', 'DIBS Internet - Sikker betaling gjennom DIBS Payment Services.');
  define('MODULE_PAYMENT_DIBSPW_TEXT_PUBLIC_DESCRIPTION', 'Sikker betaling via DIBS Internet.');
  define('MODULE_PAYMENT_DIBSPW_ERROR_MID', 'Vennligst angi \'DIBS Merchant Id\' i modulens konfigurasjon.');
  define('MODULE_PAYMENT_DIBSPW_TEXT_EMAIL_FOOTER', 'DIBS transaksjonreferanse: ');
  define('MODULE_PAYMENT_DIBSPW_SETUP_ERROR_TITLE', 'Installasjonsfeil');
  define('MODULE_PAYMENT_DIBSPW_ERROR_TITLE', 'Betaling avbrutt');
  define('MODULE_PAYMENT_DIBSPW_ERROR_DEFAULT', 'Din betaling ble ikke fullf&oslash;rt. Vennligst fors&oslash;k igjen, eller velg annen betalingsm&aring;te. Kontakt butikkeier dersom problemet vedvarer.');
  define('MODULE_PAYMENT_DIBSPW_TEXT_PROCESSING_PAYMENT', 'Behandler din betaling ...');
  define('MODULE_PAYMENT_DIBSPW_HEADING_TITLE', 'Nettbetaling');
  define('MODULE_PAYMENT_DIBSPW_STATUS_PAYMENT', 'Transaksjon');
  define('MODULE_PAYMENT_DIBSPW_MSG_TOSHOP', 'Returner til butikken');
  define('MODULE_PAYMENT_DIBSPW_MSG_REDIR', 'Klikk p&aring; knappen nedenfor dersom du ikke ble videresent automatisk til butikken.');
  define('MODULE_PAYMENT_DIBSPW_MSG_REDIRTITLE', 'Videresender til butikk ...');
  define('MODULE_PAYMENT_DIBSPW_MSG_ERRCODE', 'Feilkode:');
  define('MODULE_PAYMENT_DIBSPW_MSG_ERRCODE', 'Feilmelding:');
  define('MODULE_PAYMENT_DIBSPW_ERR_0', 'En feil har oppst&aring;tt under verifisering av betaling.');
  define('MODULE_PAYMENT_DIBSPW_TEXT_ERR_2', 'En ukjent ordre-id ble returnert fra DIBS.');
  define('MODULE_PAYMENT_DIBSPW_TEXT_ERR_1', 'Ingen ordre-id ble returnert fra DIBS.');
  define('MODULE_PAYMENT_DIBSPW_TEXT_ERR_4', 'Bel&oslash;p som ble returnert fra DIBS avviker fra det opprinnelige ordrebel&oslash;pet.');
  define('MODULE_PAYMENT_DIBSPW_TEXT_ERR_3', 'Ingen bel&oslash;p ble returnert fra DIBS.');
  define('MODULE_PAYMENT_DIBSPW_TEXT_ERR_6', 'Valuta som ble returnert fra DIBS avviker fra opprinnelig valuta for ordre.');
  define('MODULE_PAYMENT_DIBSPW_TEXT_ERR_5', 'Ingen valuta ble returnert fra DIBS.');
  define('MODULE_PAYMENT_DIBSPW_TEXT_ERR_7', '\'Fingerprint\'-n&oslash;kkel stemmer ikke.');

  // Only load overrides at checkout confirmation page when DIBS is selected, else it makes no sense.
  if ($_GET['main_page'] == 'checkout_confirmation') {
    define('TITLE_CONTINUE_CHECKOUT_PROCEDURE', 'Bekreft din ordre for &aring; g&aring; videre til betaling');
    define('TEXT_CONTINUE_CHECKOUT_PROCEDURE', '- hvor du fullf&oslash;rer ordreprosessen.');
    /* Why are the following strings overridden? A change in those in the middle of the process is only confusing.
    define('NAVBAR_TITLE_1', 'Kasse');
    define('NAVBAR_TITLE_2', 'Transaksjon');
    define('CHECKOUT_BAR_ONLINE_PAYMENT', 'Transaksjon');*/
  }

