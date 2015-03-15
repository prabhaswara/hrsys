<?php
$candidate_id  = isset($postForm["candidate_id "]) ? $postForm["candidate_id "] : "0";

$buttonSaveText="Save";

if(cleanstr($frompage)!=""){
    $buttonSaveText="Save & Add to Shortlist";
}
?>
<h2 class="form-title">Candidate</h2>
<div style="padding: 10px;">
    <?php
    echo breadcrumb_($breadcrumb)
    ?>
{message}
<form  method="POST" id="formnya" class="form-tbl" enctype="multipart/form-data" action="{site_url}/hrsys/candidate/addEditCandidate/<?=$candidate_id?>/{vacancy_id}/{frompage}">
        <?= frm_('candidate_id', $postForm, "type='hidden'") ?>   
    
        <table>
            <tr>
                <td class="aright">Candidate Name:</td>
                <td><?= frm_('name', $postForm, "class='w300 required' ") ?></td>        
            </tr>
            <tr>
                <td class="aright">Birth Day:</td>
                <td><?= frm_('birthdate', $postForm, "class='w150 date' ") ?></td>        
            </tr>
            <tr>
                <td class="aright">Sex:</td>
                <td><?= select_('sex', $postForm,$sex_list,"class='kendodropdown'",false) ?></td>        
            </tr>
            <tr>
                <td class="aright">Phone:</td>
                <td><?= frm_('phone', $postForm, "class='w200' ") ?></td>        
            </tr>
            <tr>
                <td class="aright">Email:</td>
                <td><?= frm_('email', $postForm, "class='w200' ") ?></td>        
            </tr>
            <tr>
                <td class="aright">Expected Salary (IDR):</td>
                <td><?= frm_('expectedsalary', $postForm, "class='w200 kendonumber' ") ?></td>        
            </tr>
            <tr>
                    <td class="aright">Expertise :</td>
                    <td>
                        <div style="height: 30px;margin-bottom: 3px">
                            <select id="add_expertise" style="margin: 0;height: 30px;width: 270px;float:left;border-radius: 3px 0px 0px 3px" ></select>                         
                            <input style="margin: 0 ;height: 30px;width: 30px;float:left;border-left: 0px;border-radius: 0px 5px 5px 0px" type="image" src="{base_url}/images/save_button.png" id="btn_add_expertise" width="60" height="60">
                        </div>
                        <select  id="expertise" name="expertise[]" multiple="multiple" class="w300"></select>

                    </td>        
            </tr>
            <tr>
                <td class="aright">Curriculum vitae:</td>
                <td>
                    <input name="cv" type="file" />
                    
                </td>        
            </tr>
            <tr>
                <td></td>
                <td> <input type="submit" name="action" id="action" value="<?=$buttonSaveText?>" class="w2ui-btn"/></td>
            </tr>
            
        </table>
   
</form>

</div>


<script>
    $(function () {

       $("#formnya").gn_onsubmitFile();
       
       $(this).setSkillList("add_expertise","btn_add_expertise","expertise","{site_url}",<?=json_encode($postExpertise) ?>);
       $("#btn_add_expertise").kendoButton({ imageUrl: "{base_url}/images/save_button.png"});
        
        $(".gn_breadcrumb a").click(function () {
            href = $(this).attr("href");
            if (href != "#" && href != "") {
                $.fn.gn_loadmain(href);
            }
            return false;

        });
        
      $(this).init_js("{base_url}");  

    });
</script>