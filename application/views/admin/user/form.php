<h2 class="form-title">{create_edit} User</h2>
{message}

<?php
$user_id=isset($postUser["user_id"])?$postUser["user_id"]:"0";

?>

    <form method="POST" id="formnya" class="form-tbl" >
        <?= frm_('user_id', $postUser, "type='hidden'") ?>
        <table>
            <tr>
                <td width='150px'>Username</td>
                <td>
                    <?= frm_('username', $postUser) ?>
                </td>        
            </tr>
            <tr>
                <td>Password</td>
                <td>
                    <?= frm_('password_1', $postUser, "type='password'") ?>
                </td>        
            </tr>
            <tr>
                <td>Repeat Password</td>
                <td>
                    <?= frm_('password_2', $postUser, "type='password'") ?>
                </td>        
            </tr>
            <tr>
                <td>Active\non</td>
                <td>
                    <?= select_('active_non', $postUser, $activeNonList, '', false) ?>
                </td>
            </tr>
            <tr>
                <td>Role
                    <span id="copy" class='imgbt fa  fa-copy cursorPointer'></span>
                </td>
                <td>
                    <?php
                    if (!empty($roles)) {
                        echo "<ul class='listcheckbox'>";
                        foreach ($roles as $role) {

                            echo "<li><label><input type='checkbox' class='rolechekbox' name='role[]' value='" . $role["role_id"] . "' " .
                            (in_array($role["role_id"], $postUserRole) ? "checked='checked'" : "")
                            . " />" . $role["name"] . "</label> </li>";
                        }
                        echo "</ul>";
                    }
                    ?>
                </td>
            </tr>
			
			<tr>
                <td>Consultant Code</td>
                <td>
                     <?= frm_g('employee','consultant_code', $postEmployee) ?>
                </td>
            </tr>
			<tr>
                <td>Employee Number</td>
                <td>
                     <?= frm_g('employee','employee_code', $postEmployee) ?>
                </td>
            </tr>
			
			<tr>
                <td>Employee Name</td>
                <td>
                     <?= frm_g('employee','fullname', $postEmployee) ?>
                </td>
            </tr>
        </table>
        <input type="submit" name="action" id="action" value="Save" class="w2ui-btn"/>
        <input type="button" name="action" id="cancel" value="Cancel"  class="w2ui-btn"/>
    </form>

<script type="text/javascript">

    $(function () {


        $().w2grid({
            name: 'popupUser',
            url: '{site_url}/admin/user/json_list',
            show: {
                toolbar: true,
                footer: true
            },
            columns: [
                {field: 'recid', caption: '', size: '50px', searchable: false, sortable: false,
                    render: function (record) {
                        return "<span class='fa fa-check imgbt' onclick='chooseUserRole(\"" + record.recid + "\")'></span>"

                    }

                },
                {field: 'us_sp_username', caption: 'Username', size: '100px', searchable: true, sortable: true},
                {field: 'lk_sp_display_text', caption: 'Active/Non', size: '100px', searchable: true, sortable: true},
                {field: 'us_sp_last_login', caption: 'Last Login', size: '150px', searchable: false, sortable: false},
                {field: 'rl_sp_role_name', caption: 'Role', size: '100%', searchable: false, sortable: false}

            ]

        });

        $("#action").click(function() {
            $("#formnya").gn_submit("{site_url}/admin/user/showForm/<?=$user_id?>");
            return false;
        });
        $("#cancel").click(function() {
            $(this).gn_loadmain('{site_url}/admin/user/');
            return false;
        });
        $("#copy").click(function () {

            openPopup();
            return false;
        });
    });

    function chooseUserRole(recid) {
        $.ajax({
            type: "POST",
            url: "{site_url}/admin/user/jsonUserRole/" + recid,
            success: function (data)
            {
                $('.rolechekbox').each(function () {
                    if (jQuery.inArray( $(this).val(), data )) {
                        $(this).attr('checked', true);
                    }else{
                        $(this).attr('checked', false);                        
                    }
                });

                w2popup.close();

            }
        });
    }
    function openPopup() {
        w2popup.open({
            title: 'Choose User to copy',
            width: 900,
            height: 600,
            showMax: true,
            modal:true,
            body: '<div id="main" style="position: absolute; left: 5px; top: 5px; right: 5px; bottom: 5px;"></div>',
            onOpen: function (event) {
                event.onComplete = function () {
                    $('#w2ui-popup #main').w2render('popupUser');
                };
            }
        });
    }
</script>
