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
<form method="POST" id="formnya" class="form-tbl" action="{site_url}/hrsys/candidate/addEditCandidate/<?=$candidate_id?>/{vacancy_id}/{frompage}">
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
                <td class="aright">Expertise:</td>
                <td></td>        
            </tr>
            <tr>
                <td class="aright">Curriculum vitae:</td>
                <td></td>        
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

       $("#formnya").gn_onsubmit();
       
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