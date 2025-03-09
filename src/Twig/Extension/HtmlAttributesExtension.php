<?php 
namespace OSW3\Utils\Twig\Extension;

use Twig\TwigFunction;
use Twig\Extension\AbstractExtension;
use OSW3\Utils\Twig\Runtime\HtmlAttributesExtensionRuntime;

class HtmlAttributesExtension extends AbstractExtension
{
    public function getFunctions(): array
    {
        return [
            new TwigFunction('add_attribute', [HtmlAttributesExtensionRuntime::class, 'addAttribute']),
            new TwigFunction('get_attributes', [HtmlAttributesExtensionRuntime::class, 'getAttributes'], ['is_safe' => ['html']]),
        ];
    }
}
