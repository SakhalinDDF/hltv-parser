<?php

namespace common\models;

use yii\web\IdentityInterface;

class User implements IdentityInterface
{
    /**
     * @var \common\models\User
     */
    private static $_identity;

    public static function findIdentity($id)
    {
        if (self::$_identity === null) {
            self::$_identity = new self();
        }

        return self::$_identity;
    }

    /**
     * Finds an identity by the given token.
     *
     * @param mixed $token the token to be looked for
     * @param mixed $type  the type of the token. The value of this parameter depends on the implementation.
     *                     For example, [[\yii\filters\auth\HttpBearerAuth]] will set this parameter to be `yii\filters\auth\HttpBearerAuth`.
     *
     * @return IdentityInterface the identity object that matches the given token.
     * Null should be returned if such an identity cannot be found
     * or the identity is not in an active state (disabled, deleted, etc.)
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        return self::findIdentity(1);
    }

    public function getId()
    {
        return 1;
    }

    public function getAuthKey()
    {
        return 'auth-key';
    }

    public function validateAuthKey($authKey)
    {
        return true;
    }
}
