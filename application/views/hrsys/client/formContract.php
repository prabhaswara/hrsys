<?php
$cmpyclient_ctrk_id  = isset($postForm["cmpyclient_ctrk_id"]) ? $postForm["cmpyclient_ctrk_id"] : "0";
?>

{message}


        <form method="POST" id="formnya" class="form-tbl" enctype="multipart/form-data" action="<?= $site_url . "/hrsys/client/formContract/" . $client["cmpyclient_id"] . "/" . $cmpyclient_ctrk_id  ?>">
            <?= frm_('cmpyclient_ctrk_id', $postForm, "type='hidden'") ?>             

            <table>
                <tr>
                    <td class="aright">Contract Number:</td>
                    <td>
                       <?= frm_('contract_num', $postForm, "class='w250 required'") ?>
                    </td>        
                </tr>
                <tr>
                    <td class="aright">Begin Date :</td>
                    <td>
                        <?= frm_('contractdate_1', $postForm, "class='w150 date required'") ?>
                    </td>        
                </tr>
                <tr>
                    <td class="aright">End Date :</td>
                    <td>
                        <?= frm_('contractdate_2', $postForm, "class='w150 date required'") ?>
                    </td>        
                </tr>
                <tr>
                    <td class="aright">Fee(%) :</td>
                    <td><?= frm_('fee', $postForm, "class='w150 number'") ?>
                    
                    </td> 
                </tr>        
                <tr>
                    <td class="aright">File :</td>
                    <td><input name="doc_url" type="file" class='w250' />
                    
                    </td> 
                </tr>        

                      
            </table>
            <input type="submit" name="action" id="action" value="Save" class="w2ui-btn"/>
        </form>







<script>
    $(function () {       
      

        $("#formnya").gn_onPopupSubmitFile("popupForm", w2ui["listInfContract"]);        

        $(this).init_js("{base_url}");



    });
</script>

