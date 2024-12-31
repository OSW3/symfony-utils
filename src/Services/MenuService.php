<?php 
namespace OSW3\Utils\Services;
/**
 * 1. Build menu settings
 * --
 * Open the 'config/services/menus.yaml' and add the menu tree
 * 
 * parameters:
 *    menus:
 *        main: [
 *            { label: index.links.main, route: homepage, text_domain: homepage_front_office }
 *        ]
 * 
 * 
 * 
 * 2. Import the 'config/services/menus.yaml' in the 'config/services.yaml'
 * --
 * 
 * imports:
 *    - { resource: 'services/menus.yaml' }
 * 
 * 
 * 
 * 3. Provide the MenuService to Twig config 'config/packages/twig.yaml'
 * --
 * 
 * twig:
 *    globals:
 *        menus: '@OSW3\Utils\Services\MenuService'
 */

use Symfony\Contracts\Translation\TranslatorInterface;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;

class MenuService 
{
    public function __construct(
        private LocaleService $localeService,
        private ParameterBagInterface $params,
        private TranslatorInterface $translator,
        private UrlGeneratorInterface $urlGenerator
    ){}
    
    public function build(string $name): array
    {
        $menus = $this->params->get('menus');
        
        if (!isset($menus[$name])) {
            throw new \InvalidArgumentException("Menu '$name' does not exist.");
        }

        $menu = $menus[$name];

        return $this->processMenuItems($menu);
    }

    private function processMenuItems(array $items): array
    {
        return array_map(function ($item) {
            // Text Domain
            $textDomain = $item['text_domain'] ?? null;

            // Translate Label
            $label = $this->translator->trans(
                $item['label'] ?? '',
                [],
                $textDomain,
                $this->localeService->getCurrent()
            );
            $item['label'] = $label;

            // Generate URL
            if (isset($item['route'])) {
                $item['url'] = $this->urlGenerator->generate($item['route']);
                unset($item['route']);
            }

            // Mark as Active (custom logic required)
            $currentUrl = $_SERVER['REQUEST_URI'] ?? '';
            $item['active'] = isset($item['url']) && $item['url'] === $currentUrl;

            // Process children recursively
            if (isset($item['children']) && is_array($item['children'])) {
                $item['children'] = $this->processMenuItems($item['children']);
            }

            return $item;
        }, $items);
    }
}