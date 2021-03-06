<?php defined('BASEPATH') OR exit('No direct script access allowed');

$config['order/scan/edit'] = array(
	array(
		'field' => 'v[]',
		'label' => '选择项',
		'rules' => 'trim|required|numeric|min_length[1]|max_length[10]'
	)
);
$config['order/scan/correct'] = array(
    array(
        'field' => 'v[]',
        'label' => '选择项',
        'rules' => 'trim|required|numeric|min_length[1]|max_length[10]'
    ),
    array(
        'field' => 'type',
        'label' => '类型',
        'rules' => 'trim|required|numeric|min_length[1]'
    ),
    array(
        'field' => 'scan',
        'label' => '扫描人',
        'rules' => 'trim|required|numeric|min_length[1]|max_length[10]'
    )
);
