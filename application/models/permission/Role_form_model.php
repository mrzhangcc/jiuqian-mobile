<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * Created for jiuqian-desk.
 * User: chuangchuangzhang
 * Date: 2018/2/12
 * Time: 12:30
 *
 * Desc:
 */
class Role_form_model extends MY_Model {
    public function __construct() {
        parent::__construct(__DIR__, __CLASS__);

        log_message('debug', 'Model permission/Role_form_model Start!');
    }

    public function select_by_rid($Rid) {
        $Item = $this->_Item.__FUNCTION__;
        $Cache = $this->_Cache.__FUNCTION__;
        $Return = false;
        if(!($Return = $this->cache->get($Cache))){
            $Sql = $this->_unformat_as($Item);
            $Query = $this->HostDb->select($Sql)->from('role_form')
                        ->where('rf_role_id', $Rid)
                        ->get();
            if($Query->num_rows() > 0){
                $Return = $Query->result_array();
                $this->cache->save($Cache, $Return, MONTHS);
            }
        }
        return $Return;
    }

    public function select_by_usergroup_v($V) {
        $Item = $this->_Item . __FUNCTION__;
        $Cache = $this->_Cache . __FUNCTION__ . $V;
        $Return = false;
        if (!($Return = $this->cache->get($Cache))) {
            $Sql = $this->_unformat_as($Item);
            $Query = $this->HostDb->select($Sql)->from('role_form')
                ->join('form AS FORM', 'FORM.f_id = rf_form_id', 'left')
                ->join('func AS FUNC', 'FUNC.f_id = FORM.f_func_id', 'left')
                ->join('menu', 'm_id = FUNC.f_menu_id', 'left')
                ->join('role', 'r_id = rf_role_id', 'left')
                ->join('usergroup_role', 'ur_role_id = r_id', 'left')
                ->where('ur_usergroup_id', $V)
                ->order_by('m_displayorder')
                ->group_by('FORM.f_id')->get();
            if ($Query->num_rows() > 0) {
                $Return = $Query->result_array();
                $this->cache->save($Cache, $Return, MONTHS);
            } else {
                $GLOBALS['error'] = '没有符合搜索条件的角色表单';
            }
        }
        return $Return;
    }

    public function select_by_role_v($V) {
        $Item = $this->_Item . __FUNCTION__;
        $Cache = $this->_Cache . __FUNCTION__ . $V;
        $Return = false;
        if (!($Return = $this->cache->get($Cache))) {
            $FuncVs = $this->HostDb->select('rf_func_id')->from('role_func') // Func
                            ->where('rf_role_id', $V)->get_compiled_select();

            $RoleForm = $this->HostDb->select('rf_id, rf_form_id')->from('role_form') // RoleForm
                            ->where('rf_role_id', $V)->get_compiled_select();
            $Sql = $this->_unformat_as($Item);
            $Query = $this->HostDb->select($Sql)->from('form AS FORM')
                ->join('func AS FUNC', 'FUNC.f_id = FORM.f_func_id', 'left')
                ->join('menu', 'm_id = FUNC.f_menu_id', 'left')
                ->join('(' . $RoleForm . ') as A', 'A.rf_form_id = FORM.f_id', 'left')
                ->where_in('FUNC.f_id', $FuncVs, false)
                ->order_by('m_displayorder')
                ->order_by('FUNC.f_id')
                ->get();

            /*$Sql = $this->_unformat_as($Item);
            $Query = $this->HostDb->select($Sql)->from('role_form')
                ->join('form', 'f_id = rf_form_id', 'left')
                ->where('rf_role_id', $V)
                ->group_by('f_id')->get();*/
            if ($Query->num_rows() > 0) {
                $Return = $Query->result_array();
                $this->cache->save($Cache, $Return, MONTHS);
            } else {
                $GLOBALS['error'] = '没有符合搜索条件的表单';
            }
        }
        return $Return;
    }
    
    public function insert($Data) {
        $Item = $this->_Item.__FUNCTION__;
        $Data = $this->_format($Data, $Item);
        if($this->HostDb->insert('role_form', $Data)){
            log_message('debug', "Model Role_form_model/insert_role_form Success!");
            $this->remove_cache('menu');
            return $this->HostDb->insert_id();
        }else{
            log_message('debug', "Model Role_form_model/insert_role_form Error");
            return false;
        }
    }

    public function insert_batch($Data) {
        $Item = $this->_Item.__FUNCTION__;
        foreach ($Data as $key => $value){
            $Data[$key] = $this->_format($value, $Item);
        }
        if($this->HostDb->insert_batch('role_form', $Data)){
            log_message('debug', "Model Role_form_model/insert_batch Success!");
            $this->remove_cache($this->_Module);
            return true;
        }else{
            log_message('debug', "Model Role_form_model/insert_batch Error");
            return false;
        }
    }

    /**
     * 删除功能时同时删除相应的角色权限
     * @param $Mid
     * @return bool
     */
    public function delete_by_form_v($Mid){
        if(is_array($Mid)){
            $this->HostDb->where_in('rf_form_id', $Mid);
        }else{
            $this->HostDb->where('rf_form_id', $Mid);
        }
        $this->HostDb->delete('role_form');
        $this->remove_cache($this->_Module);
        return true;
    }

    /**
     * 删除角色时同时删除相关联的功能权限
     * @param $Rid
     * @return boolean
     */
    public function delete_by_role_v($Rid) {
        if(is_array($Rid)){
            $this->HostDb->where_in('rf_role_id', $Rid);
        }else{
            $this->HostDb->where('rf_role_id', $Rid);
        }
        $this->HostDb->delete('role_form');
        $this->remove_cache($this->_Module);
        return true;
    }
}
