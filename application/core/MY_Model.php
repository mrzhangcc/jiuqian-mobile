<?php
/**
 *  2014-9-22
 * @author ZhangCC
 * @version
 * @description  
 */

class MY_Model extends CI_Model
{
    public $HostDb;
    // public $X;

    protected $_Module;
    protected $_Model;
    protected $_Item;
    protected $_DbviewFile;
    protected $_DbtableFile;
    protected $_Cache;

    protected $_Element;

	public function __construct($Module = '', $Model = '') {
		parent::__construct();
		log_message('debug', 'Model My_Model Start');

        $this->_Module = $Module;
        $this->_Model = $Model;
        $this->_init();

		$this->load->driver('cache', array('adapter' => 'apc', 'backup' => 'file')); /* 开启缓存 */
	}

    private function _init() {
	    $this->HostDb = $this->db;
        // $this->X = $this->load->database('x', true);

        $this->_Module = str_replace("\\", "/", $this->_Module);
        $this->_Module = substr($this->_Module, strrpos($this->_Module, '/')+1);
        $this->_Model = strtolower($this->_Model);
        $this->_Item = $this->_Module.'/'.$this->_Model.'/';

        $_Model = explode('_', $this->_Model);
        array_pop($_Model);
        $_Model = implode('_', $_Model);

        $this->_DbviewFile = 'dbview/' . $this->_Module . '/' . $_Model . '_dbview';
        $this->_DbtableFile = 'dbtable/' . $this->_Module . '/' . $_Model . '_dbtable';
        $this->_Cache = str_replace('/', '_', $this->_Item);
    }

    /**
     * METHOD 设置可显示元素
     * @param $E
     */
    public function set_element($E) {
        $this->_Element = $E;
    }

	public function remove_cache($File, $Reg = true){
	    $this->load->helper('file');
	    if($Reg){
	        delete_cache_files('(.*'.$File.'.*)');
	    }else{
	        delete_cache_files($File);
	    }
	}
	
	protected function _unformat_as($Item, $File = ''){
        $this->config->load($this->_DbviewFile);
        $Dbview = $this->config->item($Item);
        $Return = array();
        if (isset($this->_Element) && is_array($this->_Element) && count($this->_Element) > 0) {
            $Dbview = array_filter($Dbview, function($val) {
                return in_array($val, $this->_Element);
            });
        }
        if (is_array($Dbview) && count($Dbview) > 0) {
            foreach ($Dbview as $key => $value){
                if (is_array($value)) {
                    foreach ($value as $ivalue) {
                        $Return[] = $key.' as '.$ivalue;
                    }
                } else {
                    $Return[] = $key.' as '.$value;
                }
            }
        } else {
            log_message('ERROR', $Item . 'is not exist');
        }

        return implode(',', $Return);
	}

	protected function _unformat($Data, $Item){
	    $this->config->load($this->_DbviewFile);
	    $Dbview = $this->config->item($Item);
	    $Return = array();
	    foreach ($Data as $key => $value){
	        foreach ($Dbview as $ikey=>$ivalue){
	            $Return[$key][$ivalue] = isset($value[$ikey])?$value[$ikey]:'';
	        }
	    }
	    return $Return;
	}
	
	protected function _format($Data, $Item){
	    $this->config->load($this->_DbtableFile);
	    $FormView = $this->config->item($Item);
	    if (!(is_array($FormView) && count($FormView) > 0)) {
	        $FormView = $this->config->item(trim($this->_Item,'/'));
        }
        $Set = array();
	    if (is_array($FormView) && count($FormView) > 0) {
            foreach ($FormView as $key=>$value){
                if(isset($Data[$key])){
                    if(is_array($Data[$key])){
                        $Set[$value] = implode(',', $Data[$key]);
                    }else{
                        $Set[$value] = $Data[$key];
                    }
                }elseif(array_key_exists($key, $Data) && is_null($Data[$key])){
                    $Set[$value] = $this->_default($key, null);
                }else{
                    $Set[$value] = $this->_default($key);
                }
            }
        }
	    return $Set;
	}
	
	/**
	 * 通过Data来格式化数据
	 * @param array $Data
	 * @param string $Item
	 * @param string $File
	 */
	protected function _format_re($Data, $Item, $File = ''){
	    $this->config->load($this->_DbtableFile);
	    $FormView = $this->config->item($Item);
	    foreach ($Data as $key => $value){
	        if(is_array($value)){
	            $value = implode(',', $value);
	        }
	        if(isset($FormView[$key])){
	            $Set[$FormView[$key]] = $value;
	        }
	    }
	    return $Set;
	}
	
	protected function _default($name, $tmp=''){
	    switch ($name){
	        case 'creator':
	            $Return = isset($GLOBALS['creator']) ? $GLOBALS['creator'] : $this->session->userdata('uid');
	            break;
	        case 'create_datetime':
	            $Return = date('Y-m-d H:i:s');
	            break;
            case 'timestamp':
                list($U, $S) = explode(' ', microtime());
                $Return = number_format($S + $U, TEN, '.', '');
                break;
	        default:
	            $Return = $tmp;
	    }
	    return $Return;
	}

	public function trans_start () {
        $this->HostDb->trans_start();
    }
    public function trans_begin () {
	    $this->HostDb->trans_begin();
    }
    public function trans_complete () {
        $this->HostDb->trans_complete();
    }
    public function trans_status () {
	    return $this->HostDb->trans_status();
    }
    public function trans_commit () {
	    $this->HostDb->trans_commit();
    }
    public function trans_rollback () {
	    $this->HostDb->trans_rollback();
    }
}//end Base_Model
