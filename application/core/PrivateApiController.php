<?php

(defined('BASEPATH')) OR exit('No direct script access allowed');

/**
 * Digunakan untuk autentifikasi user yang telah login
 */
class PrivateApiController extends ApiController {

    protected $token;
    protected $user;
    protected $page;

    public function __construct() {
        parent::__construct();

        // $this->validateToken();

        $this->page = $this->uri->segment(4, 0);
    }

    /**
     * Digunakan untuk validasi token dan penyimpanan history request
     */
    public function validateToken() {
        // $this->setResponse($this->setSystem(ResponseStatus::UNAUTHORIZED, $this->postData['token']));
        if (!isset($this->postData['token'])) {
            $this->setResponse($this->setSystem(ResponseStatus::UNAUTHORIZED, 'Token tidak dikirim.'));
        }
        $auth = AuthManager::validateToken($this->postData['token']);
        if (is_string($auth)) {
            $this->setResponse($this->setSystem(ResponseStatus::UNAUTHORIZED, $auth));
        } elseif (is_array($auth)) {
            list($token, $user) = $auth;
            $this->token = $this->systemResponse->token = $token;
            $this->user = $user;
            unset($this->user['role']);
            // $this->setResponse($this->setSystem(ResponseStatus::UNAUTHORIZED, $auth));
        }
        unset($this->postData['token']);
    }

    protected function setSystem($errorCode = NULL, $errorMessage = NULL, $infos = NULL, $validation = NULL) {
        if (empty($code)) {
            $code = ResponseStatus::SUCCESS;
        }
        // $this->load->model('Notification_user_model');
        // $notification = $this->Notification_user_model->getCountMe($this->user['id']);
        $this->systemResponse->setData($code, $errorMessage, $validation, $notification);
        return $this->systemResponse;
    }

    function documentform($pureID,$folder='posts/temp')  {
        $folder_ori = $folder;
        if ($_FILES['file']['name']) {
            $files_arr = array();

            $id = md5($pureID. $this->config->item('encryption_key'));
 
            $folder .= '/' . $id;
            $ciConfig = $this->config->item('utils');
            $path = $ciConfig['full_upload_dir'] . $folder . '/';
            if (!is_dir($path)) {
               mkdir($path);
            }
            $name = $_FILES['file']['name'];
            $arr = explode(".",$name);
            $type = end($arr);
            $_FILES['userfile']['name']= $_FILES['file']['name'];
            $_FILES['userfile']['type']= $_FILES['file']['type'];
            $_FILES['userfile']['tmp_name']= $_FILES['file']['tmp_name'];
            $_FILES['userfile']['error']= $_FILES['file']['error'];
            $_FILES['userfile']['size']= $_FILES['file']['size'];
            if(strcmp($type,"jpg")==0 || strcmp($type,"png")==0 || strcmp($type,"jpeg")==0){
                $file_name = Image::getFileName($id, Image::IMAGE_ORIGINAL, $name);
                unlink($path . $file_name);
                $file_mime = Image::getMime($folder.$file_name);
                $image_mime = explode('/',$file_mime);
                if ($image_mime[0]=='image') {
                    Image::upload('userfile', $id, $name, $folder);
                    $link = Image::generateLink($id, $name, $folder);
                    $images_arr[] = $link['thumb'];
                    $_SESSION['sigap']['draft_post'] = 1;
                }
                $str = $this->_getdraftimages($folder_ori);
            }else{
                $file_name = File::getFileName($id, $name);
                unlink($path . $file_name);
                File::uploadFile('userfile', $id, $name, $folder);
                $link = File::generateLink($id, $name, $folder);
                $files_arr = $link;
                $_SESSION['sigap']['draft_post'] = 1;
                $str = $this->_getdraftfiles($folder_ori);
            }
            // die($str);
        }   
    }   

    function _moveFileTemp($post_id,$pureID,$revisi,$folder_source='posts/temp') {
        $id = md5($pureID. $this->config->item('encryption_key'));
        $folder_source .= '/'.$id;
        
        $ciConfig = $this->config->item('utils');
        $path_source = $ciConfig['full_upload_dir'] . $folder_source . '/';
        
        if (is_dir($path_source)) {
            $files = glob($path_source.'*'); 
            $arr_image = array();
            $arr_files = array();
            foreach ($files as $file) {
                list($mime,$ext) = explode('/',Image::getMime($file));
                $basename = basename($file);
                $arr = explode("-",$basename);
                if ($mime=='image') {
                    $identifier = $arr[0] . "-" . $arr[1];
                    $folder_dest = 'posts/photos';
                    $path_dest = $ciConfig['full_upload_dir'] . $folder_dest . '/';
                    $image = Image::getName($basename);
                    $arr = explode(".",$image);
                    $imageExt = $arr[sizeof($arr)-1];
                    unset($arr[sizeof($arr)-1]);
                    $nameFile = implode(".",$arr) . "." . $imageExt;
                    $temp=1;
                    while($this->model->cekSameNameFile($nameFile)){
                        $nameFile = $arr[0] . "("  . $temp . ")." . $imageExt;
                        $temp++;
                    }
                    if (!in_array($image, $arr_image)) {
                        $arr_image[] = $image;
                        if (!$this->model->insertPostImageAPI($pureID,$post_id,$revisi,$image,$file)) {
                            return false;
                        }
                    }
                } else {
                    $identifier = $arr[0];
                    $folder_dest = 'posts/files';
                    $path_dest = $ciConfig['full_upload_dir'] . $folder_dest . '/';
                    $fil = File::getName($basename);
                    $arr = explode(".",$fil);
                    $filExt = $arr[sizeof($arr)-1];
                    unset($arr[sizeof($arr)-1]);
                    $nameFile = implode(".",$arr) . "." . $filExt;
                    $temp=1;
                    while($this->model->cekSameNameFile($nameFile)){
                        $nameFile = $arr[0] . "("  . $temp . ")." . $filExt;
                        $temp++;
                    }
                    if (!in_array($fil, $arr_files)) {
                        $arr_files[] = $fil;
                        if (!$this->model->insertPostFileAPI($pureID,$post_id,$revisi,$fil, $file)) {
                            return false;
                        }
                    }
                }
                if (!rename($file, $path_dest . '/' . $identifier . "-" . $nameFile)) {
                    return false;
                }
            }
        }else {
            return false;
        }
        return $this->_deleteFiles($path_source);
    }

    function unsetFileTemp($pureID,$folder_source='posts/temp'){
        $id = md5($pureID. $this->config->item('encryption_key'));
        $folder_source .= '/'.$id;
        
        $ciConfig = $this->config->item('utils');
        $path_source = $ciConfig['full_upload_dir'] . $folder_source . '/';
        
        if (is_dir($path_source)) {
            $this->_deleteFiles($path_source);
        }
    }

    function _getdraftimages($idUser,$folder='posts/temp') {

        $str = '';
        $id = md5($idUser . $this->config->item('encryption_key'));
        $folder .= '/' . $id;
        $ciConfig = $this->config->item('utils');
        $path = $ciConfig['full_upload_dir'] . $folder . '/';
        $rel_path = $ciConfig['upload_dir'] . $folder . '/';

        if (is_dir($path)) {
           $files = glob($path.'thumb*'); 
           foreach ($files as $file) {
               $image_src = base_url() . $rel_path . basename($file);
               $str .= "<img src=\"$image_src\" style=\"max-height:100px\"> ";
           }
        }
        return $str;
    }

    function _getdraftfiles($idUser,$folder='posts/temp') {

        $str = '';
        $id = md5($idUser . $this->config->item('encryption_key'));
        $folder .= '/' . $id;
        $ciConfig = $this->config->item('utils');
        $path = $ciConfig['full_upload_dir'] . $folder . '/';
        $rel_path = $ciConfig['upload_dir'] . $folder . '/';
        if (is_dir($path)) {
           $files = glob($path.'*'); 
           foreach ($files as $file) {
               $file_src = basename($file);
               $file_name = explode('-',$file_src);
               $arr_file_ext = explode('.',$file_name[count($file_name)-1]);
               $file_ext = $arr_file_ext[count($arr_file_ext)-1];
               if ($file_ext=="pdf" || $file_ext=="doc" || $file_ext=="docx" || $file_ext=="xls" || $file_ext=="xlsx" || $file_ext=="ppt" || $file_ext=="pptx" || $file_ext=="zip" || $file_ext=="rar"){
                    $index = 0;
                    $name = '';
                    foreach ($file_name as $fname){
                        if ($index>0) {
                            $name .=$fname;
                            if ($index<count($file_name)-1) {
                                $name .='-';
                            }
                        }
                        $index++;
                    }
                    $str .= $name . "<br>";
               }
           }
        }
        return $str;
    }

    function _deleteFiles($path){
        if (is_dir($path) === true) {
            $files = array_diff(scandir($path), array('.', '..'));
            foreach ($files as $file) {
                $this->_deleteFiles(realpath($path) . '/' . $file);
            }
            return rmdir($path);
        }

        else if (is_file($path) === true) {
            return unlink($path);
        }
        return false;
    }

}
