<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * 2016年3月16日
 * @author Administrator
 * @version
 * @des
 * 打包
 */
class Pack_statistic extends MY_Controller{
    private $__Search = array(
        'pack' => 0,
        'start_date' => '',
        'end_date' => '',
        'status' => WP_PACKED,
        'paging' => NO
    );
    public function __construct() {
        parent::__construct();
        log_message('debug', 'Controller order/Ppack_statistic __construct Start!');
        $this->load->model('order/pack_model');
    }

    public function read(){
        $this->_Search = array_merge($this->_Search, $this->__Search);
        $this->get_page_search();
        if (empty($this->_Search['pack'])) {
            if ($this->_is_pack_group()) {
                $this->_Search['pack'] = $this->session->userdata('uid');
            }
        }
        if ($this->_Search['start_date'] == '') {
            $this->_Search['start_date'] = date('Y-m-01');
        }
        if ($this->_Search['pack'] == WP_PACK) {
            $this->_Search['start_date'] = '';
            $this->_Search['end_date'] = '';
        }
        $Data = array();
        if(!($Data = $this->pack_model->select($this->_Search))) {
            $this->Message = isset($GLOBALS['error'])?is_array($GLOBALS['error'])?implode(',', $GLOBALS['error']):$GLOBALS['error']:'读取信息失败';
            $this->Code = EXIT_ERROR;
        } else {
            $X = array();
            $BOrderProductNum = array();
            $BArea = 0;
            $BAmount = 0;
            foreach ($Data['content'] as $Key => $Value) {
                if ($Value['order_type'] == 'X') {
                    if (!isset($X[$Value['product']])) {
                        $X[$Value['product']] = array(
                            'num' => array(),
                            'area' => 0,
                            'amount' => 0
                        );
                    }
                    $X[$Value['product']]['area'] += $Value['area'];
                    if (!in_array($Value['num'], $X[$Value['product']]['num'])) {
                        array_push($X[$Value['product']]['num'], $Value['num']);
                        $X[$Value['product']]['amount']++;
                        if ($X[$Value['product']]['amount'] % 5 == 0) {
                            array_push($X[$Value['product']]['num'], '<br />');
                        }
                    }
                } elseif ($Value['order_type'] == 'B') {
                    $BArea += $Value['area'];
                    if (!in_array($Value['num'], $BOrderProductNum)) {
                        array_push($BOrderProductNum, $Value['num']);
                        $BAmount++;
                        if ($BAmount % 5 == 0) {
                            array_push($BOrderProductNum, '<br />');
                        }
                    }
                }
            }
            $Data['content'] = array();
            if (count($X) > 0) {
                foreach ($X as $Key => $Value) {
                    array_push($Data['content'], array(
                        'label' => $Key . '正常单',
                        'name' => implode(',', $Value['num']),
                        'area' => $Value['area'],
                        'amount' => $Value['amount']
                    ));
                }
            }
            if (count($BOrderProductNum) > 0) {
                array_push($Data['content'], array(
                    'label' => '补单',
                    'name' => implode(',', $BOrderProductNum),
                    'area' => $BArea,
                    'amount' => $BAmount
                ));
            }
            $Data['num'] = count($Data['content']);
            $Data['p'] = ONE;
            $Data['pn'] = ONE;
            $Data['pagesize'] =ALL_PAGESIZE;
        }
        $this->_return($Data);
    }

    private function _is_pack_group () {
        $this->load->model('permission/usergroup_model');
        if (!!($UsergroupV = $this->usergroup_model->select_usergroup_id('打包'))) {
            return $this->session->userdata('ugid') == $UsergroupV;
        }
        return false;
    }
}
