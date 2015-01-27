{message}
<form method="POST" id="formnya">
 
    <table>
        <tr>
            <td>ID</td>
            <td>
                <?= frm_('role_id', $post) ?>
            </td>
        </tr>
        <tr>
            <td>Name</td>
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
            $("#formnya").gn_popup_submit("{site_url}/admin/role/showForm","role_form",w2ui['listRole']);
            return false;
        });
    });
</script>

