<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Print task Controller
 *
 * @package  CodeIgniter
 * @category Controller
 */
class Print_task extends MY_Controller {
    private $__Search = array(
        'paging' => 0,
        'v' => 0
    );
    private $_MaxLineNum = 16;
    private $_StockOutted;
    private $_Nos = array(); // 每个订单的订单产品编号
    private $_Flag = array(); // 标志排在左列或右列
    private $_Scanned = 0; // 已扫描出库件数
    private $_Pack = 0; // 要求发货件数
    private $_Tmp = array();
    private $_Tables = array();
    private $_Page = 1;
    public function __construct() {
        parent::__construct();
        log_message('debug', 'Controller desk/Print_task __construct Start!');
        $this->load->model('desk/print_task_model');
    }

    /**
    *
    * @return void
    */
    public function index() {
        $View = $this->uri->segment(4, 'read');
        if(method_exists(__CLASS__, '_'.$View)){
            $View = '_'.$View;
            $this->$View();
        }else{
            $this->_index($View);
        }
    }

    public function read () {
        $this->get_page_search();
        $Data = array();
        if(!($Data = $this->print_task_model->select($this->_Search))){
            $this->Message = isset($GLOBALS['error'])?is_array($GLOBALS['error'])?implode(',', $GLOBALS['error']):$GLOBALS['error']:'读取信息失败';
            $this->Code = EXIT_ERROR;
        }
        $this->_ajax_return($Data);
    }
    public function next () {
        $Data = array();
        if(!($Next = $this->print_task_model->select_next())){
            $this->Message = isset($GLOBALS['error'])?is_array($GLOBALS['error'])?implode(',', $GLOBALS['error']):$GLOBALS['error']:'读取信息失败';
            $this->Code = EXIT_ERROR;
        } else {
            if (method_exists(__CLASS__, '_get_' . $Next['file'])) {
                $this->print_task_model->update(array('status' => PRINTED), $Next['v']);  // 更新状态，认为已经打印
                $Func = '_get_' . $Next['file'];
                $Data = $this->{$Func}($Next['source_id']);
                $Data = array_merge($Data, $Next);
            } else {
                $this->Message = '没有可打印内容';
                $this->Code = EXIT_ERROR;
            }
        }
        $this->_ajax_return($Data);
    }

    private function _get_pick_sheet ($V) {
        // $Search['v'] = $V;
        $this->_Search = array_merge($this->_Search, $this->__Search);
        $this->get_page_search();
        $this->_Search['v'] = $V;
        $Data = array();
        $this->load->model('order/order_product_model');
        $this->load->model('warehouse/stock_outted_model');
        if (!!($this->_StockOutted = $this->stock_outted_model->is_exist($this->_Search['v']))) {
            $this->_parse_stock_outted();
            if (!($Query = $this->order_product_model->select_pick_sheet_print($this->_Search))) {
                $this->Message = isset($GLOBALS['error'])?is_array($GLOBALS['error'])?implode(',', $GLOBALS['error']):$GLOBALS['error']:'读取信息失败';
                $this->Code = EXIT_ERROR;
            } else {
                $this->load->helper('json_helper');
                $this->_parse_order_product($Query);
                $this->load->model('warehouse/unqrcode_model');
                if (!!($Unqrcode = $this->unqrcode_model->select_pick_sheet_print($this->_Search))) {
                    $this->_parse_order_product($Unqrcode, true);
                }
                if (!empty($this->_Tmp)) {
                    foreach ($this->_Tmp as $Key => $Value) {
                        array_push($this->_Tables[$Key]['trs'], $Value);
                    }
                }
                $Spliceds = array();
                foreach ($this->_Tables as $Key => $Value) {
                    $Spliced = array_chunk($Value['trs'], $this->_MaxLineNum);
                    if (count($Spliced) > 1) {
                        foreach ($Spliced as $Ikey => $Ivalue) {
                            $Value['trs'] = $Ivalue;
                            $Spliceds[] = $Value;
                        }
                    } else {
                        $Spliceds[] = $Value;
                    }
                }
                $Data['tables'] = $Spliceds;
                $Data['scanned'] = $this->_Scanned;
                $Data['pack'] = $this->_Pack;
                $Data['num'] = count($Spliceds);
                if ($this->_Scanned < $this->_Pack) {
                    $Data['message'] = '请注意: 扫描件数是' . $this->_Scanned . '，发货件数是' . $this->_Pack;
                }
                $Data['query']['stock_outted_id'] = $this->_Search['v'];
            }
        } else {
            $this->Message = '您选择的发货单不存在';
            $this->Code = EXIT_ERROR;
        }
        /*if(!($Query = $this->order_product_model->select_pick_sheet_print($Search))){
            $this->Message = isset($GLOBALS['error'])?is_array($GLOBALS['error'])?implode(',', $GLOBALS['error']):$GLOBALS['error']:'读取信息失败';
            $this->Code = EXIT_ERROR;
        } else {
            $this->load->model('warehouse/unqrcode_model');
            if (!!($Unqrcode = $this->unqrcode_model->select_pick_sheet_print($Search))) {
                $Query = array_merge($Query, $Unqrcode);
            }
            $this->load->helper('json_helper');
            $Data = $this->_two_column($Query);
        }*/
        return $Data;
    }

    private function _parse_stock_outted () {
        $PackDetail = json_decode($this->_StockOutted['pack_detail'], true);
        $OrderProduct = array();
        foreach ($PackDetail as $Key => $Value) {
            $OrderProduct[$Value['v']] = $Value['pack'];
        }
        $this->_Search['order_product_id'] = array_keys($OrderProduct);
        $this->_StockOutted['pack_detail'] = $OrderProduct;
    }

    private function _parse_order_product ($Data, $Unqrcode = false) {
        foreach ($Data as $Key => $Value) {
            $this->_Scanned += $Value['scanned'];  // 订单订单产品的扫描件数
            $Pack = $Unqrcode ? $Value['order_product_pack'] : $this->_StockOutted['pack_detail'][$Value['v']]; // 如果没有Unqrcode, 则使用建立发货单时要求发货的件数
            $this->_Pack += $Pack;
            if (!isset($this->_Tables[$Value['order_v']])) {
                $this->_Tables[$Value['order_v']] = array(
                    'p' => $this->_Page++,
                    'dealer' => $Value['dealer'],
                    'delivery_area' => $Value['delivery_area'],
                    'delivery_address' => $Value['delivery_address'],
                    'delivery_linker' => $Value['delivery_linker'],
                    'delivery_phone' => $Value['delivery_phone'],
                    'logistics' => $Value['logistics'],
                    'owner' => $Value['owner'],
                    'end_datetime' => $this->_StockOutted['end_datetime'],
                    'truck' => $this->_StockOutted['truck'],
                    'train' => $this->_StockOutted['train'],
                    'page_pack' => $Pack,
                    'page_collection' => $Value['collection'],
                    'dealer_remark' => $Value['dealer_remark'],
                    'remark' => $this->_StockOutted['remark'],
                    'trs' => array()
                );
                $this->_Flag[$Value['order_v']] = false;
            } else {
                $this->_Tables[$Value['order_v']]['page_pack'] += $Pack;
            }
            $PackDetail = json_decode($Value['pack_detail'], true);
            if (!isset($this->_Nos[$Value['order_v']])) {
                $this->_Nos[$Value['order_v']] = 1; // 初始化序列号
            }
            if ($this->_Flag[$Value['order_v']] === false) { // 左列
                $this->_Tmp[$Value['order_v']] = array(
                    'one_no' => $this->_Nos[$Value['order_v']]++,
                    'one_order_product_num' => $Value['order_product_num'],
                    'one_product' => $Value['product'],
                    'one_thick' => isset($PackDetail['thick']) && $PackDetail['thick'] > 0 ? $PackDetail['thick'] : 0,
                    'one_thin' => isset($PackDetail['thin']) && $PackDetail['thin'] > 0 ? $PackDetail['thin'] : 0,
                    'one_pack' => $Pack
                );
                $this->_Flag[$Value['order_v']] = true;
            } else {  // 右列
                $this->_Tmp[$Value['order_v']] = array_merge($this->_Tmp[$Value['order_v']], array(
                    'two_no' => $this->_Nos[$Value['order_v']]++,  // 右列
                    'two_order_product_num' => $Value['order_product_num'],
                    'two_product' => $Value['product'],
                    'two_thick' => isset($PackDetail['thick']) && $PackDetail['thick'] > 0 ? $PackDetail['thick'] : 0,
                    'two_thin' => isset($PackDetail['thin']) && $PackDetail['thin'] > 0 ? $PackDetail['thin'] : 0,
                    'two_pack' => $Pack
                ));
                array_push($this->_Tables[$Value['order_v']]['trs'], $this->_Tmp[$Value['order_v']]);
                unset($this->_Tmp[$Value['order_v']]);
                $this->_Flag[$Value['order_v']] = false;
            }
        }
    }

    private function _two_column ($Query) {
        $Data = array();
        $Nos = array();
        $Flag = array();
        $Scanned = 0;
        $Pack = 0;
        $Tmp = array();
        $Tables = array();
        $Page = 1;
        foreach ($Query as $Key => $Value) {
            $Scanned += $Value['scanned'];
            $Pack += $Value['order_product_pack'];
            if('物流代收' == $Value['payed']){
                $Payed = $Value['sum'];
            }else{
                $Payed = 0;
            }
            if (!isset($Tables[$Value['order_v']])) {
                $Tables[$Value['order_v']] = array(
                    'p' => $Page++,
                    'dealer' => $Value['dealer'],
                    'delivery_area' => $Value['delivery_area'],
                    'delivery_address' => $Value['delivery_address'],
                    'delivery_linker' => $Value['delivery_linker'],
                    'delivery_phone' => $Value['delivery_phone'],
                    'logistics' => $Value['logistics'],
                    'owner' => $Value['owner'],
                    'end_datetime' => $this->_StockOutted['end_datetime'],
                    'truck' => $this->_StockOutted['truck'],
                    'train' => $this->_StockOutted['train'],
                    'pack' => $Value['pack'],
                    'page_pack' => $Value['order_product_pack'],
                    'collection' => $Value['collection'],
                    'page_collection' => $Payed,
                    'remark' => $this->_StockOutted['remark'],
                    'trs' => array()
                );
                $Flag[$Value['order_v']] = false;
            } else {
                $Tables[$Value['order_v']]['page_pack'] += $Value['order_product_pack'];
            }
            $PackDetail = json_decode($Value['pack_detail'], true);
            if (!isset($Nos[$Value['order_v']])) {
                $Nos[$Value['order_v']] = 1;
            }
            if ($Flag[$Value['order_v']] === false) {
                $Tmp[$Value['order_v']] = array(
                    'one_no' => $Nos[$Value['order_v']]++,
                    'one_order_product_num' => $Value['order_product_num'],
                    'one_product' => $Value['product'],
                    'one_thick' => isset($PackDetail['thick']) && $PackDetail['thick'] > 0 ? $PackDetail['thick'] : 0,
                    'one_thin' => isset($PackDetail['thin']) && $PackDetail['thin'] > 0 ? $PackDetail['thin'] : 0,
                    'one_pack' => $Value['order_product_pack']
                );
                $Flag[$Value['order_v']] = true;
            } else {
                $Tmp[$Value['order_v']] = array_merge($Tmp[$Value['order_v']], array(
                    'two_no' => $Nos[$Value['order_v']]++,  // 右列
                    'two_order_product_num' => $Value['order_product_num'],
                    'two_product' => $Value['product'],
                    'two_thick' => isset($PackDetail['thick']) && $PackDetail['thick'] > 0 ? $PackDetail['thick'] : 0,
                    'two_thin' => isset($PackDetail['thin']) && $PackDetail['thin'] > 0 ? $PackDetail['thin'] : 0,
                    'two_pack' => $Value['order_product_pack']
                ));
                array_push($Tables[$Value['order_v']]['trs'], $Tmp[$Value['order_v']]);
                unset($Tmp[$Value['order_v']]);
                $Flag[$Value['order_v']] = false;
            }
        }
        if (!empty($Tmp)) {
            foreach ($Tmp as $Key => $Value) {
                array_push($Tables[$Key]['trs'], $Value);
            }
        }
        $Spliceds = array();
        foreach ($Tables as $Key => $Value) {
            $Spliced = array_chunk($Value['trs'], $this->_MaxLineNum);
            if (count($Spliced) > 1) {
                foreach ($Spliced as $Ikey => $Ivalue) {
                    $Value['trs'] = $Ivalue;
                    $Spliceds[] = $Value;
                }
            } else {
                $Spliceds[] = $Value;
            }
        }
        $Data['tables'] = $Spliceds;
        $Data['scanned'] = $Scanned;
        $Data['pack'] = $Pack;
        $Data['num'] = count($Spliceds);
        if ($Scanned < $Pack) {
            $Data['message'] = '请注意: 扫描件数是' . $Scanned . '，发货件数是' . $Pack;
        }
        return $Data;
    }
    private function _one_column ($Query) {
        $Data = array();
        $Nos = array();
        // $Flag = array();
        $Scanned = 0;
        $Pack = 0;
        $Tables = array();
        $Page = 1;
        foreach ($Query as $Key => $Value) {
            $Scanned += $Value['scanned'];
            $Pack += $Value['order_product_pack'];
            if('物流代收' == $Value['payed']){
                $Payed = $Value['sum'];
            }else{
                $Payed = 0;
            }
            if (!isset($Tables[$Value['order_v']])) {
                $Tables[$Value['order_v']] = array(
                    'p' => $Page++,
                    'dealer' => $Value['dealer'],
                    'delivery_area' => $Value['delivery_area'],
                    'delivery_address' => $Value['delivery_address'],
                    'delivery_linker' => $Value['delivery_linker'],
                    'delivery_phone' => $Value['delivery_phone'],
                    'logistics' => $Value['logistics'],
                    'owner' => $Value['owner'],
                    'end_datetime' => $Value['end_datetime'],
                    'truck' => $Value['truck'],
                    'train' => $Value['train'],
                    'pack' => $Value['pack'],
                    'page_pack' => $Value['order_product_pack'],
                    'collection' => $Value['collection'],
                    'page_collection' => $Payed,
                    'trs' => array()
                );
                // $Flag[$Value['order_v']] = false;
            } else {
                $Tables[$Value['order_v']]['page_pack'] += $Value['order_product_pack'];
            }
            $PackDetail = json_decode($Value['pack_detail'], true);
            if (!isset($Nos[$Value['order_v']])) {
                $Nos[$Value['order_v']] = 1;
            }

            array_push($Tables[$Value['order_v']]['trs'], array(
                'one_no' => $Nos[$Value['order_v']]++,
                'one_order_product_num' => $Value['order_product_num'],
                'one_product' => $Value['product'],
                'one_thick' => isset($PackDetail['thick']) && $PackDetail['thick'] > 0 ? $PackDetail['thick'] : 0,
                'one_thin' => isset($PackDetail['thin']) && $PackDetail['thin'] > 0 ? $PackDetail['thin'] : 0,
                'one_pack' => $Value['order_product_pack']
            ));
            /*if ($Flag[$Value['order_v']] === false) {
                $Tmp[$Value['order_v']] = array(
                    'one_no' => $Nos[$Value['order_v']]++,
                    'one_order_product_num' => $Value['order_product_num'],
                    'one_product' => $Value['product'],
                    'one_thick' => isset($PackDetail['thick']) && $PackDetail['thick'] > 0 ? $PackDetail['thick'] : 0,
                    'one_thin' => isset($PackDetail['thin']) && $PackDetail['thin'] > 0 ? $PackDetail['thin'] : 0,
                    'one_pack' => $Value['order_product_pack']
                );
                $Flag[$Value['order_v']] = true;
            } else {
                $Tmp[$Value['order_v']] = array_merge($Tmp[$Value['order_v']], array(
                    'two_no' => $Nos[$Value['order_v']]++,  // 右列
                    'two_order_product_num' => $Value['order_product_num'],
                    'two_product' => $Value['product'],
                    'two_thick' => isset($PackDetail['thick']) && $PackDetail['thick'] > 0 ? $PackDetail['thick'] : 0,
                    'two_thin' => isset($PackDetail['thin']) && $PackDetail['thin'] > 0 ? $PackDetail['thin'] : 0,
                    'two_pack' => $Value['order_product_pack']
                ));
                array_push($Tables[$Value['order_v']]['trs'], $Tmp[$Value['order_v']]);
                unset($Tmp[$Value['order_v']]);
                $Flag[$Value['order_v']] = false;
            }*/
        }
        /*if (!empty($Tmp)) {
            foreach ($Tmp as $Key => $Value) {
                array_push($Tables[$Key]['trs'], $Value);
            }
        }*/
        $Spliceds = array();
        foreach ($Tables as $Key => $Value) {
            $Spliced = array_chunk($Value['trs'], $this->_MaxLineNum);
            if (count($Spliced) > 1) {
                foreach ($Spliced as $Ikey => $Ivalue) {
                    $Value['trs'] = $Ivalue;
                    $Spliceds[] = $Value;
                }
            } else {
                $Spliceds[] = $Value;
            }
        }
        $Data['tables'] = $Spliceds;
        $Data['scanned'] = $Scanned;
        $Data['pack'] = $Pack;
        $Data['column'] = 1; // 单列显示
        $Data['num'] = count($Spliceds);
        if ($Scanned < $Pack) {
            $Data['message'] = '请注意: 扫描件数是' . $Scanned . '，发货件数是' . $Pack;
        }
        return $Data;
    }

    /**
     *
     * @return void
     */
    public function add() {
        if ($this->_do_form_validation()) {
            $Post = gh_escape($_POST);
            if(!!($NewId = $this->print_task_model->insert($Post))) {
                $this->Message = '新建成功, 刷新后生效!';
            }else{
                $this->Message = isset($GLOBALS['error'])?is_array($GLOBALS['error'])?implode(',', $GLOBALS['error']):$GLOBALS['error']:'新建失败!';
                $this->Code = EXIT_ERROR;
            }
        }
        $this->_ajax_return();
    }

    /**
    *
    * @return void
    */
    public function edit() {
        if ($this->_do_form_validation()) {
            $Post = gh_escape($_POST);
            $Where = $Post['v'];
            unset($Post['v']);
            if(!!($this->print_task_model->update($Post, $Where))){
                $this->Message = '内容修改成功, 刷新后生效!';
            }else{
                $this->Code = EXIT_ERROR;
                $this->Message = isset($GLOBALS['error'])?is_array($GLOBALS['error'])?implode(',', $GLOBALS['error']):$GLOBALS['error']:'内容修改失败';
            }
        }
        $this->_ajax_return();
    }

    /**
     *
     * @param  int $id
     * @return void
     */
    public function remove() {
        $V = $this->input->post('v');
        if (!is_array($V)) {
            $_POST['v'] = explode(',', $V);
        }
        if ($this->_do_form_validation()) {
            $Where = $this->input->post('v', true);
            if ($this->print_task_model->delete($Where)) {
                $this->Message = '删除成功，刷新后生效!';
            } else {
                $this->Code = EXIT_ERROR;
                $this->Message = isset($GLOBALS['error'])?is_array($GLOBALS['error'])?implode(',', $GLOBALS['error']):$GLOBALS['error']:'删除失败!';
            }
        }
        $this->_ajax_return();
    }
}
