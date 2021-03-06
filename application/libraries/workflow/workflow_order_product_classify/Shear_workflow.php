<?php namespace Wopc;
if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/6/20
 * Time: 9:33
 */
class Shear_workflow extends Workflow_order_product_classify_abstract {
    public function __construct($Source_id){
        $this->_Source_id = $Source_id;
    }

    public function shear(){
        $this->_Workflow->store_message('等待排产');
        // return $this->_workflow_propagation(__FUNCTION__);
        return true;
    }

    public function re_shear () {
        $this->_Workflow->store_message('岗位变动或安排出错，重新安排下料工人!');
        return true;
    }

    public function shearing() {
        $this->_Workflow->edit_current_workflow(Workflow_order_product_classify::$AllWorkflow['shearing']);
        return $this->_Workflow->shearing();
    }

    public function sheared() {
        $this->_Workflow->edit_current_workflow(Workflow_order_product_classify::$AllWorkflow['sheared']);
        return $this->_Workflow->sheared();
    }

    public function __call($name, $arguments){
        $Methods = array('optimize');
        if (in_array($name, $Methods)) {
            return true;
        }
    }
}