<?php
/**
*
* ZF-Commons のライセンスは下記です。
* 
* Commit Practices & Contributions
* All ZF-Commons modules are released under the 3-clause BSD license, unless otherwise stated. Contributions in the form of pull requests, feedback, and ideas are welcome from anyone.
* 
* Once a module reaches its first tagged release, the following rules shall apply:
* 
* All work should be done on feature / hotfix branches (NOT MASTER!) and pushed to your own fork.
* When a feature is ready to be merged, submit a pull request.
* Those with commit access must not push their commits directly to the canonical repository or merge their own pull requests.
* Each pull request should be peer-reviewed by other member in order to keep high code quality and prevent mistakes and ommisions. Once reviewed it is ready to be merged.
* 
* 
* http://framework.zend.com/manual/2.0/en/modules/zend.permissions.rbac.examples.html
* 上記公式サンプルコードを改変したものです。(kumamidori)
*/

use Zend\Permissions\Rbac\AssertionInterface;
use Zend\Permissions\Rbac\Rbac;
require_once('vendor/autoload.php');
class AssertUserIdMatches implements AssertionInterface
{
    protected $userId;
    protected $article;

    public function __construct($userId)
    {
        $this->userId = $userId;
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
        // edits his own article
        // can not edit another users article
        return $this->userId == $this->article->getUserId();
    }
}
class User 
{
    public function getId()
    {
        return 5;
    }
    public function getRole()
    {
        return 'member';
    }
}
class MySession
{
    public function getUser()
    {
        return new User();
    }
}
class ArticleService
{
    public function getArticle($userId)
    {
        return new Article($userId);
    }
}
class Article 
{
    public $userId = null;
    public function __construct($userId)
    {
        $this->userId = $userId;
    }
    public function getUserId()
    {
        return $this->userId;
    }
}
function p($o)
{
    echo '<pre>';
    echo var_export($o, true);
    echo '</pre>';
}

$mySessionObject = new MySession();
$articleService = new ArticleService();

// User is assigned the foo role with id 5
// News article belongs to userId 5
// Jazz article belongs to userId 6

$rbac = new Rbac();
$user = $mySessionObject->getUser();
$news = $articleService->getArticle(5);
$jazz = $articleService->getArticle(6);

$rbac->addRole($user->getRole());
$rbac->getRole($user->getRole())->addPermission('edit.article');

$assertion = new AssertUserIdMatches($user->getId());
$assertion->setArticle($news);

//Determines if access is granted by checking the role and child roles for permission.

// bad!!! true always - bad !!! 
if ($rbac->isGranted($user->getRole(), 'edit.article')) {
    // hacks another users article
    // NG!!!
    p('1. This is BAD!!! sample. another users article');
}

// true for user id 5, because he belongs to write group and user id matches
if ($rbac->isGranted($user->getRole(), 'edit.article', $assertion)) {
    // edits his own article
    p('2. This is GOOD Sample. edits his own article');
}

$assertion->setArticle($jazz);

// false for user id 5
if ($rbac->isGranted($user->getRole(), 'edit.article', $assertion)) {
    // can not edit another users article
} else {
    p('3. This is GOOD Sample. can not edit another users article');
}
