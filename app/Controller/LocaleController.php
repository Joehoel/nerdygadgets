<?php

namespace App\Controller;

use App\Domain\Locale\Locale;

class LocaleController
{
    public function set($language)
    {
        if(isset($language)) {
            $lang = new Locale();
            $lang->setLocale($language)->storeLocale();
        }
        return back();
    }
}
