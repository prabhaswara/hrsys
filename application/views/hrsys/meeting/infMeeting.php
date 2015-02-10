<div style="height:450px">
    <button id="createAppointment" class="jqbutton"> <span class="fa-edit">&nbsp;</span> Create an Appointment</button>
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
            url: '{site_url}/hrsys/meeting/infMeeting/<?= $client_id ?>',
            show: {
                toolbar: true
            },
            columns: [
                {field: 'recid', caption: '', size: '30px', searchable: false, sortable: false,
                    render: function (record) {
                        return "<span class='fa-zoom-in imgbt' onclick='detailMeet(\"" + record.recid + "\")' ></span>"

                    }

                },
                {field: 'recid', caption: '', size: '30px', searchable: false, sortable: false,
                    render: function (record) {
                        return "<span class='fa-edit imgbt' onclick='editMeet(\"" + record.recid + "\")'></span>"

                    }

                },
                {field: 'lktype_sp_display_text', caption: 'Type', size: '120px', searchable: true, sortable: true},
                {field: 'met_sp_meettime', caption: 'Time', size: '130px', searchable: false, sortable: true},
                {field: 'met_sp_description', caption: 'Description', size: '100%', searchable: true, sortable: true},
                {field: 'lkout_sp_display_text', caption: 'Outcome', size: '120px', searchable: true, sortable: true},
                {field: 'met_sp_outcome_desc', caption: 'Outcome Description', size: '200px', searchable: true, sortable: true}
            ],
            postData: {
                'pg_action': 'json'
            }
        });



        $(this).init_js("{base_url}");
    });
    function showForm(recid) {
        $().w2popup('open', {
            name: 'lookup_form',
            title: (recid == 0 ? 'Create an Appointment' : 'Edit Appointment'),
            body: '<div id="popupForm" class="framepopup">please wait..</div>',
            style: 'padding: 15px 0px 0px 0px',
            width: 500,
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
        alert(id);
    }
    function editMeet(id) {
        showForm(id);
    }

</script>