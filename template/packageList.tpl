{capture assign='canonicalURLParameters'}sortField={@$sortField}&sortOrder={@$sortOrder}{/capture}

{capture assign='headContent'}
	{if $pageNo < $pages}
		<link rel="next" href="{link controller='PackageList'}pageNo={@$pageNo+1}&{@$canonicalURLParameters}{/link}">
	{/if}
	{if $pageNo > 1}
		<link rel="prev" href="{link controller='PackageList'}{if $pageNo > 2}pageNo={@$pageNo-1}&{/if}{@$canonicalURLParameters}{/link}">
	{/if}
	<link rel="canonical" href="{link controller='PackageList'}{if $pageNo > 1}pageNo={@$pageNo}&{/if}{@$canonicalURLParameters}{/link}">
{/capture}

{include file='header'}

{hascontent}
	<div class="paginationTop">
		{content}
			{pages print=true assign=pagesLinks controller='PackageList' link="pageNo=%d&sortField=$sortField&sortOrder=$sortOrder"}
		{/content}
	</div>
{/hascontent}

{if $items}
	<div id="userTableContainer" class="section tabularBox">
		<table class="table">
			<thead>
				<tr>
					<th class="columnID columnPackageID{if $sortField == 'packageID'} active {@$sortOrder}{/if}" colspan="2"><a href="{link controller='PackageList' application='translate'}pageNo={@$pageNo}&sortField=packageID&sortOrder={if $sortField == 'packageID' && $sortOrder == 'ASC'}DESC{else}ASC{/if}{/link}">{lang}wcf.global.objectID{/lang}</a></th>
					<th class="columnTitle columnPackageName{if $sortField == 'packageName'} active {@$sortOrder}{/if}"><a href="{link controller='PackageList' application='translate'}pageNo={@$pageNo}&sortField=packageName&sortOrder={if $sortField == 'packageName' && $sortOrder == 'ASC'}DESC{else}ASC{/if}{/link}">{lang}wcf.global.name{/lang}</a></th>
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
							<a href="{link controller='PackageEdit' application='translate' id=$package->packageID}{/link}" title="{lang}wcf.global.button.edit{/lang}" class="jsTooltip"><span class="icon icon16 fa-pencil"></span></a>
							
							{event name='rowButtons'}
						</td>
						<td class="columnID columnPackageID">{@$package->packageID}</td>
						<td class="columnTitle columnPackageName">
							<a href="{link controller='PackageItemList' application='translate' id=$package->packageID}{/link}">{$package->getTitle()}</a>
							<br>
							<small>
								{if $package->authorUrl}
									<a href="{$package->authorUrl}" class="externalURL"{if EXTERNAL_LINK_REL_NOFOLLOW || EXTERNAL_LINK_TARGET_BLANK} rel="{if EXTERNAL_LINK_REL_NOFOLLOW}nofollow{/if}{if EXTERNAL_LINK_TARGET_BLANK}{if EXTERNAL_LINK_REL_NOFOLLOW} {/if}noopener noreferrer{/if}"{/if}{if EXTERNAL_LINK_TARGET_BLANK} target="_blank"{/if}>{$package->author}</a>
								{else}
									{$package->author}
								{/if}
							</small>
						</td>
						<td class="columnText columnPackageVersion">{$package->getCurrentVersion()->version}</td>
						<td class="columnDigits columnVariables">{#$package->variables}</td>
						<td class="columnDigits columnCustomVariables">{#$package->variables}</td>
						
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
				<li><a href="{link controller='PackageAdd'}{/link}" class="button"><span class="icon icon16 fa-plus"></span> <span>{lang}wcf.acp.package.add{/lang}</span></a></li>
				{content}{event name='contentFooterNavigation'}{/content}
			</ul>
		</nav>
	{/hascontent}
</footer>

<script data-relocate="true">
	//<![CDATA[
	$(function() {
		new WCF.Action.Delete('translate\\data\\package\\PackageAction', '.jsPackageRow');
		new WCF.Action.Toggle('translate\\data\\package\\PackageAction', $('.jsPackageRow'));
	});
	//]]>
</script>

{include file='footer'}
