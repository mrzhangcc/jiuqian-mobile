<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Finance_account_model Model
 *
 * @package  CodeIgniter
 * @category Model
 */
class Finance_account_model extends MY_Model {
    private $_Num;
    public function __construct(){
        parent::__construct(__DIR__, __CLASS__);
        log_message('debug', 'Model finance/Finance_account_model Start!');
    }

    /**
     * Select from table finance_account
     */
    public function select($Search) {
        $Item = $this->_Item . __FUNCTION__;
        $Cache = $this->_Cache . __FUNCTION__ . implode('_', $Search);
        $Return = false;
        if (!($Return = $this->cache->get($Cache))) {
            $Search['pn'] = $this->_page_num($Search);
            if(!empty($Search['pn'])){
                $Sql = $this->_unformat_as($Item);
                $this->HostDb->select($Sql)->from('finance_account');
                if (isset($Search['intime'])) {
                    $this->HostDb->where('fa_intime', $Search['intime']);
                }
                $Query = $this->HostDb->limit($Search['pagesize'], ($Search['p']-1)*$Search['pagesize'])->get();
                $Return = array(
                    'content' => $Query->result_array(),
                    'num' => $this->_Num,
                    'p' => $Search['p'],
                    'pn' => $Search['pn'],
                    'pagesize' => $Search['pagesize']
                );
                $this->cache->save($Cache, $Return, MONTHS);
            } else {
                $GLOBALS['error'] = '没有符合搜索条件的财务账户';
            }
        }
        return $Return;
    }

    private function _page_num($Search){
        $this->HostDb->select('count(fa_id) as num', FALSE);
        if (isset($Search['intime'])) {
            $this->HostDb->where('fa_intime', $Search['intime']);
        }
        $this->HostDb->from('finance_account');

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

    /**
     * 判断是否存在账号
     * @param $Id
     * @return bool
     */
    public function is_exist($Id){
        $Item = $this->_Item . __FUNCTION__;
        $Cache = $this->_Cache . __FUNCTION__ . $Id;
        $Return = false;
        if (!($Return = $this->cache->get($Cache))) {
            $Sql = $this->_unformat_as($Item);
            $Query = $this->HostDb->select($Sql)
                ->from('finance_account')
                ->where('fa_id', $Id)
                ->get();
            if($Query->num_rows() > 0){
                $Return = $Query->row_array();
                $Query->free_result();
                $this->cache->save($Cache, $Return, MONTHS);
            }
        }
        return $Return;
    }

    /**
     * Insert data to table finance_account
     * @param $Data
     * @return Insert_id | Boolean
     */
    public function insert($Data) {
        $Item = $this->_Item.__FUNCTION__;
        $Data = $this->_format($Data, $Item);
        if($this->HostDb->insert('finance_account', $Data)){
            $this->remove_cache($this->_Module);
            return $this->HostDb->insert_id();
        } else {
            $GLOBALS['error'] = '插入财务账户数据失败!';
            return false;
        }
    }

    /**
     * Insert batch data to table finance_account
     */
    public function insert_batch($Data) {
        $Item = $this->_Item.__FUNCTION__;
        foreach ($Data as $key => $value){
            $Data[$key] = $this->_format($value, $Item);
        }
        if($this->HostDb->insert_batch('finance_account', $Data)){
            $this->remove_cache($this->_Module);
            return true;
        } else {
            $GLOBALS['error'] = '插入财务账户数据失败!';
            return false;
        }
    }

    /**
     * Update the data of table finance_account
     * @param $Data
     * @param $Where
     * @return boolean
     */
    public function update($Data, $Where) {
        $Item = $this->_Item.__FUNCTION__;
        $Data = $this->_format_re($Data, $Item);
        if (is_array($Where)) {
            $this->HostDb->where_in('fa_id', $Where);
        } else {
            $this->HostDb->where('fa_id', $Where);
        }
        $this->HostDb->update('finance_account', $Data);
        $this->remove_cache($this->_Module);
        return true;
    }

    /**
     * 批量更新table finance_account
     */
    public function update_batch($Data) {
        $Item = $this->_Item.__FUNCTION__;
        foreach ($Data as $key => $value){
            $Data[$key] = $this->_format_re($value, $Item);
        }
        $this->HostDb->update_batch('finance_account', $Data, 'fa_id');
        $this->remove_cache($this->_Module);
        return true;
    }

    /**
     * 更新财务进账
     * @param $Data
     * @param $Where
     * @return bool
     */
    public function update_balance_in ($Data, $Where) {
        if(!!($Account = $this->is_exist($Where))){
            $Set = array(
                'fa_balance' => $Data['in'] + $Account['balance'],
                'fa_in' => $Data['in'] + $Account['in'],
                'fa_in_fee' => $Data['in_fee'] + $Account['in_fee'],
            );
            $this->HostDb->where('fa_id',$Where);

            if($this->HostDb->update('finance_account', $Set)){
                $this->remove_cache($this->_Cache);
                return true;
            }else{
                $GLOBALS['error'] = '更新财务账户进账出错';
                return false;
            }
        }else{
            $GLOBALS['error'] = '财务账户不存在';
            return false;
        }
    }

    /**
     * 更新财务账户出账
     * @param $Data
     * @param $Where
     * @return bool
     */
    public function update_balance_out($Data, $Where){
        if(!!($Account = $this->is_exist($Where))){
            $Set = array(
                'fa_balance' => $Account['balance'] - $Data['out'] - $Data['out_fee'],
                'fa_out' => $Data['out'] + $Account['out'],
                'fa_out_fee' => $Data['out_fee'] + $Account['out_fee'],
            );
            $this->HostDb->where('fa_id',$Where);

            if($this->HostDb->update('finance_account', $Set)){
                $this->remove_cache($this->_Cache);
                return true;
            }else{
                $GLOBALS['error'] = '更新财务账户出账时出错';
                return false;
            }
        }else{
            $GLOBALS['error'] = '财务账户不存在';
            return false;
        }
    }
    /**
     * Delete data from table finance_account
     * @param $Where
     * @return boolean
     */
    public function delete($Where) {
        if(is_array($Where)){
            $this->HostDb->where_in('fa_id', $Where);
        } else {
            $this->HostDb->where('fa_id', $Where);
        }

        $this->HostDb->delete('finance_account');
        $this->remove_cache($this->_Module);
        return true;
    }
}
