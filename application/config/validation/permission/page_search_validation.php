<?php defined('BASEPATH') OR exit('No direct script access allowed');

$config['permission/page_search/add'] = array(
	array(
		'field' => 'name',
		'label' => '名称',
		'rules' => 'trim|required|min_length[1]|max_length[64]'
	),
	array(
		'field' => 'label',
		'label' => 'Label',
		'rules' => 'trim|max_length[64]'
	),
	array(
		'field' => 'type_V',
		'label' => '类型',
		'rules' => 'trim|max_length[32]'
	),
    array(
        'field' => 'form_type_V',
        'label' => '类型',
        'rules' => 'trim|max_length[32]'
    ),
	array(
		'field' => 'url',
		'label' => 'Url',
		'rules' => 'trim|max_length[128]'
	),
	array(
		'field' => 'menu_v',
		'label' => '菜单V',
		'rules' => 'trim|required|numeric|min_length[1]|max_length[4]'
	),
    array(
        'field' => 'dv',
        'label' => '默认值',
        'rules' => 'trim|min_length[1]|max_length[128]'
    ),
    array(
        'field' => 'placeholder',
        'label' => 'Placeholder',
        'rules' => 'trim|min_length[1]|max_length[64]'
    ),
    array(
        'field' => 'classes',
        'label' => '样式',
        'rules' => 'trim|numeric|min_length[1]|max_length[1]'
    ),
    array(
        'field' => 'classes',
        'label' => '样式',
        'rules' => 'trim|min_length[1]|max_length[64]'
    ),
    array(
        'field' => 'readonly_v',
        'label' => '样式',
        'rules' => 'trim|numeric|min_length[1]|max_length[1]'
    ),
    array(
        'field' => 'required_v',
        'label' => '样式',
        'rules' => 'trim|numeric|min_length[1]|max_length[1]'
    ),
	array(
        'field' => 'multiple_v',
        'label' => '多谢',
        'rules' => 'trim|numeric|min_length[1]|max_length[4]'
    ),
    array(
        'field' => 'max',
        'label' => '最大',
        'rules' => 'trim|min_length[1]|max_length[32]'
    ),
    array(
        'field' => 'min',
        'label' => '最小',
        'rules' => 'trim|min_length[1]|max_length[32]'
    ),
    array(
        'field' => 'maxlength',
        'label' => '最长',
        'rules' => 'trim|numeric|min_length[1]|max_length[10]'
    ),
    array(
        'field' => 'pattern',
        'label' => '正则',
        'rules' => 'trim|min_length[1]|max_length[128]'
    ),
    array(
        'field' => 'ide',
        'label' => 'ID',
        'rules' => 'trim|min_length[1]|max_length[64]'
    )
);

$config['permission/page_search/edit'] = array(
	array(
		'field' => 'v',
		'label' => '页面搜索编号',
		'rules' => 'trim|required|numeric|min_length[1]|max_length[4]'
	),
    array(
        'field' => 'name',
        'label' => '名称',
        'rules' => 'trim|required|min_length[1]|max_length[64]'
    ),
    array(
        'field' => 'label',
        'label' => 'Label',
        'rules' => 'trim|max_length[64]'
    ),
    array(
        'field' => 'type_V',
        'label' => '类型',
        'rules' => 'trim|max_length[32]'
    ),
    array(
        'field' => 'form_type_V',
        'label' => '类型',
        'rules' => 'trim|max_length[32]'
    ),
    array(
        'field' => 'url',
        'label' => 'Url',
        'rules' => 'trim|max_length[128]'
    ),
    array(
        'field' => 'dv',
        'label' => '默认值',
        'rules' => 'trim|min_length[1]|max_length[128]'
    ),
    array(
        'field' => 'placeholder',
        'label' => 'Placeholder',
        'rules' => 'trim|min_length[1]|max_length[64]'
    ),
    array(
        'field' => 'classes',
        'label' => '样式',
        'rules' => 'trim|numeric|min_length[1]|max_length[1]'
    ),
    array(
        'field' => 'classes',
        'label' => '样式',
        'rules' => 'trim|min_length[1]|max_length[64]'
    ),
    array(
        'field' => 'readonly_v',
        'label' => '样式',
        'rules' => 'trim|numeric|min_length[1]|max_length[1]'
    ),
    array(
        'field' => 'required_v',
        'label' => '样式',
        'rules' => 'trim|numeric|min_length[1]|max_length[1]'
    ),
    array(
        'field' => 'multiple_v',
        'label' => '功能',
        'rules' => 'trim|numeric|min_length[1]|max_length[4]'
    ),
    array(
        'field' => 'max',
        'label' => '最大',
        'rules' => 'trim|min_length[1]|max_length[32]'
    ),
    array(
        'field' => 'min',
        'label' => '最小',
        'rules' => 'trim|min_length[1]|max_length[32]'
    ),
    array(
        'field' => 'maxlength',
        'label' => '最长',
        'rules' => 'trim|numeric|min_length[1]|max_length[10]'
    ),
    array(
        'field' => 'pattern',
        'label' => '正则',
        'rules' => 'trim|min_length[1]|max_length[128]'
    ),
    array(
        'field' => 'ide',
        'label' => 'ID',
        'rules' => 'trim|min_length[1]|max_length[64]'
    )
);

$config['permission/page_search/remove'] = array(
	array(
		'field' => 'v[]',
		'label' => '页面搜索编号',
		'rules' => 'trim|required|numeric|min_length[1]|max_length[4]'
	)
);
