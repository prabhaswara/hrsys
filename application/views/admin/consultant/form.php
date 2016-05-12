{message}
<form method="POST" id="formnya">
 
    <table>
        <tr>
            <td>Code</td>
            <td>
                <?= frm_('consultant_code', $post) ?>
            </td>
        </tr>
        <tr>
            <td>Consultant Name</td>
            <td>
                <?= frm_('name', $post) ?>
            </td>        
        </tr>
        
    </table>
    <input type="submit" class="w2ui-btn" name="action" id="action" value="Save" />

</form>

<script>
    $(function () {
        $("#action").click(function () {
            $("#formnya").gn_popup_submit("{site_url}/admin/consultant/showForm","consultant_form",w2ui['listConsultant']);
            return false;
        });
    });
</script>

