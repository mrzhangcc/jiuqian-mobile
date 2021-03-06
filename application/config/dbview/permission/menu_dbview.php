<?php defined('BASEPATH') OR exit('No direct script access allowed');

$config['permission/menu_model/select_allowed_by_ugid'] = array(
	'm_id' => 'v',
	'm_name' => 'name',
	'm_label' => 'label',
	'm_class' => 'class',
	'm_parent' => 'parent',
	'm_url' => 'url',
	'm_displayorder' => 'displayorder',
	'm_img' => 'img',
	'm_mobile' => 'mobile_v',
	'MOBILE.bt_name' => 'mobile_name',
    'm_invisible' => 'invisible_v',
    'INVISIBLE.bt_name' => 'invisible_name',
    'pt_name' => array(
        'page_type_name',
        'page_type_v'
    ),
    'm_home' => 'home'
);

$config['permission/menu_model/select_by_usergroup_v'] = array(
    'm_id' => 'v',
    'm_name' => 'name',
    'm_label' => 'label',
    'm_class' => 'class',
    'm_parent' => 'parent',
    'm_url' => 'url',
    'm_displayorder' => 'displayorder',
    'm_img' => 'img',
    'm_mobile' => 'mobile_v',
    'MOBILE.bt_name' => 'mobile_name',
    'm_invisible' => 'invisible_v',
    'INVISIBLE.bt_name' => 'invisible_name',
    'pt_name' => array(
        'page_type_name',
        'page_type_v'
    ),
    'm_home' => 'home'
);
$config['permission/menu_model/select_by_uid'] = array(
	'm_id' => 'v',
	'm_name' => 'name',
	'm_label' => 'label',
	'm_class' => 'class',
	'm_parent' => 'parent',
	'm_url' => 'url',
	'm_displayorder' => 'displayorder',
	'm_img' => 'img',
	'm_page_type' => 'page_type',
	'm_mobile' => 'mobile',
    'm_invisible' => 'invisible',
    'm_home' => 'home'
);
$config['permission/menu_model/select_menu'] = array(
	'm_id' => 'v',
	'm_name' => 'name',
	'm_label' => 'label',
	'm_class' => 'class',
	'm_parent' => 'parent',
	'm_url' => 'url',
	'm_displayorder' => 'displayorder',
	'm_img' => 'img',
	'm_page_type' => 'page_type',
	'm_mobile' => 'mobile',
    'm_invisible' => 'invisible',
    'm_home' => 'home'
);
$config['permission/menu_model/select_is_allowed_operation'] = array(
	'm_id' => 'menu_v',
);

$config['permission/menu_model/is_exist'] = array(
    'm_id' => 'v',
    'm_name' => 'name',
    'm_class' => 'class',
    'm_parent' => 'parent'
);