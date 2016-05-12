<h2 class="form-title">Search Candidate</h2>
<div style="padding: 10px;min-width:700px">
    <?php
    echo breadcrumb_($breadcrumb)
    ?>
	<ul id="panelbar">
		<li  class="k-state-active">
		<span >Filter</span>
			<div style='padding:5px;background-color:#F5F6F7;'>
				<form class="form-tbl" id='formSearch'>
					<table colspan=0 cellpadding=0>
						<tr>
							<td>
								<table>
									<tr>
										<td class="aright">Salary Range :</td>
										<td>
											<?= frm_('salary_1', $postForm, "class=' kendonumber' style='width:140px'") ?> - 
											<?= frm_('salary_2', $postForm, "class=' kendonumber' style='width:140px'") ?>

										</td>        
									</tr>
									<tr>
										<td class="aright">Currency :</td>
										<td>
											<?= select_('salary_ccy', $postForm,$listCCY,"class='kendodropdown w75'",false) ?>

										</td>        
									</tr>
									<tr>
										<td class="aright">Sex :</td>
										<td>
											 <?= select_('sex', $postForm,$sex_list,"class='kendodropdown'",false) ?>

										</td>        
									</tr>
								</table>
							</td>
							<td>
								<table>
									<tr>
										<td class="aright">Age :</td>
										<td>
											<?= frm_('age_1', $postForm, "class=' kendonumber w75'") ?> - 
											<?= frm_('age_2', $postForm, "class=' kendonumber w75'") ?>

										</td>        
									</tr>
									<tr>
										<td class="aright">Expertise :</td>									
										<td>
											<div style='margin-bottom:5px'>
												<select id="add_expertise" class='w250'></select>                       
												<input type='hidden' id='btn_add_expertise' />
											</div>
											<select  id="expertise" name="expertise[]" multiple="multiple" class="w250"></select>
										</td>   
									</tr>
								</table>
							</td>
						</tr>
					</table>
						<input type="submit" class="w2ui-btn w2ui-btn-blue" id="search-btn" value="Search" />
					<input  type="submit" class="w2ui-btn w2ui-btn-orange" id="clear-btn" value="Clear Search" />

				
					
				</form>
			</div>
		</li>
	</ul>
  
	
        
        <div id="listCandidate" style="height:300px;margin-top:10px" ></div>
   

</div>


<script>
     function detailCandidate(recid){
             $(window).gn_loadmain('{site_url}/hrsys/candidate/detcandidate/'+recid+'/{vacancy_id}/{frompage}');
            return false;
        }
    $(function() {
	
		$("#search-btn").click(function() {
	
			w2ui['listCandidate'].reload();
			return false;
		});
		
		$("#clear-btn").click(function() {
			w2confirm('Clear Filtering ?')
			.yes(function () { 
				$("#salary_1").data("kendoNumericTextBox").value("");
				$("#salary_2").data("kendoNumericTextBox").value("");				
				$("#salary_ccy").data("kendoDropDownList").value("");
				$("#sex").data("kendoDropDownList").value("");
				$("#salary_ccy").data("kendoDropDownList").value("");			
				$("#age_1").data("kendoNumericTextBox").value("");
				$("#age_2").data("kendoNumericTextBox").value("");
				
				var multi = $("#expertise").data("kendoMultiSelect");
				expertise.value("");
				expertise.input.blur();
			
			});           
			return false;
			
			
		});
		

        $("#panelbar").kendoPanelBar();
        $(this).setSkillList("add_expertise","btn_add_expertise","expertise","{site_url}",<?=json_encode($postExpertise) ?>);
        
        $(".gn_breadcrumb a").click(function() {
            href = $(this).attr("href");
            if (href != "#" && href != "") {
                $.fn.gn_loadmain(href);
            }
            return false;

        });
		 $(this).init_js("{base_url}");
        $('#listCandidate').w2grid({
            name: 'listCandidate',
            autoLoad: false,
            limit:25,
            show: {toolbar: true},
            url: '{site_url}/hrsys/candidate/jsonListCandidate',
            columns: [
                {field: 'recid', caption: '', size: '30px', searchable: false, sortable: false,
                    render: function (record) {
                        return "<span class='fa-zoom-in imgbt' onClick='detailCandidate(\""+record.recid+"\")' ></span>"
                    }
                },
                {field: 'lksat_sp_display_text', caption: 'Status', size: '100px', sortable: true},
                {field: 'c_sp_name', caption: 'Name', size: '250px', searchable:true, sortable: true},
                {field: 'c_sp_phone', caption: 'Phone', size: '100px', searchable:true, sortable: true},
                {field: 'c_sp_expectedsalary', caption: 'Expected Salary', searchable:true, size: '150px',render:"number", sortable: true},
                {field: 'lksex_sp_display_text', caption: 'Sex', searchable:true, size: '100px', sortable: true},
                {field: 'c_sp_age', caption: 'Age', searchable:false, size: '80px', sortable: true},
                {field: 'c_sp_skill', caption: 'Experties', searchable:true, size: '100%', sortable: false},
				{field: 'cm_sp_fullname', caption: 'CM', searchable:true, size: '100px', sortable: false}
            
            ]
			,onRequest: function(target, eventData) {			
				eventData.postData.salary_1 = $("#salary_1").data("kendoNumericTextBox").value();
				eventData.postData.salary_2 = $("#salary_2").data("kendoNumericTextBox").value();
				eventData.postData.salary_ccy = $("#salary_ccy").data("kendoDropDownList").value();
				eventData.postData.sex = $("#sex").data("kendoDropDownList").value();
				eventData.postData.salary_ccy = $("#salary_ccy").data("kendoDropDownList").value();			
				eventData.postData.age_1 = $("#age_1").data("kendoNumericTextBox").value();
				eventData.postData.age_2 = $("#age_2").data("kendoNumericTextBox").value();
				eventData.postData.expertise =$("#expertise").data("kendoMultiSelect").value();		
				
			}			
        });
       

    });
</script>