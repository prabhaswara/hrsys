<?php
$vacancy = $vacancyData["vacancy"];
?>
<h2 class="form-title">Vacancy</h2>
<div class="content_body">
    <input type="hidden" id="frompage" value="{frompage}" />
    <?php
    echo breadcrumb_($breadcrumb)
    ?>

    <div id="detVacTab" style="width: 100%; height: 29px;"></div>
    <div id="detVacTab_c" class="tabboxwui2" style="position: absolute;top: 64px;bottom: 10px;left: 10px;right: 10px">
        <div id="vacancy_tab" class='divtab' style="display:none" >
            <form  class="form-tbl" >
                <table>
                    <tr>
                        <td class="aright">Status</td>
                        <td>
                            <?= $vacancy["status_text"] ?>
                        </td>        
                    </tr>

                    <tr>
                        <td class="aright">PIC:</td>
                        <td>
                            <?= $vacancy["emp_pic"] ?>
                        </td>        
                    </tr>
                    <tr>
                        <td class="aright">Open Date:</td>
                        <td>
                            <?= balikTgl($vacancy["opendate"]) ?>
                        </td>        
                    </tr>
                    <tr>
                        <td class="aright">Job Name:</td>
                        <td>
                            <?= $vacancy["name"] ?>
                        </td>        
                    </tr>
                    <tr>
                        <td class="aright">Number of Positions:</td>
                        <td>
                            <?= $vacancy["num_position"] ?>
                        </td>        
                    </tr>
                    <tr>
                        <td class="aright">Description :</td>
                        <td >
                            <?= $vacancy["description"] ?>
                        </td> 
                    </tr>          
                    <tr>
                        <td class="aright">Maintenance:</td>
                        <td >

                        </td> 
                    </tr>          
                </table>
            </form>
            <button id="addCandidate" > <span class="fa-edit">&nbsp;</span> Add Candidate</button>
            <button id="searchCandidate" > <span class="fa-search">&nbsp;</span> Search Candidate</button>
        </div>
        <div id="candidate_tab" class='divtab' style="display:none" >
            asa
        </div>
    </div>

</div>






<script>
    $(function () {

        $("#detVacTab").w2tabs(
                {
                    name: 'detVacTab',
                    tabs: [
                        {id: 'vacancy_tab', caption: 'Vacancy'}
                        , {id: 'candidate_tab', caption: 'Shortlist Candidates'}

                    ],
                    onClick: function (event) {
                        $(".divtab").hide();
                        $("#"+event.tab.id).show();
                    }
                });
        w2ui['detVacTab'].click('vacancy_tab');


        $(".gn_breadcrumb a").click(function () {
            href = $(this).attr("href");
            if (href != "#" && href != "") {
                $.fn.gn_loadmain(href);
            }
            return false;

        });

        $("#addCandidate").click(function () {
            $(window).gn_loadmain('{site_url}/hrsys/candidate/addEditCandidate/0/<?= $vacancy["vacancy_id"] ?>/{frompage}');
        });
        $("#searchCandidate").click(function () {
            $(window).gn_loadmain('{site_url}/hrsys/candidate/listCandidate/0/<?= $vacancy["vacancy_id"] ?>/{frompage}');
        });

    });
</script>
