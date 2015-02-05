<h2 class="form-title">Detail Client</h2>
<div class="breadcrumb">
    <?php
    echo breadcrumb_($breadcrumb)
    ?>

</div>


<div  id="client_tabs">
    <ul>
        <li><a href="{site_url}/hrsys/client/infClient/<?=$id?>">General Info</a></li>
        <li><a href="{site_url}/hrsys/client/infMeeting">Meeting Appointment</a></li>
        <li><a href="{site_url}/hrsys/client/infVacancies">Vacancies</a></li>
        <li><a href="{site_url}/hrsys/client/infHistory">History</a></li>

    </ul>
    <div>

        
    </div>
</div>

<script>
    $(function () {
        $("#client_tabs").tabs({
            beforeLoad: function (event, ui) {
                ui.jqXHR.error(function () {
                    ui.panel.html("Couldn't load this tab.");
                });
            }
        });
    });
</script>
