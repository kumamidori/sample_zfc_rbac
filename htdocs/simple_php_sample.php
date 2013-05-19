<?php
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
        return $this->userId == $this->article->getId();
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
    public function getArticle($id)
    {
        $result = array();
        if($id === 5) {

            return new Article();
        } elseif ($id === 6) {
            return new Article();
        } else {
            var_dump('???');
        }
    }
}
class Article 
{
    public function getId()
    {
        return 5;
    }
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
    var_dump('another users article');
}

// true for user id 5, because he belongs to write group and user id matches
if ($rbac->isGranted($user->getRole(), 'edit.article', $assertion)) {
    // edits his own article
    var_dump('edits his own article');
}

$assertion->setArticle($jazz);

// false for user id 5
if ($rbac->isGranted($user->getRole(), 'edit.article', $assertion)) {
    // can not edit another users article
} else {
    var_dump('can not edit another users article');
}
