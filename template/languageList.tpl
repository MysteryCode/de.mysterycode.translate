{capture assign='canonicalURLParameters'}sortField={@$sortField}&sortOrder={@$sortOrder}{if $countryCode}&countryCode={@$countryCode|rawurlencode}{/if}{/capture}

{capture assign='headContent'}
	{if $pageNo < $pages}
		<link rel="next" href="{link controller='LanguageList' application='translate'}pageNo={@$pageNo+1}&{@$canonicalURLParameters}{/link}">
	{/if}
	{if $pageNo > 1}
		<link rel="prev" href="{link controller='LanguageList' application='translate'}{if $pageNo > 2}pageNo={@$pageNo-1}&{/if}{@$canonicalURLParameters}{/link}">
	{/if}
	<link rel="canonical" href="{link controller='LanguageList' application='translate'}{if $pageNo > 1}pageNo={@$pageNo}&{/if}{@$canonicalURLParameters}{/link}">
{/capture}

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
				{if $__wcf->session->getPermission('user.translate.language.canAdd')}<li><a href="{link controller='LanguageAdd' application='translate'}{/link}" class="button"><span class="icon icon16 fa-plus"></span> <span>{lang}translate.language.add{/lang}</span></a></li>{/if}
				
				{event name='contentHeaderNavigation'}
			</ul>
		</nav>
	</header>
{/capture}

{include file='header'}

{hascontent}
	<div class="paginationTop">
		{content}
			{pages print=true assign=pagesLinks controller='LanguageList' application='translate' link="pageNo=%d&sortField=$sortField&sortOrder=$sortOrder&countryCode=$countryCode"}
		{/content}
	</div>
{/hascontent}

{if $items}
	<div class="section tabularBox">
		<table class="table">
			<thead>
				<tr>
					<th class="columnID columnLanguageID{if $sortField == 'languageID'} active {@$sortOrder}{/if}" colspan="2"><a href="{link controller='LanguageList' application='translate'}pageNo={@$pageNo}&sortField=languageID&sortOrder={if $sortField == 'languageID' && $sortOrder == 'ASC'}DESC{else}ASC{/if}{/link}">{lang}wcf.global.objectID{/lang}</a></th>
					<th class="columnTitle columnLanguageName{if $sortField == 'i18nlanguageName'} active {@$sortOrder}{/if}"><a href="{link controller='LanguageList' application='translate'}pageNo={@$pageNo}&sortField=i18nlanguageName&sortOrder={if $sortField == 'i18nlanguageName' && $sortOrder == 'ASC'}DESC{else}ASC{/if}{/link}">{lang}wcf.global.name{/lang}</a></th>
					<th class="columnDigits columnVariables{if $sortField == 'variables'} active {@$sortOrder}{/if}"><a href="{link controller='LanguageList' application='translate'}pageNo={@$pageNo}&sortField=variables&sortOrder={if $sortField == 'variables' && $sortOrder == 'ASC'}DESC{else}ASC{/if}{/link}">{lang}translate.language.variables{/lang}</a></th>
					<th class="columnDigits columnCheckedVariables{if $sortField == 'checkedVariables'} active {@$sortOrder}{/if}"><a href="{link controller='LanguageList' application='translate'}pageNo={@$pageNo}&sortField=checkedVariables&sortOrder={if $sortField == 'checkedVariables' && $sortOrder == 'ASC'}DESC{else}ASC{/if}{/link}">{lang}translate.language.variables.checked{/lang}</a></th>
					
					{event name='columnHeads'}
				</tr>
			</thead>
			
			<tbody>
				{foreach from=$objects item=language}
					<tr class="jsLanguageRow">
						<td class="columnIcon">
							<a href="{link controller='LanguageExport' application='translate' id=$language->languageID}{/link}" title="{lang}wcf.acp.language.export{/lang}" class="jsTooltip"><span class="icon icon16 fa-download"></span></a>
							{if $__wcf->session->getPermission('user.translate.language.canEdit')}<a href="{link controller='LanguageEdit' application='translate' id=$language->languageID}{/link}" title="{lang}wcf.global.button.edit{/lang}" class="jsTooltip"><span class="icon icon16 fa-pencil"></span></a>{/if}
							
							{event name='rowButtons'}
						</td>
						<td class="columnID columnLanguageID">{@$language->languageID}</td>
						<td class="columnTitle columnLanguageName"><a href="{$language->getLink()}">{$language->getTitle()} <small>({@$language->languageCode})</small></a></td>
						<td class="columnDigits columnVariables">
							{if $language->variables}
								<a href="{link controller='LanguageItemList' application='translate'}languageID={$language->languageID}{/link}">{#$language->variables}</a>
							{else}
								{#$language->variables}
							{/if}
						</td>
						<td class="columnDigits columnVariablesChecked">
							{if $language->variablesChecked}
								<a href="{link controller='LanguageItemList' application='translate'}languageID={$language->languageID}&checked=1{/link}">{#$language->variablesChecked}</a>
							{else}
								{#$language->variablesChecked}
							{/if}
						</td>
						
						{event name='columns'}
					</tr>
				{/foreach}
			</tbody>
		</table>
	</div>
{else}
	<p class="info">{lang}translate.language.noLanguages{/lang}</p>
{/if}

<footer class="contentFooter">
	{hascontent}
		<div class="paginationBottom">
			{content}{@$pagesLinks}{/content}
		</div>
	{/hascontent}
	
	{hascontent}
		<nav class="contentFooterNavigation">
			<ul>
				{content}{event name='contentFooterNavigation'}{/content}
			</ul>
		</nav>
	{/hascontent}
</footer>

<script data-relocate="true">
	//<![CDATA[
	$(function() {
		{if $__wcf->session->getPermission('mod.translate.language.canDelete')}new WCF.Action.Delete('translate\\data\\language\\LanguageAction', '.jsLanguageRow');{/if}
	});
	//]]>
</script>

{include file='footer'}
