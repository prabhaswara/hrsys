<h2 class="form-title">List Candidate</h2>
<div style="padding: 10px;">
    <?php
    echo breadcrumb_($breadcrumb)
    ?>

    <div>
        <form  class="form-tbl" >
            Search


        </form>
        <div id="listCandidate" style="height:300px" ></div>
    </div>

</div>


<script>
    $(function() {

        $(".gn_breadcrumb a").click(function() {
            href = $(this).attr("href");
            if (href != "#" && href != "") {
                $.fn.gn_loadmain(href);
            }
            return false;

        });
        $('#listCandidate').w2grid({
            name: 'listCandidate',
            url: '{site_url}/hrsys/candidate/jsonListCandidate',
            columns: [
                {field: 'lksat_sp_display_text', caption: 'Status', size: '100px', sortable: true},
                {field: 'c_sp_name', caption: 'Name', size: '100%', sortable: true},
                {field: 'c_sp_expectedsalary', caption: 'expectedsalary', size: '200px',render:"number", sortable: true},
                {field: 'lksex_sp_display_text', caption: 'Sex', size: '100px', sortable: true},
                {field: 'c_sp_birthdate', caption: 'Age', size: '80px', sortable: true}
            
            ]  
        });
            
            
        $(this).init_js("{base_url}");

    });
</script>