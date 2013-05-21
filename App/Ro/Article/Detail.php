<?php
use Zend\Permissions\Rbac\AssertionInterface;
use Zend\Permissions\Rbac\Rbac;
/**
 * 記事詳細Ro
 *
 */
class AssertCompanyIdMatches implements AssertionInterface
{
    public $userCompanyId;
    public $article;

    public function __construct()
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
        // edits his company's article
        // publish status [preview] only
        // can not edit another company's article

        return $this->userCompanyId == $this->article['company_id'];
    }
}

/**
 * 記事詳細Ro
 *
 */
class App_Ro_Article_Detail extends App_Ro
{
    /**
     * table
     *
     * @var string
     */
    public $_table = 'article';

    /**
     * Create
     *
     * @param array $values
     *
     * @return void
     * アノテーション（AOP）アドバイス指定ここから
     * @aspect before App_Aspect_Rbac
     * @aspect around App_Aspect_Transaction
     * アノテーション（AOP）アドバイス指定ここまで
     * @required title
     * @required contents
     *
     * @throws App_Ro_Entry_Exception 登録できない例外
     */
    public function onCreate($values)
    {
        // TODO: 設定済みの状態で取得する
        $rbac = new Rbac();
        $rbac->addRole('admin');
        $rbac->getRole('admin')->addPermission('edit.article');
        $assertion = new AssertCompanyIdMatches();
        $assertion->setArticle($values);

        $roleCode = $values['current_user_role_code'];
        unset($values['current_user_id']);
        unset($values['current_user_role_code']);
        if ($rbac->isGranted($roleCode, 'edit.article', $assertion)) {
            $publishStatus = 1;
        } else {
            $publishStatus = 0;
        }
        $values['publish_status'] = $publishStatus;

        $values['created_at'] = date('Y-m-d H:i:s');
        $values['updated_at'] = date('Y-m-d H:i:s');
        $result = $this->_query->insert($values);

        if ($this->_query->isError($result)) {
            throw $this->_exception('登録できませんでした');
        }
    }

}
