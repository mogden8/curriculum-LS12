<?php

namespace App\Word;

use PhpOffice\PhpWord\TemplateProcessor;

class SafeTemplateProcessor extends TemplateProcessor
{
    /**
     * Override setValue to sanitize all replacements before inserting into the docx.
     *
     * @param string|array $search
     * @param string|array $replace
     * @param int $limit  Dummy parameter added to satisfy Intelephense
     */
    public function setValue($search, $replace, $limit = -1)
    {
        // Handle array input (multiple replacements)
        if (is_array($search) && is_array($replace)) {
            foreach ($replace as $key => $value) {
                if (is_string($value)) {
                    $replace[$key] = htmlspecialchars($value, ENT_QUOTES, 'UTF-8');
                }
            }

            return parent::setValue($search, $replace);
        }

        // Handle single replacement
        if (is_string($replace)) {
            $replace = htmlspecialchars($replace, ENT_QUOTES, 'UTF-8');
        }

        return parent::setValue($search, $replace);
    }
}
