<?php
$note_id = isset($postForm["note_id"]) ? $postForm["note_id"] : "0";
?>

{message}

<div id="meet_tabs" style="width: 100%; height: 29px;"></div>
<div id="meet_tabs_c" class="tabboxwui2" >
    <div id="tabs-1" class="contentTab"  style="display:none" >
        <form method="POST" id="formnya" class="form-tbl" action="<?= $site_url . "/hrsys/clientnote/showform/" . $client["cmpyclient_id"] . "/" . $note_id ?>">
            <?= frm_('note_id', $postForm, "type='hidden'") ?>   
            <input type="hidden" name="do" value="schedule"/>
            <table> 
                <tr>
                    <td class="aright">Note:</td>
                    <td><?= frm_('description', $postForm, "class='w300'") ?></td>        
                </tr>                        
            </table>
            <input type="submit" name="action" id="action" value="Save" class="w2ui-btn"/>
        </form>

    </div>
    <?php if ($isEdit) { ?>
       
        <div id="tabs-2" class="contentTab" style="display:none">
            <input type="button" id="delete" value="Delete" class="w2ui-btn w2ui-btn-red"/>
        </div>
    <?php } ?>
</div>




<script>
    $(function () {
        
        if (w2ui['meet_tabs'])
            $().w2destroy("meet_tabs");

        $("#meet_tabs").w2tabs(
                {
                    name: 'meet_tabs',
                    tabs: [
                        {id: 'tabs-1', caption: 'Note'}
 <?php if($isEdit){ ?> 
                       ,{id: 'tabs-2', caption: 'Delete'}
 <?php } ?>                
                    ],
                    onClick: function (event) {

                        $(".contentTab").hide();
                        $("#" + event.tab.id).show();


                    }
                });
        w2ui['meet_tabs'].click('tabs-1');
        
<?php if ($isEdit) { ?>

        $("#delete").click(function () {

        w2confirm('Are you sure Delete This Note ?')
        .yes(function () { 
        
           $.ajax({
                        type: "POST",
                        url: '{site_url}/hrsys/clientnote/delete/<?= $note_id ?>',
                        beforeSend: function (xhr) {
                            $(this).loadingShow(true);

                        },
                        success: function (data) {
                            w2popup.close();
                            w2ui["listinfNote"].reload();
                            $(this).loadingShow(false);
                        }
                    });
          
        
        });      
        
                
            });
<?php } ?>


        $("#formnya").gn_onPopupSubmit("popupForm", w2ui["listinfNote"]);

       
        $(this).init_js("{base_url}");



    });
</script>

