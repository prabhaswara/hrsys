
<h2 class="form-title">Vacancy</h2>
<div class="content_body">
    <input type="hidden" id="frompage" value="{frompage}" />
    <?php
    echo breadcrumb_($breadcrumb)
    ?>
    
    <div id="detVacTab" style="width: 100%; height: 29px;"></div>
    <div id="detVacTab_c" class="tabboxwui2" style="position: absolute;top: 64px;bottom: 10px;left: 10px;right: 10px">
        <div id="vacancy_tab" class='divtab' style="display:none" >
            <?php
			if($canedit && $vacancy["status"]==1)
			{
			?>
			{message}
            <button id="editVacancy" class="w2ui-btn w2ui-btn-green"  style="position: absolute;left: 10px" > <span class="fa-edit">&nbsp;</span> Edit</button>
            <?php
			}
			?>
			
			<form  class="form-tbl" >
                <table>
                    <tr>
                        <td style="width:400px">
                            <table>
                                <tr>
                                    <td class="aright">Status</td>
                                    <td><?= $vacancy["status_text"] ?></td>        
                                </tr>
                                <tr>
                                    <td class="aright">Account Manager:</td>
                                    <td><?= $vacancy["emp_am"] ?></td>        
                                </tr>
                                <tr>
                                    <td class="aright">Open Date:</td>
                                    <td><?= balikTgl($vacancy["opendate"]) ?></td>        
                                </tr>
                                <tr>
                                    <td class="aright">Job Name:</td>
                                    <td><?= $vacancy["name"] ?></td>        
                                </tr>
                                <tr>
                                    <td class="aright">Number of Positions:</td>
                                    <td><?= $vacancy["num_position"] ?></td>        
                                </tr>                              
                                <tr>
                                    <td class="aright">Fee:</td>
                                    <td>
                                    <?=$vacancy["fee"].(cleanstr($vacancy["fee"])!=""?"%":"") ?>
                                    </td>        
                                </tr>                              
                            </table>

                        </td>
                        <td>
                           <?php 
                            $vacancy["salary_1"]=$vacancy["salary_1"]==0?"":$vacancy["salary_1"];
                            $vacancy["salary_2"]=$vacancy["salary_2"]==0?"":$vacancy["salary_2"];
                            
                           ?>
                            <table>
                                <tr>
                                    <td class="aright">Salary :</td>
                                    <td ><?= numSep($vacancy["salary_1"]).((cleanstr($vacancy["salary_1"])!=""&&cleanstr($vacancy["salary_2"])!="")?" - ":"").numSep($vacancy["salary_2"])
                                            .((cleanstr($vacancy["salary_1"])!=""&&cleanstr($vacancy["salary_2"])!="")?" (".$vacancy["salary_ccy"].")":"") ?></td> 
                                </tr>          
                                <tr>
                                    <td class="aright">Age :</td>
                                    <td ><?= $vacancy["age_1"].((cleanstr($vacancy["age_1"])!=""&&cleanstr($vacancy["age_2"])!="")?" - ":"").$vacancy["age_2"] ?></td> 
                                </tr>          
                                <tr>
                                    <td class="aright">Sex :</td>
                                    <td ><?= $vacancy["sex_text"] ?></td> 
                                </tr>        
                                <tr>
                                    <td class="aright">Expertise :</td>
                                    <td ><?= $expertise ?></td> 
                                </tr>
                                <tr>
                                    <td class="aright">Description :</td>
                                    <td ><?= $vacancy["description"] ?></td> 
                                </tr> 
                                <tr>
                                    <td class="aright">Maintenance:</td>
                                    <td >
                                        <?=$shareVacant?>
                                    </td> 
                                </tr>
                            </table>
                        </td>
                    </tr>
                </table>
                
                
                
            </form>
			<?php if($vacancy["status"]==1) {?>
            <button class="w2ui-btn w2ui-btn-green" id="addCandidate" > <span class="fa-edit">&nbsp;</span> Add Candidate</button>
            <button class="w2ui-btn w2ui-btn-blue" id="searchCandidate" > <span class="fa-search">&nbsp;</span> Search Candidate</button>
            <?php } ?>
            <div id="listProsesCandidate" style="height:300px;margin-top:5px" ></div>
        
        </div>
        
        
        <div id="candidate_tab" class='divtab' style="display:none" >
            <div id="layoutdetcandidate" style="position: absolute;top:0;bottom: 0px;left: 0px;right:0px;" >test</div>
            
        </div>
		
		<div id="operation_tab" class='divtab' style="display:none" >
            <div id="layoutdetcandidate" style="position: absolute;top:0;bottom: 0px;left: 0px;right:0px;padding:10px" >
				
				<?php if($candelete) { ?>
				<input type='button' id='delete_vacancy' value='Delete' class='w2ui-btn w2ui-btn-red'/>
				 <?php } ?>
				 
				 <input type='button' id='close_vacancy' value='Close Vacancy' class='w2ui-btn w2ui-btn-orange'/>
			</div>
      
        </div>
    </div>

</div>


<script>
    function detailCandidate(candidate_id){
         w2ui['detVacTab'].click('candidate_tab');        
         w2ui['candidatebar'].click(candidate_id);   
         w2ui['candidatebar'].select(candidate_id);   
         
        }
    $(function () {
        $(".gn_breadcrumb a").click(function () {
            href = $(this).attr("href");
            if (href != "#" && href != "") {
                $.fn.gn_loadmain(href);
            }
            return false;

        });
        
		
		$("#close_vacancy").click(function () {      
			w2confirm('Are You Sure Want To Close This Vacancy ?')
			.yes(function () { 			
				$.ajax({
					type: "POST",            
					url: '{site_url}/hrsys/vacancy/closeVancany/<?=$vacancy["vacancy_id"]?>',
					beforeSend: function (xhr) {
						$("#ajaxDiv").attr("class", "ajax-show");

					},
					success: function (data) {						
						$("#ajaxDiv").attr("class", "ajax-hide");	
						$(this).gn_loadmain("{site_url}/hrsys/vacancy/contentVacancy/<?=$vacancy["vacancy_id"]?>/{frompage}");
						
						
					}                
				});
			
			
			});           
			return false;
		});
        $("#delete_vacancy").click(function () {      
			w2confirm('Are You Sure Delete This Vacancy ?')
			.yes(function () { 			
				$.ajax({
					type: "POST",            
					url: '{site_url}/hrsys/vacancy/deleteVancany/<?=$vacancy["vacancy_id"]?>',
					beforeSend: function (xhr) {
						$("#ajaxDiv").attr("class", "ajax-show");

					},
					success: function (data) {						
						$("#ajaxDiv").attr("class", "ajax-hide");
						$(this).gn_loadmain('{site_url}/hrsys/client/detclient/<?=$vacancy["cmpyclient_id"]?>/home/vacancies');
							
						
					}                
				});
			
			});           
			return false;
		}); 
        
        var config={
            detVacTab:{
                    name: 'detVacTab',
                    tabs: [
                        {id: 'vacancy_tab', caption: 'Vacancy'}
                        , {id: 'candidate_tab', caption: 'Detail Candidates'}
						<?php if($vacancy["status"]==1){ ?>
                        ,{id: 'operation_tab', caption: 'Operation'}
                       <?php } ?>
                    ],
                    onClick: function (event) {
                        $(".divtab").hide();
                        $("#"+event.tab.id).show();
                        
                        if(event.tab.id=="candidate_tab"){
						
                            if(w2ui['layoutdetcandidate'])
                            w2ui['layoutdetcandidate'].refresh();
                        }else  if(event.tab.id=="vacancy_tab"){
                            if(w2ui['listProsesCandidate']){
							 w2ui['listProsesCandidate'].reload();
							
							}
                               
                        }
                    }
                },
            layoutdetcandidate:{
                name: 'layoutdetcandidate',
                panels: [             
                    { type: 'left', size: 200, resizable: true, style: "border-right:1px solid silver", content: '' },
                    { type: 'main', style: '', content: '', 
                        tabs: {
                            active: 'process',
                            tabs: [
                                { id: 'process', caption: 'Process' },
                                { id: 'info', caption: 'Info Candidate' },
                                { id: 'cv', caption: 'Curriculum Vitae' },
                                { id: 'history', caption: 'History' }
                            ],
                            onClick: function (event) {
                                //this.owner.content('main', event);
                                selectCandidate(event.tab.id,null);
                                
                            }
                        }
                    }
                ]
            },
            listProsesCandidate:{
            name: 'listProsesCandidate',
            url: '{site_url}/hrsys/vacancy/jsonVacancyCandidate/<?=$vacancy["vacancy_id"] ?>',
            show: {toolbar: true}
			 
			,columns: [
                {field: 'recid', caption: '', size: '30px', searchable: false, sortable: false,
                    render: function (record) {
                        return "<span class='fa-zoom-in imgbt' onclick='detailCandidate(\"" + record.c_sp_candidate_id + "\")' ></span>"
                    }
                },
                {field: 'klstate_sp_display_text', caption: 'State', size: '120px', searchable: true, sortable: true},
                {field: 'c_sp_name', caption: 'Name', size: '100%', searchable: true, sortable: true},
                {field: 'c_sp_phone', caption: 'Phone', size: '120px', searchable: true, sortable: true},
                {field: 'vc_sp_expectedsalary', caption: 'Expected Salary', size: '120px',render:"number", searchable: true, sortable: true},
                {field: 'vc_sp_approvedsalary', caption: 'Approved Salary', size: '120px',render:"number", searchable: true, sortable: true},
                {field: 'cm_sp_fullname', caption: 'CM', size: '120px', searchable: true, sortable: true}
            ],
            onRequest: function(event) {
                event.postData.typesearch=$("#typesearch").val();
                           
            } 
        }};
        

        $("#detVacTab").w2tabs(config.detVacTab);
        w2ui['detVacTab'].click('vacancy_tab');        
        
        $('#layoutdetcandidate').w2layout(config.layoutdetcandidate);
        
        w2ui['layoutdetcandidate'].content('left', $().w2sidebar({
                    name: 'candidatebar',
                    style:"margin-left:-40px",
                    nodes: {sidebarCandidate},
                    onClick: function(event) {
                    selectCandidate(null,event.node.id);
                    }
                })); 
                
        
        $('#listProsesCandidate').w2grid(config.listProsesCandidate);       

        $("#addCandidate").click(function () {
            $(window).gn_loadmain('{site_url}/hrsys/candidate/addEditCandidate/0/<?= $vacancy["vacancy_id"] ?>/{frompage}');
        });
        $("#editVacancy").click(function () {
            $().w2popup('open', {
                name: 'lookup_form',
                title: 'Edit Vacancy',
                body: '<div id="popupForm" class="framepopup">please wait..</div>',
                style: 'padding: 0px 0px 0px 0px',
                width: 900,
                height: 400,
                modal: true,
                onOpen: function (event) {
                    event.onComplete = function () {

                        $("#popupForm").load("{site_url}/hrsys/vacancy/showform/<?= $vacancy["cmpyclient_id"]."/".$vacancy["vacancy_id"]."/".$frompage   ?>", function () {
                        });
                    }

                }
            });
        });
        $("#searchCandidate").click(function () {
            $(window).gn_loadmain('{site_url}/hrsys/candidate/listCandidate/<?= $vacancy["vacancy_id"] ?>/{frompage}');
        });
        
        function selectCandidate(tab,candidate_id){
            if(tab==null)
                tab=w2ui['layoutdetcandidate_main_tabs'].active;
            if(candidate_id==null)
                candidate_id=w2ui['candidatebar'].selected ;           
            
            if(tab=="process"){
                w2ui['layoutdetcandidate'].load('main', '{site_url}/hrsys/vacancy/processCandidate/<?=$vacancy["vacancy_id"] ?>/'+candidate_id);
            }else if(tab=="info"){
                w2ui['layoutdetcandidate'].load('main', '{site_url}/hrsys/candidate/infoCandidate/'+candidate_id+"/<?=$vacancy["vacancy_id"] ?>");
                
            }else if(tab=="cv"){
                w2ui['layoutdetcandidate'].load('main', '{site_url}/hrsys/candidate/cvCandidate/'+candidate_id+"/<?=$vacancy["vacancy_id"] ?>");
            }else if(tab=="history"){
                w2ui['layoutdetcandidate'].load('main', '{site_url}/hrsys/candidate/historyCandidate/'+candidate_id+"/<?=$vacancy["vacancy_id"] ?>");
            }            
        }
        
    
        

    });
</script>
