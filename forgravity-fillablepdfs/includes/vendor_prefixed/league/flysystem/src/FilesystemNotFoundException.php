<?php

namespace ForGravity\Fillable_PDFs\League\Flysystem;

use LogicException;
/**
 * Thrown when the MountManager cannot find a filesystem.
 */
class FilesystemNotFoundException extends LogicException implements FilesystemException
{
}
