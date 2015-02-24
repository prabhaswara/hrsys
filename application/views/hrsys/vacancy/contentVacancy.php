<?php
    $vacancy=$vacancyData["vacancy"];
?>
<h2 class="form-title">Vacancy</h2>
<div style="padding: 10px;">
    <input type="hidden" id="frompage" value="{frompage}" />
    <?php
    echo breadcrumb_($breadcrumb)
    ?>

    <div id="detVacTab" style="width: 100%; height: 29px;"></div>
    <div id="detVacTab_c" class="tabboxwui2" style="min-height: 400px">

    </div>

</div>

<div id="vacancy_div" style="display:none" >
    <form  class="form-tbl" >
     
        <table>
            <tr>
                <td class="aright">Status</td>
                <td>
                  <?=$vacancy["status_text"] ?>
                </td>        
            </tr>
           
            <tr>
                <td class="aright">PIC:</td>
                <td>
                   <?=$vacancy["emp_pic"] ?>
                </td>        
            </tr>
            <tr>
                <td class="aright">Open Date:</td>
                <td>
                <?=  balikTgl($vacancy["opendate"]) ?>
                </td>        
            </tr>
            <tr>
                <td class="aright">Job Name:</td>
                <td>
                <?=$vacancy["name"] ?>
                </td>        
            </tr>
            <tr>
                <td class="aright">Number of Positions:</td>
                <td>
                <?=$vacancy["num_position"] ?>
                </td>        
            </tr>
            <tr>
                <td class="aright">Description :</td>
                <td >
                    <?=$vacancy["description"] ?>
                </td> 
            </tr>          
            <tr>
                <td class="aright">Maintenance:</td>
                <td >
                    
                </td> 
            </tr>          
        </table>
    </form>
</div>




<script>
    $(function () {

        $("#detVacTab").w2tabs(
                {
                    name: 'detVacTab',
                    tabs: [
                        {id: 'vacancy_tab', caption: 'Vacancy', url: ''}
                       ,{id: 'candidate_tab', caption: 'Shortlist Candidates', url: "{site_url}/hrsys/vacancy/cvCandidates/<?= $vacancy["vacancy_id"] ?>/"}
                       
                    ],
                    onClick: function (event) {
                        if(event.tab.id=="vacancy_tab"){
                            $("#detVacTab_c").html($("#vacancy_div").html());
                        }
                        else{                        
                            for (var widget in w2ui) {
                                var nm = w2ui[widget].name;
                                if (['main_layout', 'sidebar', 'detVacTab'].indexOf(nm) == -1)
                                    $().w2destroy(nm);
                            }

                            $(this).loadingShow(true);
                            $.ajax({
                                url: event.tab.url,
                                success: function (data) {
                                    $("#detVacTab_c").html(data);
                                    $(this).loadingShow(false);
                                }
                            });

                        }
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

    });
</script>
