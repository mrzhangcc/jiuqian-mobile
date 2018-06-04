<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 *  2015-4-23
 * @author ZhangCC
 * @version
 * @description  
 */
class User extends MY_Controller{
    private $__Search = array(
        'paging' => 0,
        'usergroup_v' => array()
    );
	public function __construct(){
		parent::__construct();
        log_message('debug', 'Controller Manage/User Start!');
		$this->load->model('manage/user_model');
        $this->load->model('permission/usergroup_model');
	}
	
	public function index(){
        $View = $this->uri->segment(4, 'read');
        if(method_exists(__CLASS__, '_'.$View)){
            $View = '_'.$View;
            $this->$View();
        }else{
            $this->_index($View);
        }
	}
	
	public function read(){
	    $this->__Search['paging'] = 0;
	    $this->__Search['usergroup_v'] = $this->__read_child_usergroup();$this->session->userdata('ugid');
	    array_merge($this->_Search, $this->__Search);
        $this->get_page_search();
        $Data = array();
        if(!($Data = $this->user_model->select($this->_Search))){
            // $Content = $Data['content'];
            $TmpSource = array();
            $TmpDes = array();
            foreach ($Data['content'] as $key => $value){
                $TmpSource[$value['uid']] = $value;
                $Child[$value['parent']][] = array('ugid' => $value['ugid'], 'uid' => $value['uid']);
            }
            ksort($Child);
            $Child = $this->_infinity_category($Child);
            $Child = array_unique($Child);

            while(list($key, $value) = each($Child)){
                $TmpDes[] = $TmpSource[$value];
            }
            $Data['content'] = $TmpDes;
            $this->Message = isset($GLOBALS['error'])?is_array($GLOBALS['error'])?implode(',', $GLOBALS['error']):$GLOBALS['error']:'读取信息失败';
            $this->Code = EXIT_ERROR;
        }
        $this->_ajax_return($Data);

        $Parent = $this->input->get('parent', true);
        $Parent = trim($Parent);
        if(preg_match('/\d{1,10}/', $Parent)){
            $Pid = $Parent;
        }elseif(is_string($Parent) && !empty($Parent)){
            $this->load->model('permission/usergroup_model');
            if(!($Pid = $this->usergroup_model->select_usergroup_id($Parent))){
                $this->Failue = '用户组不存在';
            }
        }else{
            $Pid = $this->session->userdata('ugid');
        }
        if(empty($this->Failue)){
            $Item = $this->_Item.__FUNCTION__;
            $Return = array();
            if(!!($Ugids = $this->_read_usergroup($Pid))
                && !!($Query = $this->user_model->select_by_usergroup($Ugids))){

                foreach ($Query as $key => $value){
                    $Data[$value['uid']] = $value;
                    $Child[$value['parent']][] = array('ugid' => $value['ugid'], 'uid' => $value['uid']);
                }
                ksort($Child);
                $Child = $this->_infinity_category($Child, $Pid);
                $Child = array_unique($Child);
                while(list($key, $value) = each($Child)){
                    $Return['content'][] = $Data[$value];
                }
            }else{
                $this->Failue = '没有其他用户';
            }
        }

        $this->_return($Return);
	}

    /**
     * 获取子用户组
     * @return array|bool
     */
	private function __read_child_usergroup() {
	    $Pid = $this->session->usergroup('ugid');
        if(!!($Query = $this->usergroup_model->select())){
            foreach ($Query as $key => $value){
                $Return[$value['parent']][] = $value['v'];
            }
            ksort($Return);
            $Return = gh_infinity_category($Return, $Pid);
        }else{
            $this->Failue = '没有用户组!';
            $Return = false;
        }

        return $Return;
    }
	
	public function read_all(){
	    $Data = array();
	    if(!!($Data = $this->user_model->select())){
	        $this->Success = '获取用户成功';
	    }else{
	        $this->Failue = isset($GLOBALS['error'])?is_array($GLOBALS['error'])?implode(',', $GLOBALS['error']):$GLOBALS['error']:'获取用户失败!';
	    }
	    $this->_return($Data);
	}
	private function _infinity_category($Tree, $Parent = 0){
		$Return = array();
		if(is_array($Tree) && count($Tree) > 0 && isset($Tree[$Parent])){
			foreach ($Tree[$Parent] as $key => $value){
				$Return[] = $value['uid'];
				if(isset($Tree[$value['ugid']])){
					$Tmp = $this->_infinity_category($Tree, $value['ugid']);
					$Return = array_merge($Return, $Tmp);
				}
			}
		}
		return $Return;
	}
	
	/**
	 * 读取当前可以读取的用户组
	 * @param unknown $Pid
	 */
	private function _read_usergroup($Pid){
	    $this->load->model('manage/usergroup_model');
	    if(!!($Query = $this->usergroup_model->select())){
	        foreach ($Query as $key => $value){
	            $Return[$value['parent']][] = $value['uid'];
	        }
	        ksort($Return);
	        $Return = gh_infinity_category($Return, $Pid);
	    }else{
	        $this->Failue = '没有用户组!';
	        $Return = false;
	    }
	    
	    return $Return;
	}
	
	public function add(){
		$Item = $this->_Item.__FUNCTION__;
		if($this->form_validation->run($Item)){
			$Post = gh_escape($_POST);
			if(!!($Id = $this->user_model->insert($Post))){
				$this->Success .= '用户新增成功, 刷新后生效!';
			}else{
				$this->Failue .= isset($GLOBALS['error'])?is_array($GLOBALS['error'])?implode(',', $GLOBALS['error']):$GLOBALS['error']:'用户新增失败';
			}
		}else{
			$this->Failue .= validation_errors();
		}
		$this->_return();
	}
	
	
	public function edit(){
		$Item = $this->_Item.__FUNCTION__;
		if($this->form_validation->run($Item)){
			$Post = gh_escape($_POST);
			unset($Post['selected']);
			$Password = $this->input->post('password', true);
			if(empty($Password)){
			    unset($Post['password']);
			}
			$where = $this->input->post('selected');
			if(!!($this->user_model->update($Post, $where))){
				$this->Success .= '用户信息修改成功, 刷新后生效!';
			}else{
				$this->Failue .= isset($GLOBALS['error'])?is_array($GLOBALS['error'])?implode(',', $GLOBALS['error']):$GLOBALS['error']:'用户信息修改失败&nbsp;&nbsp;';
			}
		}else{
			$this->Failue .= validation_errors();
		}
		$this->_return();
	}
	
	public function remove(){
		$Item = $this->_Item.__FUNCTION__;
		if($this->form_validation->run($Item)){
			$Where = $this->input->post('selected', true);
		    if($this->user_model->delete($Where)){
				$this->Success .= '用户信息删除成功, 刷新后生效!';
			}else {
				$this->Failue .= isset($GLOBALS['error'])?is_array($GLOBALS['error'])?implode(',', $GLOBALS['error']):$GLOBALS['error']:'用户组信息删除失败&nbsp;&nbsp;';
			}
		}else{
			$this->Failue .= validation_errors();
		}
		$this->_return();
	}
}
