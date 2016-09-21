{include file='header'}

<script data-relocate="true">
	$(function() {
		//TODO: get url to translation page after package and language selection
	});
</script>

<div class="section">
	<form>
		<div>
			<dl id="packageSelection">
				<dt>{lang}translate.translate.package{/lang}</dt>
				<dd>
					<select>
						<option value="0">{lang}wcf.global.noSelection{/lang}</option>
						{foreach from=$packageList item=$package}
							<option value="{$package->packageID}">{$package->getTitle()}{if $package->author} ({$package->author}){/if}</option>
						{/foreach}
					</select>
				</dd>
			</dl>
			<dl id="languageSelection">
				<dt>{lang}translate.translate.language{/lang}</dt>
				<dd>
					<select>
						<option value="0">{lang}wcf.global.noSelection{/lang}</option>
					</select>
				</dd>
			</dl>
		</div>
		
		<div class="formSubmit">
			<input type="submit" name="submit" value="{lang}translate.translate.start{/lang}" accesskey="s">
		</div>
	</form>
</div>

{include file='footer'}
