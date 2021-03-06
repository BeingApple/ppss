<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Article_model extends CI_Model{
    public $ARTICLE_SEQ;
    public $ADMIN_SEQ;
    public $ADMIN_NAME;
    public $ARTICLE_CATEGORY;
    public $ARTICLE_FILE_NAME;
    public $ARTICLE_FILE_ORG;
    public $ARTICLE_TITLE;
    public $ARTICLE_CONTENTS;
    public $VIEW_YN;
    public $AUTH_YN;
    public $DEL_YN;
    public $REG_DATE;

    function __construct(){
        parent::__construct();
        
        $this->load->database();
    }

    public function articleListCount($where = array()){
        if($where['ADMIN_SEQ'] != NULL && $where['ADMIN_SEQ'] != ""){
            $this->db->where('ADMIN_SEQ', $where['ADMIN_SEQ']);
        }

        if($where['ARTICLE_TITLE'] != NULL && $where['ARTICLE_TITLE'] != ""){
            $this->db->like('ARTICLE_TITLE', $where['ARTICLE_TITLE'], 'both');
        }

        if($where['ADMIN_NAME'] != NULL && $where['ADMIN_NAME'] != ""){
            $this->db->like('ADMIN_NAME', $where['ADMIN_NAME'], 'both');
        }

        if($where['ARTICLE_CATEGORY'] != NULL && $where['ARTICLE_CATEGORY'] != ""){
            $this->db->like('ARTICLE_CATEGORY', $where['ARTICLE_CATEGORY'], 'both');
        }

        if($where['ARTICLE_CONTENTS'] != NULL && $where['ARTICLE_CONTENTS'] != ""){
            $this->db->like('ARTICLE_CONTENTS', $where['ARTICLE_CONTENTS'], 'both');
        }

        if($where['VIEW_YN'] != NULL){
            $this->db->where('VIEW_YN', $where['VIEW_YN']);
        }

        if($where['AUTH_YN'] != NULL){
            $this->db->where('AUTH_YN', $where['AUTH_YN']);
        }

        $this->db->where('DEL_YN', $where['DEL_YN']);

        $query = $this->db->get('TBL_ARTICLE');

        return $query->num_rows();
    }

    public function articleList($where = array(), $limit, $offset){
        if($where['ADMIN_SEQ'] != NULL && $where['ADMIN_SEQ'] != ""){
            $this->db->where('ADMIN_SEQ', $where['ADMIN_SEQ']);
        }

        if($where['ARTICLE_TITLE'] != NULL && $where['ARTICLE_TITLE'] != ""){
            $this->db->like('ARTICLE_TITLE', $where['ARTICLE_TITLE'], 'both');
        }

        if($where['ADMIN_NAME'] != NULL && $where['ADMIN_NAME'] != ""){
            $this->db->like('ADMIN_NAME', $where['ADMIN_NAME'], 'both');
        }

        if($where['ARTICLE_CATEGORY'] != NULL && $where['ARTICLE_CATEGORY'] != ""){
            $this->db->like('ARTICLE_CATEGORY', $where['ARTICLE_CATEGORY'], 'both');
        }

        if($where['ARTICLE_CONTENTS'] != NULL && $where['ARTICLE_CONTENTS'] != ""){
            $this->db->like('ARTICLE_CONTENTS', $where['ARTICLE_CONTENTS'], 'both');
        }

        if($where['VIEW_YN'] != NULL){
            $this->db->where('VIEW_YN', $where['VIEW_YN']);
        }

        if($where['AUTH_YN'] != NULL){
            $this->db->where('AUTH_YN', $where['AUTH_YN']);
        }

        $this->db->where('DEL_YN', $where['DEL_YN']);

        $query = $this->db->get('TBL_ARTICLE', $limit, $offset);

        return $query->result();
    }
    
    public function articleData($idx){
        $query = $this->db->get_where('TBL_ARTICLE', array('ARTICLE_SEQ' => $idx, 'DEL_YN' => 'N'));

        return $query->row();
    }

    public function articleAuthorListCount($adminSeq){
        $query = $this->db->get_where('TBL_ARTICLE', array('ADMIN_SEQ' => $adminSeq, 'DEL_YN' => 'N', 'VIEW_YN' => 'Y', 'AUTH_YN' => 'Y'));

        return $query->num_rows();
    }

    public function articleAuthorList($adminSeq, $limit, $offset){
        $this->db->order_by('REG_DATE', 'DESC');
        $query = $this->db->get_where('TBL_ARTICLE', array('ADMIN_SEQ' => $adminSeq, 'DEL_YN' => 'N', 'VIEW_YN' => 'Y', 'AUTH_YN' => 'Y'), $limit, $offset);

        return $query->result();
    }

    public function articleCategoryListCount($category){
        $this->db->like('ARTICLE_CATEGORY', $category, 'both');
        $this->db->where("DEL_YN","N");
        $this->db->where("VIEW_YN","Y");
        $this->db->where("AUTH_YN","Y");

        $query = $this->db->get('TBL_ARTICLE');

        return $query->num_rows();
    }

    public function articleCategoryList($category, $limit, $offset){
        $this->db->like('ARTICLE_CATEGORY', $category, 'both');
        $this->db->where("DEL_YN","N");
        $this->db->where("VIEW_YN","Y");
        $this->db->where("AUTH_YN","Y");

        $query = $this->db->get('TBL_ARTICLE', $limit, $offset);

        return $query->result();
    }

    public function articleFrontListCount(){
        $query = $this->db->get_where('TBL_ARTICLE', array('DEL_YN' => 'N', 'VIEW_YN' => 'Y', 'AUTH_YN' => 'Y'));

        return $query->num_rows();
    }

    public function articleFrontList($limit, $offset){
        $this->db->order_by('REG_DATE', 'DESC');
        $query = $this->db->get_where('TBL_ARTICLE', array('DEL_YN' => 'N', 'VIEW_YN' => 'Y', 'AUTH_YN' => 'Y'), $limit, $offset);
        
        return $query->result();
    }

    public function articleFrontData($idx){
        $query = $this->db->get_where('TBL_ARTICLE', array('ARTICLE_SEQ' => $idx, 'DEL_YN' => 'N', 'VIEW_YN' => 'Y', 'AUTH_YN' => 'Y'));

        return $query->row();
    }

    public function articleInsert($data){
        return $this->db->insert("TBL_ARTICLE", $data);
    }

    public function articleUpdate($data, $where){
        return $this->db->update("TBL_ARTICLE", $data, $where);
    }

    public function articleDelete($where_in){
        $data['DEL_YN'] = 'Y';

        $this->db->where_in('ARTICLE_SEQ', $where_in); 
        return $this->db->update("TBL_ARTICLE", $data);
    }

    public function articleAuth($data, $where_in){
        $this->db->where_in('ARTICLE_SEQ', $where_in); 
        return $this->db->update("TBL_ARTICLE", $data);
    }
}
?>