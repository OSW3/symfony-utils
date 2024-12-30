<?php 
namespace OSW3\Utils\Services;

use Symfony\Component\Yaml\Yaml;
use Symfony\Component\Intl\Locales;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Contracts\Translation\TranslatorInterface;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;

final class LocaleService
{
    public function __construct(
        private ParameterBagInterface $params,
        private TranslatorInterface $translator,
        private RequestStack $request
    ){}

    public function getCurrent(): string
    {
        $locale = null;

        // Locale in session
        if ($locale === null) {
            $locale = $this->request->getSession()->get('_locale');
        }


        // Request Locale (URL or request parameter)
        if ($locale === null) {
            $locale = $this->request->getCurrentRequest()->getLocale();
        }

        // Preferred Locale (from browser settings)
        if ($locale === null) {
            $locale = $this->request->getCurrentRequest()->getPreferredLanguage();
        }

        // Default locale
        if ($locale === null) {
            $locale = $this->getDefault();
        }

        // Fallback locale if no locale is defined
        return $locale ?? 'en';
    }

    /**
     * Get default locale of translator
     *
     * @return string
     */
    public function getDefault(): string
    {
        $config = Yaml::parseFile($this->params->get('kernel.project_dir').'/config/packages/translation.yaml');
        return $config['framework']['default_locale'] ?? 'en';
    }

    /**
     * Get available locales from translator
     *
     * @return array
     */
    public function getAvailable(): array
    {
        $config    = Yaml::parseFile($this->params->get('kernel.project_dir').'/config/packages/translation.yaml');
        $available = $config['framework']['translator']['fallbacks'] ?? [];
        $choices   = [];

        foreach ($available as $code) 
        {
            $name = Locales::getName( $code, $code );
            $name = ucfirst($name);

            $choices[] = [
                'code' => $code, 
                'name' => $name,
            ];
        }

        return $choices;
    }
}