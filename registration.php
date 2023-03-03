<?php
/**
 * Copyright © Webscale Networks
 */

declare(strict_types = 1);

use Magento\Framework\Component\ComponentRegistrar;

ComponentRegistrar::register(
    ComponentRegistrar::MODULE,
    'Webscale_CacheManager',
    __DIR__
);
