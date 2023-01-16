<?php

declare(strict_types=1);

namespace Forme\Crosswise\Hooks;

use Forme\Framework\Hooks\HookInterface;
use Forme\Framework\Hooks\HookIsSet;
use Forme\Framework\Support\EndToEndRoutes;
use function Forme\getInstance;

final class EndToEndRoutesHook implements HookInterface
{
    public function maybeAdd(): void
    {
        if (HookIsSet::check('plugins_loaded', EndToEndRoutes::class)) {
            return;
        }

        add_action('plugins_loaded', getInstance(EndToEndRoutes::class));
    }
}
