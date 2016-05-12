<?php
$candidate_id = $candidate["candidate_id"];
$vacancy_id = $vacancy["vacancy_id"];


?>

<div style="position: absolute;right: 10px;left: 10px;bottom: 200px; top: 10px; overflow: auto ">
{message}
<form method="POST" id="formnya" class="form-tbl" action="<?= $site_url . "/hrsys/vacancy/processCandidateDet/" .$trail["trl_id"] ?>">
        <?= frm_('trl_id', $trail, "type='hidden'") ?>   
        <table>
			<tr>
                <td width="150px" class="aright">Action Date</td><td width="3px">:</td>
                <td><?= $candidate["name"] ?></td>        
            </tr>
            <tr>
                <td width="150px" class="aright">Candidate Name</td><td width="3px">:</td>
                <td><?= $candidate["name"] ?></td>        
            </tr>
            <tr>
                <td class="aright">Current State</td><td width="3px">:</td>
                <td><?= $vacancyCandidate["applicant_stat_t"] ?></td>        
            </tr>
			
<?php
			switch ($vacancyCandidate["applicant_stat"]) {
				case applicant_stat_processinterview:?>
			<tr>
                <td class="aright">Date Of Interview</td><td>:</td>
                <td>
					<?= frm_g("interview",'schedule_d', $interviewForm, "class='w150 date'") ?>
                    <?= select_g("interview",'schedule_t', $interviewForm, $timeList, "style='width:90px' class='kendodropdown'", false) ?>
				</td>        
            </tr>
			<tr>
                <td class="aright">Type</td><td>:</td>
                <td>
					 <?= select_g('interview','type', $interviewForm,$interview_type,'',false) ?>
				</td>        
            </tr>
			
			<tr>
                <td class="aright">Add a Reminder</td><td>:</td>
                <td>
					<input type="checkbox" value="1" <?=(isset($interviewForm["remider"])?"checked":"") ?> id="interview_remider" name="interview[remider]">
				</td>        
            </tr>
			<tr id='remider_desc_view' style='<?=(isset($interviewForm["remider"])?"":"display:none") ?>'>
                <td class="aright">Reminder Desciption</td><td>:</td>
                <td>
					
					<?= textarea_g("interview",'remider_desc', $interviewForm, "class='w250' ") ?>
				</td>        
            </tr>
			
<?php			break;
				case applicant_stat_processtoclient:?>

<?php			break;
				case applicant_stat_offeringsalary:?>
			<tr>
                <td class="aright">Current Salary</td><td>:</td>
                <td>
					<?= frm_g("offeringsalary",'current_salary', $offeringsalaryForm, "class='kendonumber'") ?>
					 <?= select_g('offeringsalary','current_ccy', $offeringsalaryForm,$listCCY,"class='kendodropdown w75'",false) ?>
				</td>        
            </tr>
			<tr>
                <td class="aright">Expected Salary</td><td>:</td>
                <td>
					<?= frm_g("offeringsalary",'expected_salary', $offeringsalaryForm, "class='kendonumber'") ?>
					 <?= select_g('offeringsalary','expected_ccy', $offeringsalaryForm,$listCCY,"class='kendodropdown w75'",false) ?>
				</td>        
            </tr>
<?php			break;
				case applicant_stat_rejectedfromcandidate:?>

<?php			break;
				case applicant_stat_rejectedfromclient:?>

<?php			break;
				case applicant_stat_notqualified:?>

<?php			break;
				case applicant_stat_placemented:?>
			<tr>
                <td class="aright">Date Of Join</td><td>:</td>
                <td>
					<?= frm_g("placemented",'date_join', $placementedForm, "class='w150 date'") ?>
                </td>        
            </tr>
			<tr>
                <td class="aright">Salary</td><td>:</td>
                <td>
					<?= frm_g("placemented",'salary', $placementedForm, "class='kendonumber'") ?>
					<?= select_g('placemented','salary_ccy', $placementedForm,$listCCY,"class='kendodropdown w75'",false) ?>
                </td>        
            </tr>
<?php			break;
					
			}?>
			<tr>
                <td  class="aright">Note</td><td width="3px">:</td>
                <td>
                    <?= textarea_('description', $postForm, "class='w250' ") ?>
                       
                </td>        
            </tr>
			<?php if (!empty($listNextState)){ ?>
            <tr>
                <td class="aright">Next State</td><td width="3px">:</td>
                <td>
                    <?= select_('applicant_stat_next', $postForm,$listNextState," class='kendodropdown w250' ") ?>
                </td>
            </tr>
<?php		
				}?>
            
        </table>
		
<?php
	if($vacancy["status"]==1 && $vacancyCandidate["closed"]!="1"){
?>		
		<div >
		<input type="submit" name="action" id="action" value="Save" class="w2ui-btn"  style="float:left"/>

		<?php if (empty($listNextState)){ ?>
           <input type='button' name="action"  id='closingProcess' value='Closing Process' class='w2ui-btn'  style="float:left"/>
<?php		
				}else{ ?>
           <input type='button' name="action"  id='nextProcess' value='Next Process' class='w2ui-btn'  style="float:left"/>
<?php		
				}?>
				
		
		<input type='button' id='delete' value='Delete' class='w2ui-btn w2ui-btn-red'  style="float:right"/>
		</div>
    
<?php 
	}
?>
</form>


</div>
<div   id="listCandidateTrail"  style="position: absolute;right: 10px;left: 10px;bottom: 10px;height: 150px;">

</div>


<script>
	function detailTrail(trail_id)
	{
		$().w2popup('open', {
                name: 'detail_process',
                title: 'Detail Process',
                body: '<div id="detail_xx" >please wait..</div>',
                style: 'padding: 5px 0px 0px 0px',
                width: 500,
                height: 300,
                onOpen: function(event) {
                    event.onComplete = function() {

                        $("#detail_xx").load("{site_url}/hrsys/candidate/detailTrail/" + trail_id, function() {
                        });
                    }

                }
            });
	}
    $(function () {
        
		
		
		$("#nextProcess").click(
			function (e) {
             $.ajax({
                type: "POST",
                data: $("#formnya").serialize()+"&action=nextProcess",
                url     : '{site_url}/hrsys/vacancy/processCandidate/<?= $vacancy_id . "/" . $candidate_id ?>',
                beforeSend: function (xhr) {
                    $("#ajaxDiv").attr("class", "ajax-show");

                },
                success: function (data) {
					w2ui['layoutdetcandidate'].content('main',data);
					
					$("#ajaxDiv").attr("class", "ajax-hide");
                    
                }
                
            });
            return false;

        });
		
		$("#closingProcess").click(
			function (e) {
             $.ajax({
                type: "POST",
                data: $("#formnya").serialize()+"&action=closeProcess",
                url     : '{site_url}/hrsys/vacancy/processCandidate/<?= $vacancy_id . "/" . $candidate_id ?>',
                beforeSend: function (xhr) {
                    $("#ajaxDiv").attr("class", "ajax-show");

                },
                success: function (data) {
					w2ui['layoutdetcandidate'].content('main',data);
					
					$("#ajaxDiv").attr("class", "ajax-hide");
                    
                }
                
            });
            return false;

        });
		$("#delete").click(
			function (e) {
            w2confirm('Are you sure Delete This Process ?')
			.yes(function () { 	
				$.ajax({
					type: "POST",
					data: $(this).serialize(),
					url     : '{site_url}/hrsys/vacancy/deleteVacantTrail/<?= $trail["trl_id"] ?>',
					beforeSend: function (xhr) {
						$("#ajaxDiv").attr("class", "ajax-show");

					},
					success: function (data) {
						if(data=="delete_all"){
							$(window).gn_loadmain('{site_url}/hrsys/vacancy/contentVacancy/<?=$vacancy_id?>/'+$("#frompage").val()+'?status=remove_candidate');
       
						}else if(data=="remove_one"){
							w2ui['layoutdetcandidate'].load('main', '{site_url}/hrsys/vacancy/processCandidate/<?=$vacancy_id."/".$candidate_id?>?status=delete_trail');
						}
						
						$("#ajaxDiv").attr("class", "ajax-hide");
						
					}
					
				});
			
			}); 
            return false;

        });
        if (w2ui['listCandidateTrail'])
            $().w2destroy("listCandidateTrail");

        $('#listCandidateTrail').w2grid({
				name    : 'listCandidateTrail',
                autoLoad: false,
                limit:50,
                url     : '{site_url}/hrsys/candidate/historyCandidate/<?= $candidate_id . "/" . $vacancy_id ?>',
                header  : 'List of lookup',
                show: {
                toolbar       : false
                },
                columns: [
{field: 'recid', caption: '', size: '30px', searchable: false, sortable: false,
                    render: function (record) {                      
                       
                         return "<span class='fa-zoom-in imgbt' onClick='detailTrail(\""+record.recid+"\")' ></span>"
                    }
                },
                { field: 'ct_sp_datecreate', caption: 'Action Date', size: '100px', searchable: false, sortable: true  }
                , { field: 'ct_sp_description', caption: 'Description', size: '100%', searchable: true, sortable: true  }
<?php if (!$vacancy_id != 0) { ?>
                    , { field: 'v_sp_name', caption: 'Vacancy', size: '150px', searchable: false, sortable: true  }
                    , { field: 'c_sp_name', caption: 'Client', size: '150px', searchable: false, sortable: true  }
<?php }
?>

                ],
                postData: {
                'pg_action' : 'json'
                }
		});
		
		
                
		$("#formnya").submit(function (event) {
            $.ajax({
                type: "POST",
                data: $(this).serialize(),
                url     : '{site_url}/hrsys/vacancy/processCandidate/<?= $vacancy_id . "/" . $candidate_id ?>',
                beforeSend: function (xhr) {
                    $("#ajaxDiv").attr("class", "ajax-show");

                },
                success: function (data) {
					w2ui['layoutdetcandidate'].content('main',data);
					
					$("#ajaxDiv").attr("class", "ajax-hide");
                    
                }
                
            });
            return false;

        });	

<?php
			switch ($vacancyCandidate["applicant_stat"]) {
				case applicant_stat_processinterview:?>
				$("#interview_remider").click(function() {
					if (this.checked) {						
						$('#remider_desc_view').show();
					}else{
						$('#remider_desc_view').hide();
					}
				});
			
<?php			break;
				case applicant_stat_processtoclient:?>

<?php			break;
				case applicant_stat_offeringsalary:?>

<?php			break;
				case applicant_stat_rejectedfromcandidate:?>

<?php			break;
				case applicant_stat_rejectedfromclient:?>

<?php			break;
				case applicant_stat_notqualified:?>

<?php			break;
				case applicant_stat_placemented:?>

<?php			break;
					
			}?>		
		$(this).init_js("{base_url}");
});
</script>