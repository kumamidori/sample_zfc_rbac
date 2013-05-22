<?php
/**
 * ロールベースアクセス制御クラス
 *
 *
 */
use Zend\Permissions\Rbac\Rbac;
use Zend\Permissions\Rbac\Role;

/**
 * ロールベースアクセス制御クラス
 *
 *
 */
class App_Rbac extends BEAR_Base
{
    public $rbac;

    public function onInject()
    {
        $rbac = new Rbac();

        $admin = new Role('admin');
        $staff = new Role('staff');
        $writer = new Role('writer');

        $staff->addChild($writer);
        $admin->addChild($staff);
        $rbac->addRole($admin);

        $rbac->getRole('writer')->addPermission('preview.manage.article');
        $rbac->getRole('staff')->addPermission('read.article');
        $rbac->getRole('admin')->addPermission('edit.article');

        $this->rbac = $rbac;
    }

}