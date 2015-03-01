<?php
$meet_id = isset($postForm["meet_id"]) ? $postForm["meet_id"] : "0";
?>



<div id="meet_tabs" style="width: 100%; height: 29px;"></div>
<div id="meet_tabs_c" class="tabboxwui2" style="min-height: 400px" >

</div>



<div id="tabs-1" style="display:none" >
    <form method="POST" id="formnya" class="form-tbl">
 
            <input type="hidden" name="do" value="schedule"/>

            <table>
                <tr>
                    <td class="aright" width="100px">Created By:</td><td><?=$createBy ?></td>
                </tr>
                
                <tr>
                    <td  class="aright">Client:</td>
                    <td><?=$data["client_name"]?></td>        
                </tr>
                <tr>
                    <td  class="aright">Meeting Type:</td>
                    <td><?=$type?></td>        
                </tr>
                <tr>
                    <td class="aright">Meet with:</td>
                    <td> <?=$data["person"]?></td>        
                </tr>
                <tr>
                    <td class="aright">Place:</td>
                    <td><?=$data["place"]?></td>        
                </tr>
                <tr>
                    <td class="aright">Date & Time :</td>
                    <td><?=  balikTglDate($data["meettime"],true)?></td> 
                </tr>         

                <tr>
                    <td class="aright">Description :</td>
                    <td ><?=replaceNewLineBr($data["description"])?></td> 
                </tr>          
                <tr>
                    <td class="aright">Share with :</td>
                    <td>
                    <?php
                        if(!empty($shareSchedule))
                            foreach($shareSchedule as $value){
                            echo "<div>".$value["name"]."</div>";
                            }
                    ?>
                    </td> 
                </tr> 
                
            </table>           
        </form>
</div>

    <div id="tabs-2"  style="display:none">
        <form method="POST" id="formOutCome" class="form-tbl" >
   
            <table>
                <tr>
                    <td class="aright">Outcome:</td>
                    <td><?=$outcome?></td>        
                </tr>
                <tr>
                    <td class="aright">Description:</td>
                    <td><?=replaceNewLineBr($data["outcome_desc"])?></td>        
                </tr>
            </table>         
        </form>
    </div>




<script>
    $(function () {

$("#tabs").tabs(<?= (isset($_POST["do"]) && $_POST["do"] == "outcome") ? "{active: 1}" : "" ?>);

        if (w2ui['meet_tabs'])
            $().w2destroy("meet_tabs");

        $("#meet_tabs").w2tabs(
                {
                    name: 'meet_tabs',
                    tabs: [
                        {id: 'tabs-1', caption: 'Schedule'}
                        ,{id: 'tabs-2', caption: 'Outcome'}
               
                    ],
                    onClick: function (event) {

                        $("#meet_tabs_c").html($("#" + event.tab.id).html());


                    }
                });
        w2ui['meet_tabs'].click('tabs-1');
        $(this).init_js("{base_url}");



    });
</script>

