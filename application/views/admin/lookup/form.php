{message}
<form method="POST" id="formnya">
    <?= frm_('lookup_id', $post, "hidden") ?>
    <table>
        <tr>
            <td>Type</td>
            <td>
                <?= frm_('type', $post) ?>
            </td>
        </tr>
        <tr>
            <td>Value</td>
            <td>
                <?= frm_('value', $post) ?>
            </td>        
        </tr>
        <tr>
            <td>Display Text</td>
            <td>
                <?= frm_('display_text', $post) ?>
            </td>
        </tr>
        <tr>
            <td>Ordering Number</td>
            <td>
                <?= frm_('order_num', $post) ?>
            </td>
        </tr>
    </table>
    <input type="submit" name="action"  class="w2ui-btn" id="action" value="Save" />

</form>

<script>
    $(function () {
        $("#action").click(function () {
            $("#formnya").gn_popup_submit("{site_url}/admin/lookup/showForm","lookup_form",w2ui['listLookup']);
            return false;
        });
    });
</script>

