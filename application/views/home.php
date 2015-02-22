<script type="text/javascript">
    $(function () {
        $("#homebox-1").resize(function () {
          
            homeboxresize($(this));

        });
        $("#homebox-2").resize(function () {
            homeboxresize($(this));

        });
        
        homeboxresize($("#homebox-1"));
        homeboxresize($("#homebox-2"));

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


<div style="padding:10px" id="content-home">
    <div class="gn_square homebox" id="homebox-1" style="width: 100%">
        <div class="k-window-content">
            <div>Next Meeting</div>
            <div style="height:200px">
                <div id="meeting_grid" style="height: 198px"></div>
            </div>    
        </div>

    </div>
    <div class="gn_square homebox" id="homebox-2"  style="width: 100%">
        <div class="k-window-content">
            <div>Next Interview</div>
            <div style="height:200px">

            </div>

        </div>
    </div>

    <div class="gn_square homebox" id="homebox-3"  style="width: 98%">
        <div class="k-window-content">
            <div>Active Vacancy</div>
            <div style="height:200px">

            </div>

        </div>
    </div>

</div>
<script>
    $(function () {
        

        
        $('#meeting_grid').w2grid({
            name: 'meeting_grid',
            url: '{site_url}/hrsys/meeting/json_nextmeeting/{user_id}',
         //   show: {toolbar: false},    
            columns: [
                {field: 'meetime', caption: 'Time', size: '190px', searchable: true, sortable: true
                ,render: function (record) {
                    kembali=record.meetime;
                        if(record.datediff<0){
                            
                            kembali="<span style='color:red'>"+kembali+"</span>";
                        }                       
                        return kembali;

                    }
                },
                
                {field: 'description', caption: 'Description', size: '100%', searchable: false, sortable: false}
            ],
            
            onDblClick: function (event) {
                detailMeet(event.recid);
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
            onOpen: function (event) {
                event.onComplete = function () {

                    $("#popupForm").load("{site_url}/hrsys/meeting/showDetail/" + id, function () {
                    });
                }

            }
        });
    }

    });
</script>