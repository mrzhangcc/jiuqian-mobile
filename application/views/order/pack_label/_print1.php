<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * 2015年12月18日
 * @author Zhangcc
 * @version
 * @des
 * 打印大标签
 */
 $Dealer = explode('_', $Data['dealer']);
 array_pop($Dealer);
 array_shift($Dealer);
 $Dealer = implode('_', $Dealer);
 
 $Start = 1;
 $EndDate = date('Y-m-d');
?>
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-offset-2 col-md-8" style="border: 3px solid red; border-radius: 10px;font-size: 32px;">
                    <dl class="dl-horizontal">
                        <dt>订单编号:</dt>
                        <dd><?php echo $Data['order_product_num'];?></dd>
                    </dl>
                    <dl class="dl-horizontal">
                        <dt>客户:</dt>
                        <dd><?php echo $Data['dealer'];?></dd>
                    </dl>
                    <dl class="dl-horizontal">
                        <dt>业主:</dt>
                        <dd><?php echo $Data['owner'];?></dd>
                    </dl>
                    <dl class="dl-horizontal">
                        <dt>货到地址:</dt>
                        <dd><?php echo $Data['delivery_area'].$Data['delivery_address'];?></dd>
                    </dl>
                    <dl class="dl-horizontal">
                        <dt>联系人:</dt>
                        <dd><?php echo $Data['delivery_linker'];?></dd>
                    </dl>
                    <dl class="dl-horizontal">
                        <dt>联系方式:</dt>
                        <dd><?php echo $Data['delivery_phone'];?></dd>
                    </dl>
                    <dl class="dl-horizontal">
                        <dt>打包件数:</dt>
                        <dd><?php echo $Pack;?></dd>
                    </dl>
                </div>
                <div class="col-md-2"></div>
                <div class="col-md-offset-4 col-md-8">
                    <button class="btn btn-primary btn-lg" value="打印" id="print" type="button">打印</button>&nbsp;&nbsp;&nbsp;
                    <button class="btn btn-default btn-lg" value="打印" id="preview" type="button">预览</button>&nbsp;&nbsp;&nbsp;
                    <button class="btn btn-default btn-lg" value="打印" id="modify" type="button">微调</button>&nbsp;&nbsp;&nbsp;
                    <button class="btn btn-default btn-lg" value="返回" id="back" type="button">返回</button>
                </div>
            </div>
        </div>
        <script language="javascript" src="<?php echo base_url('js/LodopFuncs.js');?>"></script>
        <object id="LODOP_OB" classid="clsid:2105C259-1E0C-4534-8141-A753534CB4CA" width=0 height=0> 
        	<embed id="LODOP_EM" type="application/x-print-lodop" width=0 height=0 pluginspage="install_lodop.exe"></embed>
        </object>
    </body>
    <script src="http://cdn.bootcss.com/jquery/2.1.4/jquery.js"></script>
    <script src="http://cdn.bootcss.com/bootstrap/3.3.0/js/bootstrap.min.js"></script>
    
    <script>
    var LODOP; //声明为全局变量
    
    function MyPreview() {	
		LODOP=getLodop(document.getElementById('LODOP_OB'),document.getElementById('LODOP_EM'));  
		LODOP.PRINT_INIT("条码打印");
		LODOP.SET_PRINT_PAGESIZE(0,1000,800,"9000");
   
		CreateAllPages();
		if (LODOP.SET_PRINTER_INDEXA("Godex EZ-1105"));
		LODOP.SET_PREVIEW_WINDOW(0,0,0,760,540,"");
		LODOP.PREVIEW();
	};
	
	
	function MyPrint() {	
		LODOP=getLodop(document.getElementById('LODOP_OB'),document.getElementById('LODOP_EM'));  
		LODOP.PRINT_INIT("条码打印");
		LODOP.SET_PRINT_PAGESIZE(0,1000,800,"9000");
   
		CreateAllPages();
		if (LODOP.SET_PRINTER_INDEXA("Godex EZ-1105"));
		LODOP.SET_PREVIEW_WINDOW(0,0,0,760,540,"");
		LODOP.PRINT();
	};	
	
	function Setup() {	
		LODOP=getLodop(document.getElementById('LODOP_OB'),document.getElementById('LODOP_EM'));  
		LODOP.PRINT_INIT("条码打印");
		LODOP.SET_PRINT_PAGESIZE(0,1000,800,"9000");
		if (LODOP.SET_PRINTER_INDEXA("Godex EZ-1105"));
		CreateAllPages();
		LODOP.PRINT_DESIGN();		
	};
 
 	function CreateAllPages(){	
		for (i = <?=$Start?>; i <= <?=$Pack?>; i++) {
			if(<?=$Pack?> >1){
				LODOP.NewPage();
			}
			LODOP.ADD_PRINT_TEXT('1mm',0,'14mm','12mm','编号');
			LODOP.SET_PRINT_STYLEA(0,"FontName","黑体");
			LODOP.SET_PRINT_STYLEA(0,"FontSize",14);
			LODOP.SET_PRINT_STYLEA(0,"Bold",1);
			LODOP.SET_PRINT_STYLEA(0,"LetterSpacing",-2);
			LODOP.ADD_PRINT_TEXT('1mm','14mm','46mm','12mm',"<?=$Data['order_product_num']?>");
			LODOP.SET_PRINT_STYLEA(0,"FontName","黑体");
			LODOP.SET_PRINT_STYLEA(0,"FontSize",18);
			LODOP.SET_PRINT_STYLEA(0,"Bold",1);
			LODOP.SET_PRINT_STYLEA(0,"LetterSpacing",-2);
			
			LODOP.ADD_PRINT_TEXT('12mm',0,'14mm','12mm','客户');
			LODOP.SET_PRINT_STYLEA(0,"FontName","黑体");
			LODOP.SET_PRINT_STYLEA(0,"FontSize",14);
			LODOP.SET_PRINT_STYLEA(0,"Bold",1);
			LODOP.SET_PRINT_STYLEA(0,"LetterSpacing",-2);
			LODOP.ADD_PRINT_TEXT('12mm','14mm','46mm','12mm','<?php echo $Dealer;?>');
			LODOP.SET_PRINT_STYLEA(0,"FontName","黑体");
			LODOP.SET_PRINT_STYLEA(0,"FontSize",18);
			LODOP.SET_PRINT_STYLEA(0,"Bold",1);
			LODOP.SET_PRINT_STYLEA(0,"LineSpacing",-5);
			LODOP.SET_PRINT_STYLEA(0,"LetterSpacing",-2);

			LODOP.ADD_PRINT_TEXT('24mm',0,'14mm','12mm','业主');
			LODOP.SET_PRINT_STYLEA(0,"FontName","黑体");
			LODOP.SET_PRINT_STYLEA(0,"FontSize",14);
			LODOP.SET_PRINT_STYLEA(0,"Bold",1);
			LODOP.SET_PRINT_STYLEA(0,"LetterSpacing",-2);
			LODOP.ADD_PRINT_TEXT('24mm','14mm','46mm','12mm', '<?=$Data['owner']?>');
			LODOP.SET_PRINT_STYLEA(0,"FontName","黑体");
			LODOP.SET_PRINT_STYLEA(0,"FontSize",16);
			LODOP.SET_PRINT_STYLEA(0,"Bold",1);
			LODOP.SET_PRINT_STYLEA(0,"LineSpacing",-5);
			LODOP.SET_PRINT_STYLEA(0,"LetterSpacing",-2);

			LODOP.ADD_PRINT_TEXT('36mm',0,'14mm','12mm','收货');
			LODOP.SET_PRINT_STYLEA(0,"FontName","黑体");
			LODOP.SET_PRINT_STYLEA(0,"FontSize",14);
			LODOP.SET_PRINT_STYLEA(0,"Bold",1);
			LODOP.SET_PRINT_STYLEA(0,"LetterSpacing",-2);
			LODOP.ADD_PRINT_TEXT('36mm','14mm','46mm','12mm', '<?php echo $Data['delivery_linker'];?>');
			LODOP.SET_PRINT_STYLEA(0,"FontName","黑体");
			LODOP.SET_PRINT_STYLEA(0,"FontSize",16);
			LODOP.SET_PRINT_STYLEA(0,"Bold",1);
			LODOP.SET_PRINT_STYLEA(0,"LineSpacing",-5);
			LODOP.SET_PRINT_STYLEA(0,"LetterSpacing",-2);

			LODOP.ADD_PRINT_TEXT('48mm',0,'14mm','12mm','日期');
			LODOP.SET_PRINT_STYLEA(0,"FontName","黑体");
			LODOP.SET_PRINT_STYLEA(0,"FontSize",14);
			LODOP.SET_PRINT_STYLEA(0,"Bold",1);
			LODOP.SET_PRINT_STYLEA(0,"LetterSpacing",-2);
			LODOP.ADD_PRINT_TEXT('48mm','14mm','46mm','12mm','<?php echo $EndDate;?>');
			LODOP.SET_PRINT_STYLEA(0,"FontName","黑体");
			LODOP.SET_PRINT_STYLEA(0,"FontSize",16);
			LODOP.SET_PRINT_STYLEA(0,"Bold",1);
			LODOP.SET_PRINT_STYLEA(0,"LetterSpacing",-2);
			
			LODOP.ADD_PRINT_TEXT('60mm',0,'14mm','12mm','产品');
			LODOP.SET_PRINT_STYLEA(0,"FontName","黑体");
			LODOP.SET_PRINT_STYLEA(0,"FontSize",14);
			LODOP.SET_PRINT_STYLEA(0,"Bold",1);
			LODOP.SET_PRINT_STYLEA(0,"LetterSpacing",-2);
			LODOP.ADD_PRINT_TEXT('60mm','14mm','46mm','12mm',"<?=$Data['product']?>");
			LODOP.SET_PRINT_STYLEA(0,"FontName","黑体");
			LODOP.SET_PRINT_STYLEA(0,"FontSize",18);
			LODOP.SET_PRINT_STYLEA(0,"Bold",1);
			LODOP.SET_PRINT_STYLEA(0,"LetterSpacing",-2);
			
			LODOP.ADD_PRINT_BARCODE('1mm','60mm','39mm','39mm',"QRCode",'<?php echo $Data['order_product_num'];?>');	
			LODOP.SET_PRINT_STYLEA(0,"FontSize",10);
			
			LODOP.ADD_PRINT_TEXT('41mm','60mm','40mm','10mm','货到');
			LODOP.SET_PRINT_STYLEA(0,"FontName","黑体");
			LODOP.SET_PRINT_STYLEA(0,"FontSize",18);
			LODOP.SET_PRINT_STYLEA(0,"Bold",1);
			LODOP.SET_PRINT_STYLEA(0,"LetterSpacing",-2);
			LODOP.ADD_PRINT_TEXT('50mm','60mm','40mm','24mm','<?php echo $Data['delivery_area'].$Data['delivery_address'];?>');
			LODOP.SET_PRINT_STYLEA(0,"FontName","黑体");
			LODOP.SET_PRINT_STYLEA(0,"FontSize",20);
			LODOP.SET_PRINT_STYLEA(0,"Bold",1);
			LODOP.SET_PRINT_STYLEA(0,"LineSpacing",-8);
			LODOP.SET_PRINT_STYLEA(0,"LetterSpacing",-2);

		}	
	};
    (function($){
		$('#back').click(function(e){
			window.history.back();
		});
		$('#print').on('click', function(e){
			MyPrint();
			$.ajax({
				async: false,
                data: {id: <?php echo $Data['opid'];?>, pack: <?php echo $Pack;?>},
                type: 'post',
                url: '<?php echo site_url('order/pack_label/edit');?>',
                dataType: 'json',
                success: function(msg){
                    return true;
                },
                error: function(x,t,e){
                    alert(x.responseText);
	            }
            });
		});
		$('#preview').on('click', function(e){
			MyPreview();
			$.ajax({
				async: false,
                data: {id: <?php echo $Data['opid'];?>, pack: <?php echo $Pack;?>},
                type: 'post',
                url: '<?php echo site_url('order/pack_label/edit');?>',
                dataType: 'json',
                success: function(msg){
                    return true;
                },
                error: function(x,t,e){
                    alert(x.responseText);
	            }
            });
		});
		$('#modify').on('click', function(e){
			Setup();
		});
    })(jQuery);
    </script>
</html>