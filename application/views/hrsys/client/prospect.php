<div id="listClient" class="tablegrid_stylefull"></div>

 <script>
$(function () {
    gridName='listClient';
    $('#listClient').w2grid({
        name    : gridName,
        url     : '{site_url}/hrsys/client/json_listClient/prospect',
        header  : 'Prospect client',
        show: {
            header        : true,
            toolbar       : true,
            footer        : true
        },
        columns: [
            { field: 'cl_sp_name', caption: 'Client', size: '100%', searchable: true,sortable: true  },
            { field: 'cl_sp_cp_name', caption: 'Contact Person', size: '150', searchable: true,sortable: true  },
            { field: 'cl_sp_cp_phone', caption: 'CP Phone', size: '100', searchable: true,sortable: true  },
         
        ],
        onAdd: function (event) {
            editClient(0);
        },
        onDblClick: function (event) {
            editClient(event.recid);
        }
    });

    
});

function editClient(recid) {
    $().w2popup('open', {
        name    : 'client_form',
        title   : (recid == 0 ? 'Add Client' : 'Edit Client'),
        body    : '<div id="client_form" class="framepopup">please wait..</div>',
        style   : 'padding: 15px 0px 0px 0px',
        width   : 500,
        height  : 300, 
        modal:true,
        onOpen  : function (event) {
            event.onComplete = function () {
                
               $( "#client_form" ).load( "{site_url}/admin/client/showForm/"+recid, function() {});
            }
           
        }
    });
}
</script>