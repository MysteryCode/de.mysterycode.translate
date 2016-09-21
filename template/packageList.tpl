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
				{if $__wcf->session->getPermission('user.translate.package.canAdd')}<li><a href="{link controller='PackageAdd' application='translate'}{/link}" class="button"><span class="icon icon16 fa-plus"></span> <span>{lang}translate.package.add{/lang}</span></a></li>{/if}
				
				{event name='contentHeaderNavigation'}
			</ul>
		</nav>
	</header>
{/capture}

{capture assign='canonicalURLParameters'}sortField={@$sortField}&sortOrder={@$sortOrder}{/capture}

{capture assign='headContent'}
	{if $pageNo < $pages}
		<link rel="next" href="{link controller='PackageList' application='translate'}pageNo={@$pageNo+1}&{@$canonicalURLParameters}{/link}">
	{/if}
	{if $pageNo > 1}
		<link rel="prev" href="{link controller='PackageList' application='translate'}{if $pageNo > 2}pageNo={@$pageNo-1}&{/if}{@$canonicalURLParameters}{/link}">
	{/if}
	<link rel="canonical" href="{link controller='PackageList' application='translate'}{if $pageNo > 1}pageNo={@$pageNo}&{/if}{@$canonicalURLParameters}{/link}">
{/capture}

{include file='header'}

{hascontent}
	<div class="paginationTop">
		{content}
			{pages print=true assign=pagesLinks controller='PackageList' application='translate' link="pageNo=%d&sortField=$sortField&sortOrder=$sortOrder"}
		{/content}
	</div>
{/hascontent}

{if $items}
	<div class="section tabularBox">
		<table class="table">
			<thead>
				<tr>
					<th class="columnID columnPackageID{if $sortField == 'packageID'} active {@$sortOrder}{/if}" colspan="2"><a href="{link controller='PackageList' application='translate'}pageNo={@$pageNo}&sortField=packageID&sortOrder={if $sortField == 'packageID' && $sortOrder == 'ASC'}DESC{else}ASC{/if}{/link}">{lang}wcf.global.objectID{/lang}</a></th>
					<th class="columnTitle columnPackageName{if $sortField == 'i18ntitle'} active {@$sortOrder}{/if}"><a href="{link controller='PackageList' application='translate'}pageNo={@$pageNo}&sortField=i18ntitle&sortOrder={if $sortField == 'i18ntitle' && $sortOrder == 'ASC'}DESC{else}ASC{/if}{/link}">{lang}wcf.global.name{/lang}</a></th>
					<th class="columnText columnPackageVersion">{lang}translate.package.version.number{/lang}</th>
					<th class="columnDigits columnVariables{if $sortField == 'variables'} active {@$sortOrder}{/if}"><a href="{link controller='PackageList' application='translate'}pageNo={@$pageNo}&sortField=variables&sortOrder={if $sortField == 'variables' && $sortOrder == 'ASC'}DESC{else}ASC{/if}{/link}">{lang}translate.language.variables{/lang}</a></th>
					<th class="columnDigits columnCheckedVariables{if $sortField == 'checkedVariables'} active {@$sortOrder}{/if}"><a href="{link controller='PackageList' application='translate'}pageNo={@$pageNo}&sortField=checkedVariables&sortOrder={if $sortField == 'checkedVariables' && $sortOrder == 'ASC'}DESC{else}ASC{/if}{/link}">{lang}translate.language.variables.checked{/lang}</a></th>
					
					{event name='columnHeads'}
				</tr>
			</thead>
			
			<tbody>
				{foreach from=$objects item=package}
					<tr class="jsPackageRow">
						<td class="columnIcon">
							<a href="{link controller='PackageExport' application='translate' id=$package->packageID}{/link}" title="{lang}translate.package.language.export{/lang}" class="jsTooltip"><span class="icon icon16 fa-download"></span></a>
							{if $package->canEdit()}<a href="{link controller='PackageEdit' application='translate' id=$package->packageID}{/link}" title="{lang}wcf.global.button.edit{/lang}" class="jsTooltip"><span class="icon icon16 fa-pencil"></span></a>{/if}
							
							{event name='rowButtons'}
						</td>
						<td class="columnID columnPackageID">{@$package->packageID}</td>
						<td class="columnTitle columnPackageName">
							<a href="{$package->getLink()}">{$package->getTitle()}</a>
							{if $package->author}
								<br>
								<small>
									{if $package->authorUrl}
										<a href="{$package->authorUrl}" class="externalURL"{if EXTERNAL_LINK_REL_NOFOLLOW || EXTERNAL_LINK_TARGET_BLANK} rel="{if EXTERNAL_LINK_REL_NOFOLLOW}nofollow{/if}{if EXTERNAL_LINK_TARGET_BLANK}{if EXTERNAL_LINK_REL_NOFOLLOW} {/if}noopener noreferrer{/if}"{/if}{if EXTERNAL_LINK_TARGET_BLANK} target="_blank"{/if}>{$package->author}</a>
									{else}
										{$package->author}
									{/if}
								</small>
							{/if}
						</td>
						<td class="columnText columnPackageVersion">{$package->getCurrentVersion()->version}</td>
						<td class="columnDigits columnVariables">
							{if $package->variables}
								<a href="{link controller='LanguageItemList' application='translate'}packageID={$package->packageID}{/link}">{#$package->variables}</a>
							{else}
								{#$package->variables}
							{/if}
						</td>
						<td class="columnDigits columnCustomVariables">
							{if $package->variablesChecked}
								<a href="{link controller='LanguageItemList' application='translate'}packageID={$package->packageID}&checked=1{/link}">{#$package->variablesChecked}</a>
							{else}
								{#$package->variablesChecked}
							{/if}
						</td>
						
						{event name='columns'}
					</tr>
				{/foreach}
			</tbody>
		</table>
	</div>
{else}
	<p class="info">{lang}translate.package.noPackages{/lang}</p>
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
		{if $__wcf->session->getPermission('mod.translate.package.canDelete')}new WCF.Action.Delete('translate\\data\\package\\PackageAction', '.jsPackageRow');{/if}
	});
	//]]>
</script>

{include file='footer'}
