<?php
$meet_id=isset($postForm["meet_id"])?$postForm["meet_id"]:"0";
?>

{message}

<form method="POST" id="formnya" class="form-tbl" action="<?=$site_url."/hrsys/meeting/showform/".$meet_id ?>">
        <?= frm_('meet_id', $postForm, "type='hidden'") ?>
        <table>
            <tr>
                <td class="aright">Meeting Type:</td>
                <td>
                   <?= select_('type', $postForm,$typeList,"class='kendodropdown'",false) ?>
                </td>        
            </tr>
            <tr>
                <td class="aright">Meet with:</td>
                <td>
                    <?= frm_('person', $postForm,"class='w300'") ?>
                </td>        
            </tr>
            <tr>
                <td class="aright">Place:</td>
                <td><?= frm_('place', $postForm,"class='w300'") ?></td>        
            </tr>
            <tr>
                <td>Date & Time :</td>
                <td><?= frm_('meettime_d', $postForm,"class='w200'") ?>
                    <?= select_('meettime_t', $postForm,$timeList,"class='kendodropdown'",false) ?>
                </td> 
            </tr>         

            <tr>
                <td class="aright">Description :</td>
                <td>
                    <?= frm_('description', $postForm,"class='w300'") ?>
                </td> 
            </tr>          
        </table>
        <input type="submit" name="action" id="action" value="Save" class="w2ui-btn"/>
    </form>


<script>
    $(function () {   
        
         
        $(this).init_js("{base_url}");
        
       
        
    });
</script>

