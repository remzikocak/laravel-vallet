<?php

declare(strict_types=1);

namespace RKocak\Vallet\Enums;

enum Locale: string
{
    case German = 'de';

    case Turkish = 'tr';

    case English = 'en';

    case Russian = 'ru';

    public function label(): string
    {
        return match ($this) {
            self::German  => __('vallet::vallet.locales.german'),
            self::Turkish => __('vallet::vallet.locales.turkish'),
            self::English => __('vallet::vallet.locales.english'),
            self::Russian => __('vallet::vallet.locales.russian'),
        };
    }
}
