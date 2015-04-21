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
    protected $_MAX_SIZE = 5000;

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
            $uploaddir = FILES_PATH;
            foreach ($_FILES['photos']['name'] as $name => $value) {
                $filename = stripslashes($_FILES['photos']['name'][$name]);
                $size = filesize($_FILES['photos']['tmp_name'][$name]);
                if (! in_array(pathinfo($name, PATHINFO_EXTENSION), $valid_formats)) {
                    if ($size < ($this->_MAX_SIZE * 1024)) {
                        $image_name = $filename;
                        echo "<img src='" . FILES_URL .'/user-upload/'. $image_name . "' class='imgList'>";
                        $newname = $uploaddir .'/user-upload/'. $image_name;
                        if (move_uploaded_file($_FILES['photos']['tmp_name'][$name], $newname)) {
                            $user_uploads = new Zendvn_Models_UserUploads();
                            $user_uploads->insert($image_name);
                        } else {
                            echo '<span class="imgList">You have exceeded the size limit! so moving unsuccessful! </span>';
                        }
                    } else {
                        echo '<span class="imgList">You have exceeded the size limit!</span>';
                    }
                } else {
                    echo '<span class="imgList">Unknown extension!</span>';
                }
            } //foreach end
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