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
unset($_POST['x'],$_POST['y'],$_POST['gv_redeem_code'],$_POST['securityToken']);
        
$sOutput = '';
foreach($_POST as $key=>$val) {
    
    $val = htmlentities($val, ENT_QUOTES, 'UTF-8'); 
    $sOutput .= '<input type="hidden" name="' . $key . '" value="' . $val . '" />'."\r\n";
}

$sPage = '<form id="payment" action="' . $oDIBSpw->api_dibs_get_formAction() . '" method="POST">
             '.$sOutput.'
          </form>
          <script type="text/javascript">
              setTimeout("document.getElementById(\'payment\').submit();",0);
          </script>';

echo $sPage;
  
?>