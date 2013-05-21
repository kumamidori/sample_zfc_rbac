<?php
/**
 * 記事入力フォームクラス
 *
 */

/**
 * 記事入力フォームクラス
 *
 */
class App_Form_Article_Input extends BEAR_Base
{

    private $form = null;

    // 必須マーク * 
    //「入力項目値inputタグの右（物理名html）」か（BEAR_Formのデフォルトはこちら）、
    // 「項目見出し名（物理名label）」か
    //
    // @see BEAR_Form
    //     const TEMPLATE_REQUIRED = '{$html}{if $required}<span style="font-size:80%; color:#ff0000;">*</span>{/if}';
    //     public static $requireTemplate = self::TEMPLATE_REQUIRED;
    //
    // このクラスのonRenderで参照。
    // ここではlabelの隣にした。
    private $requireTemplate = '{$label}{if $required}<span style="font-size:80%; color:#ff0000;">*</span>{/if}';

    /**
     * Inject
     *
     * @return void
     */
    public function onInject()
    {
        $customCallback = array($this, 'onRender');
        $confs = array(
            'formName' => 'articleform', 
            'adapter' => BEAR_Form::RENDERER_SMARTY_ARRAY,
            'method' => 'post',

            // レンダリングをカスタマイズするコールバック機構
            //
            //    @see BEAR_Form
            //         //HTML_QuickForm_Renderer_ArraySmartyレンダラ
            //         //フォーム描画
            //         $renderer = new HTML_QuickForm_Renderer_ArraySmarty($smarty);
            //         $renderer->setRequiredTemplate(self::$requireTemplate);
            //         $renderer->setErrorTemplate(self::$errorTemplate);
            //         if ($callback) {
            //             call_user_func($callback, $renderer);
            //         }
            //         $form->accept($renderer);
            //         $formValue = $renderer->toArray();

            'callback' => $customCallback
            );
        $this->form = BEAR::dependency('BEAR_Form', $confs);
    }

    /**
     * Form
     *
     * @return void
     */
    public function build()
    {
        $this->form->setDefaults(array('title' => '', 'contents' => ''));

        $titleAttr = array(
            'class' => 'input-xlarge', 'id' => 'title', 'rel' => 'popover'
            ,'data-content' => 'タイトルを入力して下さい。', 'data-original-title' => 'タイトル');
        $contentsAttr = array(
            'class' => 'input-xlarge', 'id' => 'contents', 'rel' => 'popover'
            ,'data-content' => '本文を入力して下さい。', 'data-original-title' => '本文',
            'rows' => '7');
        // 要素のタイプによるのですが、 HTML「属性」を引数に取る要素が多くあります。
        // 引数の型は、文字列もしくは配列です。
        // はじめの３つの引数は、 要素のタイプ、要素の名前、およびキャプション。 4番目のパラメータが「属性」。
        $this->form->addElement('text', 'title', 'タイトル', $titleAttr);
        $this->form->addElement('textarea', 'contents', '本文', $contentsAttr);
        $this->form->addElement('submit', '_submit', '登録する', '');

        // フィルタ
        $this->form->applyFilter('__ALL__', 'trim');
        $this->form->applyFilter('__ALL__', 'strip_tags');

        // 検証ルール
        $this->form->addRule('title', 'タイトルを入力してください', 'required', null, 'client');
        $this->form->addRule('contents', '本文を入力してください', 'required', null, 'client');
    }

    /**
    * Formレンダリングコールバック
    *
    */
    public function onRender($renderer) 
    {
        // 必須チェックのテンプレート適用
        $renderer->setRequiredTemplate($this->requireTemplate);
        // バリデーションエラーのテンプレートは使わない（カスタマイズでテンプレートに直接自作）
//        $renderer->setErrorTemplate($this->$errorTemplate);
    }

    /**
    * 編集して確認
    *
    *
    */
    public function reconfirm()
    {
        $this->form->addElement('submit', '_freeze', '確認する', '');
    }


    /**
    * 確認画面用プレビュー生成
    *
    */
    public function freeze()
    {
        $this->form->removeElement('_submit');

        $buttons[] = $this->form->createElement('submit', '_action', 'この内容で送信する');
        $buttons[] = $this->form->createElement('submit', '_modify', '修正する');
        //:addGroup(array $elements, $name, $groupLabel, $separator, $appendName = true)
        $this->form->addGroup($buttons, 'submitgrp', '', '', false);

        $this->form->freeze();
    }

}
