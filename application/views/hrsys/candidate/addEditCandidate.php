<?php
$candidate_id  = isset($postForm["candidate_id"]) ? $postForm["candidate_id"] : "0";

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
                <td class="aright">Candidate Manager:</td>
                <td><?= select_('candidate_manager', $postForm,$comboCM,"style='width:300px'",false) ?></td>        
            </tr>
			
		
            <tr>
                <td class="aright">Candidate Name:</td>
                <td><?= frm_('name', $postForm, "class='w300 required' ") ?></td>        
            </tr>
            <tr>
                <td class="aright">Birth Date:</td>
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
                <td class="aright">Expected Salary:</td>
                <td>
				
				<?= frm_('expectedsalary', $postForm, "class='w200 kendonumber' ") ?>
				<?= select_('expectedsalary_ccy', $postForm,$listCCY,"class='kendodropdown w75'",false) ?>
				</td>        
            </tr>
            <tr>
                    <td class="aright">Expertise :</td>
                    <td>
                        <div style="height: 30px;margin-bottom: 3px">
                            <select id="add_expertise" style="margin: 0;height: 30px;width: 270px;float:left;border-radius: 3px 0px 0px 3px" ></select>                         
                            <input style="margin: 0 ;height: 30px;width: 30px;float:left;border-left: 0px;border-radius: 0px 5px 5px 0px" type="image" src="{base_url}/images/save_button.png" id="btn_add_expertise">
                        </div>
                        <select  id="expertise" name="expertise[]" multiple="multiple" class="w300"></select>

                    </td>        
            </tr>
            <tr>
                <td class="aright">Curriculum vitae:</td>
                <td>
                    <input name="cv" type="file" accept=".pdf" onchange="checkfilepdf(this);" />
                    
                </td>        
            </tr>
			<tr>
                <td class="aright">Photo:</td>
                <td>
                    <input name="photo" type="file" accept="image/jpg, image/jpeg, image/png" onchange="checkfileimg(this);" />
                    
                </td>        
            </tr>
            <tr>
                <td></td>
                <td> 
				<button id="action" class="w2ui-btn w2ui-btn-green" > <span class="fa-edit">&nbsp;</span> Save</button>
				
				</tr>
            
        </table>
   
</form>

</div>


<script>
function checkfileimg(sender) {
    var validExts = new Array(".jpeg",".jpg",".png");
    var fileExt = sender.value;
    fileExt = fileExt.substring(fileExt.lastIndexOf('.')).toLowerCase();
    if (validExts.indexOf(fileExt) < 0) {
      alert("Invalid file selected, valid files are of " +
               validExts.toString() + " types.");
		sender.value="";
      return false;
    }
    else return true;
}
function checkfilepdf(sender) {
    var validExts = new Array(".pdf");
    var fileExt = sender.value;
    fileExt = fileExt.substring(fileExt.lastIndexOf('.')).toLowerCase();
    if (validExts.indexOf(fileExt) < 0) {
      alert("Invalid file selected, valid files are of " +
               validExts.toString() + " types.");
		sender.value="";
      return false;
    }
    else return true;
}

function checkfilepdf(sender) {
    var validExts = new Array(".pdf",".PDF");
    var fileExt = sender.value;
    fileExt = fileExt.substring(fileExt.lastIndexOf('.'));
    if (validExts.indexOf(fileExt) < 0) {
      alert("Invalid file selected, valid files are of " +
               validExts.toString() + " types.");
		sender.value="";
      return false;
    }
    else return true;
}


    $(function () {

       $("#formnya").gn_onsubmitFile();
       $("#candidate_manager ").kendoComboBox({
                        placeholder: "Select..",
                       dataValueField: "id",
                        dataTextField: "name",
                        filter: "contains",
                        autoBind: false,
                        dataSource: {
                        serverFiltering: true,
                            transport: {
                                read: {
                                    url: "{site_url}/hrsys/employee/account_manager",
                                }
                            }
                        }
                    });
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