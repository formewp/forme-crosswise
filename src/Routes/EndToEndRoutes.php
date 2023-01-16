<?php
declare(strict_types=1);

namespace Forme\Crosswise\Routes;

use Forme\Crosswise\Controllers\Create;
use Forme\Crosswise\Controllers\CurrentUser;
use Forme\Crosswise\Controllers\Login;
use Forme\Crosswise\Controllers\Migrate;
use Forme\Crosswise\Controllers\Rollback;
use Forme\Crosswise\Controllers\RunPhp;
use Forme\Framework\Core\Router;
use Forme\Framework\Middleware\TestOnlyMiddleware;

final class EndToEndRoutes
{
    private const PREFIX = '/__e2e__';

    public function __invoke(): void
    {
        if (WP_ENV === 'testing') {
            Router::post(self::PREFIX . '/create', Create::class)->addMiddleware(TestOnlyMiddleware::class);
            Router::post(self::PREFIX . '/login', Login::class)->addMiddleware(TestOnlyMiddleware::class);
            Router::get(self::PREFIX . '/current-user', CurrentUser::class)->addMiddleware(TestOnlyMiddleware::class);
            Router::get(self::PREFIX . '/migrate', Migrate::class)->addMiddleware(TestOnlyMiddleware::class);
            Router::get(self::PREFIX . '/rollback', Rollback::class)->addMiddleware(TestOnlyMiddleware::class);
            Router::post(self::PREFIX . '/run-php', RunPhp::class)->addMiddleware(TestOnlyMiddleware::class);
        }
    }
}
