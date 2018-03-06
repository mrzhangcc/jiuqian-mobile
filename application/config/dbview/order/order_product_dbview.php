<?php defined('BASEPATH') OR exit('No direct script access allowed');

$config['order/order_product_model/is_dismantlable'] = array(
	'op_id' => 'opid',
	'o_id' => 'oid',
	'p_code' => 'code',
	'op_product' => 'product',
	'op_remark' => 'remark',
);
$config['order/order_product_model/is_post_salable'] = array(
	'op_id' => 'opid',
	'o_id' => 'oid',
	'p_code' => 'code',
	'op_product' => 'product',
	'op_remark' => 'remark',
);
$config['order/order_product_model/is_deliveriable'] = array(
	'op_id' => 'opid',
	'op_num' => 'order_product_num',
	'op_product' => 'product',
	'op_pack' => 'order_pack',
	'op_pack_detail' => 'order_pack_detail',
	'o_num' => 'order_num',
	'o_dealer' => 'dealer',
	'o_owner' => 'owner',
	'o_remark' => 'remark',
	'o_pack' => 'pack',
	'o_delivery_area' => 'delivery_area',
	'o_delivery_address' => 'delivery_address',
	'o_delivery_linker' => 'delivery_linker',
	'o_delivery_phone' => 'delivery_phone',
);
$config['order/order_product_model/is_packable'] = array(
	'op_id' => 'opid',
	'op_num' => 'order_product_num',
	'op_product' => 'product',
	'op_pack' => 'pack',
	'op_pack_detail' => 'pack_detail',
	'op_status' => 'status',
	'o_dealer' => 'dealer',
	'o_owner' => 'owner',
	'o_remark' => 'remark',
	'o_delivery_area' => 'delivery_area',
	'o_delivery_address' => 'delivery_address',
	'o_delivery_linker' => 'delivery_linker',
	'o_delivery_phone' => 'delivery_phone',
);
$config['order/order_product_model/is_redismantlable'] = array(
	'op_id' => 'opid',
	'op_status' => 'status',
	'o_id' => 'oid',
	'o_dealer_id' => 'did',
	'o_sum' => 'sum',
	'o_status' => 'ostatus',
);
$config['order/order_product_model/select_bd'] = array(
	'op_id' => 'opid',
	'op_num' => 'order_product_num',
	'op_product' => 'product',
	'op_remark' => 'order_product_remark',
	'u_truename' => 'dismantler',
	'o_dealer' => 'dealer',
	'o_owner' => 'owner',
	'o_request_outdate' => 'request_outdate',
	'o_asure_datetime' => 'asure_datetime',
	'o_remark' => 'remark',
);
$config['order/order_product_model/select_brothers'] = array(
	'op_id' => 'opid',
	'op_num' => 'order_product_num',
	'op_pack_detail' => 'pack_detail',
);
$config['order/order_product_model/select_current_workflow'] = array(
	'w_id' => 'wid',
	'w_no' => 'no',
	'w_type' => 'type',
	'w_name' => 'name',
	'w_name_en' => 'name_en',
	'w_file' => 'file',
);
$config['order/order_product_model/select_wait_dismantle'] = array(
	'op_id' => 'opid',
	'o_id' => 'oid',
	'op_product_id' => 'pid',
	'op_product' => 'product',
	'op_num' => 'num',
	'op_remark' => 'remark',
	'o_dealer' => 'dealer',
	'o_owner' => 'owner',
	'C.u_truename' => 'creator',
	'B.u_truename' => 'dismantler',
	'op_dismantled_datetime' => 'dismantled_datetime',
	'w_name' => 'status',
);
$config['order/order_product_model/select_pack_detail_by_opids'] = array(
	'op_id' => 'opid',
	'op_pack_detail' => 'pack_detail',
);
$config['order/order_product_model/select_producing'] = array(
	'op_id' => 'opid',
	'o_id' => 'oid',
	'op_product' => 'product',
	'op_num' => 'num',
	'op_remark' => 'remark',
	'o_dealer' => 'dealer',
	'o_owner' => 'owner',
	'o_asure_datetime' => 'asure_datetime',
	'B.u_truename' => 'dismantler',
);
$config['order/order_product_model/select_produce_prehandle'] = array(
	'op_id' => 'opid',
	'o_id' => 'oid',
	'op_product' => 'product',
	'op_num' => 'num',
	'op_remark' => 'remark',
	'o_dealer' => 'dealer',
	'o_owner' => 'owner',
	'o_asure_datetime' => 'asure_datetime',
	'B.u_truename' => 'dismantler',
);
$config['order/order_product_model/select_clear_fitting'] = array(
	'op_id' => 'opid',
	'op_num' => 'order_product_num',
	'op_remark' => 'remark',
	'o_flag' => 'icon',
	'o_dealer' => 'dealer',
	'o_owner' => 'owner',
	'o_asure_datetime' => 'asure_datetime',
	'o_request_outdate' => 'request_outdate',
);
$config['order/order_product_model/select_wait_delivery_by_ids'] = array(
	'op_id' => 'opid',
	'op_product_id' => 'pid',
	'op_num' => 'order_product_num',
	'op_pack' => 'order_product_pack',
	'op_pack_detail' => 'order_product_pack_detail',
	'o_id' => 'oid',
	'o_num' => 'order_num',
	'o_sum' => 'sum',
	'o_dealer_id' => 'did',
	'o_dealer' => 'dealer',
	'o_owner' => 'owner',
	'o_delivery_area' => 'delivery_area',
	'o_delivery_address' => 'delivery_address',
	'o_delivery_linker' => 'delivery_linker',
	'o_delivery_phone' => 'delivery_phone',
	'o_remark' => 'remark',
	'o_pack' => 'pack',
	'o_pack_detail' => 'pack_detail',
	'o_logistics' => 'logistics',
	'if(o_payed_datetime > 0, "已付", o_payterms)' => 'payed',
	'd_balance' => 'balance',
);
$config['order/order_product_model/select_by_soid'] = array(
	'op_id' => 'opid',
	'op_product_id' => 'pid',
	'op_num' => 'order_product_num',
	'op_pack' => 'order_product_pack',
	'o_id' => 'oid',
	'o_num' => 'order_num',
	'o_sum' => 'sum',
	'o_dealer_id' => 'did',
	'o_dealer' => 'dealer',
	'o_owner' => 'owner',
	'o_delivery_area' => 'delivery_area',
	'o_delivery_address' => 'delivery_address',
	'o_delivery_linker' => 'delivery_linker',
	'o_delivery_phone' => 'delivery_phone',
	'o_remark' => 'remark',
	'o_pack' => 'pack',
	'o_pack_detail' => 'pack_detail',
	'o_logistics' => 'logistics',
	'if(o_payed_datetime > 0, "已付", o_payterms)' => 'payed',
	'd_balance' => 'balance',
);
$config['order/order_product_model/select_status'] = array(
	'op_id' => 'id',
	'op_status' => 'status',
);
$config['order/order_product_model/_select_latest_insert_ids'] = array(
	'op_id' => 'opid',
	'op_num' => 'order_product_num',
);
$config['order/order_product_model/select_print_list'] = array(
	'op_id' => 'opid',
	'op_product' => 'product',
	'op_num' => 'order_product_num',
	'op_remark' => 'order_product_remark',
	'op_print_datetime' => 'print_datetime',
	'A.u_truename' => 'dismantler',
	'o_id' => 'oid',
	'o_dealer' => 'dealer',
	'o_owner' => 'owner',
	'o_remark' => 'remark',
	'o_asure_datetime' => 'asure_datetime',
	'o_request_outdate' => 'request_outdate',
);
$config['order/order_product_model/select_pack'] = array(
	'op_id' => 'opid',
	'op_num' => 'order_product_num',
	'op_product' => 'product',
	'op_scan_start' => 'start_date',
	'op_scan_end' => 'end_date',
	'o_dealer' => 'dealer',
	'o_owner' => 'owner',
	'o_remark' => 'remark',
	'if(op_scan_status=0,"未开始", if(op_scan_status = 1, "正在扫", "已扫完"))' => 'status',
);
$config['order/order_product_model/select_pack_statistics'] = array(
	'op_id' => 'opid',
	'op_num' => 'order_product_num',
	'op_product' => 'product',
	'op_pack' => 'pack',
	'A.u_truename' => 'packer',
	'op_pack_datetime' => 'pack_datetime',
	'o_dealer' => 'dealer',
	'o_owner' => 'owner',
	'o_remark' => 'remark',
	'o_asure_datetime' => 'asure_datetime',
	'o_request_outdate' => 'request_outdate',
);
$config['order/order_product_model/select_by_oid'] = array(
	'op_id' => 'opid',
	'p_id' => 'pid',
	'p_name' => 'name',
	'p_code' => 'code',
	'op_parent' => 'parent',
	'op_num' => 'order_product_num',
	'op_product' => 'product',
	'op_remark' => 'remark',
	'op_status' => 'status',
);
$config['order/order_product_model/select_wait_position'] = array(
	'op_id' => 'opid',
	'op_num' => 'order_product_num',
);
$config['order/order_product_model/select_order_detail_by_opid'] = array(
	'op_id' => 'opid',
	'p_code' => 'code',
	'op_product' => 'product',
	'op_num' => 'order_product_num',
	'op_sum' => 'order_product_sum',
	'A.u_truename' => 'dismantler',
	'op_parent' => 'parent',
	'op_remark' => 'order_product_remark',
	'o_id' => 'oid',
	'o_num' => 'order_num',
	'o_dealer_id' => 'did',
	'o_dealer' => 'dealer',
	'o_checker' => 'checker',
	'o_checker_phone' => 'checker_phone',
	'o_payterms' => 'payterms',
	'o_payer' => 'payer',
	'o_payer_phone' => 'payer_phone',
	'o_logistics' => 'logistics',
	'o_out_method' => 'out_method',
	'o_delivery_area' => 'delivery_area',
	'o_delivery_address' => 'delivery_address',
	'o_delivery_linker' => 'delivery_linker',
	'o_delivery_phone' => 'delivery_phone',
	'o_owner' => 'owner',
	'o_remark' => 'remark',
	'o_dealer_remark' => 'dealer_remark',
	'o_request_outdate' => 'request_outdate',
	'o_payed_datetime' => 'payed_datetime',
	'o_cargo_no' => 'cargo_no',
	'B.u_truename' => 'creator',
	'o_create_datetime' => 'create_datetime',
	'o_end_datetime' => 'end_datetime',
	'o_asure_datetime' => 'asure_datetime',
	'o_sum' => 'sum',
	'o_sum_detail' => 'sum_detail',
	'o_status' => 'status',
	'w_name' => 'workflow',
);
$config['order/order_product_detail/_read_w'] = array(
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
	'opb_board' => 'board',
);
$config['order/order_product_detail/_read_y'] = array(
	'opbp_id' => 'opbpid',
	'opbp_num' => 'num',
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
	'opb_board' => 'board',
);
$config['order/order_product_detail/_read_m'] = array(
	'opdp_id' => 'opdpid',
	'opdp_width' => 'width',
	'opdp_length' => 'length',
	'opdp_thick' => 'thick',
	'opdp_handle' => 'handle',
	'opdp_punch' => 'punch',
	'opdp_open_hole' => 'open_hole',
	'opdp_invisibility' => 'invisibility',
	'opdp_remark' => 'remark',
	'opdp_color' => 'color',
	'opdp_amount' => 'amount',
);
$config['order/order_product_detail/_read_k'] = array(
	'opdp_id' => 'opdpid',
	'opdp_plate_name' => 'plate_name',
	'opdp_width' => 'width',
	'opdp_length' => 'length',
	'opdp_thick' => 'thick',
	'opdp_punch' => 'punch',
	'opdp_remark' => 'remark',
	'opdp_color' => 'color',
	'opdp_amount' => 'amount',
	'opdp_spec' => 'spec',
);
$config['order/order_product_detail/_read_p'] = array(
	'opf_id' => 'opfid',
	'opf_type' => 'type',
	'opf_name' => 'name',
	'opf_amount' => 'amount',
	'opf_unit' => 'unit',
	'opf_remark' => 'remark',
);
$config['order/order_product_detail/_read_g'] = array(
	'opo_id' => 'opoid',
	'opo_name' => 'name',
	'opo_length' => 'length',
	'opo_width' => 'width',
	'opo_amount' => 'amount',
	'opo_remark' => 'remark',
	'op_order_id' => 'oid',
);