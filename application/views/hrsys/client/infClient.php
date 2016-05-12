<div>
<?php if($canedit){
?>
    <button class="w2ui-btn w2ui-btn-green"  style='margin-bottom:5px'  id="editClient"> <span class="fa-edit">&nbsp;</span> Edit General Info</button>
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
         <?php if($client["status"]==1){ ?>
            
            <tr >
                <td class="aright">Account Manager :</td>
                <td><?= $client["emp_am"] ?></td>      
            </tr>
            <tr >
                <td class="aright">Fee :</td>
                <td><?= $client["ck_fee"].(cleanstr($client["ck_fee"])!=""?"%":"") ?></td>      
            </tr>
         <?php } ?>
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