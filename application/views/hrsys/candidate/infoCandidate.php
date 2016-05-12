


<div  class="form-tbl" >
<table><tr>

<td width='320px'>
<?php 
    if($canedit){
?>
<div>
    <button id="editInfo" class="w2ui-btn w2ui-btn-green" >Edit Info</button>
    <button id="mntDoc" class="w2ui-btn w2ui-btn-green" >Maintenance Documents</button>
</div>
<?php
    }

?>     
    <table>
		<tr>
            <td class="aright">Candidate Manager:</td>
            <td><?= $candidate["cm_sp_fullname"] ?></td>        
        </tr>
		
        <tr>
            <td class="aright">Candidate Name:</td>
            <td><?= $candidate["name"] ?></td>        
        </tr>
        <tr>
            <td class="aright">Birth Date:</td>
            <td><?= balikTgl($candidate["birthdate"]) .
 (cleanstr($candidate["age"]) == "" ? "" : ", " . $candidate["age"] . " years old" )
?></td>        
        </tr>
        <tr>
            <td class="aright">Sex:</td>
            <td><?= $candidate["sex"] ?></td>        
        </tr>
        <tr>
            <td class="aright">Phone:</td>
            <td><?= $candidate["phone"] ?></td>        
        </tr>
        <tr>
            <td class="aright">Email:</td>
            <td><?= $candidate["email"] ?></td>        
        </tr>
        <tr>
            <td class="aright">Expected Salary (<?=$candidate["expectedsalary_ccy"] ?>):</td>
            <td><?= numSep($candidate["expectedsalary"]) ?></td>        
        </tr>
        <tr>
            <td class="aright">Expertise :</td>
            <td><?= $candidate["skill"] ?></td>        
        </tr>     
        
        <tr>
            <td class="aright">Curriculum vitae :</td>
            <td><?=$cv?"<a href='$site_url/hrsys/candidate/downloadCV/".$candidate["candidate_id"]."'>main_cv.pdf</a>":""  ?></td>        
        </tr>
        
        
        <?php
    if(!empty($listFile)){
        $row=0;
        foreach($listFile as $file){
            echo "<tr> <td class='aright'>".($row==0?"Other Documents :":"")." </td> <td>".
                 "<a href='$site_url/hrsys/candidate/downloadDoc/$file/".$candidate["candidate_id"]."'>$file</a>".
                 "</td></tr>";
        $row++;
            
        }
        
    }
?>

    </table>
</td>
<td>
<?php

	if($candidate["photo"]!=""&&(!empty($vacancy)&&$showAddVac=="show"))
	{?>
	<img onclick="showPhoto()" style='border:3px solid silver;cursor:pointer'  src= "<?=$site_url."/hrsys/candidate/getphotoThumb/".$candidate["candidate_id"]."/".$candidate["photo"]."?random=".str_shuffle("0123456789abcdefghijklmnopqrstuvwxyz") ?>" />
<?php
	} ?>
</td>
</tr></table>
</div>

<div style='position: absolute;top: 10px;right: 10px;'>

<?php

	if($candidate["photo"]!=""&& !(!empty($vacancy)&&$showAddVac=="show"))
	{?>
	<img onclick="showPhoto()" style='border:3px solid silver;cursor:pointer' src= "<?=$site_url."/hrsys/candidate/getphotoThumb/".$candidate["candidate_id"]."/".$candidate["photo"]."?random=".str_shuffle("0123456789abcdefghijklmnopqrstuvwxyz") ?>" />
<?php
	} ?>

<?php if(!empty($vacancy)){ ?>
<div style="float:right; margin:0px 10px;text-align:right;border:1px solid silver;width: 350px;padding: 5px;<?=$showAddVac=="show"?"":"display:none" ?>">
   <input type='hidden' id='v_vacancy_id' value='<?=(empty($vacancy)?'':$vacancy['vacancy_id'])?>'/>
        
    <button id="btn_addtoshortlist" class="w2ui-btn w2ui-btn-green">Add To Shortlist</button>

    <table>
        <tr>
            <td class="aright">Vacancy :</td>
            <td class="aleft" id="v_vacancy"><?= empty($vacancy)?"":$vacancy["name"] ?></td>
        </tr>
        <tr>
            <td class="aright">Salary :</td>
            <td id="v_salary"><?= !( !empty($vacancy)&& isset($vacancy["salary_1"])&&cleanNumber($vacancy["salary_1"])!=0)?"": numSep($vacancy["salary_1"]) . ((cleanstr($vacancy["salary_1"]) != "" && cleanstr($vacancy["salary_2"]) != "") ? " - " : "") . numSep($vacancy["salary_2"])
 . ((cleanstr($vacancy["salary_1"]) != "" && cleanstr($vacancy["salary_2"]) != "") ? " (IDR)" : "")
?></td> 
        </tr>          
        <tr>
            <td class="aright">Age :</td>
            <td  class="aleft" id="v_age"><?= !( !empty($vacancy)&&isset($vacancy["age_1"])&&cleanNumber($vacancy["age_1"])!=0)?"":$vacancy["age_1"] . ((cleanstr($vacancy["age_1"]) != "" && cleanstr($vacancy["age_2"]) != "") ? " - " : "") . $vacancy["age_2"] ?></td> 
        </tr>          
        <tr>
            <td class="aright">Sex :</td>
            <td  class="aleft" id="v_sex"><?= empty($vacancy)?"":$vacancy["sex_text"] ?></td> 
        </tr>        
        <tr>
            <td class="aright">Expertise :</td>
            <td class="aleft" id="v_expertise"><?= empty($vacancy)?"":$expertise ?></td> 
        </tr>
        <tr>
            <td class="aright">Description :</td>
            <td class="aleft" id="v_description"><?= empty($vacancy)?"":$vacancy["description"] ?></td> 
        </tr>
        
        
    </table>
</div>
<?php } ?>
</div>
<div >


</div>
<script>
     function numberseparator(x) {
            return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
          }
		  
	
	function showPhoto() {
		
		var img = $("<img />").attr('src', "<?=$site_url."/hrsys/candidate/getphoto/".$candidate["candidate_id"]."/".$candidate["photo"]."?random=".str_shuffle("0123456789abcdefghijklmnopqrstuvwxyz") ?>")
		.on('load', function() {
			if (!this.complete || typeof this.naturalWidth == "undefined" || this.naturalWidth == 0) {
				alert('broken image!');
			} else {
				img.kendoWindow({
			  modal: true
			}).data("kendoWindow").center().open();
			}
		});
		
		
	}
          
    $(function () {
      
       

<?php 
    if(empty($vacancy)){
?>
        $("#v_vacancy_id").change(function () {
            
            $.ajax({
                type: "POST",            
                url: '{site_url}/hrsys/vacancy/jsonDetVac/'+$("#v_vacancy_id").val(),
                beforeSend: function (xhr) {
                    $("#ajaxDiv").attr("class", "ajax-show");

                },
                success: function (data) {
                    $("#v_vacancy").html(data.name);
                    
                    salary="";
                    if(data.salary_1=="0" ){data.salary_1="";}
                    if(data.salary_2=="0" ){ data.salary_2="";}                    
                    if(data.salary_1!="" || data.salary_2!=""){
                        salary=numberseparator(data.salary_1)+" - "+numberseparator(data.salary_2)+" (IDR)" ;
                    }
                    $("#v_salary").html(salary);
                    
                    age="";
                    if(data.age_1=="0" ){data.age_1="";}
                    if(data.age_2=="0" ){ data.age_2="";}                    
                    if(data.age_1!="" || data.age_2!=""){
                        age=data.age_1+" - "+data.age_2
                    }                    
                    $("#v_age").html(age);
                  
                    $("#v_sex").html(data.sex_text);
                    $("#v_expertise").html(data.expertise);
                    $("#v_description").html(data.description);
                   console.log(data);
                    $("#ajaxDiv").attr("class", "ajax-hide");
                    
                }                
            });
        });
<?php
    }
?>
    
    $("#editInfo").click(function () {   
        vacancy_id=$("#v_vacancy_id").val();
        frompage=$("#frompage").val(); 
    
        $(window).gn_loadmain('{site_url}/hrsys/candidate/addEditCandidate/<?= $candidate["candidate_id"] ?>/'+vacancy_id+'/'+frompage);
        return false;        
    });
    $("#mntDoc").click(function () { 
        vacancy_id=$("#v_vacancy_id").val();
        frompage=$("#frompage").val(); 
        $(window).gn_loadmain('{site_url}/hrsys/candidate/maintenanceDoc/<?= $candidate["candidate_id"] ?>/'+vacancy_id+'/'+frompage);
        return false;
    });
    
    $("#btn_addtoshortlist").click(function () {
      
        vacancy_id=$("#v_vacancy_id").val();
        frompage=$("#frompage").val(); 
        if(vacancy_id==""){
        w2alert('Please Select Vacancy');
        return false;
    }
      
        w2confirm('Are you sure add candidate to shortlist ?')
        .yes(function () { 
            $(window).gn_loadmain('{site_url}/hrsys/candidate/addCandidate/<?= $candidate["candidate_id"] ?>/'+vacancy_id+'/'+frompage);
        });           
        return false;
    });
    $(this).init_js("{base_url}");
                


    });
</script>