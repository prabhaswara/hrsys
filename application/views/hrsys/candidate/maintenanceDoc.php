<?php
$candidate_id  = isset($postForm["candidate_id"]) ? $postForm["candidate_id"] : "0";

?>
<h2 class="form-title">Maintenance  <?=$candidate["name"] ?> Documents</h2>
<div style="padding: 10px;">
<?php
    echo breadcrumb_($breadcrumb)
?>    
    <form  method="POST" id="formnya" class="form-tbl" enctype="multipart/form-data" action="{site_url}/hrsys/candidate/maintenanceDoc/<?=$candidate["candidate_id"] ?>/{vacancy_id}/{frompage}">
        <input name="filedoc" type="file" style="margin: 0 ;" />
         <input id="upload" style="margin: 0 ;height: 30px;width: 30px;" type="image" src="{base_url}/images/upload.png">
    </form>
    
    <table border="0">
<?php
    if(!empty($listFile))
        foreach($listFile as $file){
            echo "<tr> <td width='30px'> <a class='deleteButton' href='$site_url/hrsys/candidate/deleteDoc/$file/".$candidate["candidate_id"]."/$vacancy_id/$frompage'></a> </td> <td>".
                 "<a href='$site_url/hrsys/candidate/downloadDoc/$file/".$candidate["candidate_id"]."'>$file</a>".
                 "</td></tr>";
        }
?>
    </table>
</div>


<script>
    $(function () {

      $("#upload").kendoButton();
      $(".deleteButton").kendoButton({ icon: "close"});
      
      $(".deleteButton").click(function () {
           href = $(this).attr("href");           
           w2confirm('Are you sure delete this file ?')
            .yes(function () {                
                if (href != "#" && href != "") {
                    $.fn.gn_loadmain(href);
                }            
            });          
            
            return false;

        });
        
        $(".gn_breadcrumb a").click(function () {
            href = $(this).attr("href");
            if (href != "#" && href != "") {
                $.fn.gn_loadmain(href);
            }
            return false;

        });
      $("#formnya").gn_onsubmitFile();  
      $(this).init_js("{base_url}");  

    });
</script>