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
require(DIR_WS_LANGUAGES . $lng->language['directory'] . '/modules/payment/dibsflex.php');
require(DIR_WS_MODULES . 'payment/dibsflex.php');


$oDIBSflex = new dibsflex();
$iCode = $oDIBSflex->success();
echo !empty($iCode) ? $oDIBSflex->api_dibs_getFatalErrorPage($iCode) :
     $oDIBSflex->cms_dibs_genRedirectPage(zen_href_link(FILENAME_CHECKOUT_PROCESS,'','SSL'), 'toshop');
?>