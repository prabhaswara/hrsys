<?php
$cmpyclient_ctrk_id  = isset($postForm["cmpyclient_ctrk_id"]) ? $postForm["cmpyclient_ctrk_id"] : "0";
?>

{message}

<div id="meet_tabs" style="width: 100%; height: 29px;"></div>
<div id="meet_tabs_c" class="tabboxwui2" style="min-height: 320px" >
    <div id="tabs-1" class="contentTab"  style="display:none" >
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
        
    </div>
    <div id="tabs-2" class="contentTab"  style="display:none" >
        <input type="button" id="delete" value="Delete" class="w2ui-btn w2ui-btn-red"/>
        
    </div>
</div>


        







<script>
    $(function () {       
        
      $("#delete").click(function () {
    
        w2confirm('Are you sure Delete This Contract ?')
        .yes(function () { 
        
            $.ajax({
                type: "POST",            
                url: '{site_url}/hrsys/client/deleteContract/<?=$cmpyclient_ctrk_id?>',
                beforeSend: function (xhr) {
                    $("#ajaxDiv").attr("class", "ajax-show");

                },
                success: function (data) {
                    w2popup.close();
                    w2ui['listInfContract'].reload();
                    $("#ajaxDiv").attr("class", "ajax-hide");
                    
                }                
            });
        
        });           
        return false;
    });  
        
      if (w2ui['meet_tabs'])
            $().w2destroy("meet_tabs");
        
      $("#meet_tabs").w2tabs(
                {
                    name: 'meet_tabs',
                    tabs: [
                        {id: 'tabs-1', caption: 'Schedule'}
 <?php if($isEdit){ ?> ,{id: 'tabs-2', caption: 'Delete'}
 <?php } ?>                
                    ],
                    onClick: function (event) {

                        $(".contentTab").hide();
                        $("#" + event.tab.id).show();


                    }
                });
        w2ui['meet_tabs'].click('tabs-1');
        

        $("#formnya").gn_onPopupSubmitFile("popupForm", w2ui["listInfContract"]);        

        $(this).init_js("{base_url}");



    });
</script>

