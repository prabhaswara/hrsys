<div>
<?php if($canEdit){
?>
    <button  id="editClient"> <span class="fa-edit">&nbsp;</span> Edit General Info</button>
<?php } ?>
    <div class="form-tbl" >
        <table>
            <tr>
                <td class="aright">Create By :</td>
                <td><?= $client["empcrt_fullname"] ?></td>        
            </tr>
            <tr>
                <td class="aright">Company Name :</td>
                <td><?= $client["name"] ?></td>        
            </tr>
            <tr>
                <td class="aright">Address :</td>
                <td><?= replaceNewLineBr($client["address"]) ?></td>       
            </tr>
            <tr>
                <td class="aright">Website Link :</td>
                <td><?= $client["website"] ?></td>     
            </tr>
            <tr>
                <td>Contact Person :</td>
                <td><?= $client["cp_name"] ?></td>     
            </tr>
            <tr>
                <td class="aright"><span class="fa-phone">&nbsp;</span></td>
                <td><?= $client["cp_phone"] ?></td>     
            </tr>        
            <tr>
                <td class="aright">Status :</td>
                <td><?= $client["status_text"] ?></td>     
            </tr>
            <tr >
                <td class="aright">PIC :</td>
                <td><?= $client["emp_pic"] ?></td>      
            </tr>

        </table>
    </div>
</div>
<script>
    $(function() {

        $("#editClient").click(function() {
            $().w2popup('open', {
                name: 'popup_form',
                title: 'Edit Client',
                body: '<div id="popup_form" class="framepopup">please wait..</div>',
                style: 'padding: 15px 0px 0px 0px',
                width: 500,
                height: 460,
                modal: true,
                onOpen: function(event) {
                    event.onComplete = function() {
                        $("#popup_form").load("{site_url}/hrsys/client/addEditClient/<?= $client["cmpyclient_id"] ?>", function() {
                        });
                    }

                }
            });

        });
        $(this).init_js("{base_url}");
    });
</script>