<?php
/**
 * App
 *
 * @category   BEAR
 * @package    BEAR.app
 * @subpackage Ro
 * @author     $Author:$ <username@example.com>
 * @license    @license@ http://@license_url@
 * @version    Release: 0.9.15 $Id:$
 * @link       http://@link_url@
 */

/**
 * Sample resource
 *
 * @category   BEAR
 * @package    BEAR.app
 * @subpackage Ro
 * @author     $Author:$ <username@example.com>
 * @license    @license@ http://@license_url@
 * @version    Release: 0.9.15 $Id:$
 * @link       http://@link_url@
 */
class App_Ro_Article_List extends App_Ro
{
    /**
     * table
     *
     * @var string
     */
    public $_table = 'article';


    /**
     * Read
     *
     * @param array $values
     *
     * @return array
     * @optional id ID,未指定の場合は全県
     */
    public function onRead($values)
    {
        $where = ' WHERE deleted_at IS NULL';
        $sql = "SELECT * FROM {$this->_table}{$where}";
        $result = $this->_query->select($sql);

        return $result;
    }

}
