<div><a href="/">/HOME/</a></div>
<div><a href="/article/new.php">新規登録</a></div>

<div>■記事一覧</div>
{if $articles}
    <table>
	    <tr>
	    <th>title</th>
	    <th>contents</th>
	    <th>publish status</th>
	    </tr>
	{foreach item=article from=$articles}
	    <tr>
	    <td>{$article.title}</td>
	    <td>{$article.contents}</td>
	    <td>{$article.publish_status}</td>
	    </tr>
	{/foreach}
    </table>
{/if}