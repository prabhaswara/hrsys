<div>
<?php if($canedit){
?>
    <button  id="addContract"> <span class="fa-edit">&nbsp;</span> Add Contract</button>
<?php } ?>
    <div id="listInfContract" style="height:300px" ></div>
</div>

<script>
    $(function () {
        $("#addContract").click(function () {
            showForm(0);
            return false;
        });
        $('#listInfContract').w2grid({
            name: 'listInfContract',
            autoLoad: false,
            limit:50,
            url: '{site_url}/hrsys/client/infContract/<?= $client_id ?>',
            show: {toolbar: true},
            columns: [
          
                {field: 'recid', caption: '', size: '30px', searchable: false, sortable: false,
                    render: function (record) {                   
                       
                       return "<span class='fa-zoom-in imgbt' onClick='viewContract(\""+record.recid+"\")' ></span>"
     
                    }
                },
                {field: 'recid', caption: '', size: '30px', searchable: false, sortable: false,
                    render: function (record) {                   
                       
                       return "<span class='fa-download imgbt' onClick='dowloadContract(\""+record.recid+"\")' ></span>"
     
                    }
                },
                {field: 'recid', caption: '', size: '30px', searchable: false, sortable: false,
                    render: function (record) {                      
                       
                        if(record.vu_sp_user_id!=null || 1==<?=$canedit?"1":0 ?>){
                        return "<span class='fa-edit imgbt' onClick='showForm(\""+record.recid+"\")' ></span>"

                        }
                        else{
                         return "";
                        }
                    }
                },
         
                {field: 'contract_num', caption: 'Contract Number', size: '100%', searchable: true, sortable: true},
                {field: 'fee', caption: 'Fee(%)', size: '100px', searchable: false, sortable: true},
                {field: 'contractdate_1', caption: 'Begin Date', size: '120px', searchable: false, sortable: true},
                {field: 'contractdate_2', caption: 'Expire Date', size: '120px', searchable: false, sortable: true}
                
            ],
            postData: {
                'pg_action': 'json'
            },
            onRequest: function(event) {
                event.postData.typesearch=$("#typesearch").val();
                           
            },  
            <?php if($canedit){ ?>
            onDblClick: function (event) {
                viewContract(event.recid);
            },
            <?php } ?>
            onResize : function(event) {
                //<select id='typesearch' onchange='typesearchChange()'><option value='active'>Active Schedule</option><option value='all'>All Schedule</option></select>
                //typesearchspan
                typesearch=$("#typesearchhide").val();
             
                $("#typesearchspan").html("");

                $("#typesearchspan").html(
                        "<select id='typesearch' onchange='typesearchChange(this.value)'>"+
                        "<option value='open' "+(typesearch=="open"?"selected":"")+">Open Vacancies</option>"+
                        "<option value='all' "+(typesearch=="all"?"selected":"")+">All Vacancies</option></select>");
                
           
                 
            }  
        });
            
     

        $(this).init_js("{base_url}");
    });
    function typesearchChange(valuenya)
    {
        $("#typesearchhide").val(valuenya);
        w2ui['listInfContract'].reload();
    }
    function showForm(recid) {
        $().w2popup('open', {
            name: 'lookup_form',
            title: (recid == 0 ? 'Create Contract' : 'Edit Contract'),
            body: '<div id="popupForm" class="framepopup">please wait..</div>',
            style: 'padding: 0px 0px 0px 0px',
            width: 500,
            height: 400,
            modal: true,
            onOpen: function (event) {
                event.onComplete = function () {

                    $("#popupForm").load("{site_url}/hrsys/client/formContract/<?= $client_id ?>/" + recid, function () {
                    });
                }

            }
        });
    }

    function viewContract(id) {
       $().w2popup('open', {
            name: 'lookup_form',
            title: 'View Contract',
            body: '<div id="popupForm" class="framepopup">please wait..</div>',
            style: 'padding: 0px 0px 0px 0px',
            width: 800,
            height: 500,
            modal: true,
            onOpen: function (event) {
                event.onComplete = function () {
                    $("#popupForm").load("{site_url}/hrsys/client/viewContract/" + recid, function () {
                    });
                }

            }
        });
        
       return false;
    }
    function dowloadContract(){
        return false;
    }
    
    
</script>