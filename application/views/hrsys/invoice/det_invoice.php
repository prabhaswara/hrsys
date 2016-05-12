
<h2 class="form-title">Invoice</h2>
<div style="padding: 10px;">
    <?php
    echo breadcrumb_($breadcrumb);
	
	if(!empty($dataItem))
	{
		$total=0;
		foreach($dataItem as $item)
		{
			$total+=$item["bill"];
		}
		$dataItem[]=array("recid"=>"summary","summary"=>true,"fee"=>"Total","bill"=>$total);
		
	}
	
	
	$json_item= json_encode($dataItem); 
	
    ?>
{message}

<form  method="POST" id="formnya" class="form-tbl" >
        
		<table>
            <tr>
                <td class="aright">Client:</td>
                <td><?= $data['cmpyclient_name']?></td>        
            </tr>
			
            <tr>
                <td class="aright">Invoice Num:</td>
				<td><?= $data['invoice_num']?></td>       
            </tr>
			<tr>
                <td class="aright">Invoice Date:</td>
				<td><?= balikTgl($data['invoice_date'])?></td>          
            </tr>
			<tr>
                <td class="aright">Due Date:</td>
				<td><?= balikTgl($data['due_date'])?></td>          
            </tr>
			<?php if($data['paid_date']!="")
			{ ?>
			<tr>
                <td class="aright">Paid Date:</td>
				<td><?= balikTgl($data['paid_date'])?></td>          
            </tr>
			<?php } ?>
		</table>		
</form>
<div id="listItem" style="height:200px;margin:10px 5px" ></div>

	<div>
		<?php if($data['paid_date']=="")
			{ ?>
		<button id="editBtn" class="w2ui-btn w2ui-btn-green w100" > <span class="fa-edit">&nbsp;</span> Edit</button>
		<button id="setPaymentBtn" class="w2ui-btn w2ui-btn-green " > <span class="fa-check">&nbsp;</span> Set Paid Date</button>
		<?php } ?>
		<button id="downloadBtn" class="w2ui-btn w2ui-btn-blue " > <span class="fa-download">&nbsp;</span> Download</button>
		<?php if($data['paid_date']=="")
			{ ?>
		<button style='float:right' id="deletebtn" class="w2ui-btn w2ui-btn-red w100" > <span class="fa-close">&nbsp;</span> Delete</button>
		<?php } ?>
	
	</div>


</div>

<script>

	
	function setPaymentDate()
	{
		w2confirm('Are you sure want submit this request ?')
        .yes(function () { 
        
            $.ajax({
                type: "POST",            
                url: '{site_url}/hrsys/invoice/setPaidDate/',
				data: { invoice_id: "<?=$data['invoice_id']?>", paid_date: $("#paid_date").val() },
                beforeSend: function (xhr) {
                    $("#ajaxDiv").attr("class", "ajax-show");

                },
                success: function (data) {
					$("#ajaxDiv").attr("class", "ajax-hide");
                    if(data!="")
					{
						alert(data);
					}else
					{
						w2popup.close();
						$(this).gn_loadmain('{site_url}/hrsys/invoice/det_invoice/<?=$data['invoice_id']?>');
					}
                   
                    
                        
                    
                }                
            });
        
        });   
		
	
	}
 $(function () {
	$("#setPaymentBtn").click(function () {
		w2popup.open({
			title   : 'Set Paid Date',
			width   : 350,
			height  : 180,
			body    : '<div id="main" style="position: absolute; left: 5px; top: 5px; right: 5px; bottom: 5px;"> Paid Date: <input type="text" id="paid_date" name="paid_date" class="date"/> <br> <button class="w2ui-btn w2ui-btn-green "  onclick="setPaymentDate()"> Submit</button> <p style="color:red">* Warning if you set Paid date. you can\'t edit this content </p></div>  ',
			onOpen  : function (event) {		
				
				event.onComplete = function () {
					$("#paid_date").kendoDatePicker({format: "dd-MM-yyyy"});
					$("#paid_date").mask('99-99-9999');
				}
				
			},
			onToggle: function (event) { 
				event.onComplete = function () {
				
				}
			}
		});
	
		return false;

    });
	
	
	
	$("#deletebtn").click(function () {   
      
        w2confirm('Are you sure want delete this invoice ?')
        .yes(function () { 
        
            $.ajax({
                type: "POST",            
                url: '{site_url}/hrsys/invoice/deleteInvoice/',
				data: { invoice_id: "<?=$data['invoice_id']?>" },
                beforeSend: function (xhr) {
                    $("#ajaxDiv").attr("class", "ajax-show");

                },
                success: function (data) {
					$("#ajaxDiv").attr("class", "ajax-hide");
                    if(data!="")
					{
						alert(data);
					}else
					{
						w2popup.close();
						$(this).gn_loadmain('{site_url}/hrsys/invoice/list_invoice');
					}
                   
                    
                        
                    
                }                
            });
        
        });  
		return false;        
    });
	$("#editBtn").click(function () {   
      
        $(window).gn_loadmain('{site_url}/hrsys/invoice/create_invoice/<?= $data['invoice_id'] ?>');
        return false;        
    });
	$("#downloadBtn").click(function () {   
		window.location.href = '{site_url}/hrsys/invoice/donwloadInvoice/<?= $data['invoice_id'] ?>';
        return false;        
    });
	
    $('#listItem').w2grid({
            name: 'listItem'
            ,show: {toolbar: false}
            ,columns: [
				{field: 'vacancy_name', caption: 'Vacancy Name', size: '250px'}
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
					
            
            ],records: <?php if(empty($dataItem)){echo "[{ summary: true, recid:'summary',fee:'Total:'}]";} else {echo $json_item;} ?>
				
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
