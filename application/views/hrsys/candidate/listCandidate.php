<h2 class="form-title">List Candidate</h2>
<div style="padding: 10px;">
    <?php
    echo breadcrumb_($breadcrumb)
    ?>

</div>


<script>
    $(function () {

    $(".gn_breadcrumb a").click(function () {
            href = $(this).attr("href");
            if (href != "#" && href != "") {
                $.fn.gn_loadmain(href);
            }
            return false;

        });
      $(this).init_js("{base_url}");  

    });
</script>