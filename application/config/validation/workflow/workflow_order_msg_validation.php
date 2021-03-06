<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$config['workflow/workflow_order_msg/add'] = array(
                        array (
            'field' => 'order_id',
            'label' => '订单V',
            'rules' => 'trim|required|numeric|max_length[10]'
        ),
                                array (
            'field' => 'workflow_order_id',
            'label' => '工作流v',
            'rules' => 'trim|required|numeric|max_length[4]'
        ),
                                array (
            'field' => 'msg',
            'label' => 'Msg',
            'rules' => 'trim|required|max_length[128]'
        ),
                                array (
            'field' => 'previous',
            'label' => '前置节点',
            'rules' => 'trim|numeric|max_length[4]'
        )
            );

$config['workflow/workflow_order_msg/edit'] = array(
                    array(
            'field' => 'v',
            'label' => '编号',
            'rules' => 'trim|required|numeric|min_length[1]|max_length[10]'
        ),
                                array (
            'field' => 'order_id',
            'label' => '订单V',
            'rules' => 'trim|required|numeric|max_length[10]'
        ),
                                array (
            'field' => 'workflow_order_id',
            'label' => '工作流v',
            'rules' => 'trim|required|numeric|max_length[4]'
        ),
                                array (
            'field' => 'msg',
            'label' => 'Msg',
            'rules' => 'trim|required|max_length[128]'
        ),
                                array (
            'field' => 'previous',
            'label' => '前置节点',
            'rules' => 'trim|numeric|max_length[4]'
        )
            );

$config['workflow/workflow_order_msg/remove'] = array(
            array(
            'field' => 'v[]',
            'label' => '选择项',
            'rules' => 'trim|required|numeric|min_length[1]|max_length[10]'
        )
                    );
