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

unset($_POST['x'],$_POST['y'],$_POST['gv_redeem_code'],$_POST['securityToken']);
       
$oDIBSflex = new dibsflex();
echo $oDIBSflex->cms_dibs_genRedirectPage(dibs_fw_api::api_dibs_get_formAction(), 'todibs');
?>