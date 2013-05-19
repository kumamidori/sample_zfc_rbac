<?php
/**
 * App
 *
 * @category   BEAR
 * @package    BEAR.app
 * @subpackage Page
 * @author     $Author:$ <username@example.com>
 * @license    @license@ http://@license_url@
 * @version    Release: 0.9.15 $Id:$
 * @link       http://@link_url@
 */

require_once 'App.php';

/**
 * Index
 *
 * @category   BEAR
 * @package    BEAR.app
 * @subpackage Page
 * @author     $Author:$ <username@example.com>
 * @license    @license@ http://@license_url@
 * @version    Release: 0.9.15 $Id:$
 * @link       http://@link_url@
 */
class Page_Index extends App_Page
{
    public function onOutput()
    {
        $this->display('index.tpl');
    }
}
App_Main::run('Page_Index');