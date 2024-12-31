<?php 
namespace OSW3\Utils\Services;
/**
 * 1. Brand settings
 * --
 * Open the 'config/services/brand.yaml' and add the brand settings
 * 
 * parameters:
 *    brand:
 *        name: My Brand Name
 *        favicon: My Brand Name
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

class BrandService 
{
    private array $options = [];

    public function __construct(
        private LocaleService $localeService,
        private ParameterBagInterface $params,
        private TranslatorInterface $translator,
        private UrlGeneratorInterface $urlGenerator
    ){
        $this->options = $this->params->get('brand');
    }
    
    public function getName(): ?string
    {
        return $this->options['name'] ?? null;
    }
}