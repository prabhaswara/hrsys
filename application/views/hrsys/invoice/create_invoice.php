
<h2 class="form-title">Invoice</h2>
<div style="padding: 10px;">
    <?php
    echo breadcrumb_($breadcrumb);
	if(!empty($postItem))
	{
		$total=0;
		foreach($postItem as $item)
		{
			$total+=$item["bill"];
		}
		$postItem[]=array("recid"=>"summary","summary"=>true,"fee"=>"Total","bill"=>$total);
		
	}
	
	
	$json_item= json_encode($postItem); 

	
    ?>
{message}

<form  method="POST" id="formnya" class="form-tbl" >
        
		<?= frm_('invoice_id', $postForm, "type='hidden'") ?>
		<table>
            <tr>
                <td class="aright">Client:</td>
                <td><?= select_('cmpyclient_id', $postForm,$client_list,"class='kendodropdown w250'",false) ?>
				
				</td>        
            </tr>
			
            <tr>
                <td class="aright">Invoice Num:</td>
                <td><?= frm_('invoice_num', $postForm, "class='w250 required' ") ?></td>        
            </tr>
			<tr>
                <td class="aright">Invoice Date:</td>
                <td><?= frm_('invoice_date', $postForm, "class='w150 date required' ") ?></td>        
            </tr>
			<tr>
                <td class="aright">Due Date:</td>
                <td><?= frm_('due_date', $postForm, "class='w150 date required' ") ?></td>        
            </tr>
			
		</table>
	<button id="add_item" class="w2ui-btn w2ui-btn-blue" > <span class="fa-plus">&nbsp;</span> Add Item</button>
				
</form>
<div id="listItem" style="height:200px;margin:10px 5px" ></div>



<button id="savebtn" class="w2ui-btn w2ui-btn-green w100" > <span class="fa-edit">&nbsp;</span> Save</button>



</div>

<script>

var config = {
		listAddItem:{
					name: 'listAddItem',
					autoLoad: false,					
					limit:50,         
					show: {toolbar: true}
					,columns: [
				  
						{field: 'recid', caption: '', size: '30px', searchable: false, sortable: false,
							render: function (record) {
							   return "<span class='fa-plus imgbt' onClick='addToGrid(\""+record.recid+"\")' ></span>"
							}
						},          
						{field: 'v_sp_name', caption: 'Vacancy Name', size: '200px', searchable: true, sortable: true},
						{field: 'c_sp_name', caption: 'Candidate Name', size: '100%', searchable: true, sortable: true},
						{field: 'vc_sp_date_join', caption: 'Date Join', size: '120px', searchable: false, sortable: true},
						{field: 'vc_sp_approvedsalary', caption: 'Salary', size: '120px', searchable: false, sortable: true,render:"number"},
						{field: 'vc_sp_approvedsalary_ccy', caption: 'CCY', size: '50px', searchable: false, sortable: true}               
						
					]
				}
	}
			
	function addToGrid(vac_id){
		
		
		$.ajax({
					type: "POST",            
					url: '{site_url}/hrsys/invoice/jsonAddItem/'+vac_id,
					beforeSend: function (xhr) {
						$("#ajaxDiv").attr("class", "ajax-show");

					},
					dataType :'json',
					success: function (data) {					
						
						findId = w2ui['listItem'].find({ recid: data.vc_sp_vacancycandidate_id});
						if(jQuery.isEmptyObject(findId))
						{
							w2ui['listItem'].add({ 
							recid: data.vc_sp_vacancycandidate_id,
							vacancy_name: data.v_sp_name,
							candidate_name: data.c_sp_name,
							join_date: data.vc_sp_date_join,
							approvedsalary: data.vc_sp_approvedsalary,					
							fee: data.v_sp_fee,
							bill: data.bill});		
							
							
							var sum_bill=0;
							$.each(w2ui['listItem'].records, function(index, rec ) {
							
							  sum_bill+=rec.bill;
							});
							w2ui['listItem'].set("summary", { bill: sum_bill });
						}	
						
						$("#ajaxDiv").attr("class", "ajax-hide");						
					}                
				});
				
		
		
		
	}
	function removeItemInGrid(recid)
	{
		w2ui['listItem'].remove(recid);
		var sum_bill=0;
		$.each(w2ui['listItem'].records, function(index, rec ) {
		
		  sum_bill+=rec.bill;
		});
		w2ui['listItem'].set("summary", { bill: sum_bill });
	}
	
 $(function () {
	
    $().w2grid(config.listAddItem);
	
	$("#savebtn").click(
		function (){
		
			dataArray={
				
				"frm":{			
					"cmpyclient_id":$("#cmpyclient_id").val(),
					"invoice_id":$("#invoice_id").val(),
					"invoice_num":$("#invoice_num").val(),
					"invoice_date":$("#invoice_date").val(),
					"due_date":$("#due_date").val()
				},
				"item":w2ui['listItem'].records
			};
			
			
			 $.ajax({
                type: "POST",
                data: dataArray,
				url: '{site_url}/hrsys/invoice/create_invoice/'+$("#invoice_id").val(),
                beforeSend: function (xhr) {
                    $("#ajaxDiv").attr("class", "ajax-show");

                },
                success: function (returnDt) {      
					if (returnDt.match("^save_ok")) {
						id=returnDt.replace('save_ok','');						
						$(window).gn_loadmain('hrsys/invoice/det_invoice/'+id);
						 
					}
					else{
						for (var widget in w2ui) {
							var nm = w2ui[widget].name;
							if (['main_layout', 'sidebar'].indexOf(nm) == -1)
								$().w2destroy(nm);
						}
				
						w2ui['main_layout'].content('main', returnDt);
					}
                    $("#ajaxDiv").attr("class", "ajax-hide");                    
                }
                
            });			
			
			
		}
	
	);
	
	$("#cmpyclient_id").change(function() {
		w2ui['listItem'].clear();
		w2ui['listItem'].add({ 
			summary:true, recid:"summary",fee:"Total:"});	
	});
	$("#add_item").click(function () {
		w2ui['listAddItem'].url = '{site_url}/hrsys/invoice/jsonListAddItem/'+$("#cmpyclient_id").data("kendoDropDownList").value();
		
		w2popup.open({
			title   : 'Popup',
			width   : 800,
			height  : 400,
			body    : '<div id="main" style="position: absolute; left: 5px; top: 5px; right: 5px; bottom: 5px;"></div>',
			onOpen  : function (event) {		
					
				event.onComplete = function () {					
					$('#w2ui-popup #main').w2render('listAddItem');						
					
				};
			},
			onToggle: function (event) { 
				event.onComplete = function () {
					
				//	w2ui.popupLayout.resize();
				}
			}
		});
	
		return false;

    });
	
	
	
    $('#listItem').w2grid({
            name: 'listItem'
            ,show: {toolbar: false}
            ,columns: [
                {field: 'recid', caption: '', size: '30px', searchable: false, sortable: false,
                    render: function (record) {
						render="";
						if(record.recid!="summary"){
							render="<span class=' fa-remove imgbt' onClick='removeItemInGrid(\""+record.recid+"\")' ></span>"
                    
						}
                        return render;
					}
                }
                ,{field: 'vacancy_name', caption: 'Vacancy Name', size: '250px'}
				,{field: 'candidate_name', caption: 'Candidate Name', size: '100%'}
				,{field: 'join_date', caption: 'Join Date', size: '150px'}
				,{field: 'approvedsalary', caption: 'Salary', size: '200px',render:"number"}					
				
				,{field: 'fee', caption: 'Fee', size: '50px', searchable: false, sortable: false,
                    render: function (record) {	
						render=record.fee;
						if(record.recid!="summary"){
							render=record.fee+"%"
                    
						}
						return render;
					}
                }
				,{field: 'bill', caption: 'Bill', size: '150px',render:"number"}
				
				
            
            ],records: <?php if(empty($postItem)){echo "[{ summary: true, recid:'summary',fee:'Total:'}]";} else {echo $json_item;} ?>
				
        });
		
      $(".gn_breadcrumb a").click(function () {
            href = $(this).attr("href");
            if (href != "#" && href != "") {
                $.fn.gn_loadmain(href);
            }
            return false;

        });  
      $(this).init_js("{base_url}");  

    });
</script>
