<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * Created for jiuqian.
 * User => chuangchuangzhang
 * Date => 2018/2/3
 * Time => 09 =>06
 *
 * Desc =>
 */
class Navbars extends CI_Controller {
    function __construct() {
        parent::__construct();
    }
    
    public function index() {
        $data = array(
            array(
                'id' => 'Home',
                'name' => '首页',
                'href' => '/home',
                'font' => 'fa fa-home',
                'size' => 'fa-2x',
                'show' => true,
                'component' => 'navbar-item'
            ),
            array(
                'id' => 'Apps',
                'name' => '应用',
                'href' => '/apps',
                'font' => 'fa fa-th',
                'size' => 'fa-2x',
                'show' => true,
                'active' => false,
                'component' => 'navbar-item'
            ),
            array(
                'id' => 'App',
                'name' => '',
                'font' => 'fa fa-folder',
                'size' => 'fa-2x',
                'href' => '/app',
                'show' => false,
                'funcs' => [],
                'component' => 'navbar-dropdown'
            ),
            array(
                'id' => 'Myself',
                'name' => '我的',
                'href' => '/myself',
                'font' => 'fa fa-user',
                'size' => 'fa-2x',
                'show' => true,
                'component' => 'navbar-item'
            )
        );
        /*$this->output->set_header('Access-Control-Allow-Origin: *');
        $this->output->set_header('Access-Control-Allow-Methods: GET');*/
        header("Access-Control-Allow-Origin: *");
        exit(json_encode($data));
    }
}
