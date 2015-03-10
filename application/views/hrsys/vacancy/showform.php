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

                        <input type="text" id="add_expertise" /><button id="btn_add_expertise">Add</button>
                        <select id="expertise" name="expertise[]" multiple="multiple" class="w250"></select>

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
        
        $("#expertise").kendoMultiSelect({
            dataTextField: "skill",
            dataValueField: "skill_id",
            open: function(e) {
              e.sender.ul.css('display', 'none'); 
              }
        });
        $("#add_expertise").kendoComboBox({
                        filter: "contains",
                        dataValueField: "skill_id",
                        dataTextField: "skill",           
                        dataSource: {
                            serverFiltering: true,
                            transport: {
                                read: {
                                    url: "{site_url}/hrsys/skill/searchSkill",
                                }
                            }
                        },
                        change: function(e) {
                                         
                           list_expertise=$('#expertise').data("kendoMultiSelect");                      
                           tx_expertise=$("#add_expertise").data("kendoComboBox");
                            var values = list_expertise.value().slice(); 
                            var item=tx_expertise.value();                          
                            if(jQuery.inArray(item,values)!=-1){
                                
                                 tx_expertise.value("");                         
                            }
                        
                         
                        },
                        select: function(e) {
                            
                        skill=e.item.text();
                        skill_id=this.dataItem(e.item.index()).skill_id;
                        
                        expertise=$('#expertise').data("kendoMultiSelect");                      
                        
                        var values = expertise.value().slice();                        
                        if(jQuery.inArray(skill_id,values)==-1){                          
                            expertise.dataSource.add( { skill_id: skill_id, skill: skill });
                            $.merge(values, [skill_id]);                        
                            expertise.value(values);                            
                        }
                        
                      }
                    });
                    $("#add_expertise").data("kendoComboBox").wrapper.find(".k-dropdown-wrap").removeClass("k-dropdown-wrap").addClass("k-autocomplete").find("span").hide();
                    
                    
        $("#btn_add_expertise").click(function() {
           console.log($("#add_expertise").val());
           return false;
        });
        
  

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