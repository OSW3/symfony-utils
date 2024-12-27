<?php
namespace OSW3\Utils\Twig\Extension;

use Twig\TwigFunction;
use Twig\Extension\AbstractExtension;
use OSW3\Utils\Twig\Runtime\HelloExtensionRuntime;

class HelloExtension extends AbstractExtension
{
    public function getFunctions(): array
    {
        return [
            new TwigFunction('hello', [HelloExtensionRuntime::class, 'hello'], ['is_safe' => ['html']]),
        ];
    }
}
