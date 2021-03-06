<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Util{
    function multipleUpload($path) {
        $CI =& get_instance();
        $CI->config->load('upload', TRUE);

        $config = $CI->config->config['upload'];
        $config['upload_path'] = $config['upload_path'].$path."/";

        if(is_dir($config['upload_path'])){

        }else{
            if(@mkdir($config['upload_path'], 0700, true)){}
            else{ return FALSE; }
        }

        $files = array ();
        
        $CI->load->library ('upload', $config);
        
        $errors = FALSE;
        
        foreach ( $_FILES as $key => $value ) {
            // print_r($key);
            if (! $CI->upload->do_upload ( $key)) {
                // $data['upload_message'] = $CI->upload->display_errors(); // ERR_OPEN and ERR_CLOSE are error delimiters defined in a config file
                // $CI->load->vars($data);
                // echo "<pre>";
                // print_r($data['upload_message']);
                // echo "</pre>";
                // $errors = TRUE;
            } else {
                // Build a file array from all uploaded files
                $files[$key] = $CI->upload->data ();
            }
        }
        
        // There was errors, we have to delete the uploaded files
        if ($errors) {
            foreach ( $files as $key => $file ) {
                @unlink ( $file ['full_path'] );
            }
        } elseif (empty ( $files ) and empty ( $data ['upload_message'] )) {
            $CI->lang->load ( 'upload' );
            $data ['upload_message'] = $CI->lang->line ( 'upload_no_file_selected' );
            $CI->load->vars ( $data );
        } else {
            return $files;
        }
    }

    function multipleImageUpload($path) {
        $CI =& get_instance();
        $CI->config->load('upload', TRUE);

        $config = $CI->config->config['upload'];
        $config['upload_path'] = $config['upload_path'].$path."/";
        $config['allowed_types'] = "gif|jpg|png|jpeg";

        if(is_dir($config['upload_path'])){

        }else{
            if(@mkdir($config['upload_path'], 0700, true)){}
            else{ return FALSE; }
        }

        $files = array ();
        
        $CI->load->library ('upload', $config);
        
        $errors = FALSE;
        
        foreach ( $_FILES as $key => $value ) {
            // print_r($key);
            if (! $CI->upload->do_upload ( $key)) {
                // $data['upload_message'] = $CI->upload->display_errors(); // ERR_OPEN and ERR_CLOSE are error delimiters defined in a config file
                // $CI->load->vars($data);
                // echo "<pre>";
                // print_r($data['upload_message']);
                // echo "</pre>";
                // $errors = TRUE;
            } else {
                // Build a file array from all uploaded files
                $files[$key] = $CI->upload->data ();
            }
        }
        
        // There was errors, we have to delete the uploaded files
        if ($errors) {
            foreach ( $files as $key => $file ) {
                @unlink ( $file ['full_path'] );
            }
        } elseif (empty ( $files ) and empty ( $data ['upload_message'] )) {
            $CI->lang->load ( 'upload' );
            $data ['upload_message'] = $CI->lang->line ( 'upload_no_file_selected' );
            $CI->load->vars ( $data );
        } else {
            return $files;
        }
    }
    
    // 경고메세지를 경고창으로
    function alert($msg = '', $url = '') {
        $CI = & get_instance ();
        
        if (! $msg)
            $msg = '올바른 방법으로 이용해 주십시오.'; 
        echo "<!DOCTYPE html>";
        echo "<html lang=\"ko\">";
        echo "<head>";
        echo "<meta charset=" . $CI->config->item ( 'charset' ) . "\" />";
        echo "<title>ㅍㅍㅅㅅ | 관리자</title>";
        echo "<script type='text/javascript'>alert('" . $msg . "');";
        if ($url)
            echo "location.replace('" . $url . "');";
        else
            echo "history.go(-1);";
            echo "</script>";
            echo "</head><body></body></html>";
        exit ();
    }

    function stripTags($text){
        $text = strip_tags($text);
        $text = preg_replace('/<iframe.*?\/iframe>/i','', $text);

        return trim($text);
    }
}
?>