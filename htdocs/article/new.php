<?php
/**
 * 記事作成ページクラス
 *
 */

require_once 'App.php';

/**
 * 記事作成ページクラス
 *
 */
class Page_Article_New extends App_Page
{
    public function onInit()
    {
        $this->form = BEAR::dependency('App_Form_Article_Input');
        $this->form->build();
    }

    public function onActionArticleForm(array $submit)
    {
        // POE(Post Once Exactly)で一度しか実行しない
        $params = array('uri' => 'Article/Detail', 'values' => $submit, 'options' => array('poe' => true));
        $this->_resource->create($params)->request();
        $this->set('submit', $submit);
        $options = array('click' => 'done');
        $this->header->redirect('/article/', $options);        
    }

    public function onOutput()
    {
        $this->display('new.tpl');
    }
}

App_Main::run('Page_Article_New');
