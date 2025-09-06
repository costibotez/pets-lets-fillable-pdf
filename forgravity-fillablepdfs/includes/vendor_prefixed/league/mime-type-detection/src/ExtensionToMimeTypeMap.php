<?php

declare (strict_types=1);
namespace ForGravity\Fillable_PDFs\League\MimeTypeDetection;

interface ExtensionToMimeTypeMap
{
    public function lookupMimeType(string $extension) : ?string;
}
