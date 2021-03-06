<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * 2016年1月4日
 * @author 记录用户登录信息模块
 * @version
 * @des
 */

class Signin_model extends MY_Model {
    private $_Num;

    public function __construct(){
        parent::__construct(__DIR__, __CLASS__);
        log_message('debug', 'Model Manage/Signin_model Start');
    }

    /**
     * Select from table card_type
     */
    public function select($Search) {
        $Item = $this->_Item . __FUNCTION__;
        $Cache = $this->_Cache . __FUNCTION__ . implode('_', $Search);
        $Return = false;
        if (!($Return = $this->cache->get($Cache))) {
            if(empty($Search['pn'])){
                $Search['pn'] = $this->_page_num($Search);
            }else{
                $this->_Num = $Search['num'];
            }
            if(!empty($Search['pn'])){
                $Sql = $this->_unformat_as($Item);
                $this->HostDb->select($Sql)->from('signin');
                $this->HostDb->where('s_user_id', $Search['user_v']);
                $Query = $this->HostDb->limit($Search['pagesize'], ($Search['p']-1)*$Search['pagesize'])
                    ->order_by('s_create_datetime', 'desc')->get();
                if ($Query->num_rows() > 0) {
                    $Return = array(
                        'content' => $Query->result_array(),
                        'num' => $this->_Num,
                        'p' => $Search['p'],
                        'pn' => $Search['pn']
                    );
                    $this->cache->save($Cache, $Return, MONTHS);
                } else {
                    $GLOBALS['error'] = '没有符合搜索条件的登录记录';
                }
            }
        }
        return $Return;
    }

    private function _page_num($Search){
        $this->HostDb->select('count(s_id) as num', FALSE);
        $this->HostDb->where('s_user_id', $Search['user_v']);
        $this->HostDb->from('signin');

        $Query = $this->HostDb->get();
        if($Query->num_rows() > 0){
            $Row = $Query->row_array();
            $Query->free_result();
            $this->_Num = $Row['num'];
            if(intval($Row['num']%$Search['pagesize']) == 0){
                $Pn = intval($Row['num']/$Search['pagesize']);
            }else{
                $Pn = intval($Row['num']/$Search['pagesize'])+1;
            }
            return $Pn;
        }else{
            return false;
        }
    }
    /*
    function select_self($Con){
        $Item = $this->_Item.__FUNCTION__;
        $Cache = $this->_Cache.__FUNCTION__;
        $Return = false;
        if(!($Return = $this->cache->get($Cache))){
            if(empty($Con['pn'])){
                $Con['pn'] = $this->_page($Con);
            }else{
                $this->_Num = $Con['num'];
            }
            $Sql = $this->_unformat_as($Item);
            $Query = $this->HostDb->select($Sql)
                                        ->from('signin')
                                        ->where('s_user_id', $this->input->cookie('uid'))
                                        ->order_by('s_create_datetime', 'desc')
                                    ->get();
            if($Query->num_rows() > 0){
                $Return = array(
                    'content' => $Query->result_array(),
                    'num' => $this->_Num,
                    'p' => $Con['p'],
                    'pn' => $Con['pn']
                );
                $Query->free_result();
                $this->cache->save($Cache, $Return, MONTHS);
            }
        }
        return $Return;
    }

    private function _page($Con){
        $this->HostDb->select('count(s_id) as num', FALSE);
        $this->HostDb->from('signin');
        $this->HostDb->where('s_user_id', $this->input->cookie('uid'));
        $Query = $this->HostDb->get();
        if($Query->num_rows() > 0){
            $Row = $Query->row_array();
            $Query->free_result();
            $this->_Num = $Row['num'];
            if(intval($Row['num']%$Con['pagesize']) == 0){
                $Pn = intval($Row['num']/$Con['pagesize']);
            }else{
                $Pn = intval($Row['num']/$Con['pagesize'])+1;
            }
            log_message('debug', 'Num is '.$Row['num'].' and Pagesize is'.$Con['pagesize'].' and Page Nums is'.$Pn);
            return $Pn;
        }else{
            return false;
        }
    }*/

    /**
     * @param $Data
     * @return bool
     * @des 增加用户登录信息
     */
    function insert($Data){
        $Item = $this->_Item.__FUNCTION__;
        $Data = $this->_format($Data, $Item);
        if($this->HostDb->insert('signin', $Data)){
            log_message('debug', "Model Signin_model/insert Success!");
            $this->remove_cache($this->_Cache);
            return $this->HostDb->insert_id();
        }else{
            log_message('debug', "Model Signin_model/insert Error");
            $GLOBALS['error'] = $this->HostDb->error();
            return false;
        }
    }
}
