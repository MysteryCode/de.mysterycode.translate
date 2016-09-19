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
	<header class="contentHeader">
		<div class="contentHeaderTitle">
			<h1 class="contentTitle">{@$contentTitle}</h1>
			{if !$contentDescription|empty}<p class="contentHeaderDescription">{@$contentDescription}</p>{/if}
		</div>
		
		<nav class="contentHeaderNavigation">
			<ul>
				<li><a href="{link controller='LanguageAdd' application='translate'}{/link}" class="button"><span class="icon icon16 fa-plus"></span> <span>{lang}translate.language.add{/lang}</span></a></li>
				
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
							<a href="{link controller='LanguageEdit' application='translate' id=$language->languageID}{/link}" title="{lang}wcf.global.button.edit{/lang}" class="jsTooltip"><span class="icon icon16 fa-pencil"></span></a>
							
							{event name='rowButtons'}
						</td>
						<td class="columnID columnLanguageID">{@$language->languageID}</td>
						<td class="columnTitle columnLanguageName"><a href="{link controller='LanguageItemList' application='translate' id=$language->languageID}{/link}">{$language->getTitle()} <small>({@$language->languageCode})</small></a></td>
						<td class="columnDigits columnVariables">{#$language->variables}</td>
						<td class="columnDigits columnCustomVariables">{#$language->variables}</td>
						
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
				<li><a href="{link controller='LanguageAdd' application='translate'}{/link}" class="button"><span class="icon icon16 fa-plus"></span> <span>{lang}wcf.acp.language.add{/lang}</span></a></li>
				{content}{event name='contentFooterNavigation'}{/content}
			</ul>
		</nav>
	{/hascontent}
</footer>

<script data-relocate="true">
	//<![CDATA[
	$(function() {
		new WCF.Action.Delete('translate\\data\\language\\LanguageAction', '.jsLanguageRow');
		new WCF.Action.Toggle('translate\\data\\language\\LanguageAction', $('.jsLanguageRow'));
	});
	//]]>
</script>

{include file='footer'}
