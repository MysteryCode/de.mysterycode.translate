{capture assign='pageTitle'}{$package->getTitle()}{/capture}

{capture assign='headContent'}
	{event name='javascriptInclude'}
	<script data-relocate="true">


	</script>
{/capture}

{include file='header'}

<div id="packageInformation" class="section">
	<h2 class="sectionTitle">{lang}translate.package.information{/lang}</h2>
	
	<dl>
		<dt>{lang}translate.package.identifier{/lang}</dt>
		<dd>{$package->identifier}</dd>
	</dl>
	
	<dl>
		<dt>{lang}translate.package.title{/lang}</dt>
		<dd>{$package->getTitle()}</dd>
	</dl>
	
	<dl>
		<dt>{lang}translate.package.descripton{/lang}</dt>
		<dd>{$package->descripton}</dd>
	</dl>
	
	{if $package->author}
		<dl>
			<dt>{lang}translate.package.github{/lang}</dt>
			<dd>
				{if $package->authorUrl}
					<a href="{$package->authorUrl}" class="externalURL"{if EXTERNAL_LINK_REL_NOFOLLOW || EXTERNAL_LINK_TARGET_BLANK} rel="{if EXTERNAL_LINK_REL_NOFOLLOW}nofollow{/if}{if EXTERNAL_LINK_TARGET_BLANK}{if EXTERNAL_LINK_REL_NOFOLLOW} {/if}noopener noreferrer{/if}"{/if}{if EXTERNAL_LINK_TARGET_BLANK} target="_blank"{/if}>{$package->author}</a>
				{else}
					{$package->author}
				{/if}
			</dd>
		</dl>
	{/if}
	
	{if $package->github}
		<dl>
			<dt>{lang}translate.package.github{/lang}</dt>
			<dd><a href="{$package->github}" class="externalURL"{if EXTERNAL_LINK_REL_NOFOLLOW || EXTERNAL_LINK_TARGET_BLANK} rel="{if EXTERNAL_LINK_REL_NOFOLLOW}nofollow{/if}{if EXTERNAL_LINK_TARGET_BLANK}{if EXTERNAL_LINK_REL_NOFOLLOW} {/if}noopener noreferrer{/if}"{/if}{if EXTERNAL_LINK_TARGET_BLANK} target="_blank"{/if}>{$package->github}</a></dd>
		</dl>
	{/if}
	
	<dl>
		<dt>{lang}translate.package.veriables{/lang}</dt>
		<dd>{$package->variables}</dd>
	</dl>
	
	{event name='packageInformation'}
</div>

<div id="translationInformation" class="section">
	<h2 class="sectionTitle">{lang}translate.package.information.translation{/lang}</h2>
	
	<dl>
		<dt>{lang}translate.package.language.completed{/lang}</dt>
		<dd>{$package->variablesChecked}</dd>
	</dl>
	
	<dl>
		<dt>{lang}translate.package.language.inprogress{/lang}</dt>
		<dd>--</dd>
	</dl>
	
	<dl>
		<dt>{lang}translate.package.language.empty{/lang}</dt>
		<dd>--</dd>
	</dl>
	
	{event name='languageInformation'}
</div>

{include file='footer'}
