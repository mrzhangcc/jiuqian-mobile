<?php namespace Wopc;
if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/6/23
 * Time: 9:33
 */
class Scan_workflow extends Workflow_order_product_classify_abstract {
    public function __construct($Source_id){
        $this->_Source_id = $Source_id;
    }

    public function scan(){
        $this->_Workflow->store_message('==等待做卫生和扫描');
        return true;
    }

    public function re_scan () {
        $this->_Workflow->store_message('岗位工作变动，重新安排扫描工人!');
        return true;
    }

    public function scanning () {
        $this->_Workflow->edit_current_workflow(Workflow_order_product_classify::$AllWorkflow['scanning'], array('scan' => $this->_CI->session->userdata('uid')));
        return $this->_Workflow->scanning();
    }

    public function scanned() {
        $this->_Workflow->edit_current_workflow(Workflow_order_product_classify::$AllWorkflow['scanned'], array('scan' => $this->_CI->session->userdata('uid'), 'scan_datetime' => date('Y-m-d H:i:s')));
        return $this->_Workflow->scanned();
    }

    public function __call($name, $arguments) {
        $Methods = array('optimize');
        if (in_array($name, $Methods)) {
            return true;
        }
    }
}