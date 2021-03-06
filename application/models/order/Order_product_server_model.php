<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * 2015年12月4日
 * @author Zhangcc
 * @version
 * @des
 */
class Order_product_server_model extends MY_Model{
    private $_Num;
    public function __construct(){
        parent::__construct(__DIR__, __CLASS__);
        log_message('debug', 'Model Order/Order_product_server_model start!');
    }

    /**
     * 通过order_product_id 获取板块信息
     * @param unknown $Opid
     */
    public function select ($Search) {
        $Item = $this->_Item . __FUNCTION__;
        $Cache = $this->_Cache . __FUNCTION__ . array_to_string($Search);
        $Return = false;
        if (!($Return = $this->cache->get($Cache))) {
            $Sql = $this->_unformat_as($Item);
            $this->HostDb->select($Sql)->from('order_product_server')
                ->join('order_product', 'op_id = ops_order_product_id', 'left')
                ->join('product', 'p_id = op_product_id', 'left')
                ->join('workflow_order_product', 'wop_id = op_status', 'left')
                ->where('op_status > ', OP_REMOVE);

            if (!empty($Search['order_id'])) {
                $this->HostDb->where('op_order_id', $Search['order_id']);
            }

            if (!empty($Search['order_product_id'])) {
                $this->HostDb->where('op_id', $Search['order_product_id']);
            }

            $Query = $this->HostDb->order_by('op_id')->order_by('ops_goods_speci_id')->get();
            if ($Query->num_rows() > 0) {
                $Return = array(
                    'content' => $Query->result_array(),
                    'num' => $Query->num_rows(),
                    'p' => ONE,
                    'pn' => ONE,
                    'pagesize' => ALL_PAGESIZE
                );
                $this->cache->save($Cache, $Return, MONTHS);
            } else {
                $GLOBALS['error'] = '没有符合搜索条件的订单服务类信息';
            }
        }
        return $Return;
    }
    /**
     * 通过订单产品编号获取信息
     * @param $Search
     * @return array|bool
     */
    public function select_by_order_product_id ($Search) {
        $Item = $this->_Item.__FUNCTION__;
        $Cache = $this->_Cache . __FUNCTION__ . implode('_', $Search);
        $Return = false;
        if(!($Return = $this->cache->get($Cache))){
            $Sql = $this->_unformat_as($Item);
            $Query = $this->HostDb->select($Sql)->from('order_product_server')
                ->where('ops_order_product_id', $Search['order_product_id'])->get();
            if ($Query->num_rows() > 0) {
                $Return = array(
                    'content' => $Query->result_array(),
                    'num' => $Query->num_rows(),
                    'p' => ONE,
                    'pn' => ONE,
                    'pagesize' => ALL_PAGESIZE
                );
                $this->cache->save($Cache, $Return, MONTHS);
            } else {
                $GLOBALS['error'] = '没有符合搜索条件的订单产品服务信息';
            }
        }
        return $Return;
    }

    public function select_sales($Con) {
        $Item = $this->_Item.__FUNCTION__;
        $Cache = $this->_Cache.__FUNCTION__.array_to_string($Con);
        if(!($Return = $this->cache->get($Cache))){
            $Sql = $this->_unformat_as($Item);

            $this->HostDb->select($Sql, FALSE)
                ->from('order_product_server')
                ->join('order_product', 'op_id = ops_order_product_id', 'left')
                ->join('product', 'p_id = op_product_id', 'left')
                ->join('order', 'o_id = op_order_id', 'left')
                ->join('order_datetime', 'od_order_id = o_id', 'left')
                ->where('op_status > ', OP_DISMANTLING)
                ->where('o_status > ', O_WAIT_SURE)
                ->where('od_sure_datetime > ', $Con['start_date']);
            if(!empty($Con['end_date'])) {
                $this->HostDb->where('od_sure_datetime < ', $Con['end_date']);
            }
            if (!empty($Con['product_id'])) {
                $this->HostDb->where_in('p_id', $Con['product_id']);
            }
            if(!empty($Con['keyword'])){
                $this->HostDb->group_start()
                    ->like('o_dealer', $Con['keyword'])
                    ->group_end();
            }

            $Query = $this->HostDb->get();
            if($Query->num_rows() > 0){
                $Return = $Query->result_array();
                $Query->free_result();
                $this->cache->save($Cache, $Return, HOURS);
            }else{
                $GLOBALS['error'] = '没有对应销售记录';
                $Return = false;
            }
        }
        return $Return;
    }

    public function insert_batch($Set){
        $Item = $this->_Item.__FUNCTION__;
        foreach ($Set as $key => $value){
            $Set[$key] = $this->_format($value, $Item, $this->_Module);
        }
        if($this->HostDb->insert_batch('order_product_server', $Set)){
            log_message('debug', "Model Order_product_server_model/insert_batch Success!");
            $this->remove_cache($this->_Module);
            return true;
        }else{
            log_message('debug', "Model Order_product_server_model/insert_batch Error");
            return false;
        }
    }


    public function update_batch ($Data) {
        $Item = $this->_Item.__FUNCTION__;
        foreach ($Data as $key => $value){
            $Data[$key] = $this->_format_re($value, $Item);
        }
        $this->HostDb->update_batch('order_product_server', $Data, 'ops_id');
        $this->remove_cache($this->_Module);
        return true;
    }
    /**
     * 通过订单产品Id删除配件信息
     * @param $OrderProductId
     * @return mixed
     */
    public function delete_by_order_product_id ($OrderProductId) {
        $this->HostDb->where_in('ops_order_product_id', is_array($OrderProductId) ? $OrderProductId : array($OrderProductId));
        $this->remove_cache($this->_Module);
        return $this->HostDb->delete('order_product_server');
    }
}
