
<form method="POST" id="formnya" class="form-tbl" action="<?=$site_url."/hrsys/client/changePICJoinDate/".$client["cmpyclient_id"]."/".$method ?>">
        <?= frm_('cmpyclient_id', $postForm, "type='hidden'") ?>
        <table>
            <tr>
                <td class="aright">Company Name :</td>
                <td>
                    <?= $client["name"]?>
                </td>        
            </tr>
            
            <tr>
                <td class="aright">Date Join :</td>
                <td>
                    <?= frm_('datejoin', $postForm, "class='w150 date'") ?>
                </td> 
            </tr>
            <tr>
                <td class="aright">PIC :</td>
                <td>
                    <?= select_('pic', $postForm,$comboPIC,"style='width:300px'",false) ?>
                </td> 
            </tr>

        </table>
        <input type="submit" name="action" id="action" value="Save" class="w2ui-btn"/>
    </form>


<script>
    $(function () {
        
        
                
        
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
