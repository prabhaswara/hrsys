<?php

?>



        <table>
            <tr>
                <td width="150px" class="aright">Action Date</td><td width="3px">:</td>
                <td><?= balikTglDate($dataTrail["datecreate"]) ?></td>        
            </tr>
			
			
			<tr>
                <td class="aright">Candidate Name</td><td width="3px">:</td>
                <td><?= $candidate["name"] ?></td>        
            </tr>
            <tr>
                <td class="aright">Current State</td><td width="3px">:</td>
                <td><?=$dataTrail["applicant_stat"] ?></td>        
            </tr>
			
<?php
			switch ($dataTrail["applicant_stat_id"]) {
				case applicant_stat_processinterview:?>
			<tr>
                <td class="aright">Date Of Interview</td><td>:</td>
                <td><?=$interview["schedule"] ?></td>        
            </tr>
			<tr>
                <td class="aright">Type</td><td>:</td>
                <td><?=$interview["type_t"] ?></td>        
            </tr>
			
			<tr>
                <td class="aright">Add a Reminder</td><td>:</td>
                <td><?=$interview["remider"] ?>
				</td>        
            </tr>
			<tr >
                <td class="aright">Reminder Desciption</td><td>:</td>
                <td><?=$interview["remider_desc"] ?></td>        
            </tr>
			
<?php			break;
				case applicant_stat_processtoclient:?>

<?php			break;
				case applicant_stat_offeringsalary:?>
			<tr>
                <td class="aright">Current Salary</td><td>:</td>
                <td><?=numSep($offeringsalary["current_salary"])." ".$offeringsalary["current_ccy"] ?></td>        
            </tr>
			<tr>
                <td class="aright">Expected Salary</td><td>:</td>
				<td><?=numSep($offeringsalary["expected_salary"])." ".$offeringsalary["expected_ccy"] ?></td>
                     
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
					<?=$placemented["date_join"]?>
                </td>        
            </tr>
			<tr>
                <td class="aright">Salary</td><td>:</td>
                <td>
					<?=numSep($placemented["salary"])." ".$placemented["salary_ccy"] ?>
                </td>        
            </tr>
<?php			break;
					
			}?>
			<tr>
                <td  class="aright">Note</td><td width="3px">:</td>
                <td>
                    <?= $dataTrail["description"] ?>
                       
                </td>        
            </tr>
			
            <tr>
                <td class="aright">Next State</td><td width="3px">:</td>
                <td><?=$dataTrail["applicant_stat_next_t"] ?>
                </td>
            </tr>

            