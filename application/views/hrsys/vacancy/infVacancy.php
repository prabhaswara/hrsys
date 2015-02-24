<div>
    <button value="142459840454e9a5840c1e4" id="pindah" onclick="detailVac(this.value)">Pindah</button>
    <input type="hidden" id="typesearchhide" value="open"/>
    <button id="createAppointment" > <span class="fa-edit">&nbsp;</span> Add Job Vacancy</button>
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
                        return "<span class='fa-zoom-in imgbt' onClick='$( \"#pindah\" ).click()' ></span>"
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
            onDblClick: function (event) {
                detailVac(event.recid);
            },
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
            style: 'padding: 5px 0px 0px 0px',
            width: 500,
            height: 500,
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