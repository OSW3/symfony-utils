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
 * 2. Import the 'config/services/brand.yaml' in the 'config/services.yaml'
 * --
 * 
 * imports:
 *    - { resource: 'services/brand.yaml' }
 * 
 * 
 * 
 * 3. Provide the MenuService to Twig config 'config/packages/twig.yaml'
 * --
 * 
 * twig:
 *    globals:
 *        brand: '@OSW3\Utils\Services\BrandService'
 */

use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;

class BrandService 
{
    private array $options = [];

    public function __construct(
        private ParameterBagInterface $params,
    ){
        // $this->options = $this->params->get('brand');
    }
    
    public function getName(): ?string
    {
        return $this->params->get('brand.name') ?? null;
    }
}