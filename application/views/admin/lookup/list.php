
    <div id="listLookup" class="tablegrid_stylefull"></div>

 <script>
$(function () {
    gridName='listLookup';

    $('#listLookup').w2grid({
        name    : gridName,
        url     : '{site_url}/admin/lookup/json_list',
        header  : 'List of lookup',
        show: {
            header        : true,
            toolbar       : true,
            footer        : true,
            toolbarAdd    : true,
            toolbarDelete : true
        },
        columns: [
            { field: 'type', caption: 'Type', size: '150px', searchable: true,sortable: true  },
            { field: 'value', caption: 'Value', size: '150px', searchable: true,sortable: true  },
            { field: 'display_text', caption: 'Name', size: '100%', searchable: true,sortable: true  },
            { field: 'order_num', caption: 'Ordering number', size: '150px', searchable: true,sortable: true  }
        
        ],
        onAdd: function (event) {
            editLookup(0);
        },
        onDelete: function (event) {          
            w2ui['listLookup'].url = '{site_url}/admin/lookup/delete';
        },
        onLoad: function (event) {
         w2ui['listLookup'].url = '{site_url}/admin/lookup/json_list';
        },
        onDblClick: function (event) {
            editLookup(event.recid);
        }
    });

    
});

function editLookup(recid) {
    $().w2popup('open', {
        name    : 'lookup_form',
        title   : (recid == 0 ? 'Add Lookup' : 'Edit Lookup'),
        body    : '<div id="lookup_form" class="framepopup">please wait..</div>',
        style   : 'padding: 15px 0px 0px 0px',
        width   : 500,
        height  : 300, 
        onOpen  : function (event) {
            event.onComplete = function () {
                
               $( "#lookup_form" ).load( "{site_url}/admin/lookup/showForm/"+recid, function() {});
            }
           
        }
    });
}
</script>