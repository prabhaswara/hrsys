<?php
$candidate_id = $candidate["candidate_id"];
$vacancy_id = $vacancy["vacancy_id"];
?>

<div style="position: absolute;right: 10px;left: 10px;bottom: 240px; top: 10px; overflow: auto ">

    <ul id="workflow" class="h_workflow" style="margin: 0px;padding: 0px;">
        <?php
            if(!empty($headerTrail))
            foreach($headerTrail as $row){
                echo "<li><a href=''>Add To Shortlist</a></li>";
            }
        ?>
       
        <!--<li class="failed"><a href="#">Rejected</a></li>-->

        <li><a href="#" ></a></li>
    </ul>
    {message}
<form method="POST" id="formnya" class="form-tbl" action="<?= $site_url . "/hrsys/vacancy/processCandidateDet/" .$trail["trl_id"] ?>">
        <?= frm_('trl_id', $trail["trl_id"], "type='hidden'") ?>   

    
    
        <table>
            <tr>
                <td >Candidate Name</td><td width="3px">:</td>
                <td><?= $candidate["name"] ?></td>        
            </tr>
            <tr>
                <td >Current State</td><td width="3px">:</td>
                <td><?= $vacancyCandidate["applicant_stat_t"] ?></td>        
            </tr>
            <tr>
                <td >Next State</td><td width="3px">:</td>
                <td>
                    <?= select_('applicant_stat_next', $postForm,$listNextState," class='kendodropdown w250' ") ?>
                       
                </td>        
            </tr>
            <tr>
                <td >Description</td><td width="3px">:</td>
                <td>
                    <?= textarea_('description', $postForm, "class='w250' ") ?>
                       
                </td>        
            </tr>
        </table>
    <input type="submit" name="action" id="action" value="Save Drat" class="w2ui-btn"/>
    <input type="submit" name="action" id="action" value="Next Process" class="w2ui-btn"/>
</form>


</div>
<div  style="position: absolute;right: 10px;left: 10px;bottom: 210px;">

    <button id="createSchedule" > <span class="fa-edit">&nbsp;</span> Create Schedule</button>
    <button id="createNote" > <span class="fa-edit">&nbsp;</span> Create Note</button>


</div>

<div   id="listCandidateTrail"  style="position: absolute;right: 10px;left: 10px;bottom: 10px;height: 200px;">

</div>


<script>
    $(function () {
        
        var ulWidth = -40;
        $("#workflow li a").each(function() {
            ulWidth = ulWidth + $(this).width()+55
        });
        
        $("#workflow").width(ulWidth);

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
    $(this).init_js("{base_url}");
            });
</script>