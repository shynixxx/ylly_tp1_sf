<?php

namespace AppBundle\WebService;

interface GoogleTranslateInterface
{
    public function getTranslate($text, $language, $class);
}
