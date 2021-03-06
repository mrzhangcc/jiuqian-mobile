<?php namespace Wopc;
if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/6/23
 * Time: 9:34
 */
class Electronic_sawing_workflow extends Workflow_order_product_classify_abstract {
    public function __construct($Source_id){
        $this->_Source_id = $Source_id;
    }

    public function electronic_sawing () {
        $this->_Workflow->store_message('正在下料');
        return true;
    }

    public function re_shear () {
        $this->_Workflow->edit_current_workflow(Workflow_order_product_classify::$AllWorkflow['shear'], array('saw' => ZERO, 'saw_datetime' => null));
        return $this->_Workflow->shear();
    }

    public function electronic_sawed() {
        $this->_Workflow->edit_current_workflow(Workflow_order_product_classify::$AllWorkflow['electronic_sawed'], array('saw' => $this->_CI->session->userdata('uid'), 'saw_datetime' => date('Y-m-d H:i:s')));
        return $this->_Workflow->electronic_sawed();
    }

    public function __call($name, $arguments){
        $Methods = array('optimize');
        if (in_array($name, $Methods)) {
            return true;
        }
    }
}