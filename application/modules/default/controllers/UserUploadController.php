<?php

class UserUploadController extends Zendvn_Controller_Action {

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

        //Truyen ra view
        $this->view->arrParam = $this->_arrParam;
        $this->view->currentController = $this->_currentController;
        $this->view->actionMain = $this->_actionMain;
    }

    public function indexAction() {
        $this->_helper->layout->disableLayout();
        $this->_helper->viewRenderer->setNoRender();
        $valid_formats = array("jpg", "png", "gif", "bmp", "jpeg");
        if ($this->_request->isPost()) {
            $valid_formats = array("jpg", "png", "gif", "zip", "bmp");
            $max_file_size = 1024 * 50000; //100 kb

            $path = FILES_PATH; // Upload directory
            foreach ($_FILES['photos']['name'] as $f => $name) {
                $photos[] = $name;
                if ($_FILES['photos']['error'][$f] == 4) {
                    continue; // Skip file if any error found
                }
                if ($_FILES['photos']['error'][$f] == 0) {
                    if ($_FILES['photos']['size'][$f] > $max_file_size) {
                        $message[] = "$name is too large!.";
                        continue; // Skip large files
                    } elseif (!in_array(pathinfo($name, PATHINFO_EXTENSION), $valid_formats)) {
                        $message[] = "$name is not a valid format";
                        continue; // Skip invalid file formats
                    } else { // No error found! Move uploaded files 
                        $filename = $_FILES["photos"]["tmp_name"][$f];
                        move_uploaded_file($filename, $path . '/user-upload/' . $name);
                        $user_upload = new Zendvn_Models_UserUploads();
                        $user_upload->insert($name);
                    }
                }
            }
        }
    }

    public function getExtension($str) {
        $i = strrpos($str, ".");
        if (!$i) {
            return "";
        }
        $l = strlen($str) - $i;
        $ext = substr($str, $i + 1, $l);
        return $ext;
    }

}