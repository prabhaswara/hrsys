<?php
$vacancy_id = isset($postForm["vacancy_id"]) ? $postForm["vacancy_id"] : "0";
?>
{message}
<form method="POST" id="formnya" class="form-tbl" action="<?= $site_url . "/hrsys/vacancy/showform/" . $client["cmpyclient_id"] . "/" . $vacancy_id ?>">
        <?= frm_('vacancy_id', $postForm, "type='hidden'") ?>   
       

        <table>
            <tr>
                <td class="aright">PIC:</td>
                <td>
                   <?= select_('pic', $postForm,$comboPIC," class='w300' ",false) ?>
                    <img src="http://localhost:81/hrsys/images/star_red.png" class="required-star">
                </td>        
            </tr>
            <tr>
                <td class="aright">Open Date:</td>
                <td><?= frm_('opendate', $postForm, "class='w150 date required'") ?></td>        
            </tr>
            <tr>
                <td class="aright">Job Name:</td>
                <td><?= frm_('name', $postForm, "class='w300 required' ") ?></td>        
            </tr>
            <tr>
                <td class="aright">Number of Positions:</td>
                <td><?= frm_('num_position', $postForm, "class='w150 kendonumber'") ?></td>        
            </tr>
            <tr>
                <td class="aright">Description :</td>
                <td >
                    <?= textarea_('description', $postForm, "class='w300' ") ?>
                </td> 
            </tr>          
            <tr>
                <td class="aright">Maintenance:</td>
                <td >
                    <select id="shareMaintance" name="shareMaintance[]" multiple="multiple" class="w300"></select>
                </td> 
            </tr>          
        </table>
        <input type="submit" name="action" id="action" value="Save" class="w2ui-btn"/>
    </form>
<script>
    $(function () {

        

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
        
        
        $("#pic").kendoComboBox({
                        placeholder: "Select..",
                       dataValueField: "emp_id",
                        dataTextField: "name",
                        filter: "contains",
                        autoBind: false,
                        dataSource: {
                        serverFiltering: true,
                            transport: {
                                read: {
                                    url: "{site_url}/hrsys/employee/pic",
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
                       w2ui['client_tabs'].click('info');
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