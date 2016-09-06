{capture assign='canonicalURLParameters'}sortField={@$sortField}&sortOrder={@$sortOrder}{/capture}

{capture assign='headContent'}
	{if $pageNo < $pages}
		<link rel="next" href="{link controller='LanguageItemList'}pageNo={@$pageNo+1}&{@$canonicalURLParameters}{/link}">
	{/if}
	{if $pageNo > 1}
		<link rel="prev" href="{link controller='LanguageItemList'}{if $pageNo > 2}pageNo={@$pageNo-1}&{/if}{@$canonicalURLParameters}{/link}">
	{/if}
	<link rel="canonical" href="{link controller='LanguageItemList'}{if $pageNo > 1}pageNo={@$pageNo}&{/if}{@$canonicalURLParameters}{/link}">
{/capture}

{include file='header'}

{hascontent}
	<div class="paginationTop">
		{content}
			{pages print=true assign=pagesLinks controller='LanguageItemList' link="pageNo=%d&sortField=$sortField&sortOrder=$sortOrder"}
		{/content}
	</div>
{/hascontent}

{if $items}
	<div class="section tabularBox">
		<table class="table">
			<thead>
				<tr>
					<th class="columnID columnLanguageItemID{if $sortField == 'languageItemID'} active {@$sortOrder}{/if}" colspan="2"><a href="{link controller='LanguageItemList' application='translate'}pageNo={@$pageNo}&sortField=languageItemID&sortOrder={if $sortField == 'languageItemID' && $sortOrder == 'ASC'}DESC{else}ASC{/if}{/link}">{lang}wcf.global.objectID{/lang}</a></th>
					<th class="columnTitle columnLanguageItemName{if $sortField == 'languageItemName'} active {@$sortOrder}{/if}"><a href="{link controller='LanguageItemList' application='translate'}pageNo={@$pageNo}&sortField=languageItemName&sortOrder={if $sortField == 'languageItemName' && $sortOrder == 'ASC'}DESC{else}ASC{/if}{/link}">{lang}wcf.global.name{/lang}</a></th>
					
					{foreach from=$availableLanguages item=language}
						<th class="columnIcon columnStatus">{@$language->getIconTag()}</th>
					{/foreach}
					
					{event name='columnHeads'}
				</tr>
			</thead>
			
			<tbody>
				{foreach from=$objects item=languageItem}
					<tr class="jsLanguageItemRow">
						<td class="columnIcon">
							<a href="{link controller='LanguageItemEdit' application='translate' id=$languageItem->languageItemID}{/link}" title="{lang}wcf.global.button.edit{/lang}" class="jsTooltip"><span class="icon icon16 fa-pencil"></span></a>
							
							{event name='rowButtons'}
						</td>
						<td class="columnID columnLanguageItemID">{@$languageItem->languageItemID}</td>
						<td class="columnTitle columnLanguageItemName">
							<a href="{link controller='LanguageItemItemEdit' application='translate' id=$languageItem->languageItemID}{/link}">{$languageItem->languageItem}</a>
							<br>
							<small>{$languageItem->getCategory()->languageCategory}</small>
						</td>
						
						{foreach from=$languageItem->getTranslationStatus() item=$status}
							<td class="columnIcon columnStatus"><span class="icon icon16 fa-{if $status == -1}times{else if $status == 0}refresh{else if $status == 1}check{/if}"></span></td>
						{/foreach}
						
						{event name='columns'}
					</tr>
				{/foreach}
			</tbody>
		</table>
	</div>
{else}
	<p class="info">{lang}translate.languageItem.noLanguageItems{/lang}</p>
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
				<li><a href="{link controller='LanguageItemAdd'}{/link}" class="button"><span class="icon icon16 fa-plus"></span> <span>{lang}wcf.acp.languageItem.add{/lang}</span></a></li>
				{content}{event name='contentFooterNavigation'}{/content}
			</ul>
		</nav>
	{/hascontent}
</footer>

<script data-relocate="true">
	//<![CDATA[
	$(function() {
		new WCF.Action.Delete('translate\\data\\language\\item\\LanguageItemAction', '.jsLanguageItemRow');
		new WCF.Action.Toggle('translate\\data\\language\\item\\LanguageItemAction', $('.jsLanguageItemRow'));
	});
	//]]>
</script>

{include file='footer'}
