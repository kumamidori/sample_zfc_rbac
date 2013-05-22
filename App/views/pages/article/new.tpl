<div><a href="/">/HOME/</a></div>
<div><a href="/article/">記事一覧へ戻る</a></div>

<div>■記事作成</div>

<form class="form-horizontal" id="articleform" {$articleform.attributes}>
{$articleform.hidden}
<fieldset>
    <legend>記事入力フォーム</legend>
    <div class="control-group">
        <label class="control-label" for="input01">{$articleform.title.label}</label>
        <div class="controls">
        {$articleform.title.html}
        {if $articleform.errors.title}<p class="alert alert-error input-err-msg">{$articleform.errors.title}</p>{/if}
        </div>
    </div>
    <div class="control-group">
        <label class="control-label" for="input01">{$articleform.contents.label}</label>
        <div class="controls">
        {$articleform.contents.html}
        {if $articleform.errors.contents}<p class="alert alert-error input-err-msg">{$articleform.errors.contents}</p>{/if}
        </div>
    </div>
    <div class="control-group">
        <label class="control-label" for="input01"></label>
        <div class="controls">
        {if $articleform.frozen}
            {$articleform.submitgrp._action.html}
            {$articleform.submitgrp._modify.html}
        {else}
            {$articleform._submit.html}
        {/if}
        </div>
    </div>
</fieldset>
</form>