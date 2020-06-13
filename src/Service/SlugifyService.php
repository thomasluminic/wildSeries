<?php

namespace App\Service;


class SlugifyService
{
    public function generateSlugify(string $string)
    {
        $slug = strtolower(trim($string));
        $slug = transliterator_transliterate('Any-Latin; Latin-ASCII; [\u0080-\u7fff] remove', $slug);
        $slug = str_replace(' ', '-', $slug);
        $slug = preg_replace('/[^a-z\d-]+/i', '', $slug);
        $slug = str_replace('--', '-', $slug);
        $slug = rtrim($slug, "-");
        return $slug;
    }
}
