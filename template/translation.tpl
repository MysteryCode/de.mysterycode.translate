{capture assign='canonicalURLParameters'}languageID={$sourceLanguage->languageID}&packageID={$package->packageID}{/capture}

{capture assign='headContent'}
	{if $pageNo < $pages}
		<link rel="next" href="{link controller='Translation' application='translate'}pageNo={@$pageNo+1}&{@$canonicalURLParameters}{/link}">
	{/if}
	{if $pageNo > 1}
		<link rel="prev" href="{link controller='Translation' application='translate'}{if $pageNo > 2}pageNo={@$pageNo-1}&{/if}{@$canonicalURLParameters}{/link}">
	{/if}
	<link rel="canonical" href="{link controller='Translation' application='translate'}{if $pageNo > 1}pageNo={@$pageNo}&{/if}{@$canonicalURLParameters}{/link}">
{/capture}

{include file='header'}

{hascontent}
	<div class="paginationTop">
		{content}
			{pages print=true assign=pagesLinks controller='Translation' application='translate' link="pageNo=%d&$canonicalURLParameters"}
		{/content}
	</div>
{/hascontent}

{if $items}
	<div class="section tabularBox">
		<table class="table">
			<thead>
				<tr>
					<th class="columnText columnOrigin">{lang}translate.translate.origin{/lang}</th>
					<th class="columnText columnOrigin columnOriginSecondary">{lang}translate.translate.origin.secondary{/lang}</th>
					<th class="columnText columnTranslation">{lang}translate.translate.translation{/lang}</th>
					<th class="columnText columnButton"></th>
					
					{event name='columnHeads'}
				</tr>
			</thead>
			
			<tbody>
				{foreach from=$objects item=languageItem}
					<tr class="languageItemName">
						<td colspan="4">
							<span class="inlineCode">{$languageItem->languageItem}</span>
						</td>
					<tr>
					<tr class="jsTranslationRow">
						<td class="columnText columnOrigin">
							<textarea rows="5" readonly>{$languageItem->getSourceValue()}</textarea>
						</td>
						<td class="columnText columnOrigin columnOriginSecondary">
							{assign var=secondarySourceValue value=$languageItem->getSourceValue(true)}
							{if $secondarySourceValue}
								<textarea rows="5" readonly>{$secondarySourceValue}</textarea>
							{/if}
						</td>
						<td class="columnText columnTranslation">
							<textarea rows="5" id="languageItemTranslation{$languageItem->languageItemID}" class="jsTranslation">{$languageItem->languageItemValueSecondary}</textarea>
						</td>
						<td class="columnText columnButton">
							<span class="button disabled jsSubmitTranslation">{lang}wcf.global.submit{/lang}</span>
						</td>
					</tr>
				{/foreach}
			</tbody>
		</table>
	</div>
{else}
	<p class="info">{lang}translate.translation.noItems{/lang}</p>
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
		//TODO: catch click on submit buttons
	});
	//]]>
</script>

{include file='footer'}
