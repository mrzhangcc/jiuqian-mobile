<?php namespace Wm;
if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/6/20
 * Time: 9:33
 */
class Sheared_workflow extends Workflow_mrp_abstract {
    public function __construct($Source_id){
        $this->_Source_id = $Source_id;
    }

    public function sheared(){
        $this->_Workflow->store_message('已排产 ');
        $this->_workflow_propagation(__FUNCTION__);
        $this->_Workflow->edit_current_workflow(Workflow_mrp::$AllWorkflow['electronic_saw']);
        $this->_Workflow->electronic_saw();
    }

    public function __call($name, $arguments){
        ;
    }
}