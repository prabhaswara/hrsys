<?php 

$idChange="changePIC";
$value="Change PIC And Join Date ";

if($client["status"]=="0"){ //prospect
    $idChange="changeToClient";
    $value="Change Status To Client";
}
?>

<input type='button' id='btnChangePIC' value='<?=$value ?>' class='w2ui-btn w2ui-btn-green'/>
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
                        $("#popup_form").load("{site_url}/hrsys/client/changePICJoinDate/<?= $client["cmpyclient_id"]."/".$idChange ?>", function() {
                        });
                    }

                }
            });

        });
</script>
    


<input type='button' id='delete' value='Delete' class='w2ui-btn w2ui-btn-red'/>
