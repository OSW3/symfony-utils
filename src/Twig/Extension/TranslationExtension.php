<?php
namespace OSW3\Utils\Twig\Extension;

use Twig\TwigFunction;
use Twig\Extension\AbstractExtension;
use OSW3\Utils\Twig\Runtime\TranslationExtensionRuntime;

class TranslationExtension extends AbstractExtension
{
    public function getFunctions(): array
    {
        return [
            new TwigFunction('translation', [TranslationExtensionRuntime::class, 'getTranslation'], ['is_safe' => ['html']]),
        ];
    }
}
