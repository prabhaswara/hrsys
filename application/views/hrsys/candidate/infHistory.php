<div id="listCandidateTrail" style="position: absolute;top:5px;bottom: 5px;right: 5px;left: 5px;" ></div>
   
 <script>
$(function () {
    if (w2ui['listCandidateTrail'])
        $().w2destroy("listCandidateTrail");
    
    $('#listCandidateTrail').w2grid({
        name    : 'listCandidateTrail',
        autoLoad: false,
        limit:50,
        url     : '{site_url}/hrsys/candidate/historyCandidate/<?=$candidate_id."/".$vacancy_id ?>',
        header  : 'List of lookup',
        show: {         
            toolbar       : true           
        },        
        columns: [
            
            { field: 'ct_sp_datecreate', caption: 'Action Date', size: '150px', searchable: false,sortable: true  }
            ,{ field: 'ct_sp_description', caption: 'Description', size: '100%', searchable: true,sortable: true  }
        <?php
                if(!$vacancy_id!=0){?>
            ,{ field: 'v_sp_name', caption: 'Vacancy', size: '150px', searchable: false,sortable: true  }
            ,{ field: 'c_sp_name', caption: 'Client', size: '150px', searchable: false,sortable: true  }
<?php           }
            ?>
    
        ],
        postData: {
            'pg_action' : 'json'
        }
    });

});
 </script>
