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
$iCode = $oDIBSpw->success();
if(!empty($iCode)) echo $oDIBSpw->api_dibs_getFatalErrorPage($iCode);
else {
    $sForm = "";
    foreach($_POST as $sKey => $sVal) {
        $sForm .= "<input type=\"hidden\" name=\"" . $sKey . "\" value=\"" . 
                  htmlspecialchars($sVal, ENT_COMPAT, "UTF-8") . "\" />\r\n";
    }

    $aParams = array('redirtitle_msg' => 'redirtitle',
                     'redir_msg'      => 'redir', 
                     'redir_link'     => zen_href_link(FILENAME_CHECKOUT_PROCESS,'','SSL'),
                     'form_content'   => $sForm,
                     'toshop_msg'     => 'toshop');
    echo $oDIBSpw->api_dibs_renderTemplate('dibs_pw_redir', $aParams);
}
?>