<?php namespace Wopf;
if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/7/13
 * Time: 21:24
 */
class Packing_workflow extends Workflow_order_product_fitting_abstract {
    public function __construct($Source_id) {
        $this->_Source_id = $Source_id;
    }

    public function packing () {
        $this->_Workflow->store_message('正在打包');
        return true;
    }

    public function re_pack () {
        $this->_Workflow->edit_current_workflow(Workflow_order_product_fitting::$AllWorkflow['pack']);
        return $this->_Workflow->re_pack();
    }

    public function packed($arguments) {
        if (!isset($GLOBALS['creator'])) {
            $GLOBALS['creator'] = $this->_CI->session->userdata('uid');
        }
        $this->_Workflow->edit_current_workflow(Workflow_order_product_fitting::$AllWorkflow['packed'], array('pack' => $GLOBALS['creator'], 'pack_datetime' => date('Y-m-d H:i:s')));
        if (count($arguments) == TWO) {
            $Msg = $arguments[0];
            $Data = $arguments[1];
        } else {
            $arguments = array_pop($arguments);
            if (is_array($arguments)) {
                $Data = $arguments;
                $Msg = '';
            } else {
                $Msg = $arguments;
                $Data = array();
            }
        }
        return $this->_Workflow->packed($Msg, $Data);
    }

    public function __call($name, $arguments) {
        ;
    }
}