

<div style="padding:10px;min-width:700px" id="content-home">
    <div class="gn_square homebox" id="homebox-1" style="width: 98%">
        <div class="k-window-content">
            <div>Next Meeting</div>
            <div  id="meeting_grid" style="height:200px">
               
            </div>    
        </div>

    </div>
    <div class="gn_square homebox" id="homebox-2"  style="width: 98%">
        <div class="k-window-content">
            <div>Next Interview</div>
            <div style="height:200px">

            </div>

        </div>
    </div>

    <div class="gn_square homebox" id="homebox-3"  style="width: 98%">
        <div class="k-window-content">
            <div>My Client</div>
            <div id="myClient" style="height:200px"></div>

        </div>
    </div>
    
    <div class="gn_square homebox" id="homebox-4"  style="width: 98%">
        <div class="k-window-content">
            <div>Open Vacancy</div>
            <div id="myOpenVacancy" style="height:200px"></div>

        </div>
    </div>

</div>
<script>
    $(function() {



        $('#meeting_grid').w2grid({
            name: 'meeting_grid',
            url: '{site_url}/hrsys/meeting/json_nextmeeting/{user_id}',
            //   show: {toolbar: false},    
            columns: [
                {field: 'meetime', caption: 'Time', size: '190px', searchable: true, sortable: true
                    , render: function(record) {
                        kembali = record.meetime;
                        if(record.lewat==1){

                            kembali = "<span style='color:red'>" + kembali + "</span>";
                        }
                        return kembali;

                    }
                },
                {field: 'description', caption: 'Description', size: '100%', searchable: false, sortable: false}
            ],
            onDblClick: function(event) {
                detailMeet(event.recid);
            }

        });
        
     
        $('#myClient').w2grid({
            name    : "myClient",
            autoLoad: false,
            limit:20,
            url     : '{site_url}/hrsys/client/json_listClientByPIC/{emp_id}',        
            columns: [
                { field: 'cl_sp_name', caption: 'Client', size: '100%', searchable: true,sortable: true  },
                { field: 'cl_sp_cp_name', caption: 'Contact Person', size: '150', searchable: true,sortable: true  },
                { field: 'cl_sp_cp_phone', caption: 'CP Phone', size: '100', searchable: true,sortable: true  },
            
            ],
            onDblClick: function (event) {
                $(this).gn_loadmain('{site_url}/hrsys/client/detclient/'+event.recid+'/home');
            }
        });
        $('#myOpenVacancy').w2grid({
            name    : "myOpenVacancy",
            autoLoad: false,
            limit:20,
            url     : '{site_url}/hrsys/vacancy/jsonListVacOpenByPIC/{emp_id}',        
            columns: [
                { field: 'vac_sp_name', caption: 'Vacancy', size: '100%', searchable: true,sortable: true  },
                { field: 'vac_sp_opendate', caption: 'Open Date', size: '150', searchable: true,sortable: true  },
                { field: 'client_sp_name', caption: 'Client', size: '100', searchable: true,sortable: true  },
            
            ],
            onDblClick: function (event) {
                $(this).gn_loadmain('{site_url}/hrsys/vacancy/contentVacancy/'+event.recid+'/home');
            }
        });
       

        function detailMeet(id) {
            $().w2popup('open', {
                name: 'lookup_form',
                title: 'Detail Meeting',
                body: '<div id="popupForm" class="framepopup">please wait..</div>',
                style: 'padding: 5px 0px 0px 0px',
                width: 500,
                height: 500,
                onOpen: function(event) {
                    event.onComplete = function() {

                        $("#popupForm").load("{site_url}/hrsys/meeting/showDetail/" + id+"?gridReload=meeting_grid", function() {
                        });
                    }

                }
            });
        }

        $("#homebox-1").resize(function() {

            homeboxresize($(this));

        });
        $("#homebox-2").resize(function() {
            homeboxresize($(this));

        });
        $("#homebox-3").resize(function() {

            homeboxresize($(this));

        });
        $("#homebox-4").resize(function() {
            homeboxresize($(this));

        });

        homeboxresize($("#homebox-1"));
        homeboxresize($("#homebox-2"));
        homeboxresize($("#homebox-3"));
        homeboxresize($("#homebox-4"));

        function homeboxresize(box) {
            var cw = $("#content-home").width();
            var bw = box.width();
            var persen = bw / cw * 100;

            if (cw <= 900 && persen < 96) {
                box.width("98%");

            } else if (cw > 900 && persen > 48) {
                box.width("46%");
            }

        }

    });
</script>