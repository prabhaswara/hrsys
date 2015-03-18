<div style="height: 60px">
   <h2 class="form-title"><?=$candidate["name"] ?></h2>
    <div style="padding: 10px;">
        <?php
        echo breadcrumb_($breadcrumb)
        ?>
    </div> 
</div>
<input type="hidden" id="frompage" value="{frompage}" />
<div id="candidateTab" style="width: 100%; height: 29px;"></div>
<div id="candidateTab_c" class="tabboxwui2" style="position: absolute;top: 89px;bottom: 10px;left: 0px;right: 0px"></div>


<script>
    
    $(function() {      
        
        $(".gn_breadcrumb a").click(function() {
            href = $(this).attr("href");
            if (href != "#" && href != "") {
                $.fn.gn_loadmain(href);
            }
            return false;

        });
        function selectCandidate(tab){                 
            for (var widget in w2ui) {
                var nm = w2ui[widget].name;
                if (['main_layout', 'sidebar','candidateTab'].indexOf(nm) == -1)
                    $().w2destroy(nm);
            }
            if(tab=="info"){
                $("#candidateTab_c").load('{site_url}/hrsys/candidate/infoCandidate/<?=$candidate["candidate_id"] ?>/<?=$vacancy_id ?>/show');
            }else if(tab=="cv"){
                $("#candidateTab_c").load('{site_url}/hrsys/candidate/cvCandidate/<?=$candidate["candidate_id"] ?>/<?=$vacancy_id ?>/show');
            }else if(tab=="history"){
                $("#candidateTab_c").load('{site_url}/hrsys/candidate/historyCandidate/<?=$candidate["candidate_id"] ?>/<?=$vacancy_id ?>/show');
            }            
        }
        
        var config={
            candidateTab:{
                    name: 'candidateTab',
                    tabs: [
                        { id: 'info', caption: 'Info Candidate' },
                        { id: 'cv', caption: 'Curriculum Vitae' },
                        { id: 'history', caption: 'History' }

                    ],
                    onClick: function (event) {
                        selectCandidate(event.tab.id);
                    }
                } 
        };
        

        $("#candidateTab").w2tabs(config.candidateTab);
        w2ui['candidateTab'].click('info'); 
        
        $(this).init_js("{base_url}");

    });
</script>
