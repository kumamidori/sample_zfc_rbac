<div>新規登録</div>

<div>記事一覧</div>
{if $articles}
<ul>
	{foreach item=article from=$articles}
	    <li>{$article.title}</li>
	{/foreach}
</ul>
{/if}