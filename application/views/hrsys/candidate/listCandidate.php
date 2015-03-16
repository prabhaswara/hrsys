<h2 class="form-title">Search Candidate</h2>
<div style="padding: 10px;">
    <?php
    echo breadcrumb_($breadcrumb)
    ?>

    <div>
        <form  class="form-tbl" >
            <table>
                <tr>
                    <td class="" width="150px">Salary Range (IDR) </td><td width="2px">:</td>
                    <td width="310px">
                        <?= frm_('salary_1', $postForm, "class=' kendonumber' style='width:140px'") ?> - 
                        <?= frm_('salary_2', $postForm, "class=' kendonumber' style='width:140px'") ?>

                    </td>       
                    <td width="80px" class="">Sex</td><td width="2px">:</td>
                    <td><?= select_('sex', $postForm,$sex_list,"class='kendodropdown'",false) ?></td>
                </tr>

                <tr>
                    <td class="">Age </td><td>:</td>
                    <td>
                        <?= frm_('age_1', $postForm, "class=' kendonumber w75'") ?> - 
                        <?= frm_('age_2', $postForm, "class=' kendonumber w75'") ?>

                    </td>  
                    <td class="">Expertise </td><td>:</td>
                    <td>
                        <select  id="expertise" name="expertise[]" multiple="multiple" class="w250"></select>
                    </td>     
                </tr>
                
                
            </table>
            <button>Search</button>

        </form>
        <div id="listCandidate" style="height:300px" ></div>
    </div>

</div>


<script>
     function detailCandidate(recid){
             $(window).gn_loadmain('{site_url}/hrsys/candidate/detcandidate/'+recid+'/{vacancy_id}/{frompage}');
            return false;
        }
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
            autoLoad: false,
            limit:25,
            show: {toolbar: true},
            url: '{site_url}/hrsys/candidate/jsonListCandidate',
            columns: [
                {field: 'recid', caption: '', size: '30px', searchable: false, sortable: false,
                    render: function (record) {
                        return "<span class='fa-zoom-in imgbt' onClick='detailCandidate(\""+record.recid+"\")' ></span>"
                    }
                },
                {field: 'lksat_sp_display_text', caption: 'Status', size: '100px', sortable: true},
                {field: 'c_sp_name', caption: 'Name', size: '250px', searchable:true, sortable: true},
                {field: 'c_sp_phone', caption: 'Phone', size: '100px', searchable:true, sortable: true},
                {field: 'c_sp_expectedsalary', caption: 'Expected Salary', searchable:true, size: '150px',render:"number", sortable: true},
                {field: 'lksex_sp_display_text', caption: 'Sex', searchable:true, size: '100px', sortable: true},
                {field: 'c_sp_birthdate', caption: 'Age', searchable:true, size: '80px', sortable: true},
                {field: 'ms_sp_skill', caption: 'Experties', searchable:true, size: '100%', sortable: false}
            
            ]  
        });
            
            
        $(this).init_js("{base_url}");

    });
</script>