<?php
$vacancy_id = isset($postForm["vacancy_id"]) ? $postForm["vacancy_id"] : "0";
?>
{message}
<form method="POST" id="formnya" class="form-tbl" action="<?= $site_url . "/hrsys/vacancy/showform/" . $client["cmpyclient_id"] . "/" . $vacancy_id ?>">
        <?= frm_('vacancy_id', $postForm, "type='hidden'") ?>   
       
    <table>
        <td style="vertical-align: top" width="420">
            <table>
                <tr>
                    <td class="aright">Account Manager:</td>
                    <td>
                       <?= select_('account_manager', $postForm,$comboAM," class='w250' ",false) ?>
                        <img src="http://localhost:81/hrsys/images/star_red.png" class="required-star">
                    </td>        
                </tr>
                <tr>
                    <td class="aright">Open Date:</td>
                    <td><?= frm_('opendate', $postForm, "class='w150 date required'") ?></td>        
                </tr>
                <tr>
                    <td class="aright">Number of Positions:</td>
                    <td><?= frm_('num_position', $postForm, "class='w75 kendonumber'") ?></td>        
                </tr>
                <tr>
                    <td class="aright">Fee ( % ):</td>
                    <td><?= frm_('fee', $postForm, "class='w75 kendonumber' ") ?> </td>        
                </tr>
                <tr>
                    <td class="aright">Job Name:</td>
                    <td><?= frm_('name', $postForm, "class='w250 required' ") ?></td>        
                </tr>

                    
                <tr>
                    <td class="aright">Description :</td>
                    <td >
                        <?= textarea_('description', $postForm, "class='w250' ") ?>
                    </td> 
                </tr>          
                        
            </table>
        </td>
        <td style="vertical-align: top">
            <table>
                <tr>
                    <td class="aright">Salary Range (IDR) :</td>
                    <td>
                        <?= frm_('salary_1', $postForm, "class=' kendonumber' style='width:140px'") ?> - 
                        <?= frm_('salary_2', $postForm, "class=' kendonumber' style='width:140px'") ?>

                    </td>        
                </tr>

                <tr>
                    <td class="aright">Age :</td>
                    <td>
                        <?= frm_('age_1', $postForm, "class=' kendonumber w75'") ?> - 
                        <?= frm_('age_2', $postForm, "class=' kendonumber w75'") ?>

                    </td>        
                </tr>
                <tr>
                    <td class="aright">Sex :</td>
                    <td>
                        <?= select_('sex', $postForm,$sex_list,"class='kendodropdown'",false) ?>

                    </td>        
                </tr>    
                <tr>
                    <td class="aright">Expertise :</td>
                    <td>
                        <div style="height: 30px;margin-bottom: 3px">
                            <input type="text" id="add_expertise" style="float:left;margin: 0;height: 30px" /><button style="float:left;margin: 0 ;height: 30px"  id="btn_add_expertise">Add</button>
                        </div>
                        <select  id="expertise" name="expertise[]" multiple="multiple" class="w250"></select>

                    </td>        
                </tr>    
                <tr>
                    <td class="aright">Maintenance:</td>
                    <td >
                        <select id="shareMaintance" name="shareMaintance[]" multiple="multiple" class="w250"></select>
                    </td> 
                </tr>           
            </table>
          
        </td>
    </table>

        
        <input type="submit" name="action" id="action" value="Save" class="w2ui-btn"/>
    </form>
<script>
    $(function () {
        
        $(this).setSkillList("add_expertise","btn_add_expertise","expertise","{site_url}",<?=json_encode($postExpertise) ?>);

        $("#btn_add_expertise").kendoButton({icon: "save"});
        $("#shareMaintance").kendoMultiSelect({
            placeholder: "Select Name...",
            dataValueField: "user_id",
            dataTextField: "name",
            autoBind: false,
            dataSource: {
                serverFiltering: true,
                transport: {
                    read: {
                        url: "{site_url}/hrsys/employee/sharewith",
                    }
                }
            }
<?php
if (!empty($postShareMaintance)) {
    echo ",value:" . json_encode($postShareMaintance);
}
?>
        });
        
        
        $("#account_manager").kendoComboBox({
                        placeholder: "Select..",
                       dataValueField: "emp_id",
                        dataTextField: "name",
                        filter: "contains",
                        autoBind: false,
                        dataSource: {
                        serverFiltering: true,
                        pageSize:3,
                            transport: {
                                read: {
                                    url: "{site_url}/hrsys/employee/account_manager",
                                }
                            }
                        }
                    });
        $("#formnya").submit(function (event) {
            $.ajax({
                type: "POST",
                data: $(this).serialize(),
                url: $(this).attr("action"),
                beforeSend: function (xhr) {
                    $("#ajaxDiv").attr("class", "ajax-show");

                },
                success: function (data) {
                    if (data == "close_popup") {
                       w2popup.close();
                       <?php 
                        if($frompage==""){
                       ?>
                        w2ui['client_tabs'].click('vacancies');
                       <?php
                        }else{
                            ?>
                        $(window).gn_loadmain('{site_url}/hrsys/vacancy/contentVacancy/<?=$vacancy_id."/".$frompage?>');
                       
                            <?php
                        }
                       ?>
                         w2popup.close();
                      
                        
                    } else {
                        $('#popupForm').html(data);
                    }
                    $("#ajaxDiv").attr("class", "ajax-hide");                    
                }                
            });
            return false;

        });
        $(this).init_js("{base_url}");
    });
</script>