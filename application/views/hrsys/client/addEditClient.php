<?php
$cmpyclient_id=isset($postForm["cmpyclient_id"])?$postForm["cmpyclient_id"]:"0";
if(!$isEdit){ ?>
<h2 class="form-title">New Client</h2>
<?php } ?>
{message}

<form method="POST" id="formnya" class="form-tbl" action="<?=$site_url."/hrsys/client/addEditClient/".$cmpyclient_id ?>">
        <?= frm_('cmpyclient_id', $postForm, "type='hidden'") ?>
        <table>
            <tr>
                <td class="aright">Company Name :</td>
                <td>
                    <?= frm_('name', $postForm,"class='w300 required'") ?>
                </td>        
            </tr>
            <tr>
                <td class="aright">Address :</td>
                <td>
                    <?= textarea_('address', $postForm,"class='w300'") ?>
                </td>        
            </tr>
            <tr>
                <td class="aright">Website Link :</td>
                <td><?= frm_('website', $postForm,"class='w300'") ?></td>        
            </tr>
            <tr>
                <td>Contact Person :</td>
                <td><?= frm_('cp_name', $postForm,"class='w300'") ?></td> 
            </tr>
            <tr>
                <td class="aright"><span class="fa-phone">&nbsp;</span></td>
                <td> <?= frm_('cp_phone', $postForm,"class='w300'") ?></td> 
            </tr>
 <?php if(!$isEdit){ ?>
            <tr>
                <td class="aright">Status :</td>
                <td>
                    <?= select_('status', $postForm,$stat_list,"class='kendodropdown'",false) ?>
                </td> 
            </tr>
           
            <tr class="statusClientDiv" style="<?=(isset($postForm['status'])&&$postForm['status']==1)?"":"display:none"?>">
                <td class="aright">Account Manager :</td>
                <td>
                    <?= select_('account_manager', $postForm,$comboAM,"style='width:300px'",false) ?>
                </td> 
            </tr>
 <?php }?>
        </table>
        <input type="submit" name="action" id="action" value="Save" class="w2ui-btn"/>
    </form>


<script>
    $(function () {
        
        
         
        
        
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
        <?php if($isEdit){ ?>
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
       
        <?php }else{ ?>
         $("#status").change(function() {
            if($(this).val()==0){
                $(".statusClientDiv").hide('medium');
                $("#pic").data("kendoComboBox").value("");
                $("#datejoin").val("");
            }else{
                $(".statusClientDiv").show('medium');
            }
            
        });
            
        $("#formnya").gn_onsubmit();
            
        <?php } ?>
            
            
        
        $(this).init_js("{base_url}");
    });
</script>

