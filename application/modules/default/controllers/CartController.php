<?php

class CartController extends Zendvn_Controller_Action {

    //Mang tham so nhan duoc o moi Action
    protected $_arrParam;
    //Duong dan cua Controller
    protected $_currentController;
    //Duong dan cua Action chinh
    protected $_actionMain;
    //Thong so phan trang
    protected $_paginator = array(
        'itemCountPerPage' => 20,
        'pageRange' => 4,
    );
    protected $_namespace;

    public function init() {
        //Mang tham so nhan duoc o moi Action
        $this->_arrParam = $this->_request->getParams();

        //Duong dan cua Controller
        $this->_currentController = '/' . $this->_arrParam['module']
                . '/' . $this->_arrParam['controller'];

        //Duong dan cua Action chinh		
        $this->_actionMain = '/' . $this->_arrParam['module']
                . '/' . $this->_arrParam['controller'] . '/index';


        $this->_paginator['currentPage'] = $this->_request->getParam('page', 1);
        $this->_arrParam['paginator'] = $this->_paginator;

        //Luu cac du lieu filter vao SESSION
        //Dat ten SESSION
        $this->_namespace = $this->_arrParam['module'] . '-' . $this->_arrParam['controller'];
        $ssFilter = new Zend_Session_Namespace($this->_namespace);
        //$ssFilter->unsetAll();
        if (empty($ssFilter->col)) {
            $ssFilter->keywords = '';
        }
        $this->_arrParam['ssFilter']['keywords'] = $ssFilter->keywords;


        /* ====================================================
         * Load Zendvn Translate for Controller
         * ==================================================== */
        /* $this->_langObj->setLangFile(array('default.language.tmx'));		
          Zend_Registry::set('Zend_Translate', $this->_langObj->generate()); */

        $info = new Zendvn_System_Info();

        $language = $info->getLanguage('admin');
        if (empty($language)) {
            $language = 'vi';
        }
        $translate = array(
            'adapter' => 'tmx',
            'content' => LANG_PATH . '/' . $language . '/admin/default.language.tmx',
            'locale' => $language,
        );
        $translate = new Zend_Translate($translate);
        Zend_Registry::set('Zend_Translate', $translate);



        //Truyen ra view
        $this->view->arrParam = $this->_arrParam;
        $this->view->currentController = $this->_currentController;
        $this->view->actionMain = $this->_actionMain;

        $template_path = TEMPLATE_PATH . "/public/system";
        $this->loadTemplate($template_path, 'template.ini', 'template');
    }

    public function indexAction() {
        $this->_helper->layout->setLayout('cart');
        $yourCart = new Zend_Session_Namespace('cart');
        if ($this->_request->isPost()) {
            $itemProduct = $this->_arrParam['itemProduct'];
            if (count($itemProduct) > 0)
                foreach ($itemProduct as $key => $val) {
                    if ($val == 0) {
                        unset($itemProduct[$key]);
                    }
                }
            $yourCart->cart = $itemProduct;
        }
        $ssInfo = $yourCart->getIterator();
        $tblPricePro = new Zendvn_Models_PricePro();
        $this->_arrParam['cart'] = $ssInfo['cart'];
        $this->view->Items = $tblPricePro->listItem($this->_arrParam, array('task' => 'view-cart'));
        $this->view->cart = $ssInfo['cart'];
    }

    public function addItemAction() {
        $this->_helper->layout->disableLayout();
        $this->_helper->viewRenderer->setNoRender();
        $yourCart = new Zend_Session_Namespace('cart');
        $ssInfo = $yourCart->getIterator();
        $filter = new Zend_Filter_Digits();
        
        $size =0; $price =0; $selloff = 0; $id = 0;
        if(isset($this->_arrParam['size']))
            $size = $this->_arrParam['size'];
        if(isset($this->_arrParam['price']))
            $price = $this->_arrParam['price'];
        if(isset($this->_arrParam['selloff']))
            $selloff = $this->_arrParam['selloff'];
        if(isset($this->_arrParam['selloff']))
            $selloff = $this->_arrParam['selloff'];
        if(isset($this->_arrParam['id']))
            $id = $this->_arrParam['id'];
        $priId = $filter->filter($this->_arrParam['priID']);
        if (count($yourCart->cart) == 0) {
            if($id >0){
                $cart[$priId][$id]['number'] = 1;
                $cart[$priId][$id]['size'] = $size;
                $cart[$priId][$id]['price'] = $price;
                $cart[$priId][$id]['selloff'] = $selloff;
            }
            else{
                $cart[$priId]['number'] = 1;
            }
            $yourCart->cart = $cart;
        } else {
            $tmp = $ssInfo['cart'];
            if (array_key_exists($priId, $tmp) == true) {
                if($id == 0)
                    $tmp[$priId]['number'] = $tmp[$priId]['number'] + 1;
                else{
                    if(array_key_exists($id, $tmp) == false){
                        $tmp[$priId][$id]['number'] = $tmp[$priId][$id]['number'] + 1;
                        $tmp[$priId][$id]['size'] = $size;
                        $tmp[$priId][$id]['price'] = $price;
                        $tmp[$priId][$id]['selloff'] = $selloff;
                    }
                    else
                     $tmp[$priId][$id]['number'] = 1;
                }
                    
            } else {
                $tmp[$priId]['number'] = 1;
            }
            $yourCart->cart = $tmp;
        }
        $this->_redirect($this->_currentController);
    }

    public function changeNumberAction() {
        $this->_helper->layout->disableLayout();
        $this->_helper->viewRenderer->setNoRender();
        $yourCart = new Zend_Session_Namespace('cart');
        $ssInfo = $yourCart->getIterator();
        $tmp = $ssInfo['cart'];
        if ($this->_request->isPost()) {
            $id = $this->_arrParam['id'];
            $priId = $this->_arrParam['priId'];
            $quantity = $this->_arrParam['quantity'];
            if($id > 0)
                $tmp[$priId][$id]['number'] =  $quantity;
            else {
                $tmp[$priId]['number'] = $this->_arrParam['value'];
            }
            $yourCart->cart = $tmp;
        }
    }

    public function deleteAction() {
        $this->_helper->layout->disableLayout();
        $this->_helper->viewRenderer->setNoRender();
        $friId = $this->_arrParam['friId'];
        $id = $this->_arrParam['id'];
        $yourCart = new Zend_Session_Namespace('cart');
        $cart = $yourCart->cart;
        if($id > 0)
            unset($cart[$friId][$id]);
        else
            unset($cart[$friId]);
        $yourCart->cart = $cart;
    }

    public function deleteAllAction() {
        $this->_helper->layout->disableLayout();
        $this->_helper->viewRenderer->setNoRender();
        $yourCart = new Zend_Session_Namespace('cart');
        $yourCart->cart;
        unset($yourCart->cart);
        $this->_redirect($this->_currentController);
    }
    public function changeSizeAction(){
        $this->_helper->layout->disableLayout();
        $this->_helper->viewRenderer->setNoRender();
        $yourCart = new Zend_Session_Namespace('cart');
        $ssInfo = $yourCart->getIterator();
        $tmp = $ssInfo['cart'];
        
        if ($this->_request->isPost()) {
            $id = $this->_arrParam['id'];
            $price = $this->_arrParam['price'];
            $size = $this->_arrParam['size'];
            $tmp[$id]['price'] = $price;
            $tmp[$id]['size'] = $size;
            $yourCart->cart = $tmp;
        }
    }
    public function orderDetailAction() {
        $this->_helper->layout->disableLayout();
        $this->_helper->viewRenderer->setNoRender();
        if($this->_request->isPost()){
            $yourCart = new Zend_Session_Namespace('cart');
            $this->_arrParam['cart'] = $yourCart->cart;
            if(count($this->_arrParam['cart'])>0){
                foreach ($this->_arrParam['cart'] as $key => $val){
                    foreach ($val as $id => $value)
                        if($id > 0)
                            $tmp[] = $id;
                }
            }
            $this->_arrParam['arrId'] = $tmp;
            $invoice = new Zendvn_Models_Invoice();
            $this->_arrParam['invoice_id'] = $invoice->saveItem($this->_arrParam,array('task'=>'public-order'));
            $invoice = new Zend_Session_Namespace('invoice');
            $invoice->id = $this->_arrParam['invoice_id'];
            $invoiceDetail = new Zendvn_Models_InvoiceDetail();
            $invoiceDetail->saveItem($this->_arrParam);
        }
    }
}