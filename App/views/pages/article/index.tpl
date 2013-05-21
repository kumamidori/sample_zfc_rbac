<div><a href="/article/new.php">新規登録</a></div>

<div>■記事一覧</div>
{if $articles}
<ul>
	{foreach item=article from=$articles}
	    <li>{$article.title}</li>
	    {$article.publish_status}
	{/foreach}
</ul>
{/if}