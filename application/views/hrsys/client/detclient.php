<h2 class="form-title">Detail Client</h2>
<div class="breadcrumb">
    <?php
       echo breadcrumb_($breadcrumb)
    ?>
    
</div>


<div class="tabs-js">
    <ul>
        <li><a href="#generalInfo">General Info</a></li>
        <li><a href="{site_url}/hrsys/client/detMeeting">Meeting Appointment</a></li>
        <li><a href="{site_url}/hrsys/client/detVacancies">Vacancies</a></li>
        <li><a href="{site_url}/hrsys/client/detHistory">History</a></li>
      
    </ul>
    <div id="generalInfo">
        
        <button class="jqbutton"> <span class="fa-edit">&nbsp;</span> Edit General Info</button>
       <table>
            <tr>
                <td class="aright">Company Name :</td>
                <td><?=$client["name"]?></td>        
            </tr>
            <tr>
                <td class="aright">Address :</td>
               <td><?=$client["address"]?></td>       
            </tr>
            <tr>
                <td class="aright">Website Link :</td>
                <td><?=$client["website"]?></td>     
            </tr>
            <tr>
                <td>Contact Person :</td>
                <td><?=$client["cp_name"]?></td>     
            </tr>
            <tr>
                <td class="aright"><span class="fa-phone">&nbsp;</span></td>
                <td><?=$client["cp_phone"]?></td>     
            </tr>        
            <tr>
                <td class="aright">Status :</td>
                <td><?=$client["status_text"]?></td>     
            </tr>
            <tr id="picdiv">
                <td class="aright">PIC :</td>
               <td><?=$client["emp_pic"]?></td>      
            </tr>
         
        </table>
    </div>
</div>




<script>
    $(function () {
        
        $(".linksite").on("click", function()
        {
        
            return false;
        });
        
                 $(this).init_js("{base_url}");
    });
</script>