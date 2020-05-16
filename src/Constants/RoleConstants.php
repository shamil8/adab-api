<?php

namespace App\Constants;

use App\Abstracts\Constants;

/**
 * Список ролей системы
 *
 * @package App\Constants
 */
final class RoleConstants extends Constants
{
    /** @var string Role - User */
    public const USER = 'ROLE_USER';
    /** @var string Role - Moderator */
    public const MODERATOR = 'ROLE_MODERATOR';
    /** @var string Role - Admin */
    public const ADMIN = 'ROLE_ADMIN';
    /** @var string Role - Debug */
    public const DEBUG = 'ROLE_DEBUG';

    /**
     * @var string Role - Teacher
     * @deprecated
     */
    public const TEACHER = 'ROLE_TEACHER';
}
