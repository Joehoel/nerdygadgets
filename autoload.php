<?php

class AutoLoader
{
    private $files = [];
    private $base = __DIR__ . '/app';
    private $configDir = __DIR__ . '/config';

    public function app()
    {
        $baseDirectories = array_slice(scandir($this->base), 2);
        $this->get($baseDirectories);
        $this->get($configDir);
        $files = $this->files;
        spl_autoload_register(function () use ($files) {
            foreach($files as $file) {
                if(is_file($file)) {
                    require_once $file;
                }
            }
        });
    }

    /**
     * @param $files
     * @return array
     *
     * Recursive function to loop through all directories, adding all
     * found files to an array.
     */
    public function get(&$files)
    {
        foreach ($files as $key => $value) {
            $fullPath = realpath($this->base . DIRECTORY_SEPARATOR . $value);
            if(is_dir($fullPath)) {
                // Since this is a directory, we must loop through this as well.
                $baseDirectories = array_slice(scandir($fullPath), 2);
                $edited = [];
                foreach($baseDirectories as $base) {
                    $edited[] = $value . DIRECTORY_SEPARATOR . $base;
                }
                $this->get($edited);
            }
            if(is_file($fullPath)) {
                $this->files[] = $fullPath;
            }
        }
        return $this->files;
    }
}

$autoLoad = new AutoLoader();
$autoLoad->app();