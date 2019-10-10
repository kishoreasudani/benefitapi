<tr>
	<td style="padding: 40px 70px 30px;">
		<table border="0" cellpadding="0" cellspacing="0" width="100%" height="100%">
			<tr>
				<td style="font-weight: 600; font-size: 14px;">Hi <?php echo $data['username'];?>,</td>
			</tr>
			<tr>
				<td style="font-size: 14px; padding: 12px 0;">We've received a request to reset your Mind Stock account password. Click the link below to reset it.</td>
			</tr>
			<tr>
				<td style="font-size: 14px; padding: 12px 0;"><strong>Reset Password Link: <a href = <?php echo $data['passwordLink']; ?> target="_blank" style="text-decoration: none;font-weight:bold; color:#2778b7 ">Click Here</a></strong> </td>
			</tr>
			<tr>
				<td style="font-size: 14px; padding-bottom: 0;">Look forward to serving you.</td>
			</tr>
			<tr>
				<td style="font-size: 14px; padding-bottom: 0;">Please contact us in case you have any queries regarding your password.</td>
			</tr>
		</table>
	</td>
</tr>