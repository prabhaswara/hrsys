<?php
$candidate_id = $candidate["candidate_id"];
$vacancy_id = $vacancy["vacancy_id"];
?>

<div style="position: absolute;right: 10px;left: 10px;bottom: 240px; top: 10px; overflow: auto ">

    <ul id="workflow" class="h_workflow" style="margin: 0px;padding: 0px;">
        <?php
            if(!empty($workflow))
            foreach($workflow as $row){
                echo "<li><a href=''>Add To Shortlist</a></li>";
            }
        ?>
       
        <!--<li class="failed"><a href="#">Rejected</a></li>-->

        <li><a href="#" ></a></li>
    </ul>
    <div  class="form-tbl" >      
        <table>
            <tr>
                <td class="aright">Candidate Name:</td>
                <td><?= $candidate["name"] ?></td>        
            </tr>
            <tr>
                <td class="aright">Current State:</td>
                <td><?= $candidate["name"] ?></td>        
            </tr>
        </table>
    </div>


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
            });
</script>