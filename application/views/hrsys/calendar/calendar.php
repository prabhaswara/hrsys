<script>

	$(document).ready(function() {
	
		$('#calendar').fullCalendar({
			header: {
				left: 'prev,next today',
				center: 'title',
				right: 'month,agendaWeek,agendaDay'
			},
			fixedWeekCount:false, 
                        height: 550,
                        editable:true,
			eventLimit: true, // allow "more" link when too many events
			events: {
				url: '{site_url}/hrsys/calendar/json_event',
				error: function() {
					
				}
			},
                        eventRender: function (event, element) {
                            element.attr('href', 'javascript:void(0);');
                            element.click(function() {
                               showpopupdetail(event.id);
                              
                            });
                        },
			loading: function(bool) {
				$(this).loadingShow(bool);
			}
		});
		
	});
        
        function showpopupdetail(id) {
        $().w2popup('open', {
            name: 'lookup_form',
            title: 'Detail',
            body: '<div id="popupDetail" class="framepopup">please wait..</div>',
            style: 'padding: 5px 0px 0px 0px',
            width: 500,
            height: 500,
            onOpen: function (event) {
                event.onComplete = function () {

                    $("#popupDetail").load("{site_url}/hrsys/calendar/showDetail/" + id, function () {
                    });
                }

            }
        });
    }

</script>

<div id="calendar" style="margin: 10px"></div>