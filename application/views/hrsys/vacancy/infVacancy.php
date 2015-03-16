<div>
    <input type="hidden" id="typesearchhide" value="open"/>
    <?php if($canedit){ ?>
    <button id="createAppointment" > <span class="fa-edit">&nbsp;</span> Add Job Vacancy</button>
    <?php }?>
    <div id="listInfVacancy" style="height:300px" ></div>

</div>

<script>
    $(function () {

        $("#createAppointment").click(function () {
            showForm(0);
            return false;
        });
         



        $('#listInfVacancy').w2grid({
            name: 'listInfVacancy',
            autoLoad: false,
            limit:50,
            url: '{site_url}/hrsys/vacancy/infVacancy/<?= $client_id ?>',
            show: {toolbar: true},
            toolbar: {
                items: [
                    { type: 'break' },
                    { type: 'html',  id: 'item6',
                            html: "<span id='typesearchspan'></span>" 
                    }
                ],
                onClick: function (target, data) {
                  
                }
            },
            columns: [
          
                {field: 'recid', caption: '', size: '30px', searchable: false, sortable: false,
                    render: function (record) {
                      
                       
                        if(record.vu_sp_user_id!=null || 1==<?=$canedit?"1":0 ?>){
                        return "<span class='fa-zoom-in imgbt' onClick='detailVac(\""+record.recid+"\")' ></span>"
                        }
                        else{
                         return "";
                        }
                    }
                },
         
                {field: 'lkstat_sp_display_text', caption: 'Status', size: '120px', searchable: true, sortable: true},
                {field: 'vac_sp_opendate', caption: 'Open Date', size: '120px', searchable: true, sortable: true},
                {field: 'vac_sp_name', caption: 'Vacany Name', size: '100%', searchable: true, sortable: true}
                
            ],
            postData: {
                'pg_action': 'json'
            },
            onRequest: function(event) {
                event.postData.typesearch=$("#typesearch").val();
                           
            },  
            <?php if($canedit){ ?>
            onDblClick: function (event) {
                detailVac(event.recid);
            },
            <?php } ?>
            onResize : function(event) {
                //<select id='typesearch' onchange='typesearchChange()'><option value='active'>Active Schedule</option><option value='all'>All Schedule</option></select>
                //typesearchspan
                typesearch=$("#typesearchhide").val();
             
                $("#typesearchspan").html("");

                $("#typesearchspan").html(
                        "<select id='typesearch' onchange='typesearchChange(this.value)'>"+
                        "<option value='open' "+(typesearch=="open"?"selected":"")+">Open Vacancies</option>"+
                        "<option value='all' "+(typesearch=="all"?"selected":"")+">All Vacancies</option></select>");
                
           
                 
            }  
        });
            
     

        $(this).init_js("{base_url}");
    });
    function typesearchChange(valuenya)
    {
        $("#typesearchhide").val(valuenya);
        w2ui['listInfVacancy'].reload();
    }
    function showForm(recid) {
        $().w2popup('open', {
            name: 'lookup_form',
            title: (recid == 0 ? 'Create Vacancy' : 'Edit Vacancy'),
            body: '<div id="popupForm" class="framepopup">please wait..</div>',
            style: 'padding: 0px 0px 0px 0px',
            width: 900,
            height: 400,
            modal: true,
            onOpen: function (event) {
                event.onComplete = function () {

                    $("#popupForm").load("{site_url}/hrsys/vacancy/showform/<?= $client_id ?>/" + recid, function () {
                    });
                }

            }
        });
    }

    function detailVac(id) {
    
       $(window).gn_loadmain('{site_url}/hrsys/vacancy/contentVacancy/'+id+'/'+$("#frompage").val());
       return false;
    }
    function editVac(id) {
        showForm(id);
    }

</script>