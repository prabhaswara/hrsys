
<form method="POST" id="formnya" class="form-tbl" action="<?=$site_url."/hrsys/client/changePIC/".$client["cmpyclient_id"]."/".$method ?>">
        <?= frm_('cmpyclient_id', $postForm, "type='hidden'") ?>
        <table>
            <tr>
                <td class="aright">Company Name :</td>
                <td>
                    <?= $client["name"]?>
                </td>        
            </tr>
                <td class="aright">Account Manager :</td>
                <td>
                    <?= select_('account_manager', $postForm,$comboAM,"style='width:300px'",false) ?>
                </td> 
            </tr>

        </table>
        <input type="submit" name="action" id="action" value="Save" class="w2ui-btn"/>
    </form>


<script>
    $(function () {
        
        
                
        
        $("#account_manager ").kendoComboBox({
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
                        $(this).gn_loadmain('{site_url}/hrsys/client/detclient/<?=$client["cmpyclient_id"]?>/'+$("#frompage").val());
                        
                    } else {
                        $('#popup_form').html(data);
                    }
                    $("#ajaxDiv").attr("class", "ajax-hide");
                    
                }
                
            });
            return false;
        });
                   
            
        
        $(this).init_js("{base_url}");
    });
</script>
