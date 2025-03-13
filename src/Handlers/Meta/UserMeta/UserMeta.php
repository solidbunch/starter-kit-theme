<?php

namespace StarterKit\Handlers\Meta\UserMeta;

defined('ABSPATH') || exit;

use Carbon_Fields\Container;
use Carbon_Fields\Field;

class UserMeta
{
    public static function make(): void
    {
        $metaPrefix = SK_PREFIX;

        Container::make('user_meta', __('Additional settings', 'starter-kit'))
                 ->add_fields([
                     Field::make('image', $metaPrefix . 'avatar_id', __('Avatar', 'starter-kit'))
                          ->set_type(['image/jpeg', 'image/jpg', 'image/png', 'image/svg+xml', 'image/webp',]),
                     Field::make('text', $metaPrefix . 'position', __('Position', 'starter-kit')),
                 ]);
    }
}
