<?php
/*
  $Id$

  DIBS module for ZenCart

  DIBS Payment Systems
  http://www.dibs.dk

  Copyright (c) 2011 DIBS A/S

  Released under the GNU General Public License
 
*/

chdir('../../../../');
require('includes/application_top.php');
$lng = new language();
require(DIR_WS_LANGUAGES . $lng->language['directory'] . '/modules/payment/dibspw.php');
require(DIR_WS_MODULES . 'payment/dibspw.php');

$oDIBSpw = new dibspw();

$oDIBSpw->cancel();
?>