<?php
namespace OSW3\Utils\Twig\Runtime;

use Twig\Extension\RuntimeExtensionInterface;

class TranslationExtensionRuntime implements RuntimeExtensionInterface
{
    /**
     * Retrieve translations in Translation table and return
     * -> $language values, (ex return French values if $language is 'fr') or
     * -> $fallback values, (ex return English values if $fallback is 'en' and French values is empty) or
     * -> null
     *
     * @param [type] $entity
     * @param [type] $property
     * @param [type] $language
     * @param string $fallback
     * @return string|null
     */
    public function getTranslation($entity, $property, $language, $fallback='en'): ?string
    {
        // Get all translations
        $translations = $entity->getTranslations()->toArray();

        // Filter translations by language
        $fallbackTranslations = array_filter($translations, fn($t) => $t->getLanguage() == $fallback);
        $languageTranslations = array_filter($translations, fn($t) => $t->getLanguage() == $language);

        // Reduce properties
        $fallbackProperties = array_reduce($fallbackTranslations, fn($p, $t) => [...$p, $t->getName() => $t->getValue()], []);
        $languageProperties = array_reduce($languageTranslations, fn($p, $t) => [...$p, $t->getName() => $t->getValue()], []);
        
        return $languageProperties[$property] ?? $fallbackProperties[$property] ?? null;
    }
}
