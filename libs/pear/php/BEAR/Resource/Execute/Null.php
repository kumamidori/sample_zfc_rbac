<?php
/**
 * BEAR
 *
 * PHP versions 5
 *
 * @category   BEAR
 * @package    BEAR_Resource
 * @subpackage Execute
 * @author     Akihito Koriyama <koriyama@bear-project.net>
 * @copyright  2008-2011 Akihito Koriyama All rights reserved.
 * @license    http://opensource.org/licenses/bsd-license.php BSD
 * @version    SVN: Release: 0.9.15 $Id: Null.php 2486 2011-06-06 07:44:05Z koriyama@bear-project.net $
 * @link       http://www.bear-project.net/
 */

/**
 * Nullリソース
 *
 * @category   BEAR
 * @package    BEAR_Resource
 * @subpackage Execute
 * @author     Akihito Koriyama <koriyama@bear-project.net>
 * @copyright  2008-2011 Akihito Koriyama All rights reserved.
 * @license    http://opensource.org/licenses/bsd-license.php BSD
 * @version    Release: 0.9.15 $Id: Null.php 2486 2011-06-06 07:44:05Z koriyama@bear-project.net $
 * @link       http://www.bear-project.net
 */
class BEAR_Resource_Execute_Null extends BEAR_Resource_Execute_Adapter
{
    /**
     * リソースリクエスト実行
     *
     * @return mixed
     */
    public function request()
    {
        return null;
    }
}
