<h2 class="form-title">Detail Client</h2>
<div class="breadcrumb">
    <?php
    echo breadcrumb_($breadcrumb)
    ?>

</div>


<div  id="client_tabs" >
    <ul>
        <li><a href="#test">General Info</a></li>
        <li><a href="{site_url}/hrsys/meeting/infMeeting/<?=$id?>">Meeting Appointment</a></li>
        <li><a href="{site_url}/hrsys/client/infVacancies/<?=$id?>">Vacancies</a></li>
        <li><a href="{site_url}/hrsys/client/infHistory/<?=$id?>">History</a></li>

    </ul>
    <div id="test" style="height:400px">

        
    </div>
</div>

<script>
    $(function () {
        $("#client_tabs").tabs({         
            beforeLoad: function (event, ui) {
                
                for (var widget in w2ui) {
                    var nm = w2ui[widget].name;
                    if (['main_layout', 'sidebar'].indexOf(nm) == -1)
                        $().w2destroy(nm);
                }

                ui.jqXHR.error(function () {
                    ui.panel.html("Couldn't load this tab.");
                });
            }
        });
        
    });
</script>
