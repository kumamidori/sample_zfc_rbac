<?php
/**
 * 記事詳細Ro
 *
 */
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
        $appRbac = BEAR::dependency('App_Rbac');
        $rbac = $appRbac->rbac;

        $assertion = BEAR::dependency('App_Rbac_AssertCompanyIdMatches');
        $assertion->setArticle($values);

        $roleCode = $values['current_user_role_code'];
        unset($values['current_user_id']);
        unset($values['current_user_role_code']);
        if ($rbac->isGranted($roleCode, 'edit.article', $assertion)) {
            $publishStatus = 1;
        } else if($rbac->isGranted($roleCode, 'preview.manage.article', $assertion)) {
            $publishStatus = 0;
        } else {
            throw new Exception('予期しないエラーが発生しました');
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
