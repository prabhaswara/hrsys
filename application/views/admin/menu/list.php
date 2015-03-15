
<div id="listMenu" class="tablegrid_stylefull"></div>

 <script>
$(function () {
 
    $('#listMenu').w2grid({
        name    : 'listMenu',
        autoLoad: false,
        limit:50,
        url     : '{site_url}/admin/menu/json_list',
        header  : 'List of menu',
        show: {
            header        : true,
            toolbar       : true,
            footer        : true,
            toolbarAdd    : true,
            toolbarDelete : true
        },
        columns: [
            { field: 'pp_sp_menu_title', caption: 'Parent', size: '150px', searchable: true,sortable: true  },
            { field: 'mn_sp_menu_title', caption: 'Menu Title', size: '150px', searchable: true,sortable: true  },
            { field: 'mn_sp_url', caption: 'Url', size: '100%', searchable: true,sortable: true  },
            { field: 'mn_sp_attributes', caption: 'attributes', size: '150px', searchable: true,sortable: true  },
            { field: 'lk_sp_display_text', caption: 'Active/Non', size: '100px', searchable: true,sortable: true  },
            { field: 'mn_sp_order_num', caption: 'Ordering Num', size: '100px', searchable: true,sortable: true  },
            { field: 'rl_sp_name', caption: 'Role', size: '100px', searchable: true,sortable: true  }
            
        ],
        onAdd: function (event) {
            editMenu(0);
        },
        onDelete: function (event) {          
            w2ui['listMenu'].url = '{site_url}/admin/menu/delete';
        },
        onLoad: function (event) {
         w2ui['listMenu'].url = '{site_url}/admin/menu/json_list';
        },
        onDblClick: function (event) {
            editMenu(event.recid);
        }
    });

    
});

function editMenu(recid) {
    $().w2popup('open', {
        name    : 'menu_form',
        title   : (recid == 0 ? 'Add Menu' : 'Edit Menu'),
        body    : '<div id="menu_form" class="framepopup">please wait..</div>',
        style   : 'padding: 15px 0px 0px 0px',
        width   : 500,
        height  : 300, 
        modal:true,
        onOpen  : function (event) {
            event.onComplete = function () {
                
               $( "#menu_form" ).load( "{site_url}/admin/menu/showForm/"+recid, function() {});
            }
           
        }
    });
}
</script>