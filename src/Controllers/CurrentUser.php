<?php
declare(strict_types=1);

namespace Forme\Crosswise\Controllers;

use Forme\Framework\Controllers\AbstractController;
use Forme\Framework\Models\User;
use Laminas\Diactoros\Response\JsonResponse;

final class CurrentUser extends AbstractController
{
    public function __invoke($request)
    {
        return new JsonResponse(User::find(get_current_user_id()));
    }
}
