<?php defined('BASEPATH') OR exit('No direct script access allowed');

$config['permission/role_page_search_model/select_by_rid'] = array(
	'rps_page_search_id' => 'page_search_v',
);

$config['permission/role_page_search_model/select_by_usergroup_v'] = array(
    'ps_id' => 'v',
    'ps_label' => 'label',
    'm_label' => 'menu_label'
);

$config['permission/role_page_search_model/select_by_role_v'] = array(
    'ps_id' => 'v',
    'ps_label' => 'label',
    'm_label' => 'menu_label',
    'if(A.rps_id is not null && A.rps_id > 0, 1, 0)' => 'checked'
);