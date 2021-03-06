<?php
$meet_id = isset($postForm["meet_id"]) ? $postForm["meet_id"] : "0";
?>

{message}

<div id="meet_tabs" style="width: 100%; height: 29px;"></div>
<div id="meet_tabs_c" class="tabboxwui2" style="min-height: 400px" >
    <div id="tabs-1" class="contentTab"  style="display:none" >
        <form method="POST" id="formnya" class="form-tbl" action="<?= $site_url . "/hrsys/meeting/showform/" . $client["cmpyclient_id"] . "/" . $meet_id ?>">
            <?= frm_('meet_id', $postForm, "type='hidden'") ?>   
            <input type="hidden" name="do" value="schedule"/>

            <table>
                <tr>
                    <td class="aright">Meeting Type:</td>
                    <td>
                        <?= select_('type', $postForm, $typeList, "class='kendodropdown'", false) ?>
                    </td>        
                </tr>
                <tr>
                    <td class="aright">Meet with:</td>
                    <td>
                        <?= frm_('person', $postForm, "class='w300'") ?>
                        <span id="generate_person"  class='imgbt fa  fa-cog cursorPointer'></span>
                    </td>        
                </tr>
                <tr>
                    <td class="aright">Place:</td>
                    <td><?= frm_('place', $postForm, "class='w300'") ?></td>        
                </tr>
                <tr>
                    <td class="aright">Date & Time :</td>
                    <td><?= frm_('meettime_d', $postForm, "class='w150 date'") ?>
                        <?= select_('meettime_t', $postForm, $timeList, "style='width:90px' class='kendodropdown'", false) ?>
                    </td> 
                </tr>         

                <tr>
                    <td class="aright">Description :</td>
                    <td >
                        <?= textarea_('description', $postForm, "class='w300' ") ?>
                        <span id="generate_desc" style="vertical-align: top" class='imgbt fa  fa-cog cursorPointer'></span>
                    </td> 
                </tr>          
                <tr>
                    <td class="aright">Share with :</td>
                    <td >
                        <select id="shareSchedule" name="shareSchedule[]" multiple="multiple" class="w300"></select>
                    </td> 
                </tr>          
            </table>
            <input type="submit" name="action" id="action" value="Save" class="w2ui-btn"/>
        </form>

    </div>
    <?php if ($isEdit) { ?>
        <div id="tabs-2" class="contentTab"  style="display:none">
            <form method="POST" id="formOutCome" class="form-tbl" action="<?= $site_url . "/hrsys/meeting/showform/" . $client["cmpyclient_id"] . "/" . $meet_id ?>">
                <?= frm_g('outcome', 'meet_id', $postOutcome, "type='hidden'") ?> 
                <input type="hidden" name="do" value="outcome"/>
                <table>
                    <tr>
                        <td class="aright">Outcome:</td>
                        <td>
                            <?= select_g('outcome', 'outcome', $postOutcome, $outcomeList, "class='kendodropdown'", false) ?>
                        </td>        
                    </tr>
                    <tr>
                        <td class="aright">Description:</td>
                        <td>
                            <?= textarea_g('outcome', 'outcome_desc', $postOutcome, "class='w300' ") ?>
                        </td>        
                    </tr>
                </table>
                <input type="submit" name="action" id="action" value="Save" class="w2ui-btn"/>
            </form>
        </div>
        <div id="tabs-3" class="contentTab" style="display:none">
            <input type="button" id="delete" value="Delete" class="w2ui-btn w2ui-btn-red"/>
        </div>
    <?php } ?>
</div>






<input type="hidden" id="client_cp" value="<?= $client["cp_name"] ?>" />




<script>
    $(function () {
        
        if (w2ui['meet_tabs'])
            $().w2destroy("meet_tabs");

        $("#meet_tabs").w2tabs(
                {
                    name: 'meet_tabs',
                    tabs: [
                        {id: 'tabs-1', caption: 'Schedule'}
 <?php if($isEdit){ ?> ,{id: 'tabs-2', caption: 'Outcome'}
                       ,{id: 'tabs-3', caption: 'Delete'}
 <?php } ?>                
                    ],
                    onClick: function (event) {

                        $(".contentTab").hide();
                        $("#" + event.tab.id).show();


                    }
                });
        w2ui['meet_tabs'].click('tabs-1');
        
<?php if ($isEdit) { ?>

            $("#delete").click(function () {

w2confirm('Are you sure Delete This Meeting ?')
        .yes(function () { 
        
           $.ajax({
                        type: "POST",
                        url: '{site_url}/hrsys/meeting/delete/<?= $meet_id ?>',
                        beforeSend: function (xhr) {
                            $(this).loadingShow(true);

                        },
                        success: function (data) {
                            w2popup.close();
<?php if($gridReload!="calendar"){ ?>
							w2ui["<?=$gridReload ?>"].reload();
<?php } ?>
                            
                            $(this).loadingShow(false);
                        }
                    });
          
        
        });      
        
                
            });
<?php } ?>
<?php if($gridReload=="calendar"){ ?>
		$("#formnya").gn_onPopupSubmit("popupForm",$("#calendar"),"calendar");
        $("#formOutCome").gn_onPopupSubmit("popupForm",$("#calendar"),"calendar");
<?php } else { ?>
		
        $("#formnya").gn_onPopupSubmit("popupForm", w2ui["<?=$gridReload ?>"]);
        $("#formOutCome").gn_onPopupSubmit("popupForm", w2ui["<?=$gridReload ?>"]);
<?php } ?>
        $("#shareSchedule").kendoMultiSelect({
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
if (!empty($postShareSchedule)) {
    echo ",value:" . json_encode($postShareSchedule);
}
?>
        });





        $("#generate_person").click(function () {          
            $("#person").val($("#client_cp").val());

        });

        $("#generate_desc").click(function () {
            person = $("#person").val().trim();
            place = $("#place").val().trim();
            meettime_d = $("#meettime_d").val().trim();
            meettime_t = $("#meettime_t").val().trim();

            description = (person == "" ? "" : "meeting with " + person)
                    + (place == "" ? "" : " in " + place) + (meettime_d == "" ? "" : " at " + meettime_d) + (meettime_t == "" ? "" : " " + meettime_t);

            $("#description").val(description);
        });


        $(this).init_js("{base_url}");



    });
</script>

