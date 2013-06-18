<?php

class Bootstrap extends Zend_Application_Bootstrap_Bootstrap {


    protected function _initView() {
        
        $view = new Zend_View();
        $view->doctype('XHTML1_STRICT');
        $view->setEncoding('UTF-8');
        $view->headTitle()->setSeparator(' - ');
        $view->headTitle('Divine Breath');
        $view->headMeta()->appendHttpEquiv('Content-Type', 'text/html;charset=utf-8');
        
        $view->env = APPLICATION_ENV;
        $view->addHelperPath(APPLICATION_PATH . '/modules/home/views/helpers', 'Zend_view_helper');
        $viewRenderer = Zend_Controller_Action_HelperBroker::getStaticHelper('ViewRenderer');
      
        $viewRenderer->setView($view); 
        return $view; 
    }


}

