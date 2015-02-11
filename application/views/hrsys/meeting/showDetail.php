

<div id="tabs">
    <ul>
        <li><a href="#tabs-1">Schedule</a></li>
        <li><a href="#tabs-2">Outcome</a></li>

    </ul>
    <div id="tabs-1" style="min-height: 400px">
        <form method="POST" id="formnya" class="form-tbl">
 
            <input type="hidden" name="do" value="schedule"/>

            <table>
                <tr>
                    <td class="aright" width="100px">Created By:</td><td><?=$createBy ?></td>
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
                    <td><?=  balikTglDate($data["place"],true)?></td> 
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

    <div id="tabs-2"  style="min-height: 400px">
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
</div>


<script>
    $(function () {
        $("#tabs").tabs();       

    });
</script>

