<?php
class dibs_pw_helpers_cms {
    
    private static $sTableOrderToSession = 'dibs_pw_order2session';
    
    public static function cms_dibs_get_order2sessionTable() {
        return self::$sTableOrderToSession;
    }
    
    protected function cms_dibs_get_title() {
        return '<img src="images/DIBSPW/dibspw.gif" alt="DIBS Payment Services" ' .
               'style="vertical-align: middle; margin-right: 10px;" />' . $this->public_title . 
               (strlen(MODULE_PAYMENT_DIBSPW_TEXT_PUBLIC_DESCRIPTION) > 0 ? ' (' . 
               MODULE_PAYMENT_DIBSPW_TEXT_PUBLIC_DESCRIPTION . ')' : '');
    }
    
    private function cms_dibs_db_read($sQuery) {
        global $db;
        
        return $db->Execute($sQuery);
    }
    
    public function cms_dibs_get_tmpTableFullName() {
        return $this->helper_dibs_tools_prefix() . self::cms_dibs_get_order2sessionTable();
    }
    
    private static function cms_dibs_draw_pullDownMenu($sName, $aMethodArray, $sValue) {
        return zen_draw_pull_down_menu($sName, $aMethodArray, $sValue);
    }
    
    private function cms_dibs_db_perform($sTable, $aData) {
        return zen_db_perform($sTable, $aData);
    }
    
    private function cms_dibs_db_read_fetch($mQuery) {
        while (!$mQuery->EOF) {
            $mResult[] = $mQuery->fields;
            $mQuery->MoveNext();
        }
        return $mResult;
    }
    
    protected function cms_dibs_get_orderData($mPostOrderId) {
        $mOrderData = $this->cms_dibs_db_read("SELECT `session_cart_id` AS orderid, `amount`,
                                   `currency` FROM `" . $this->cms_dibs_get_tmpTableFullName() . "` 
                                   WHERE `session_cart_id` = '" . 
                                   dibs_pw_api::api_dibs_sqlEncode($mPostOrderId) . "' LIMIT 1;");	

        $aResult = $this->cms_dibs_db_read_fetch($mOrderData);
        return (count($aResult[0]) > 0) ? (object)$aResult[0] : (object)array();
    }
    
    protected function cms_dibs_completeCart($iOrderId, $mCartId) {
        $dibsInvoiceFields = array("acquirerLastName",          "acquirerFirstName",
                                       "acquirerDeliveryAddress",   "acquirerDeliveryPostalCode",
                                       "acquirerDeliveryPostalPlace" );
        $dibsInvoiceFieldsString = "";
        
        
         foreach($_POST as $key=>$value) {
              if(in_array($key, $dibsInvoiceFields)) {
                   $dibsInvoiceFieldsString .= "{$key}={$value}\n";              
              }
         } 
            
        
        $this->helper_dibs_db_write("UPDATE `" . $this->cms_dibs_get_tmpTableFullName() . "` 
                                    SET `orderid`='" . dibs_pw_api::api_dibs_sqlEncode($iOrderId) . "' 
                                    WHERE `session_cart_id`='" .
                                    dibs_pw_api::api_dibs_sqlEncode($mCartId) . "' LIMIT 1;");
        $this->helper_dibs_db_write("UPDATE `" . $this->helper_dibs_tools_prefix() . 
                                   "orders_status_history` 
                                   SET `comments`=CONCAT('[DIBS Order ID: " . $mCartId ."]\n ".  $dibsInvoiceFieldsString ." \n', `comments`) 
                                   WHERE `orders_id`='" . dibs_pw_api::api_dibs_sqlEncode($iOrderId) . 
                                   "' AND `orders_status_id`='" . $this->order_status . "' LIMIT 1;");
        
        
         
        
    }
    
    protected function cms_dibs_processHelperTable($oOrderInfo) {
        $this->cms_dibs_helperTable();
        
        $mOrderExists = $this->cms_dibs_db_read("SELECT COUNT(`session_cart_id`) AS session_cart_exists 
                                                FROM `" . $this->cms_dibs_get_tmpTableFullName() . "` 
                                                WHERE `session_cart_id` = '" . 
                                                dibs_pw_api::api_dibs_sqlEncode($oOrderInfo->orderid) . 
                                                "' LIMIT 1;");	

        $aResult = $this->cms_dibs_db_read_fetch($mOrderExists);
        if($aResult[0]['session_cart_exists'] > 0) {
            $this->helper_dibs_db_write("DELETE FROM `" . $this->cms_dibs_get_tmpTableFullName() . "` 
                                        WHERE `session_cart_id` = '" . 
                                        dibs_pw_api::api_dibs_sqlEncode($oOrderInfo->orderid) . "' LIMIT 1;");
        }
        
        $aInsertData = array(
            'session_cart_id' => $oOrderInfo->orderid,
            'orderid'        => '0',
            'amount'          => $oOrderInfo->amount,
            'currency'        => $oOrderInfo->currency
        );
        $this->cms_dibs_db_perform($this->cms_dibs_get_tmpTableFullName(), $aInsertData);
    }
    
    protected function cms_dibs_helperTable() {
        $this->helper_dibs_db_write("CREATE TABLE IF NOT EXISTS `" . 
                                    $this->cms_dibs_get_tmpTableFullName() . "` (
                                        `session_cart_id` varchar(45) NOT NULL DEFAULT '',
                                        `orderid` varchar(45) NOT NULL DEFAULT '',
                                        `amount` decimal(15,4) NOT NULL DEFAULT '0.0000',
                                        `currency` varchar(45) NOT NULL DEFAULT '',
                                        KEY `session_cart_id` (`session_cart_id`)
                                    ) ENGINE=MyISAM DEFAULT CHARSET=utf8;");
    }
    
   /**
     * Creating settings pulldown list (<select>) for language
     */
    public static function cms_dibs_get_selectLang($sValue, $sKey) {
        return self::cms_dibs_draw_pullDownMenu('configuration[' . $sKey . ']',
                                                  array(
                                                      array('id' => 'da_DK',  'text' => 'Danish'),
                                                      array('id' => 'en_UK',  'text' => 'English'),
                                                      array('id' => 'fi_FIN', 'text' => 'Finnish'),
                                                      array('id' => 'nb_NO',  'text' => 'Norwegian'),
                                                      array('id' => 'sv_SE',  'text' => 'Swedish'),
                                                  ),
                                                  $sValue);
    }
    
    /**
     * Creating settings pulldown list (<select>) for integration method
     */
    public static function cms_dibs_get_selectMethod($sValue, $sKey) {
        return self::cms_dibs_draw_pullDownMenu('configuration[' . $sKey . ']', 
                                                  array(
                                                      array('id' => '1', 'text' => 'Auto'),
                                                      array('id' => '2', 'text' => 'DIBS Payment Window'),
                                                      array('id' => '3', 'text' => 'Mobile Payment Window'),
                                                  ), 
                                                  $sValue);
    }
    
    /**
     * Creating settings pulldown list (<select>) for distribution method
     */
    public static function cms_dibs_get_selectDistr($sValue, $sKey) {
        return self::cms_dibs_draw_pullDownMenu('configuration[' . $sKey . ']',
                                                  array(
                                                      array('id' => 'empty', 'text' => '-'),
                                                      array('id' => 'email', 'text' => 'Email'),
                                                      array('id' => 'paper', 'text' => 'Paper')
                                                  ),
                                                  $sValue);
    }
}
?>