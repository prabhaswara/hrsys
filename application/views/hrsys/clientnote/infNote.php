<div>
    <input type="hidden" id="typesearchhide" value="active"/>
    <?php if($canedit) { ?>
    <button id="createNote" > <span class="fa-edit">&nbsp;</span> Create Note</button>
    <?php } ?>
    
    <div id="listinfNote" style="height:300px" ></div>

</div>

<script>
    $(function () {

        $("#createNote").click(function () {
            showForm(0);
            return false;
        });
         



        $('#listinfNote').w2grid({
            name: 'listinfNote',
            autoLoad: false,
            limit:50,
            url: '{site_url}/hrsys/clientnote/infNote/<?= $client_id ?>',
            show: {toolbar: true},
            columns: [
                
                {field: 'recid', caption: '', size: '30px', searchable: false, sortable: false,
                    render: function (record) {
                        if(record.canedit=="1"){
                            return "<span class='fa-edit imgbt' onclick='editNote(\"" + record.recid + "\")'></span>"
                        }else{
                            return "";
                        }           
                    }
                },
                {field: 'description', caption: 'Note', size: '100%', searchable: true, sortable: true},
                
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
            title: (recid == 0 ? 'Create Note' : 'Edit Note'),
            body: '<div id="popupForm" class="framepopup">please wait..</div>',
            style: 'padding: 5px 0px 0px 0px',
            width: 500,
            height: 200,
            modal: true,
            onOpen: function (event) {
                event.onComplete = function () {

                    $("#popupForm").load("{site_url}/hrsys/clientnote/showform/<?= $client_id ?>/" + recid, function () {
                    });
                }

            }
        });
    }


    function editNote(id) {
        showForm(id);
    }

</script>