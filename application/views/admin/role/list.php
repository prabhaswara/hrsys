
<div id="listRole" class="tablegrid_stylefull"></div>

 <script>
$(function () {
    gridName='listRole';
    $('#listRole').w2grid({
        name    : gridName,
        url     : '{site_url}/admin/role/json_list',
        header  : 'List of role',
        show: {
            header        : true,
            toolbar       : true,
            footer        : true,
            toolbarAdd    : true,
            toolbarDelete : true
        },
        columns: [
            { field: 'role_id', caption: 'Role Id', size: '150px', searchable: true,sortable: true  },
            { field: 'name', caption: 'Name', size: '100%', searchable: true,sortable: true  },
         
        ],
        onAdd: function (event) {
            editRole(0);
        },
        onDelete: function (event) {          
            w2ui['listRole'].url = '{site_url}/admin/role/delete';
        },
        onLoad: function (event) {
         w2ui['listRole'].url = '{site_url}/admin/role/json_list';
        },
        onDblClick: function (event) {
            editRole(event.recid);
        }
    });

    
});

function editRole(recid) {
    $().w2popup('open', {
        name    : 'role_form',
        title   : (recid == 0 ? 'Add Role' : 'Edit Role'),
        body    : '<div id="role_form" class="framepopup">please wait..</div>',
        style   : 'padding: 15px 0px 0px 0px',
        width   : 500,
        height  : 300, 
        modal:true,
        onOpen  : function (event) {
            event.onComplete = function () {
                
               $( "#role_form" ).load( "{site_url}/admin/role/showForm/"+recid, function() {});
            }
           
        }
    });
}
</script>