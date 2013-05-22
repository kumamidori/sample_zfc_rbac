<?php
/**
 * Transaction advice
 *
 */

/**
 * Transaction advice
 *
 */
class App_Aspect_Rbac implements BEAR_Aspect_Before_Interface
{
    /**
     * Transaction aroud advice
     *
     * @param array                 $values
     * @param BEAR_Aspect_JoinPoint $joinPoint
     *
     * @return array
     */
    public function before(array $values, BEAR_Aspect_JoinPoint $joinPoint)
    {
        $session = BEAR::dependency('BEAR_Session');
        $userId = $session->get('current_user_id');
        $roleCode = $session->get('current_user_role_code');
        if(strlen($roleCode) == 0) {
            // TODO: 例外を投げる
            // throw new RbacRoleNotFoundException();
            // とりあえずダミーで固定
            $userId = 3;
            $roleCode = 'writer';
        }
        $values['current_user_id'] = $userId;
        $values['current_user_role_code'] = $roleCode;

        return $values;
    }

}
