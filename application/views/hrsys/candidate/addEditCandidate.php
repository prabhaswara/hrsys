<?php
$candidate_id  = isset($postForm["candidate_id "]) ? $postForm["candidate_id "] : "0";
?>
<h2 class="form-title">Candidate</h2>
<div style="padding: 10px;">
    <?php
    echo breadcrumb_($breadcrumb)
    ?>
{message}
<form method="POST" id="formnya" class="form-tbl" action="{site_url}/hrsys/candidate/addEditCandidate/<?=$candidate_id?>/{frompage}">
        <?= frm_('candidate_id ', $postForm, "type='hidden'") ?>   
    
        <table>
            <tr>
                <td class="aright">Candidate Name:</td>
                <td><?= frm_('name', $postForm, "class='w300 required' ") ?></td>        
            </tr>
            <tr>
                <td class="aright">Phone:</td>
                <td><?= frm_('phone', $postForm, "class='w300' ") ?></td>        
            </tr>
            <tr>
                <td class="aright">Skill:</td>
                <td></td>        
            </tr>
            <tr>
                <td class="aright">Upload CV:</td>
                <td></td>        
            </tr>
            <tr>
                <td class="aright">Summary:</td>
                <td></td>        
            </tr>
            
            
        </table>
</form>

</div>


<script>
    $(function () {

       
        $(".gn_breadcrumb a").click(function () {
            href = $(this).attr("href");
            if (href != "#" && href != "") {
                $.fn.gn_loadmain(href);
            }
            return false;

        });
        
        

    });
</script>