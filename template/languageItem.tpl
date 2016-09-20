{capture assign='pageTitle'}{$languageItem->languageItem}{/capture}

{include file='header'}

<div class="section htmlContent">
	<h2 class="sectionHeadline">{lang}translate.language.variable.information{/lang}</h2>
	
	<dl>
		<dt>{lang}translate.language.variable.languageItem{/lang}</dt>
		<dd>{$languageItem->languageItem}</dd>
	</dl>
	
	<dl>
		<dt>{lang}wcf.acp.language.category{/lang}</dt>
		<dd>{$languageItem->getCategory()->languageCategory}</dd>
	</dl>
	
	<dl>
		<dt>{lang}translate.language.variable.package{/lang}</dt>
		<dd><a href="{$languageItem->getPackage()->getLink()}">{$languageItem->getPackage()->getTitle()}</a></dd>
	</dl>
	
	{event name='languageInformation'}
</div>

<div class="section htmlContent">
	<h2 class="sectionHeadline">{lang}translate.language.variable.translations{/lang}</h2>
	
	{foreach from=$languageItem->getTranslations() item=translation}
		<dl>
			<dt>{@$translation->getLanguage()->getIconTag()} {$translation->getLanguage()->getTitle()}</dt>
			<dd>
				<textarea rows="5" class="long" onclick="this.select()" readonly>{$translation->languageItemValue}</textarea>
				{assign var='status' value=$translation->getStatus()}
				<small>{lang}translate.language.variable.status{/lang}: <span class="icon icon16 fa-{if $status == -1}times{else if $status == 0}refresh{else if $status == 1}check{else}question{/if} jsTooltip" title="{lang}translate.language.variable.status.{if $status == -1}untranslated{else if $status == 0}unconfirmed{else if $status == 1}confirmed{else}error{/if}{/lang}"></span></small>
				
				{event name='afterTranslation'}
			</dd>
		</dl>
	{/foreach}
</div>
	
{include file='footer'}
