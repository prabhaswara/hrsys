<div style="height:450px">
    <div id="listClientTrail" style="height:300px" ></div>
    
</div>
 <script>
$(function () {
    
    $('#listClientTrail').w2grid({
        name    : 'listClientTrail',
        url     : '{site_url}/hrsys/client/infHistory/<?=$client_id?>',
        header  : 'List of lookup',
        show: {         
            toolbar       : true           
        },        
        columns: [
            { field: 'datecreate', caption: 'Action Date', size: '150px', searchable: false,sortable: true  },
            { field: 'description', caption: 'Description', size: '100%', searchable: true,sortable: true  }
        ],
        postData: {
            'pg_action' : 'json'
        }
    });

});
 </script>
