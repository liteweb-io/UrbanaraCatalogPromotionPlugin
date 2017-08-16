<?php

namespace spec\Urbanara\CatalogPromotionPlugin\Decoration;

use PhpSpec\ObjectBehavior;
use Urbanara\CatalogPromotionPlugin\Decoration\DecorationConfigurationTranslatorInterface;

final class DecorationConfigurationTranslatorSpec extends ObjectBehavior
{
    function it_is_a_decoration_configuration_translator()
    {
        $this->shouldImplement(DecorationConfigurationTranslatorInterface::class);
    }

    function it_does_not_change_anything_if_type_is_not_message()
    {
        $this('strikethrough', ['message' => ['en_US' => 'xD', 'de_DE' => 'XD']], 'en_US')
            ->shouldReturn(['message' => ['en_US' => 'xD', 'de_DE' => 'XD']])
        ;
    }

    function it_does_not_change_anything_if_there_is_no_message_configuration_option()
    {
        $this('message', ['not_a_message' => ['en_US' => 'xD', 'de_DE' => 'XD']], 'en_US')
            ->shouldReturn(['not_a_message' => ['en_US' => 'xD', 'de_DE' => 'XD']])
        ;
    }

    function it_translates_message_if_locale_is_found_in_the_configuration()
    {
        $this('message', ['message' => ['en_US' => 'xD', 'de_DE' => 'XD']], 'en_US')->shouldReturn(['message' => 'xD']);
    }

    function it_leaves_message_empty_if_locale_is_not_found_in_the_configuration()
    {
        $this('message', ['message' => ['en_US' => 'xD', 'de_DE' => 'XD']], 'pl_PL')->shouldReturn(['message' => '']);
    }
}
