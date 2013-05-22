<?php
/**
* 会社IDアサートクラス
*
*
*/
use Zend\Permissions\Rbac\AssertionInterface;
use Zend\Permissions\Rbac\Rbac;

/**
* 会社IDアサートクラス
*
*
*/
class App_Rbac_AssertCompanyIdMatches extends BEAR_Base implements AssertionInterface 
{
    public $userCompanyId;
    public $article;

    public function onInject()
    {
        $session = BEAR::dependency('BEAR_Session');
        $curUserId = $session->get('current_user_id');
        // TODO: 検索して取得する。とりあえず固定。
        $this->userCompanyId = null;
    }

    public function setArticle($article)
    {
        $this->article = $article;
    }

    public function assert(Rbac $rbac)
    {
        if (!$this->article) {
            return false;
        }
        // false case:
        // edits his company's article
        // publish status [preview] only
        // can not edit another company's article

        return $this->userCompanyId == $this->article['company_id'];
    }

}
