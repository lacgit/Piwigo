<div class="titrePage">
	<h2>{'steghide plugin'|@translate}</h2>
</div>
<div id="configContent">
	<form method="post" >
	 <fieldset id="mainConf">
			<span class="property">
				<label for="pftperso">{'Configuration'|@translate}</label><br><br>
			</span>
			<table align="left">
				<tr>
					<td>External Steghide Directory:</td>
					<td><input type="text" name="ext_steghide_dir"
								value="{$stegconf.EXT_STEGHIDE_DIR}" size="50"
								style="text-align: left;"
								placeholder="{'ext_steghide_dir'|@translate}"
							/></td>
				</tr>
				<tr>
					<td>Steghide Passphrase File:</td>
					<td><input type="text" name="steghide_pass_file"
								value="{$stegconf.STEGHIDE_PASS_FILE}" size="50"
								style="text-align: left;"
								placeholder="{'steghide_pass_file'|@translate}"
							/></td>
				</tr>
				<tr>
					<td>Steghide Embed File:</td>
					<td><input type="text" name="steghide_embed_file"
								value="{$stegconf.STEGHIDE_EMBED_FILE}" size="50"
								style="text-align: left;"
								placeholder="{'steghide_embed_file'|@translate}"
							/></td>
				</tr>
				<tr>
				</tr>
				<tr>
					<td>
						<input class="submit" type="submit" name="submitpft"
							value="{'Submit'|@translate}">
						<input class="submit" type="reset" name="reset"
							value="{'Reset'|@translate}">
					</td>
				</tr>
			</table>
	</form>

{if isset ($gestB)}
{/if}
</div>
