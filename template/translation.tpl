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

<div class="section">
	<h2 class="sectionHeadline">{$package->getTitle()}</h2>
	
	{if $package->description}
		<dl>
			<dt>{lang}translate.package.description{/lang}</dt>
			<dd>{$package->description}</dd>
		</dl>
	{/if}
	{if $package->author}
		<dl>
			<dt>{lang}translate.package.author{/lang}</dt>
			<dd>{$package->author}</dd>
		</dl>
	{/if}
	<dl>
		<dt>{lang}translate.translate.target{/lang}</dt>
		<dd>{@$language->getIconTag()} {$language->getTitle()}</dd>
	</dl>
	<dl>
		<dt>{lang}translate.language.variables{/lang}</dt>
		<dd>{#$package->variables}</dd>
	</dl>
	<dl>
		<dt>{lang}translate.translate.variables.current{/lang}</dt>
		<dd>{#$items}</dd>
	</dl>
</div>

{if $items}
	<div class="section tabularBox">
		<table class="table">
			<thead>
				<tr>
					<th class="columnText columnOrigin">{lang}translate.translate.origin{/lang}</th>
					{if $__wcf->user->getUserOption('originLanguageSecondary')}<th class="columnText columnOrigin columnOriginSecondary">{lang}translate.translate.origin.secondary{/lang}</th>{/if}
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
							{assign var=sourceValue value=$languageItem->getSourceValue()}
							{if $sourceValue}
								<textarea rows="5" readonly>{$sourceValue}</textarea>
							{/if}
						</td>
						{if $__wcf->user->getUserOption('originLanguageSecondary')}
							<td class="columnText columnOrigin columnOriginSecondary">
								{assign var=secondarySourceValue value=$languageItem->getSourceValue(true)}
								{if $secondarySourceValue}
									<textarea rows="5" readonly>{$secondarySourceValue}</textarea>
								{/if}
							</td>
						{/if}
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
