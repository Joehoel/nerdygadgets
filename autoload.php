<?php

class AutoLoader
{
    // Array of files to autoload
    private $files = [];

    private $base = __DIR__ . '/app';

    public function app()
    {
        /**
         * Scandir is a function to scan all directories and files for a given path.
         * It uses array_slice in order to remove the first . and .. from the result of scandir.
         *
         */
        $baseDir = array_slice(scandir($this->base), 2);

        /**
         *  $this->>get is a RECURSIVE function that loops through everything inside
         *  the given path. ($baseDir).
         *
         *  I've made it so any actual FILE is being added to the $files array.
         *  If the function encounters a directory, it will call it self and adds those files/folders as well.
         *  It does this until every single file (even the nested ones) added to the $files array.
         *
         */
        $this->get($baseDir);

        /*
         * Here we turn $this->files into a local variable to be used in the anonyomous function below.
         * A anonymous function is a function that can be used as an arugment inside an already existing function.
         * It doesn't have a name, and it's not inside a class. The "scope" is also different in PHP.
         * Therefor, we cannot use $this (refering to this current class).
         *
         * The spl_autoload_register is there for autoloading. Autoloading allows you to use classes
         * anywere in your program that is registered within your autoloader. In the foreach loop
         * it goes through every single found file and require_once's it. This way it get's added.
         *
         * In our case, all files from the app directory and inside the config directory are being added
         * to the autoloader.
         *
         * */
        $files = $this->files;
        spl_autoload_register(function () use ($files) {
            foreach ($files as $file) {
                if (is_file($file)) {
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
    public function get(&$path)
    {
        // First we check if $files is an array as we cannot loop through a string, int etc.
        if (is_array($path)) {
            /**
             * $path is a string to the path of the directory or file we want
             * to examen. Here we look through each item in the array.
             */
            foreach ($path as $key => $value) {
                // we get the fullpath so we can check if it's a file or directory.
                $fullPath = realpath($this->base . DIRECTORY_SEPARATOR . $value);
                if (is_dir($fullPath)) {
                    // Since this is a directory, we must loop through this as well.
                    $baseDirectories = array_slice(scandir($fullPath), 2);
                    $edited = [];
                    //Anything that comes out of scandir above will be added to $edited array.
                    //Array slice is only used to remove '.' and '..' from the scandir result.
                    foreach ($baseDirectories as $base) {
                        $edited[] = $value . DIRECTORY_SEPARATOR . $base;
                    }
                    //we call this function agian, now with a different directory/file array (depends on
                    //what comes out of the scandir of course).
                    $this->get($edited);
                }
                // If it's a file we add it to the files array so we can autoload it.
                if (is_file($fullPath)) {
                    $this->files[] = $fullPath;
                }
            }
        }
        // Eventually, when the loop is done we return the files.
        return $this->files;
    }
}

$autoLoad = new AutoLoader();
$autoLoad->app();
