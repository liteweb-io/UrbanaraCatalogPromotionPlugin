<?php

declare(strict_types=1);

namespace Urbanara\CatalogPromotionPlugin\Decoration;

interface DecorationConfigurationTranslatorInterface
{
    public function __invoke(string $type, array $configuration, string $localeCode): array;
}
