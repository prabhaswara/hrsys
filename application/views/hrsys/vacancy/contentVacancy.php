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
            
            <div id="listProsesCandidate" style="height:300px" ></div>
        
        </div>
        
        
        <div id="candidate_tab" class='divtab' style="display:none" >
            <div id="layoutdetcandidate" style="position: absolute;top:0;bottom: 0px;left: 0px;right:0px;" >test</div>
            
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
                        , {id: 'candidate_tab', caption: 'Detail Candidates'}

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
        
        $('#layoutdetcandidate').w2layout({
            name: 'layoutdetcandidate',
            panels: [             
                { type: 'left', size: 200, resizable: true, style: "border-right:1px solid red", content: 'left' },
                { type: 'main', style: '', content: 'test', 
                    tabs: {
                        active: 'tab1',
                        tabs: [
                            { id: 'info', caption: 'Info Candidate' },
                            { id: 'cv', caption: 'Curriculum Vitae' },
                            { id: 'history', caption: 'History' },
                        ],
                        onClick: function (event) {
                            this.owner.content('main', event);
                        }
                    }
                }
            ]
        });
    
        $('#listProsesCandidate').w2grid({
            name: 'listProsesCandidate',
            url: '{site_url}/hrsys/vacancy/jsonVacancyCandidate/<?=$vacancy["vacancy_id"] ?>',
            show: {toolbar: true},
            toolbar: {
                items: [
                    { type: 'break' },
                    { type: 'html',  id: 'item6',
                            html: "<span id='typesearchspan'></span>" 
                    }
                ]
            },
            columns: [
                {field: 'recid', caption: '', size: '30px', searchable: false, sortable: false,
                    render: function (record) {
                        return "<span class='fa-zoom-in imgbt' onclick='detailMeet(\"" + record.recid + "\")' ></span>"
                    }
                },
                {field: 'c_sp_name', caption: 'Name', size: '100%', searchable: true, sortable: true},
                {field: 'c_sp_phone', caption: 'Phone', size: '120px', searchable: true, sortable: true},
                {field: 'cv_sp_expectedsalary', caption: 'Expected Salary', size: '120px', searchable: true, sortable: true},
                {field: 'klstate_sp_display_text', caption: 'State', size: '120px', searchable: true, sortable: true}
            ],
            onRequest: function(event) {
                event.postData.typesearch=$("#typesearch").val();
                           
            },  
            onResize : function(event) {
              
                typesearch=$("#typesearchhide").val();             
                $("#typesearchspan").html("");

                $("#typesearchspan").html(
                        "<select id='typesearch' onchange='typesearchChange(this.value)'>"+
                        "<option value='' "+(typesearch==""?"selected":"")+">All</option>"+
                      <?php /*  "<option value='active' "+(typesearch=="active"?"selected":"")+">Active Schedule</option>"+ */ ?>
                        "</select>");
                
           
                 
            }  
        });
        
        

        $("#addCandidate").click(function () {
            $(window).gn_loadmain('{site_url}/hrsys/candidate/addEditCandidate/0/<?= $vacancy["vacancy_id"] ?>/{frompage}');
        });
        $("#searchCandidate").click(function () {
            $(window).gn_loadmain('{site_url}/hrsys/candidate/listCandidate/0/<?= $vacancy["vacancy_id"] ?>/{frompage}');
        });

    });
</script>
