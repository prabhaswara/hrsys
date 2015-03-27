<h2 class="form-title">Detail Client</h2>
<div class="content_body">
    <input type="hidden" id="frompage" value="{frompage}" />
    <?php
    echo breadcrumb_($breadcrumb)
    ?>

    <div id="client_tabs" style="width: 100%; height: 29px;"></div>
    <div id="client_tabs_c" class="tabboxwui2" style="position: absolute;top: 64px;bottom: 10px;left: 10px;right: 10px">

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
                        
                        ,{id: 'contract', caption: 'Contract', url: '{site_url}/hrsys/client/infContract/<?= $id ?>'}
                        
                        <?php } ?>
                        ,{id: 'history', caption: 'History', url: '{site_url}/hrsys/client/infHistory/<?= $id ?>'}
                        <?php if($canedit) { ?>
                        ,{id: 'operation', caption: 'Operation', url: '{site_url}/hrsys/client/infoperation/<?= $id ?>'}
                        <?php } ?>
                    ],
                    onClick: function (event) {
                                               
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
