<?php 

$idChange="changePIC";
$value="Change PIC";

if($client["status"]=="0"){ //prospect
    $idChange="changeToClient";
    $value="Change Status To Client";
}
?>

<input type='button' id='btnChangePIC' value='<?=$value ?>' class='w2ui-btn w2ui-btn-green'/>
<?php if($canDelete){ ?>
<input type='button' id='delete' value='Delete' class='w2ui-btn w2ui-btn-red'/>
<?php } ?>

<script>
    $("#btnChangePIC").click(function() {
            $().w2popup('open', {
                name: 'popup_form',
                title: '<?=$value ?>',
                body: '<div id="popup_form" class="framepopup">please wait..</div>',
                style: 'padding: 15px 0px 0px 0px',
                width: 500,
                height: 300,
                modal: true,
                onOpen: function(event) {
                    event.onComplete = function() {
                        $("#popup_form").load("{site_url}/hrsys/client/changePIC/<?= $client["cmpyclient_id"]."/".$idChange ?>", function() {
                        });
                    }

                }
            });
         
        });
        
        <?php if($canDelete){ ?>
    $("#delete").click(function () {
    
        w2confirm('Are you sure Delete This Client ?')
        .yes(function () { 
        
            $.ajax({
                type: "POST",            
                url: '{site_url}/hrsys/client/delete/<?=$client["cmpyclient_id"]?>',
                beforeSend: function (xhr) {
                    $("#ajaxDiv").attr("class", "ajax-show");

                },
                success: function (data) {
                    
                    $("#ajaxDiv").attr("class", "ajax-hide");
                    $(this).gn_loadmain('{site_url}/home/main_home');
                        
                    
                }                
            });
        
        });           
        return false;
    });  
<?php } ?>
</script>
    


