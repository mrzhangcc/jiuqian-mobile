<?php defined('BASEPATH') OR exit('No direct script access allowed');
$config['order/order_product_board_plate_model/select'] = array(
    'opbp_id' => 'v',
    'opbp_qrcode' => 'qrcode',
    'opbp_cubicle_name' => 'cubicle_name',
    'opbp_cubicle_num' => 'cubicle_num',
    'opbp_plate_name' => 'plate_name',
    'opbp_plate_num' => 'plate_num',
    'opbp_width' => 'width',
    'opbp_length' => 'length',
    'opbp_thick' => 'thick',
    'opbp_up_edge' => 'up_edge',
    'opbp_down_edge' => 'down_edge',
    'opbp_left_edge' => 'left_edge',
    'opbp_right_edge' => 'right_edge',
    'opbp_amount' => 'amount',
    'opbp_area' => 'area',
    'opbp_slot' => 'slot',
    'opbp_punch' => 'punch',
    'opbp_edge' => 'edge',
    'opbp_remark' => 'remark',
    'opbp_decide_size' => 'decide_size',
    'if(opbp_abnormity = 0, "", "异")' => 'abnormity',
    'opbp_bd_file' => 'bd_file',
    'opb_board' => 'board',
    'ifnull(C.wp_label, ifnull(B.wp_label, ""))' => 'status',
    'opbp_scanner' => 'scanner',
);

$config['order/order_product_board_plate_model/is_uploaded'] = array(
	'opbp_id' => 'v',
	'opbp_order_product_board_id' => 'order_product_board_id',
	'opbp_area' => 'plate_area',
	'opb_area' => 'area'
);

$config['order/order_product_board_plate_model/select_optimize'] = array(
	'opbp_id' => 'v',
	'opbp_qrcode' => 'qrcode',
	'opbp_cubicle_name' => 'cubicle_name',
	'opbp_cubicle_num' => 'cubicle_num',
	'opbp_plate_name' => 'plate_name',
	'opbp_plate_num' => 'plate_num',
	'opbp_width' => 'width',
	'opbp_length' => 'length',
	'opbp_thick' => 'thick',
	'opbp_slot' => 'slot',
	'opbp_punch' => 'punch',
	'opbp_edge' => 'edge',
	'opbp_remark' => 'remark',
	'opbp_decide_size' => 'decide_size',
	'if(opbp_abnormity = 0, "", "异")' => 'abnormity',
	'opbp_up_edge' => 'up_edge',
	'opbp_down_edge' => 'down_edge',
	'opbp_left_edge' => 'left_edge',
	'opbp_right_edge' => 'right_edge',
	'opc_board' => 'board',
	'opc_optimize' => 'status',
	'opc_sn' => 'sn',
	'op_num' => 'order_product_num',
	'op_product' => 'product',
	'o_dealer' => 'dealers',
	'd_name' => 'dealer',
	's_name' => 'shop',
	'o_owner' => 'owner',
);
$config['order/order_product_board_plate_model/select_optimize_produce_prehandle'] = array(
	'opbp_id' => 'opbpid',
	'opbp_qrcode' => 'qrcode',
	'opbp_cubicle_name' => 'cubicle_name',
	'opbp_cubicle_num' => 'cubicle_num',
	'opbp_plate_name' => 'plate_name',
	'opbp_plate_num' => 'plate_num',
	'opbp_width' => 'width',
	'opbp_length' => 'length',
	'opbp_thick' => 'thick',
	'opbp_slot' => 'slot',
	'opbp_punch' => 'punch',
	'opbp_edge' => 'edge',
	'opbp_remark' => 'remark',
	'opbp_decide_size' => 'decide_size',
	'if(opbp_abnormity = 0, "", "异")' => 'abnormity',
	'opbp_up_edge' => 'up_edge',
	'opbp_down_edge' => 'down_edge',
	'opbp_left_edge' => 'left_edge',
	'opbp_right_edge' => 'right_edge',
	'opc_board' => 'board',
	'opc_optimize' => 'status',
	'opc_sn' => 'sn',
	'op_num' => 'order_product_num',
	'o_dealer' => 'dealers',
	'o_owner' => 'owner',
);
$config['order/order_product_board_plate_model/select_optimize_produce_prehandled'] = array(
	'opbp_id' => 'opbpid',
	'opbp_qrcode' => 'qrcode',
	'opbp_cubicle_name' => 'cubicle_name',
	'opbp_cubicle_num' => 'cubicle_num',
	'opbp_plate_name' => 'plate_name',
	'opbp_plate_num' => 'plate_num',
	'opbp_width' => 'width',
	'opbp_length' => 'length',
	'opbp_thick' => 'thick',
	'opbp_slot' => 'slot',
	'opbp_punch' => 'punch',
	'opbp_edge' => 'edge',
	'opbp_remark' => 'remark',
	'opbp_decide_size' => 'decide_size',
	'if(opbp_abnormity = 0, "", "异")' => 'abnormity',
	'opbp_up_edge' => 'up_edge',
	'opbp_down_edge' => 'down_edge',
	'opbp_left_edge' => 'left_edge',
	'opbp_right_edge' => 'right_edge',
	'opc_board' => 'board',
	'opc_optimize' => 'status',
	'opc_sn' => 'sn',
	'op_num' => 'order_product_num',
	'o_dealer' => 'dealers',
	'o_owner' => 'owner',
);
$config['order/order_product_board_plate_model/select_label'] = array(
	'opbp_qrcode' => 'qrcode',
	'opbp_cubicle_name' => 'cubicle_name',
	'opbp_plate_name' => 'plate_name',
	'opbp_width' => 'width',
	'opbp_length' => 'length',
	'opbp_slot' => 'slot',
	'opbp_punch' => 'punch',
	'opbp_edge' => 'edge',
	'opbp_remark' => 'remark',
	'opbp_decide_size' => 'decide_size',
	'opbp_up_edge' => 'up_edge',
	'opbp_down_edge' => 'down_edge',
	'opbp_left_edge' => 'left_edge',
	'opbp_right_edge' => 'right_edge',
	'opc_board' => 'board',
	'opc_optimize' => 'status',
	'opc_sn' => 'sn',
	'op_num' => 'order_product_num',
	'o_dealer' => 'dealer',
	'o_owner' => 'owner',
);
$config['order/order_product_board_plate_model/select_classify_label'] = array(
	'opbp_qrcode' => 'qrcode',
	'opbp_cubicle_name' => 'cubicle_name',
	'opbp_plate_name' => 'plate_name',
	'opbp_width' => 'width',
	'opbp_length' => 'length',
	'opbp_slot' => 'slot',
	'opbp_punch' => 'punch',
	'opbp_edge' => 'edge',
	'opbp_remark' => 'remark',
	'opbp_decide_size' => 'decide_size',
	'opbp_up_edge' => 'up_edge',
	'opbp_down_edge' => 'down_edge',
	'opbp_left_edge' => 'left_edge',
	'opbp_right_edge' => 'right_edge',
	'opc_board' => 'board',
	'opc_optimize' => 'status',
	'op_num' => 'order_product_num',
	'o_dealer' => 'dealer',
	'o_owner' => 'owner',
);
$config['order/order_product_board_plate_model/select_by_order_product_classify_id'] = array(
	'opbp_qrcode' => 'qrcode',
	'opbp_cubicle_name' => 'cubicle_name',
	'opbp_cubicle_num' => 'cubicle_num',
	'opbp_plate_name' => 'plate_name',
	'opbp_plate_num' => 'plate_num',
	'opbp_width' => 'width',
	'opbp_length' => 'length',
	'opbp_thick' => 'thick',
	'opbp_amount' => 'num',
	'opbp_area' => 'area',
	'opbp_slot' => 'slot',
	'opbp_edge' => 'edge',
	'opbp_punch' => 'punch',
	'opbp_abnormity' => 'abnormity',
	'opbp_remark' => 'remark',
	'opbp_decide_size' => 'decide_size',
	'opbp_right_edge' => 'right_edge',
	'opbp_left_edge' => 'left_edge',
	'opbp_up_edge' => 'up_edge',
	'opbp_down_edge' => 'down_edge',
	'opbp_bd_file' => 'bd_file',
    'opc_board' => 'good'
);
$config['order/order_product_board_plate_model/select_by_order_product_board_id'] = array(
    'opbp_qrcode' => 'qrcode',
    'opbp_cubicle_name' => 'cubicle_name',
    'opbp_cubicle_num' => 'cubicle_num',
    'opbp_plate_name' => 'plate_name',
    'opbp_plate_num' => 'plate_num',
    'opbp_width' => 'width',
    'opbp_length' => 'length',
    'opbp_thick' => 'thick',
    'opbp_amount' => 'num',
    'opbp_area' => 'area',
    'opbp_slot' => 'slot',
    'opbp_edge' => 'edge',
    'opbp_punch' => 'punch',
    'opbp_abnormity' => 'abnormity',
    'opbp_remark' => 'remark',
    'opbp_decide_size' => 'decide_size',
    'opbp_right_edge' => 'right_edge',
    'opbp_left_edge' => 'left_edge',
    'opbp_up_edge' => 'up_edge',
    'opbp_down_edge' => 'down_edge',
    'opbp_bd_file' => 'bd_file',
    'opb_board' => 'good'
);
$config['order/order_product_board_plate_model/select_abnormity_by_order_product_id'] = array(
	'opbp_qrcode' => 'qrcode',
	'opbp_cubicle_name' => 'cubicle_name',
	'opbp_cubicle_num' => 'cubicle_num',
	'opbp_plate_name' => 'plate_name',
	'opbp_plate_num' => 'plate_num',
	'opbp_width' => 'width',
	'opbp_length' => 'length',
	'opbp_thick' => 'thick',
	'opbp_amount' => 'num',
	'opbp_area' => 'area',
	'opbp_slot' => 'slot',
	'opbp_edge' => 'edge',
	'opbp_punch' => 'punch',
	'opbp_abnormity' => 'abnormity',
	'opbp_remark' => 'remark',
	'opbp_decide_size' => 'decide_size',
	'opbp_right_edge' => 'right_edge',
	'opbp_left_edge' => 'left_edge',
	'opbp_up_edge' => 'up_edge',
	'opbp_down_edge' => 'down_edge',
	'opbp_bd_file' => 'bd_file',
    'opb_board' => 'good'
);
$config['order/order_product_board_plate_model/select_classify_print_list'] = array(
	'opbp_cubicle_name' => 'cubicle_name',
	'opbp_cubicle_num' => 'cubicle_num',
	'opbp_plate_name' => 'plate_name',
	'opbp_plate_num' => 'plate_num',
	'opbp_width' => 'width',
	'opbp_length' => 'length',
	'opbp_thick' => 'thick',
	'opbp_amount' => 'num',
	'opbp_area' => 'area',
	'opbp_slot' => 'slot',
	'opbp_edge' => 'edge',
	'opbp_punch' => 'punch',
	'opbp_remark' => 'remark',
    'opbp_abnormity' => 'abnormity',
	'opbp_decide_size' => 'decide_size',
	'opc_board' => 'good',
	'opbp_right_edge' => 'right_edge',
	'opbp_left_edge' => 'left_edge',
	'opbp_up_edge' => 'up_edge',
	'opbp_down_edge' => 'down_edge',
);
$config['order/order_product_board_plate_model/select_for_sure'] = array(
	'opbp_id' => 'v',
	'opbp_cubicle_num' => 'cubicle_num',
	'opbp_plate_num' => 'plate_num',
	'opbp_plate_name' => 'plate_name',
	'opbp_width' => 'width',
	'opbp_length' => 'length',
	'opbp_thick' => 'thick',
	'opbp_slot' => 'slot',
	'opbp_edge' => 'edge',
	'opbp_remark' => 'remark',
	'opbp_decide_size' => 'decide_size',
	'opbp_amount' => 'amount',
	'opbp_area' => 'area',
	'opbp_bd_file' => 'bd_file',
    'opbp_qrcode' => 'qrcode',
	'opbp_abnormity' => 'abnormity',
	'opb_board' => 'board',
	'op_id' => 'order_product_id',
	'op_num' => 'order_product_num',
	'op_bd' => 'bd'
);
$config['order/order_product_board_plate_model/select_qrcode_by_opid'] = array(
	'opbp_id' => 'opbpid',
	'opbp_cubicle_num' => 'cubicle_num',
	'opbp_plate_num' => 'plate_num',
	'opbp_plate_name' => 'plate_name',
	'opbp_width' => 'width',
	'opbp_length' => 'length',
	'opbp_thick' => 'thick',
	'opbp_slot' => 'slot',
	'opbp_edge' => 'edge',
	'opbp_remark' => 'remark',
	'opbp_decide_size' => 'decide_size',
	'opbp_amount' => 'amount',
	'opbp_area' => 'area',
	'opb_board' => 'board',
	'op_id' => 'opid',
	'op_num' => 'order_product_num',
	'op_bd' => 'bd',
	'opbp_qrcode' => 'qrcode',
);
$config['order/order_product_board_plate_model/is_exist'] = array(
    'opbp_id' => 'v',
	'opbp_order_product_board_id' => 'order_product_board_id',
	'opbp_order_product_classify_id' => 'opbp_order_product_classify_id',
    'opbp_thick' => 'thick',
    'ifnull(opc_status, opb_status)' => 'scan_status',
	'op_id' => 'order_product_id',
	'op_num' => 'order_product_num',
	'o_id' => 'order_id',
	'o_dealer' => 'dealer',
	'o_owner' => 'owner',
	'o_num' => 'num',
	'o_request_outdate' => 'request_outdate',
    'o_status' => 'status'
);

$config['order/order_product_board_plate_model/select_scan_list'] = array(
	'opbp_id' => 'v',
	'opbp_qrcode' => 'qrcode',
    'opbp_order_product_board_id' => 'order_product_board_id',
    'opbp_order_product_classify_id' => 'order_product_classify_id',
	'opbp_cubicle_name' => 'cubicle_name',
	'opbp_cubicle_num' => 'cubicle_num',
	'opbp_plate_name' => 'plate_name',
	'opbp_plate_num' => 'plate_num',
	'opbp_width' => 'width',
	'opbp_length' => 'length',
	'opbp_thick' => 'thick',
	'opbp_area' => 'area',
	'opbp_slot' => 'slot',
	'opbp_punch' => 'punch',
	'opbp_edge' => 'edge',
	'opbp_remark' => 'remark',
	'opbp_decide_size' => 'decide_size',
	'opbp_abnormity' => 'abnormity',
	'u_truename' => 'scanner',
	'if(opbp_scan_datetime = "0000-00-00 00:00:00", "", opbp_scan_datetime)' => 'scan_datetime',
	'opb_board' => 'board'
);
$config['order/order_product_board_plate_model/select_scan_lack'] = array(
	'op_id' => 'v',
	'op_num' => 'order_product_num',
    'op_product' => 'product',
	'o_dealer' => 'dealer',
	'o_owner' => 'owner',
	'u_truename' => 'creator',
	'opc_board' => 'board',
    'sum(opc_amount)' => 'amount',
	'count(op_id)' => 'lack'
);

$config['order/order_product_board_plate_model/select_un_scanned_by_order_product_id'] = array(
    'opbp_thick' => 'thick',
    'opb_board' => 'board',
    'count(opb_id)' => 'amount'
);

$config['order/order_product_board_plate_model/select_scan_lack_detail'] = array(
	'opbp_id' => 'v',
	'opbp_qrcode' => 'qrcode',
	'opbp_cubicle_name' => 'cubicle_name',
	'opbp_plate_name' => 'plate_name',
	'opbp_width' => 'width',
	'opbp_length' => 'length',
	'opbp_thick' => 'thick',
	'opbp_area' => 'area',
	'opbp_slot' => 'slot',
	'opbp_punch' => 'punch',
	'opbp_edge' => 'edge',
	'opbp_remark' => 'remark',
	'opbp_decide_size' => 'decide_size',
	'opc_board' => 'board',
    'u_truename' => 'scanner',
    'opbp_scan_datetime' => 'scan_datetime',
    'ifnull(C.wp_label, ifnull(B.wp_label, ""))' => 'status'
);
$config['order/order_product_board_plate_model/select_by_order_product_id'] = array(
    'opbp_id' => 'v',
    'opbp_qrcode' => 'qrcode',
    'opbp_cubicle_name' => 'cubicle_name',
    'opbp_plate_name' => 'plate_name',
    'opbp_width' => 'width',
    'opbp_length' => 'length',
    'opbp_thick' => 'thick',
    'opbp_area' => 'area',
    'opbp_slot' => 'slot',
    'opbp_punch' => 'punch',
    'opbp_edge' => 'edge',
    'opbp_remark' => 'remark',
    'opbp_decide_size' => 'decide_size',
    'opbp_bd_file' => 'bd_file',
    'opb_board' => 'board',
    'opb_unit_price' => 'unit_price',
    'opb_purchase' => 'purchase',
    'opb_sum' => 'sum',
    'opb_virtual_sum' => 'virtual_sum',
    'u_truename' => 'scanner',
    'opbp_scan_datetime' => 'scan_datetime'
);
$config['order/order_product_board_plate_model/select_produce_prehandled'] = array(
	'opbp_id' => 'opbpid',
	'opbp_qrcode' => 'qrcode',
	'opbp_cubicle_name' => 'cubicle_name',
	'opbp_cubicle_num' => 'cubicle_num',
	'opbp_plate_name' => 'plate_name',
	'opbp_plate_num' => 'plate_num',
	'opbp_width' => 'width',
	'opbp_length' => 'length',
	'opbp_thick' => 'thick',
	'opbp_area' => 'area',
	'opbp_slot' => 'slot',
	'opbp_punch' => 'punch',
	'opbp_edge' => 'edge',
	'opbp_remark' => 'remark',
	'opbp_decide_size' => 'decide_size',
	'opc_board' => 'board',
	'c_name' => 'classify',
	'c_id' => 'classify_id',
);

$config['order/order_product_board_plate_model/select_classify_batch_num'] = array(
    'opc_id' => 'v',
    'opc_batch_num' => 'batch_num',
    'opc_board' => 'board',
    'm_id' => 'mrp_v',
    'm_status' => 'status'
);