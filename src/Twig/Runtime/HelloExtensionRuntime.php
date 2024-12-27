<?php
namespace OSW3\Utils\Twig\Runtime;

use Twig\Extension\RuntimeExtensionInterface;

class HelloExtensionRuntime implements RuntimeExtensionInterface
{
    public function hello(): string
    {
        return "Hello There";
    }
}
