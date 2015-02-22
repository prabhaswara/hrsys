<h2 class="form-title">Detail Client</h2>
<div style="padding: 10px;">

    <?php
    echo breadcrumb_($breadcrumb)
    ?>

    <div id="client_tabs" style="width: 100%; height: 29px;"></div>
    <div id="client_tabs_c" class="tabboxwui2" style="min-height: 400px">

    </div>

</div>




<script>
    $(function () {

        $("#client_tabs").w2tabs(
                {
                    name: 'client_tabs',
                    tabs: [
                        {id: 'info', caption: 'General Info', url: '{site_url}/hrsys/client/infClient/<?= $id ?>'}
                        ,{id: 'meeting', caption: 'Meeting Appointment', url: '{site_url}/hrsys/meeting/infMeeting/<?= $id ?>'}
                        <?php if($client["status"]==1){ ?>
                        ,{id: 'vacancies', caption: 'Vacancies', url: '{site_url}/hrsys/vacancy/infVacancy/<?= $id ?>'}
                        <?php } ?>
                        ,{id: 'history', caption: 'History', url: '{site_url}/hrsys/client/infHistory/<?= $id ?>'}
                        <?php if($canDelete){ ?>
                        ,{id: 'delete', caption: 'Delete', url: '{site_url}/hrsys/client/infVacancies/<?= $id ?>'}
                        <?php } ?>
                    ],
                    onClick: function (event) {
                        if(event.tab.id=="delete"){
                            $("#client_tabs_c").html("<input type='button' id='delete' value='Delete' class='w2ui-btn w2ui-btn-red'/>");
                        }
                        else{                        
                            for (var widget in w2ui) {
                                var nm = w2ui[widget].name;
                                if (['main_layout', 'sidebar', 'client_tabs'].indexOf(nm) == -1)
                                    $().w2destroy(nm);
                            }

                            $(this).loadingShow(true);
                            $.ajax({
                                url: event.tab.url,
                                success: function (data) {
                                    $("#client_tabs_c").html(data);
                                    $(this).loadingShow(false);
                                }
                            });

                        }
                    }
                });
                w2ui['client_tabs'].click('info');


        $(".gn_breadcrumb a").click(function () {
            href = $(this).attr("href");
            if (href != "#" && href != "") {
                $.fn.gn_loadmain(href);
            }
            return false;

        });

    });
</script>
