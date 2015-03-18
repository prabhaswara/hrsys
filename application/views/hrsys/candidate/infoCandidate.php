<div  class="form-tbl" >      
    <table>
        <tr>
            <td class="aright">Candidate Name:</td>
            <td><?= $candidate["name"] ?></td>        
        </tr>
        <tr>
            <td class="aright">Birth Day:</td>
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
            <td class="aright">Expected Salary (IDR):</td>
            <td><?= numSep($candidate["expectedsalary"]) ?></td>        
        </tr>
        <tr>
            <td class="aright">Expertise :</td>
            <td><?= $candidate["skill"] ?></td>        
        </tr>               

    </table>

</div>

<div style="border:1px solid silver;width: 350px;position: absolute;top: 10px;right: 10px;padding: 5px;<?=$showAddVac=="show"?"":"display:none" ?>">
    <div style="position: relative;height: 35px"> 
        <?php
        
                if(empty($vacancy))
                    echo select_("v_vacancy_id",array() ,$listVacany,"style='width:200px' class='kendodropdown'");
                else
                    echo "<input type='hidden' id='v_vacancy_id' value='".(empty($vacancy)?'':$vacancy['vacancy_id'])."'/>";
        ?>
        
        <button id="btn_addtoshortlist" style="float: right" class="kendobutton">Add To Shortlist</button>
      
    </div>

    <table>
        <tr>
            <td class="aright">Vacancy :</td>
            <td><?= empty($vacancy)?"":$vacancy["name"] ?></td>
        </tr>
        <tr>
            <td class="aright">Salary :</td>
            <td id="v_salary"><?= !( !empty($vacancy)&& isset($vacancy["salary_1"])&&cleanNumber($vacancy["salary_1"])!=0)?"": numSep($vacancy["salary_1"]) . ((cleanstr($vacancy["salary_1"]) != "" && cleanstr($vacancy["salary_2"]) != "") ? " - " : "") . numSep($vacancy["salary_2"])
 . ((cleanstr($vacancy["salary_1"]) != "" && cleanstr($vacancy["salary_2"]) != "") ? " (IDR)" : "")
?></td> 
        </tr>          
        <tr>
            <td class="aright">Age :</td>
            <td id="v_age"><?= !( !empty($vacancy)&&isset($vacancy["age_1"])&&cleanNumber($vacancy["age_1"])!=0)?"":$vacancy["age_1"] . ((cleanstr($vacancy["age_1"]) != "" && cleanstr($vacancy["age_2"]) != "") ? " - " : "") . $vacancy["age_2"] ?></td> 
        </tr>          
        <tr>
            <td class="aright">Sex :</td>
            <td  id="v_sex"><?= empty($vacancy)?"":$vacancy["sex_text"] ?></td> 
        </tr>        
        <tr>
            <td class="aright">Expertise :</td>
            <td  id="v_expertise"><?= empty($vacancy)?"":$expertise ?></td> 
        </tr>
        <tr>
            <td class="aright">Description :</td>
            <td  id="v_description"><?= empty($vacancy)?"":$vacancy["description"] ?></td> 
        </tr>
    </table>
</div>

<script>
    $(function () {
        $("#btn_addtoshortlist").click(function () {
           vacancy_id=$("#v_vacancy_id").val();
           frompage=$("#frompage").val();
           w2confirm('Are you sure add candidate to shortlist ?')
            .yes(function () { 
               $(window).gn_loadmain('{site_url}/hrsys/candidate/addCandidate/<?=$candidate["candidate_id"] ?>/'+vacancy_id+'/'+frompage);
           
            });
    
           
           return false;
        });
    $(this).init_js("{base_url}");
                


    });
</script>