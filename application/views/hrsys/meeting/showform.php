<?php
$meet_id = isset($postForm["meet_id"]) ? $postForm["meet_id"] : "0";
?>

{message}

<div id="tabs">
    <ul>
        <li><a href="#tabs-1">Schedule</a></li>
        <?php if($isEdit){ ?>
        <li><a href="#tabs-2">Outcome</a></li>
        <li><a href="#tabs-3">Operations</a></li>
        <?php } ?>
    </ul>
    <div id="tabs-1" style="min-height: 400px">
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
    <?php if($isEdit){ ?>
    <div id="tabs-2"  style="min-height: 400px">
        <form method="POST" id="formOutCome" class="form-tbl" action="<?= $site_url . "/hrsys/meeting/showform/" . $client["cmpyclient_id"] . "/" . $meet_id ?>">
            <?= frm_g('outcome','meet_id', $postOutcome, "type='hidden'") ?> 
            <input type="hidden" name="do" value="outcome"/>
            <table>
                <tr>
                    <td class="aright">Outcome:</td>
                    <td>
                        <?= select_g('outcome','outcome', $postOutcome, $outcomeList, "class='kendodropdown'", false) ?>
                    </td>        
                </tr>
                <tr>
                    <td class="aright">Description:</td>
                    <td>
                       <?= textarea_g('outcome','outcome_desc', $postOutcome, "class='w300' ") ?>
                    </td>        
                </tr>
            </table>
             <input type="submit" name="action" id="action" value="Save" class="w2ui-btn"/>
        </form>
    </div>
    <div id="tabs-3" style="min-height: 400px">
        <input type="button" id="delete" value="Delete" class="w2ui-btn w2ui-btn-red"/>
    </div>
    <?php } ?>
    
</div>

<input type="hidden" id="client_cp" value="<?= $client["cp_name"] ?>" />




<script>
    $(function () {
         <?php if($isEdit){ ?>
         
       $("#delete").click(function () {
            
            if(confirm("Are you sure delete this?")){
                    $.ajax({
                    type: "POST",
                    url: '{site_url}/hrsys/meeting/delete/<?=$meet_id?>',
                    beforeSend: function (xhr) {
                        $(this).loadingShow(true);

                    },
                    success: function (data) {
                        w2popup.close();
                        w2ui["listInfMeeting"].reload();
                        $(this).loadingShow(false);
                    }
                });
            }
            return false;
        });
        <?php } ?>
        $("#tabs").tabs(<?=(isset($_POST["do"])&&$_POST["do"]=="outcome")?"{active: 1}":""?>);
       
        $("#formnya").gn_onPopupSubmit("popupForm", w2ui["listInfMeeting"]);
        $("#formOutCome").gn_onPopupSubmit("popupForm", w2ui["listInfMeeting"]);

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

