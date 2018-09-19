<?php namespace Wop;
if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/6/20
 * Time: 11:49
 */
require_once 'Workflow_order_product_abstract.php';

class Workflow_order_product {
    static $AllWorkflow = NULL;
    private $_Workflow;
    private $_V;
    private $_Model = 'order_product_model';
    private $_Source_id;
    private $_Source_ids;
    private $_Dir;
    private $_CI;
    private $_Failue;

    private $_Data = array();

    public function __construct() {
        $this->_CI = &get_instance();
        log_message('debug', 'Library Workflow/Workflow_order_product __construct Start');
        $this->_Dir = dirname(__FILE__);
        $this->_CI->load->model('workflow/workflow_order_product_model');
        $this->_CI->load->model('workflow/workflow_order_product_msg_model');
    }

    /**
     * 初始化，设置工作流节点类型(订单，订单产品，订单产品板材，订单产品板块...)，根据类型设置模型(Model)
     * 设置对应的源Id，获取所有的工作流节点
     * @param unknown $Source_id
     * @param array $Data
     * @param string $Model
     */
    public function initialize($Source_id, $Data = array()) {
        $this->_Source_ids = $Source_id;
        if(is_array($this->_Source_ids)){
            $this->_Source_id = $this->_Source_ids[array_rand($this->_Source_ids, 1)];
        }else{
            $this->_Source_id = $this->_Source_ids;
        }
        if(is_null(self::$AllWorkflow)){
            if(!!($Query = $this->_CI->workflow_order_product_model->select(array('pagesize' => ALL_PAGESIZE, 'p' => ONE)))) {
                $Query = $Query['content'];
                foreach ($Query as $key => $value) {
                    self::$AllWorkflow[$value['name']] = $value;
                }
            } else {
                $this->_Failue = '获取订单产品工作流失败!';
                return false;
            }
        }
        if (!empty($Data)) { // 提交的时候同时修改数据
            $this->_Data = $Data;
        }
        return $this->read_current_workflow();
    }

    /**
     * 获取当前工作流类型的工作流，以及设置上下文环境
     */
    public function read_current_workflow() {
        if(!!($Query = $this->_CI->{$this->_Model}->select_current_workflow($this->_Source_id))){
            return $this->_set_context($Query);
        }else{
            log_message('debug', 'Library Workflow/Workflow read_current_workflow Failue');
            $this->_Failue = '获取当前订单产品的工作流失败';
            return false;
        }
    }

    /**
     * 编辑当前订单的工作流
     * @param unknown $Workflow
     */
    public function edit_current_workflow($Workflow, $Other = array()) {
        $Other['status'] = $Workflow['v'];
        $Other = array_merge($this->_Data, $Other);
        $this->_Data = array();
        if(!!($Query = $this->_CI->{$this->_Model}->update($Other,$this->_Source_ids))){
            return $this->_set_context($Workflow);
        }else{
            $this->_Failue = '设置当前订单的工作流失败';
            return false;
        }
    }

    /**
     * 设置当前环境，引入执行文件，设置执行文件的工作流
     * @param unknown $Workflow
     */
    private function _set_context($Workflow) {
        $this->_V = $Workflow['v'];

        $File = $this->_Dir . '/workflow_order_product/' . $Workflow['file'].'.php';
        if (file_exists($File)) {
            require_once $File;
            log_message('debug', 'Library Workflow/workflow_order_product _set_content on File = '.$File.' And Source_id'.$this->_Source_id);
            $Class = '\\Wop\\' . $Workflow['file'];
            $this->_Workflow = new $Class($this->_Source_id);
            $this->_Workflow->set_workflow($this);
            return true;
        }else{
            $this->_Failue = '您要执行的工作流文件不存在!' . $File;
            return false;
        }
    }

    /**
     * 在修改订单状态之前可以编辑$Data, 提交的时候一次性提交
     * @param $Data
     */
    public function edit_data ($Data) {
        $this->_Data = array_merge($this->_Data, $Data);
    }

    /**
     * 更新编辑数据，是在状态不更换时但是需要更新数据时使用
     * @param array $Data
     * @return bool
     */
    public function set_edit_data ($Data = array()) {
        $Data = array_merge($this->_Data, $Data);
        $this->_Data = array();
        if (!empty($Data)) {
            return $this->_CI->{$this->_Model}->update($Data,$this->_Source_ids);
        } else {
            return true;
        }
    }

    /**
     * 获取并unset Data
     * @param string $Key
     * @return array|bool|mixed
     */
    public function unset_edit_data ($Key = '') {
        if (empty($Key)) {
            $Data = $this->_Data;
            $this->_Data = array();
            return $Data;
        } else {
            if (isset($this->_Data[$Key])) {
                $Data = $this->_Data[$Key];
                unset($this->_Data[$Key]);
                return $Data;
            } else {
                return false;
            }
        }
    }
    /**
     * 更新数据, 仅仅是更新数据，在修改订单状态之后单独修改数据
     * @param $Data
     * @return mixed
     */
    public function set_data ($Data) {
        return $this->_CI->{$this->_Model}->update($Data, $this->_Source_ids);
    }
    /**
     * 存储信息
     */
    public function store_message($Msg, $WorkflowOrderProductId = '') {
        $GLOBALS['workflow_msg'] = isset($GLOBALS['workflow_msg']) ? $GLOBALS['workflow_msg'] : '';
        if ($WorkflowOrderProductId === '') {
            $WorkflowOrderProductId = $this->_V;
        }
        if(is_array($this->_Source_ids)){
            $Set = array();
            foreach ($this->_Source_ids as $value){
                $Set[] = array(
                    'order_product_id' => $value,
                    'msg' => $Msg . $GLOBALS['workflow_msg'],
                    'workflow_order_product_id' => $WorkflowOrderProductId
                );
            }
            $this->_CI->workflow_order_product_msg_model->insert_batch($Set);
        }else{
            $Set = array(
                'order_product_id' => $this->_Source_id,
                'msg' => $Msg . $GLOBALS['workflow_msg'],
                'workflow_order_product_id' => $WorkflowOrderProductId
            );
            $this->_CI->workflow_order_product_msg_model->insert($Set);
        }
        $GLOBALS['workflow_msg'] = '';
        return true;
    }

    public function set_failue($Failue) {
        $GLOBALS['error'] = $Failue;
        $this->_Failue = $Failue;
    }
    public function get_failue() {
        return $this->_Failue;
    }

    public function get_source_ids() {
        return $this->_Source_ids;
    }
    public function __call($name, $arguments){
        $Methods = array('create', 'dismantling', 'dismantled', 're_dismantle', 'served', 'optimize', 'printed_list', 'pre_produce', 're_shear', 'electronic_sawed', 'edged', 'punched', 'scanned', 'producing', 'packing', 'packed', 'inned', 'remove', 'to_board', 'to_classify');
        if (in_array($name, $Methods)) {
            return $this->_Workflow->{$name}();
        }
    }
}