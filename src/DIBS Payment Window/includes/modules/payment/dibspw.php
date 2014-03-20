<?php
/*
  
  $Id$

  DIBS module for ZenCart

  DIBS Payment Services
  http://www.dibspayment.com

  Copyright (c) 2011 DIBS A/S

  Released under the GNU General Public License
 
*/

require_once dirname(__FILE__) . '/dibs_api/pw/dibs_pw_api.php';

class dibspw extends dibs_pw_api {
    
    /** START OF ZenCart SPECIFIC METHODS **/
    
    var $code, $title, $description, $enabled;
    /**
     * constructor
     * 
     * @global array $order 
     */
    function dibspw() {
        global $order;

        $this->signature = 'dibspw|dibspw|4.1.0|1.5.0';

        $this->code = 'dibspw';
        $this->title = MODULE_PAYMENT_DIBSPW_TEXT_TITLE_MODULES;
        $this->public_title = MODULE_PAYMENT_DIBSPW_TEXT_TITLE;
        $this->description = MODULE_PAYMENT_DIBSPW_TEXT_DESCRIPTION;
        $this->sort_order = MODULE_PAYMENT_DIBSPW_SORT_ORDER;
        $this->enabled = ((MODULE_PAYMENT_DIBSPW_STATUS == 'True') ? true : false);

        if ((int)MODULE_PAYMENT_DIBSPW_ORDER_STATUS_ID > 0) {
            $this->order_status = MODULE_PAYMENT_DIBSPW_ORDER_STATUS_ID;
        }

        if (is_object($order)) $this->update_status();

        $this->form_action_url = $this->helper_dibs_tools_url("ext/modules/payment/dibspw/redirect.php");
    }
    
    /**
     * form handler
     * 
     * @global type $HTTP_POST_VARS
     * @global array $order
     * @global type $currencies
     * @global type $currency
     * @global type $languages_id
     * @global type $shipping
     * @return string 
     */
    function process_button() {
        global $HTTP_POST_VARS, $order, $currencies, $currency,  $languages_id, $shipping;
        
        /** DIBS integration */
        $aData = $this->api_dibs_get_requestFields($order);
        /* DIBS integration **/
        
        $this->cms_dibs_processHelperTable($this->helper_dibs_obj_order($order));
        
        $sButtonString = "";
        foreach($aData as $sName => $sVal) $sButtonString .= zen_draw_hidden_field($sName, $sVal);
        
        return $sButtonString;
    }
    
    function after_process() {
	global $_POST, $db, $insert_id, $order;
        $this->cms_dibs_completeCart($insert_id, $_POST['orderid']);
        return false;
    }

    /**
     * Succes page handler
     */
    function success() {
        global $order; 
        return (isset($_POST['orderid'])) ? $this->api_dibs_action_success(null) :
               $this->helper_dibs_tools_lang(1, 'err');
    }
    
    /**
     * Callback handler
     */
    function callback(){
        if (isset($_POST['orderid'])) $this->api_dibs_action_callback(null);
        else exit("1");
    }
    
    /**
     * Cancel page handler
     */
    function cancel() {
        $this->api_dibs_action_cancel();
        zen_redirect(zen_href_link(FILENAME_SHOPPING_CART,'','NONSSL'));
    }
    
    function check() {
        global $db;
        
	if(!isset($this->_check )) {
            $sCheck_query = $db->Execute("SELECT configuration_value FROM " . TABLE_CONFIGURATION .
                                         " WHERE configuration_key = 'MODULE_PAYMENT_DIBSPW_STATUS'");
            $this->_check = $sCheck_query->RecordCount();
	}
        return $this->_check;
    }
    
    function update_status() {
	global $order, $db;
		
	if (($this->enabled == true) && ((int)MODULE_PAYMENT_DIBSPW_ZONE > 0)) {
            $check_flag = false;
            $check = $db->Execute("SELECT `zone_id` FROM " . TABLE_ZONES_TO_GEO_ZONES . 
                                  " WHERE `geo_zone_id` = '" . MODULE_PAYMENT_DIBSPW_ZONE . 
                                  "' AND `zone_country_id` = '" . $order->billing['country']['id'] . 
                                  "' ORDER BY `zone_id`");
		
            while (!$check->EOF) {
                if ($check->fields['zone_id'] < 1) {
                    $check_flag = true;
                    break;
		}
                elseif ($check->fields['zone_id'] == $order->billing['zone_id']) {
                    $check_flag = true;
                    break;
		}
                $check->MoveNext();
            }
			
            if ($check_flag == false) $this->enabled = false;
        }
    }
    
    function before_process() {
        return false;
    }
    
    function output_error() {
        return false;
    }
    
    function get_error() {
        return array('title' => '', 'error' => MODULE_PAYMENT_DIBSPW_ERR_MID);
    }
    
    function selection() {
        return array('id' => $this->code, 'module' => $this->cms_dibs_get_title());
    }
    
    function pre_confirmation_check() {
        if (MODULE_PAYMENT_DIBSPW_MID == "") {
            zen_redirect($this->helper_dibs_tools_url(FILENAME_CHECKOUT_PAYMENT, 
                                        'payment_error=dibspw&error=dibspw_empty_mid', 'SSL', true));
	}
        else return true;
    }
        
    function confirmation() {
        return array ('title' => $this->cms_dibs_get_title());
    }
    
    function javascript_validation() {
        return false;
    }
    
    function installApply($aConfigs) {
        foreach($aConfigs as $aConfig){
            $this->helper_dibs_db_write("INSERT INTO " . 
                                        TABLE_CONFIGURATION . "(
                                            configuration_title, 
                                            configuration_key, 
                                            configuration_value, 
                                            configuration_description, 
                                            configuration_group_id, 
                                            sort_order, 
                                            set_function,
                                            use_function,
                                            date_added
                                        ) 
                                        VALUES(
                                            '" . $aConfig['title'] ."',
                                            '" . $aConfig['cfkey'] . "',
                                            '" . $aConfig['value'] . "', 
                                            '" . $aConfig['descr'] . "', 
                                            '6', 
                                            '" . $aConfig['order'] . "', 
                                            " .  $aConfig['sfunc'] . ",
                                            NULL,
                                            NOW()
                                        )"
            );
        }
    }
    
    /**
     * ZenCart module uninstaller
     */
    function remove() {
        $this->helper_dibs_db_write("DELETE FROM " . TABLE_CONFIGURATION . 
                                    " WHERE configuration_key in ('" . 
                                    implode("', '", $this->keys()) . "')");
    }
   
    /**
     * ZenCart module installer
     */
    function install() {
        $this->installApply(array(
                                array('title' => 'Enable DIBS module:', 
                                      'cfkey' => 'MODULE_PAYMENT_DIBSPW_STATUS', 
                                      'value' => 'False', 
                                      'descr' => 'Turn on DIBS module', 
                                      'order' => 1, 
                                      'sfunc' => "'zen_cfg_select_option(array(\'True\', \'False\'),'"),
                                array('title' => 'Title:', 
                                      'cfkey' => 'MODULE_PAYMENT_DIBSPW_TEXT_TITLE',
                                      'value' => 'DIBS | Secure Payment Services', 
                                      'descr' => 'Title of payment module that customer see on checkout.', 
                                      'order' => 2, 
                                      'sfunc' => 'NULL'),
                               array('title' => 'Merchant ID:', 
                                      'cfkey' => 'MODULE_PAYMENT_DIBSPW_MID', 
                                      'value' => '', 
                                      'descr' => 'Your merchant ID in DIBS service.', 
                                      'order' => 3, 
                                      'sfunc' => 'NULL'),        
        		      array('title' => 'Partner ID:', 
                                      'cfkey' => 'MODULE_PAYMENT_DIBSPW_PID', 
                                      'value' => '', 
                                      'descr' => 'Partner ID', 
                                      'order' => 3, 
                                      'sfunc' => 'NULL'),        
                              array('title' => 'HMAC:', 
                                      'cfkey' => 'MODULE_PAYMENT_DIBSPW_HMAC', 
                                      'value' => '', 
                                      'descr' => 'HMAC code for secured transactions.', 
                                      'order' => 5, 
                                      'sfunc' => "NULL"),
                                array('title' => 'Test mode:', 
                                      'cfkey' => 'MODULE_PAYMENT_DIBSPW_TESTMODE', 
                                      'value' => 'yes', 
                                      'descr' => 'Use in test mode.', 
                                      'order' => 6, 
                                      'sfunc' => "'zen_cfg_select_option(array(\'yes\', \'no\'),'"),
                                array('title' => 'Add fee:', 
                                      'cfkey' => 'MODULE_PAYMENT_DIBSPW_FEE', 
                                      'value' => 'no', 
                                      'descr' => 'Customer pays fee.', 
                                      'order' => 7, 
                                      'sfunc' => "'zen_cfg_select_option(array(\'yes\', \'no\'),'"),
                                array('title' => 'Capture now:', 
                                      'cfkey' => 'MODULE_PAYMENT_DIBSPW_CAPTURENOW', 
                                      'value' => 'no', 
                                      'descr' => 'If this field exists, an "instant capture" is carried out, 
                                                  i.e. the amount is immediately transferred from the customer’s 
                                                  account to the shop’s account (DIBS PW only).', 
                                      'order' => 8, 
                                      'sfunc' => "'zen_cfg_select_option(array(\'yes\', \'no\'),'"),
                                array('title' => 'Unique order ID:', 
                                      'cfkey' => 'MODULE_PAYMENT_DIBSPW_UNIQ', 
                                      'value' => 'no', 
                                      'descr' => 'Only unique order IDs (Mobile PW only).', 
                                      'order' => 10, 
                                      'sfunc' => "'zen_cfg_select_option(array(\'yes\', \'no\'),'"),
                                array('title' => 'Paytype:', 
                                      'cfkey' => 'MODULE_PAYMENT_DIBSPW_PAYTYPE', 
                                      'value' => '', 
                                      'descr' => 'This list must be comma separated with 
                                                  no spaces in between. E.g. VISA,MC', 
                                      'order' => 11, 
                                      'sfunc' => "NULL"),
                                array('title' => 'Language:', 
                                      'cfkey' => 'MODULE_PAYMENT_DIBSPW_LANG', 
                                      'value' => 'en_UK', 
                                      'descr' => 'Language used during checkout.', 
                                      'order' => 12, 
                                      'sfunc' => "'dibspw::cms_dibs_get_selectLang('"),
                                array('title' => 'Account:', 
                                      'cfkey' => 'MODULE_PAYMENT_DIBSPW_ACCOUNT', 
                                      'value' => '', 
                                      'descr' => 'An "account number" may be inserted in this field, 
                                                  so as to separate transactions at DIBS.', 
                                      'order' => 13, 
                                      'sfunc' => "NULL"),
                                array('title' => 'Distribution method:', 
                                      'cfkey' => 'MODULE_PAYMENT_DIBSPW_DISTR', 
                                      'value' => '1', 
                                      'descr' => 'Invoice distribution (DIBS PW only.).', 
                                      'order' => 14, 
                                      'sfunc' => "'dibspw::cms_dibs_get_selectDistr('"),
                                array('title' => 'Set order status', 
                                      'cfkey' => 'MODULE_PAYMENT_DIBSPW_ORDER_STATUS_ID',
                                      'value' => '2', 
                                      'descr' => 'Set the status of orders made with this payment module to this value', 
                                      'order' => 15, 
                                      'sfunc' => "'zen_cfg_pull_down_order_statuses('", "'zen_get_order_status_name'"),
                                array('title' => 'Payment zone:', 
                                      'cfkey' => 'MODULE_PAYMENT_DIBSPW_ZONE', 
                                      'value' => '0', 
                                      'descr' => 'If a zone is selected, only enable this payment method for that zone.', 
                                      'order' => 16, 
                                      'sfunc' => "'zen_cfg_pull_down_zone_classes('", "'zen_get_zone_class_title'"),
                                array('title' => 'Sort order:', 
                                      'cfkey' => 'MODULE_PAYMENT_DIBSPW_SORT_ORDER',
                                      'value' => '0', 
                                      'descr' => 'Sort order in list of availiable payment methods.', 
                                      'order' => 17, 
                                      'sfunc' => "NULL")
            )
        );
    }

    /**
     * config keys helper
     * 
     * @return array 
     */
    function keys() {
        return array('MODULE_PAYMENT_DIBSPW_STATUS', 
                     'MODULE_PAYMENT_DIBSPW_TEXT_TITLE', 'MODULE_PAYMENT_DIBSPW_MID',
                     'MODULE_PAYMENT_DIBSPW_HMAC', 'MODULE_PAYMENT_DIBSPW_MID',
                     'MODULE_PAYMENT_DIBSPW_TESTMODE','MODULE_PAYMENT_DIBSPW_FEE',
                     'MODULE_PAYMENT_DIBSPW_CAPTURENOW', 
                     'MODULE_PAYMENT_DIBSPW_UNIQ', 'MODULE_PAYMENT_DIBSPW_PAYTYPE',
                     'MODULE_PAYMENT_DIBSPW_LANG', 'MODULE_PAYMENT_DIBSPW_ACCOUNT',
                     'MODULE_PAYMENT_DIBSPW_DISTR','MODULE_PAYMENT_DIBSPW_ORDER_STATUS_ID', 
                     'MODULE_PAYMENT_DIBSPW_ZONE', 'MODULE_PAYMENT_DIBSPW_SORT_ORDER',
                     'MODULE_PAYMENT_DIBSPW_PID'
        );
    }
}
?>