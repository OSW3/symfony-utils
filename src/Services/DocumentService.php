<?php 
namespace OSW3\Utils\Services;

class DocumentService 
{
    private string $documentTitle;

    /**
     * Get the value of documentTitle
     */ 
    public function getDocumentTitle(): string
    {
        return $this->documentTitle;
    }

    /**
     * Set the value of documentTitle
     *
     * @return  self
     */ 
    public function setDocumentTitle($documentTitle): static
    {
        $this->documentTitle = $documentTitle;

        return $this;
    }
}