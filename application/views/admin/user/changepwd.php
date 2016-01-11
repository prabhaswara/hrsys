{message}
<form method="POST" id="formnya" class="form-tbl" >
	<table>
		<tr>
			<td  class="aright">Old Password :</td><td> <?= frm_('oldPassword', $postUser,"type='password'") ?></td>
		</tr>
		<tr>
			<td  class="aright">New Password :</td><td> <?= frm_('newPassword', $postUser,"type='password'") ?></td>
		</tr>
		<tr>
			<td  class="aright">Repeat New Password :</td><td> <?= frm_('repeatNewPassword', $postUser,"type='password'") ?></td>
		</tr>
		
		<tr>
			<td></td><td>
				<input type="submit" name="action" id="changePwdSaveBtn" value="Save" class="w2ui-btn"/>
				
				</td>
		</tr>
	</table>
</form>


<script type="text/javascript">

    $(function () {
        $("#changePwdSaveBtn").click(function() {
            $("#formnya").gn_popup_submit("{site_url}/admin/user/changepwd/",'changepwd_panel');
            return false;
        });
        $("#changePwdCancelBtn").click(function() {
            
            return false;
        });
	});
</script>