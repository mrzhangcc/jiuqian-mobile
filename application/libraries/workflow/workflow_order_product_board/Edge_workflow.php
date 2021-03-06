<?php namespace Wopb;
if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/6/23
 * Time: 9:34
 */
class Edge_workflow extends Workflow_order_product_board_abstract {
    public function __construct($Source_id){
        $this->_Source_id = $Source_id;
    }

    public function edge () {
        $this->_Workflow->store_message('等待封边');
        // $this->_workflow_propagation(__FUNCTION__);
        return true;
    }

    public function re_edge () {
        $this->_Workflow->store_message('岗位工作变动，重新安排封边工人!');
        return true;
    }
    public function edged() {
        $this->_Workflow->edit_current_workflow(Workflow_order_product_board::$AllWorkflow['edged'], array('edge' => $this->_CI->session->userdata('uid'), 'edge_datetime' => date('Y-m-d H:i:s')));
        return $this->_Workflow->edged();
    }
    public function edging() {
        $this->_Workflow->edit_current_workflow(Workflow_order_product_board::$AllWorkflow['edging'], array('edge' => $this->_CI->session->userdata('uid')));
        return $this->_Workflow->edging();
    }

    public function __call($name, $arguments){
        ;
    }
}