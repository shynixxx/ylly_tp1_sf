<?php

namespace AppBundle\WebService;

use Doctrine\ORM\EntityManager;
use Google\Cloud\Translate\TranslateClient;

class GoogleTranslate implements GoogleTranslateInterface
{
    private $apiKey;
    private $entityManager;

    public function __construct(EntityManager $entityManager)
    {
        $this->translate = new TranslateClient();
        $this->entityManager = $entityManager;
    }

    /**
     * @param string $apiKey
     */
    public function setApiKey($apiKey)
    {
        $this->apiKey = $apiKey;
    }

    /**
     * @param string $text
     * @param string $language
     * @param string $class
     * @return array
     */
    public function getTranslate($text, $language, $class)
    {

        $translate = new TranslateClient([
            'keyFilePath' => $this->apiKey
        ]);

        $entity = $this->entityManager->getRepository($class)->findAll();

        $translation = $translate->translate($text, [
            'target' => $language
        ]);

        return $translation['text'];
    }
}
