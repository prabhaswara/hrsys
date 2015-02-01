<?php
$cmpyclient_id=isset($postForm["cmpyclient_id"])?$postForm["cmpyclient_id"]:"0";
if(!$isEdit){ ?>
<h2 class="form-title">New Client</h2>
<?php } ?>
{message}

<form method="POST" id="formnya" class="form-tbl" action="<?=$site_url."/hrsys/client/addclient/".$cmpyclient_id ?>">
        <?= frm_('cmpyclient_id', $postForm, "type='hidden'") ?>
        <table>
            <tr>
                <td class="aright">Company Name :</td>
                <td>
                    <?= frm_('name', $postForm,"class='w300 required'") ?>
                </td>        
            </tr>
            <tr>
                <td class="aright">Address :</td>
                <td>
                    <?= textarea_('address', $postForm,"class='w300'") ?>
                </td>        
            </tr>
            <tr>
                <td class="aright">Website Link :</td>
                <td><?= frm_('website', $postForm,"class='w300'") ?></td>        
            </tr>
            <tr>
                <td>Contact Person :</td>
                <td><?= frm_('cp_name', $postForm,"class='w300'") ?></td> 
            </tr>
            <tr>
                <td class="aright"><span class="fa-phone">&nbsp;</span></td>
                <td> <?= frm_('cp_name', $postForm,"class='w300'") ?></td> 
            </tr>
            <?php
            if(!$isEdit){ ?>
            <tr>
                <td class="aright">Status :</td>
                <td>
                    <?= select_('status', $postForm,$stat_list,"class='kendodropdown'",false) ?>
                </td> 
            </tr>
            <tr id="picdiv" style="<?=(isset($postForm['status'])&&$postForm['status']==1)?"":"display:none"?>">
                <td class="aright">PIC :</td>
                <td>
                    <?= select_('pic', $postForm,$comboPIC,"class='kendocombo' style='width:300px'",false) ?>
                </td> 
            </tr>
            <?php
            }
            ?>
        </table>
        <input type="submit" name="action" id="action" value="Save" class="w2ui-btn"/>
        <input type="button" name="action" id="cancel" value="Cancel"  class="w2ui-btn"/>
    </form>


<script>
    $(function () {
        
        
         
        $(this).init_js("{base_url}");
        
        $("#formnya").gn_onsubmit();
        <?php if(!$isEdit){ ?>
        $("#status").change(function() {
            if($(this).val()==0){
                $("#picdiv").hide('slow');
                $("#pic").data("kendoComboBox").value("");
            }else{
                $("#picdiv").show('slow');
            }
            
        });
        <?php } ?>
        
        
    });
</script>

