{capture assign='pageTitle'}{$package->getTitle()}{/capture}

{capture assign='headContent'}
	{event name='javascriptInclude'}
	<script data-relocate="true">


	</script>
{/capture}

{include file='userSidebar' assign='sidebarRight'}

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
	
	{if $package->github}
		<dl>
			<dt>{lang}translate.package.github{/lang}</dt>
			<dd>{$package->github}</dd>
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
		<dd>--</dd>
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
