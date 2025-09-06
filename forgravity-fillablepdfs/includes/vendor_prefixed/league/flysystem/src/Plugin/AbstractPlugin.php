<?php

namespace ForGravity\Fillable_PDFs\League\Flysystem\Plugin;

use ForGravity\Fillable_PDFs\League\Flysystem\FilesystemInterface;
use ForGravity\Fillable_PDFs\League\Flysystem\PluginInterface;
abstract class AbstractPlugin implements PluginInterface
{
    /**
     * @var FilesystemInterface
     */
    protected $filesystem;
    /**
     * Set the Filesystem object.
     *
     * @param FilesystemInterface $filesystem
     */
    public function setFilesystem(FilesystemInterface $filesystem)
    {
        $this->filesystem = $filesystem;
    }
}
