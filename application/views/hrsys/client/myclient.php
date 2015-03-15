<div id="listClient" class="tablegrid_stylefull"></div>

 <script>
$(function () {
    gridName='listClient';
    $('#listClient').w2grid({
        name    : gridName,
        autoLoad: false,
        limit:50,
        url     : '{site_url}/hrsys/client/json_listClient/my',
        header  : 'My client',
        show: {
            header        : true,
            toolbar       : true,
            footer        : true
        },
        columns: [
            { field: 'cl_sp_name', caption: 'Client', size: '100%', searchable: true,sortable: true  },
            { field: 'cl_sp_cp_name', caption: 'Contact Person', size: '150', searchable: true,sortable: true  },
            { field: 'cl_sp_cp_phone', caption: 'CP Phone', size: '100', searchable: true,sortable: true  },
            { field: 'emp_sp_fullname', caption: 'account_manager', size: '100', searchable: true,sortable: true  },
            { field: 'lk_sp_display_text', caption: 'Status', size: '100', searchable: true,sortable: true  },
         
        ],
        onDblClick: function (event) {
            $(this).gn_loadmain('{site_url}/hrsys/client/detclient/'+event.recid+'/myclient');
        }
    });

    
});


</script>