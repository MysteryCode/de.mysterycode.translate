{capture assign='contentHeader'}
	{if $contentTitle|empty}
		{if $__wcf->isLandingPage()}
			{capture assign='contentTitle'}{PAGE_TITLE|language}{/capture}
			{capture assign='contentDescription'}{PAGE_DESCRIPTION|language}{/capture}
		{elseif $__wcf->getActivePage() != null && $__wcf->getActivePage()->getTitle()}
			{capture assign='contentTitle'}{$__wcf->getActivePage()->getTitle()}{/capture}
		{/if}
	{/if}
	
	<header class="contentHeader">
		<div class="contentHeaderTitle">
			<h1 class="contentTitle">{@$contentTitle}</h1>
			{if !$contentDescription|empty}<p class="contentHeaderDescription">{@$contentDescription}</p>{/if}
		</div>
		
		<nav class="contentHeaderNavigation">
			<ul>
				<li><a href="{link controller='LanguageList' application='translate'}{/link}" class="button"><span class="icon icon16 fa-list"></span> <span>{lang}translate.language.list{/lang}</span></a></li>
				
				{event name='contentHeaderNavigation'}
			</ul>
		</nav>
	</header>
{/capture}

{include file='header'}

{include file='formError'}

{if $success|isset}
	<p class="success">{lang}wcf.global.success.{@$action}{/lang}</p>
{/if}

<form method="post" action="{if $action == 'add'}{link controller='LanguageAdd' controller='translate'}{/link}{else}{link controller='LanguageEdit' controller='translate' id=$languageID}{/link}{/if}">
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
				<input type="text" id="languageName" name="languageName" value="{$i18nPlainValues['languageName']}" required class="long">
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
						<option value="0"></option>
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
	
	<div class="formSubmit">
		<input type="submit" name="submit" value="{lang}wcf.global.submit{/lang}" accesskey="s">
		{@SECURITY_TOKEN_INPUT_TAG}
	</div>
</form>

{include file='footer'}
