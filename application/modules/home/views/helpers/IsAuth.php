<?php
class Zend_View_Helper_IsAuth extends Zend_View_Helper_Abstract {
public function isAuth(){
         $userInfo = Zend_Auth::getInstance()->getStorage()->read();
         return $userInfo;
    }
}
?>
