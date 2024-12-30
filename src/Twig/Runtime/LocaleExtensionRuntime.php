<?php
namespace OSW3\Utils\Twig\Runtime;

use OSW3\Utils\Services\LocaleService;
use Twig\Extension\RuntimeExtensionInterface;

class LocaleExtensionRuntime implements RuntimeExtensionInterface
{
    public function __construct(
        private LocaleService $localeService
    ){}

    public function getCurrent(): string
    {
        return $this->localeService->getCurrent();
    }

    public function getDefault(): string
    {
        return $this->localeService->getDefault();
    }

    public function getAvailable(): array
    {
        return $this->localeService->getAvailable();
    }
}
