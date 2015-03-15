<div id="listClient" class="tablegrid_stylefull"></div>

 <script>
$(function () {
    gridName='listClient';
    $('#listClient').w2grid({
        name    : gridName,
        url     : '{site_url}/hrsys/client/json_listClient/prospect',
        header  : 'Prospect client',
        autoLoad: false,
        limit:50,
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
        onDblClick: function (event) {
           $(this).gn_loadmain('{site_url}/hrsys/client/detclient/'+event.recid+'/prospect');
        }
    });

    
});

</script>