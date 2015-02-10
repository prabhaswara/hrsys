<?php
$meet_id = isset($postForm["meet_id"]) ? $postForm["meet_id"] : "0";
?>

{message}

<div id="tabs">
    <ul>
        <li><a href="#tabs-1">Schedule</a></li>
        <?php if($isEdit){ ?>
        <li><a href="#tabs-2">Outcome</a></li>
        <?php } ?>
    </ul>
    <div id="tabs-1" style="min-height: 350px">
        <form method="POST" id="formnya" class="form-tbl" action="<?= $site_url . "/hrsys/meeting/showform/" . $client["cmpyclient_id"] . "/" . $meet_id ?>">
            <?= frm_('meet_id', $postForm, "type='hidden'") ?>   

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
    <div id="tabs-2"  style="min-height: 350px">
        <form method="POST" id="formnya" class="form-tbl" action="<?= $site_url . "/hrsys/meeting/outcome/" . $meet_id ?>">
                <?= frm_('meet_id', $postForm, "type='hidden'") ?> 
            <table>
                <tr>
                    <td class="aright">Outcome:</td>
                    <td>
                       
                    </td>        
                </tr>
                <tr>
                    <td class="aright">Description:</td>
                    <td>
                       
                    </td>        
                </tr>
            </table>
        </form>
    </div>
    <?php } ?>
</div>

<input type="hidden" id="client_cp" value="<?= $client["cp_name"] ?>" />




<script>
    $(function () {
        $("#tabs").tabs();
        $("#formnya").gn_onPopupSubmit("popupForm", "listInfMeeting");

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

            description = "[<?= $client["name"] ?>]" + (person == "" ? "" : " meet " + person)
                    + (place == "" ? "" : " in " + place) + (meettime_d == "" ? "" : " at " + meettime_d) + (meettime_t == "" ? "" : " " + meettime_t);

            $("#description").val(description);
        });
        $(this).init_js("{base_url}");



    });
</script>

