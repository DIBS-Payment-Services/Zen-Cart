<?php
class dibs_pw_helpers extends dibs_pw_helpers_cms implements dibs_pw_helpers_interface {
    
    public static $bTaxAmount = true;
    
    /**
     * Process write SQL query (insert, update, delete) with build-in CMS ADO engine.
     * 
     * @param string $sQuery 
     */
    function helper_dibs_db_write($sQuery) {
        global $db;
        
        return $db->Execute($sQuery);
    }
    
    /**
     * Read single value ($sName) from SQL select result.
     * If result with name $sName not found null returned.
     * 
     * @param string $sQuery
     * @param string $sName
     * @return mixed 
     */
    function helper_dibs_db_read_single($sQuery, $sName) {
        global $db;
        
        $mResult = $db->Execute($sQuery);
        return (isset($mResult->fields[$sName])) ? $mResult->fields[$sName] : null;
    }
    
    /**
     * Return settings with CMS method.
     * 
     * @param string $sVar
     * @param string $sPrefix
     * @return string 
     */
    function helper_dibs_tools_conf($sVar, $sPrefix = 'DIBSPW_') {
        $sName = strtoupper("MODULE_PAYMENT_" . $sPrefix . $sVar);
        return defined($sName) ? constant($sName) : "";
    }
    
    /**
     * Return CMS DB table prefix.
     * 
     * @return string 
     */
    function helper_dibs_tools_prefix() {
        return defined("DB_PREFIX") ? DB_PREFIX : '';
    }
    
    /**
     * Returns text by key using CMS engine.
     * 
     * @param type $sKey
     * @return type 
     */
    function helper_dibs_tools_lang($sKey, $sType = "msg") {
        $sName = strtoupper("MODULE_PAYMENT_DIBSPW_" . $sType . "_" . $sKey);
        return defined($sName) ? constant($sName) : "";
    }

    /**
     * Get full CMS url for page.
     * 
     * @param string $sLink
     * @return string 
     */
    function helper_dibs_tools_url($sLink) {
        return ((defined('ENABLE_SSL') && ENABLE_SSL == 'true') ? 
               HTTPS_SERVER . DIR_WS_HTTPS_CATALOG : HTTP_SERVER . DIR_WS_CATALOG) . $sLink;
    }
    
    /**
     * Build CMS order information to API object.
     * 
     * @param mixed $mOrderInfo
     * @param bool $bResponse
     * @return object 
     */
    function helper_dibs_obj_order($mOrderInfo, $bResponse = FALSE) {
        global $currencies;
        
        $iDec = $currencies->get_decimal_places($mOrderInfo->info['currency']);
        if($bResponse === TRUE) {
            return $this->cms_dibs_get_orderData((string)$_POST['orderid']);
        }
        else {
            $sTotal = (isset($mOrderInfo->info['currency_value'])) ? 
                       ($mOrderInfo->info['total'] * $mOrderInfo->info['currency_value']) :
                       $mOrderInfo->info['total'];
            
            return (object)array(
                'orderid'  => $_SESSION['cartID'] . $_SESSION['customer_id'] . 
                              date("dmyHi"),
                'amount'   => zen_round($sTotal, $iDec),
                'currency' => dibs_pw_api::api_dibs_get_currencyValue($mOrderInfo->info['currency'])
            );
        }
    }
    
    /**
     * Returns object with URLs needed for API, 
     * e.g.: callbackurl, acceptreturnurl, etc.
     * 
     * @param mixed $mOrderInfo
     * @return object 
     */
    function helper_dibs_obj_urls($mOrderInfo = null) {
        return (object)array(
            'acceptreturnurl' => "ext/modules/payment/dibspw/success.php",
            'callbackurl'     => "ext/modules/payment/dibspw/callback.php",
            'cancelreturnurl' => "ext/modules/payment/dibspw/cancel.php",
            'carturl'         => FILENAME_SHOPPING_CART
        );
    }
    
    /**
     * Returns object with additional information to send with payment.
     * 
     * @param mixed $mOrderInfo
     * @return object 
     */
    function helper_dibs_obj_etc($mOrderInfo) {
        return (object)array(
            'sysmod'      => 'znc1_4_1_0',
            'callbackfix' => $this->helper_dibs_tools_url("ext/modules/payment/dibspw/callback.php")
        );
    }
}
?>