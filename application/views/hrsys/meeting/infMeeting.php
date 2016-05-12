<div>
    <input type="hidden" id="typesearchhide" value="active"/>
    <?php if($canedit) { ?>
    <button class="w2ui-btn w2ui-btn-green"  style='margin-bottom:5px'  id="createAppointment" > <span class="fa-edit">&nbsp;</span> Create an Appointment</button>
    <?php } ?>
    
    <div id="listInfMeeting" style="height:300px" ></div>

</div>

<script>
    $(function () {

        $("#createAppointment").click(function () {
            showForm(0);
            return false;
        });
         



        $('#listInfMeeting').w2grid({
            name: 'listInfMeeting',
            autoLoad: false,
            limit:50,
            url: '{site_url}/hrsys/meeting/infMeeting/<?= $client_id ?>',
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
                        return "<span class='fa-zoom-in imgbt' onclick='detailMeet(\"" + record.recid + "\")' ></span>"
                    }
                },
                {field: 'recid', caption: '', size: '30px', searchable: false, sortable: false,
                    render: function (record) {
                        if(record.canedit=="1"){
                            return "<span class='fa-edit imgbt' onclick='editMeet(\"" + record.recid + "\")'></span>"
                        }else{
                            return "";
                        }           
                    }
                },
                {field: 'lktype_sp_display_text', caption: 'Type', size: '120px', searchable: true, sortable: true},
                {field: 'met_sp_meettime', caption: 'Date', size: '100px', searchable: false, sortable: true,
                    render: function (record) {
                    dateArray=record.met_sp_meettime.split(" ");
                    kembali=dateArray[0];
                        if(record.lewat==1){
                            
                            kembali="<span style='color:red'>"+kembali+"</span>";
                        }                       
                        return kembali;

                    }
                },
                {field: 'met_sp_meettime', caption: 'Time', size: '50px', searchable: false, sortable: true,
                    render: function (record) {
                        dateArray=record.met_sp_meettime.split(" ");
                        kembali="";
                        if(dateArray.length>1)
                            kembali=dateArray[1];
                                         
                        return kembali;

                    }
                },
                {field: 'met_sp_description', caption: 'Description', size: '100%', searchable: true, sortable: true},
                {field: 'lkout_sp_display_text', caption: 'Outcome', size: '120px', searchable: true, sortable: true},
                {field: 'met_sp_outcome_desc', caption: 'Outcome Description', size: '200px', searchable: true, sortable: true}
            ],
            postData: {
                'pg_action': 'json'
            },
            onRequest: function(event) {
                event.postData.typesearch=$("#typesearch").val();
                           
            },  
            onResize : function(event) {
                //<select id='typesearch' onchange='typesearchChange()'><option value='active'>Active Schedule</option><option value='all'>All Schedule</option></select>
                //typesearchspan
                typesearch=$("#typesearchhide").val();
             
                $("#typesearchspan").html("");

                $("#typesearchspan").html(
                        "<select id='typesearch' onchange='typesearchChange(this.value)'>"+
                        "<option value='active' "+(typesearch=="active"?"selected":"")+">Active Schedule</option>"+
                        "<option value='all' "+(typesearch=="all"?"selected":"")+">All Schedule</option></select>");
                
           
                 
            }  
        });
            
     

        $(this).init_js("{base_url}");
    });
    function typesearchChange(valuenya)
    {
        $("#typesearchhide").val(valuenya);
        w2ui['listInfMeeting'].reload();
    }
    function showForm(recid) {
        $().w2popup('open', {
            name: 'lookup_form',
            title: (recid == 0 ? 'Create an Appointment' : 'Edit Appointment'),
            body: '<div id="popupForm" class="framepopup">please wait..</div>',
            style: 'padding: 5px 0px 0px 0px',
            width: 510,
            height: 500,
            modal: true,
            onOpen: function (event) {
                event.onComplete = function () {

                    $("#popupForm").load("{site_url}/hrsys/meeting/showform/<?= $client_id ?>/" + recid, function () {
                    });
                }

            }
        });
    }

    function detailMeet(id) {
        $().w2popup('open', {
            name: 'lookup_form',
            title: 'View',
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
    function editMeet(id) {
        showForm(id);
    }

</script>