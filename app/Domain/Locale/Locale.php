<?php

namespace App\Domain\Locale;

class Locale
{
    private $friendlyLocale, $locale;
    private $default = 'nl';
    /**
     * @var string[]
     *
     * The key is the informal language name, to be used in routing.
     * On the key side country code using ISO 639-1 standard (https://en.wikipedia.org/wiki/List_of_ISO_639-1_codes)
     *
     */
    private $friendlyLocaleList = [
        'english' => 'en',
        'nederlands' => 'nl'
    ];

    /**
     * @return string
     */
    private function getLocale($friendlyLocale)
    {
        return $this->friendlyLocaleList[$friendlyLocale];
    }

    public function storeLocale()
    {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
        $_SESSION['language'] = $this->locale;
    }

    public function setLocale($friendlyLocale)
    {
        $this->locale = $this->getLocale($friendlyLocale);

        if($this->locale !== $this->default) {
            $this->setPageLocale($this->locale);
        }
        return $this;
    }

    public function setPageLocale($langCode)
    {
        if (defined('LC_MESSAGES')) {
            setlocale(LC_MESSAGES, $langCode);
            putenv("LC_ALL={$langCode}");
            putenv("LANGUAGE={$langCode}.UTF-8");
            bindtextdomain("messages", "locale");
        } else {
            setlocale(LC_ALL, $langCode);
            putenv("LC_ALL={$langCode}");
            putenv("LANGUAGE={$langCode}.UTF-8");
            bindtextdomain("messages", "locale");
        }
        textdomain("messages");
        return $this;
    }

}