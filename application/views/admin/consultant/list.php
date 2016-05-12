
<div id="listConsultant" class="tablegrid_stylefull"></div>

 <script>
$(function () {
    gridName='listConsultant';
    $('#listConsultant').w2grid({
        name    : gridName,
        autoLoad: false,
        limit:50,
        url     : '{site_url}/admin/consultant/json_list',
        header  : 'List of consultant',
        show: {
            header        : true,
            toolbar       : true,
            footer        : true,
            toolbarAdd    : true,
            toolbarDelete : true
        },
        columns: [
            { field: 'consultant_code', caption: 'Consultant Id', size: '150px', searchable: true,sortable: true  },
            { field: 'name', caption: 'Name', size: '100%', searchable: true,sortable: true  },
         
        ],
        onAdd: function (event) {
            editConsultant(0);
        },
        onDelete: function (event) {          
            w2ui['listConsultant'].url = '{site_url}/admin/consultant/delete';
        },
        onLoad: function (event) {
         w2ui['listConsultant'].url = '{site_url}/admin/consultant/json_list';
        },
        onDblClick: function (event) {
            editConsultant(event.recid);
        }
    });

    
});

function editConsultant(recid) {
    $().w2popup('open', {
        name    : 'consultant_form',
        title   : (recid == 0 ? 'Add Consultant' : 'Edit Consultant'),
        body    : '<div id="consultant_form" class="framepopup">please wait..</div>',
        style   : 'padding: 15px 0px 0px 0px',
        width   : 500,
        height  : 300, 
        modal:true,
        onOpen  : function (event) {
            event.onComplete = function () {
                
               $( "#consultant_form" ).load( "{site_url}/admin/consultant/showForm/"+recid, function() {});
            }
           
        }
    });
}
</script>