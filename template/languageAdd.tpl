{include file='header'}

{include file='multipleLanguageInputJavascript' elementIdentifier='languageName' forceSelection=true}

{include file='formError'}

{if $success|isset}
	<p class="success">{lang}wcf.global.success.{@$action}{/lang}</p>
{/if}

<form method="post" action="{if $action == 'add'}{link controller='LanguageAdd'}{/link}{else}{link controller='LanguageEdit' id=$languageID}{/link}{/if}">
	{event name='beforeSections'}
	
	<div class="section htmlContent">
		<dl{if $errorField == 'languageCode'} class="formError"{/if}>
			<dt>{lang}wcf.acp.language.code{/lang}</dt>
			<dd>
				<input type="text" id="languageCode" name="languageCode" value="{$languageCode}" required class="medium">
				{if $errorField == 'languageCode'}
					<small class="innerError">
						{if $errorType == 'empty'}
							{lang}wcf.global.form.error.empty{/lang}
						{else}
							{lang}translate.language.languageCode.error.notValid{/lang}
						{/if}
					</small>
				{/if}
			</dd>
		</dl>
		
		<dl{if $errorField == 'countryCode'} class="formError"{/if}>
			<dt>{lang}wcf.acp.language.countryCode{/lang}</dt>
			<dd>
				<input type="text" id="countryCode" name="countryCode" value="{$countryCode}" required class="medium">
				{if $errorField == 'countryCode'}
					<small class="innerError">
						{if $errorType == 'empty'}
							{lang}wcf.global.form.error.empty{/lang}
						{else}
							{lang}translate.language.countryCode.error.notValid{/lang}
						{/if}
					</small>
				{/if}
			</dd>
		</dl>
		
		<dl{if $errorField == 'languageName'} class="formError"{/if}>
			<dt>{lang}wcf.global.name{/lang}</dt>
			<dd>
				<input type="text" id="languageName" name="languageName" value="{$languageName}" required class="long">
				{include file='multipleLanguageInputJavascript' elementIdentifier='languageName' forceSelection=true}
				{if $errorField == 'languageName'}
					<small class="innerError">
						{if $errorType == 'empty'}
							{lang}wcf.global.form.error.empty{/lang}
						{else}
							{lang}translate.language.languageName.error.notValid{/lang}
						{/if}
					</small>
				{/if}
			</dd>
		</dl>
		
		{if $action == 'add'}
			<dl{if $errorField == 'foreignLanguageName'} class="formError"{/if}>
				<dt>{lang}translate.language.foreignLanguageName{/lang}</dt>
				<dd>
					<input type="text" id="foreignLanguageName" name="foreignLanguageName" value="{$foreignLanguageName}" required class="long">
					{if $errorField == 'foreignLanguageName'}
						<small class="innerError">
							{if $errorType == 'empty'}
								{lang}wcf.global.form.error.empty{/lang}
							{else}
								{lang}translate.language.foreignLanguageName.error.notValid{/lang}
							{/if}
						</small>
					{/if}
				</dd>
			</dl>
			
			<dl{if $errorField == 'sourceLanguageID'} class="formError"{/if}>
				<dt><label for="sourceLanguageID">{lang}wcf.acp.language.add.source{/lang}</label></dt>
				<dd>
					<select id="sourceLanguageID" name="sourceLanguageID">
						{foreach from=$languages item=language}
							<option value="{@$language->languageID}"{if $language->languageID == $sourceLanguageID} selected{/if}>{$language->languageName} ({$language->languageCode})</option>
						{/foreach}
					</select>
					{if $errorField == 'sourceLanguageID'}
						<small class="innerError">
							{if $errorType == 'empty'}
								{lang}wcf.global.form.error.empty{/lang}
							{else}
								{lang}wcf.acp.language.add.source.error.{@$errorType}{/lang}
							{/if}
						</small>
					{/if}
				</dd>
			</dl>
		{/if}
		
		{event name='fields'}
	</div>
	
	{event name='afterSections'}
	
	{if !$__wcf->user->userID}
		<div class="formSubmit">
			<input type="submit" name="submit" value="{lang}wcf.global.submit{/lang}" accesskey="s">
			{@SECURITY_TOKEN_INPUT_TAG}
		</div>
	{/if}
</form>

{include file='footer'}
