<?php
class dibs_fw_helpers_cms {
    
    private static $sTableOrderToSession = 'dibs_fw_order2session';
    
    /** START OF CGI API CMS Helpers **/
    public function cms_dibs_cgi_getButtonsRealID($iRealId) {
        $mPostId = $this->cms_dibs_cgi_getPostId($iRealId);
        return (!empty($mPostId)) ? $this->api_dibs_cgi_getAdminControls($mPostId) : "";
    }
    
    private function cms_dibs_cgi_getPostId($iRealId) {
        $mOrderData = $this->cms_dibs_db_read("SELECT `session_cart_id` AS oid FROM `" . 
                                              $this->cms_dibs_get_tmpTableFullName() . "`
                                              WHERE `orderid` = '" . 
                                              dibs_fw_api::api_dibs_sqlEncode($iRealId) . 
                                              "' LIMIT 1;");
        return (isset($mOrderData->fields['oid'])) ? $mOrderData->fields['oid'] : "";
    }
    /** EOF CGI API CMS Helpers **/
    
    public static function cms_dibs_get_order2sessionTable() {
        return self::$sTableOrderToSession;
    }
    
    protected function cms_dibs_get_title() {
        return '<img src="images/DIBSFLEX/dibsflex.gif" alt="DIBS Payment Services" ' .
               'style="vertical-align: middle; margin-right: 10px;" />' . $this->public_title . 
               (strlen(MODULE_PAYMENT_DIBSFLEX_TEXT_PUBLIC_DESCRIPTION) > 0 ? ' (' . 
               MODULE_PAYMENT_DIBSFLEX_TEXT_PUBLIC_DESCRIPTION . ')' : '');
    }
    
    private function cms_dibs_db_read($sQuery) {
        global $db;
        
        return $db->Execute($sQuery);
    }
    
    public function cms_dibs_genRedirectPage($sLink, $sDirection) {
        $sForm = "";
        foreach($_POST as $sKey => $sVal) {
            $sForm .= "<input type=\"hidden\" name=\"" . $sKey . "\" value=\"" . 
                      htmlspecialchars($sVal, ENT_COMPAT, "UTF-8") . "\" />\r\n";
        }

        $aParams = array('redirtitle_msg' => 'redirtitle_' . $sDirection,
                         'redir_msg'      => 'redir_' . $sDirection, 
                         'redir_link'     => $sLink,
                         'form_content'   => $sForm,
                         'toshop_msg'     => $sDirection);
        return $this->api_dibs_renderTemplate('dibs_fw_redir', $aParams);
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
        $mResult = array();
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
                                   dibs_fw_api::api_dibs_sqlEncode($mPostOrderId) . "' LIMIT 1;");	

        $aResult = $this->cms_dibs_db_read_fetch($mOrderData);
        return (count($aResult[0]) > 0) ? (object)$aResult[0] : (object)array();
    }
    
    protected function cms_dibs_completeCart($iOrderId, $mCartId) {
        $this->helper_dibs_db_write("UPDATE `" . $this->cms_dibs_get_tmpTableFullName() . "` 
                                    SET `orderid`='" . dibs_fw_api::api_dibs_sqlEncode($iOrderId) . "' 
                                    WHERE `session_cart_id`='" .
                                    dibs_fw_api::api_dibs_sqlEncode($mCartId) . "' LIMIT 1;");
        $this->helper_dibs_db_write("UPDATE `" . $this->helper_dibs_tools_prefix() . 
                                   "orders_status_history` 
                                   SET `comments`=CONCAT('[DIBS Order ID: " . $mCartId . "] \n', `comments`) 
                                   WHERE `orders_id`='" . dibs_fw_api::api_dibs_sqlEncode($iOrderId) . 
                                   "' AND `orders_status_id`='" . dibs_fw_api::api_dibs_sqlEncode($this->order_status) . 
                                   "' LIMIT 1;");
    }
    
    protected function cms_dibs_processHelperTable($oOrderInfo) {
        $this->cms_dibs_helperTable();
        
        $mOrderExists = $this->cms_dibs_db_read("SELECT COUNT(`session_cart_id`) AS session_cart_exists 
                                                FROM `" . $this->cms_dibs_get_tmpTableFullName() . "` 
                                                WHERE `session_cart_id` = '" . 
                                                dibs_fw_api::api_dibs_sqlEncode($oOrderInfo->orderid) . 
                                                "' LIMIT 1;");	

        $aResult = $this->cms_dibs_db_read_fetch($mOrderExists);
        if($aResult[0]['session_cart_exists'] > 0) {
            $this->helper_dibs_db_write("DELETE FROM `" . $this->cms_dibs_get_tmpTableFullName() . "` 
                                        WHERE `session_cart_id` = '" . 
                                        dibs_fw_api::api_dibs_sqlEncode($oOrderInfo->orderid) . "' LIMIT 1;");
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
                                                    array('id' => 'da', 'text' => 'Danish'),
                                                    array('id' => 'nl', 'text' => 'Dutch'),
                                                    array('id' => 'en', 'text' => 'English'),
                                                    array('id' => 'fo', 'text' => 'Faroese'),
                                                    array('id' => 'fi', 'text' => 'Finnish'),
                                                    array('id' => 'fr', 'text' => 'French'),
                                                    array('id' => 'de', 'text' => 'German'),
                                                    array('id' => 'it', 'text' => 'Italian'),
                                                    array('id' => 'no', 'text' => 'Norwegian'),
                                                    array('id' => 'pl', 'text' => 'Polish'),
                                                    array('id' => 'es', 'text' => 'Spanish'),
                                                    array('id' => 'sv', 'text' => 'Swedish'),
                                                ),
                                                $sValue);
    }
    
    /**
     * Creating settings pulldown list (<select>) for decorators
     */
    public static function cms_dibs_get_selectDecor($sValue, $sKey) {
        return self::cms_dibs_draw_pullDownMenu('configuration[' . $sKey . ']', 
                                                array(
                                                    array('id' => 'default', 'text' => 'Default'),
                                                    array('id' => 'basal',   'text' => 'Basal'),
                                                    array('id' => 'rich',    'text' => 'Rich'),
                                                    array('id' => 'own',     'text' => 'Own decorator')
                                                ), 
                                                $sValue);
    }

    /**
     * Creating settings pulldown list (<select>) for colors
     */
    public static function cms_dibs_get_selectColor($sValue, $sKey) {
        return self::cms_dibs_draw_pullDownMenu('configuration[' . $sKey . ']', 
                                                array(
                                                    array('id' => 'blank', 'text' => 'None'),
                                                    array('id' => 'sand',  'text' => 'Sand'),
                                                    array('id' => 'grey',  'text' => 'Grey'),
                                                    array('id' => 'blue',  'text' => 'Blue')
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