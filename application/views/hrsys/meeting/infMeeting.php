<div style="height:400px">
    <button id="createAppointment" class="jqbutton"> <span class="fa-edit">&nbsp;</span> Create an Appointment</button>

</div>


<script>
    $(function() { 
        
        $("#createAppointment").click(function () {
            showForm(0);
            return false;
        });
        
        
        function showForm(recid) {
            $().w2popup('open', {
                name    : 'lookup_form',
                title   : (recid == 0 ? 'Create an Appointment' : 'Edit Appointment'),
                body    : '<div id="popupForm" class="framepopup">please wait..</div>',
                style   : 'padding: 15px 0px 0px 0px',
                width   : 500,
                height  : 300, 
                onOpen  : function (event) {
                    event.onComplete = function () {

                       $( "#popupForm" ).load( "{site_url}/hrsys/meeting/showform/"+recid, function() {});
                    }

                }
            });
        }
        
        $(this).init_js("{base_url}");
    });
</script>