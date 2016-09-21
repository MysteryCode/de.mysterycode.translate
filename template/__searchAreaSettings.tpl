{if $__translate->isActiveApplication() && $__searchAreaInitialized|empty}
	{capture assign='__searchInputPlaceholder'}{lang}translate.server.search{/lang}{/capture}
	{capture assign='__searchHiddenInputFields'}<input type="hidden" name="types[]" value="de.mysterycode.translate.language" />{/capture}
	{capture assign='__searchHiddenInputFields'}<input type="hidden" name="types[]" value="de.mysterycode.translate.package" />{/capture}
	{capture assign='__searchHiddenInputFields'}<input type="hidden" name="types[]" value="de.mysterycode.translate.language.item" />{/capture}
{/if}
