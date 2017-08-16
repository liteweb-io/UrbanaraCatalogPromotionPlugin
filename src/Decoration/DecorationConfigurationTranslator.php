<?php

declare(strict_types=1);

namespace Urbanara\CatalogPromotionPlugin\Decoration;

final class DecorationConfigurationTranslator implements DecorationConfigurationTranslatorInterface
{
    /** {@inheritdoc} */
    public function __invoke(string $type, array $configuration, string $localeCode): array
    {
        if ($type !== 'message') {
            return $configuration;
        }

        if (!array_key_exists('message', $configuration)) {
            return $configuration;
        }

        $configuration['message'] = $configuration['message'][$localeCode] ?? '';

        return $configuration;
    }
}
