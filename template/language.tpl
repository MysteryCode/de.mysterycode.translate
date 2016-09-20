{capture assign='pageTitle'}{$language->getTitle()}{/capture}

{include file='header'}

<script data-relocate="true">
	$(function() {
		WCF.TabMenu.init();
	});
</script>

<div class="section tabMenuContainer" data-active="languageInformation" data-store="activeTabMenuItem">
	<nav class="tabMenu">
		<ul>
			<li><a href="{@$__wcf->getAnchor('languageInformation')}">{lang}translate.language.information{/lang}</a></li>
			<li><a href="{@$__wcf->getAnchor('translationInformation')}">{lang}translate.language.information.translation{/lang}</a></li>
			<li><a href="{@$__wcf->getAnchor('languageItemList')}">{lang}translate.language.variables.list{/lang}</a></li>
			
			{event name='tabMenuTabs'}	
		</ul>
	</nav>
	
	<div id="languageInformation" class="hidden tabMenuContent">
		<section class="section">
			<dl>
				<dt>{lang}wcf.global.name{/lang}</dt>
				<dd>{$language->getTitle()}</dd>
			</dl>
			
			<dl>
				<dt>{lang}translate.language.foreignLanguageName{/lang}</dt>
				<dd>{$language->foreignLanguageName}</dd>
			</dl>
			
			<dl>
				<dt>{lang}wcf.acp.language.countryCode{/lang}</dt>
				<dd>{$language->countryCode}</dd>
			</dl>
			
			<dl>
				<dt>{lang}wcf.acp.language.code{/lang}</dt>
				<dd>{$language->languageCode}</dd>
			</dl>
			
			{event name='languageInformation'}
		</section>
	</div>
	
	<div id="translationInformation" class="hidden tabMenuContent">
		<section class="section">
			<dl>
				<dt>{lang}translate.language.variables{/lang}</dt>
				<dd>{$language->variables}</dd>
			</dl>
			
			<dl>
				<dt>{lang}translate.language.variables.checked{/lang}</dt>
				<dd>{$language->variablesChecked}</dd>
			</dl>
			
			{event name='translationInformation'}
		</section>
	</div>
	
	<div id="languageItemList" class="hidden tabMenuContent">
		<section class="section">
			TODO: language item list
		</section>
	</div>
	
	{event name='tabMenuContents'}
</div>
	
{include file='footer'}
