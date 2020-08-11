<?php

class ThemosisValetDriver extends BasicValetDriver
{

    /**
     * Mutate the incoming URI.
     *
     * @param  string  $uri
     * @return string
     */
    public function mutateUri($uri)
    {
        return rtrim('/htdocs'.$uri, '/');
    }

    /**
     * Determine if the driver serves the request.
     *
     * @param  string  $sitePath
     * @param  string  $siteName
     * @param  string  $uri
     * @return bool
     */
    public function serves($sitePath, $siteName, $uri)
    {
        return file_exists($sitePath.'/library/Thms/Config/Environment.php');
    }

    /**
     * Get the fully resolved path to the application's front controller.
     *
     * @param  string  $sitePath
     * @param  string  $siteName
     * @param  string  $uri
     * @return string
     */
    public function frontControllerPath($sitePath, $siteName, $uri)
    {
        if (strpos($uri, '/cms/') !== false) {
            $_SERVER['PHP_SELF']    = $uri;
            $_SERVER['SERVER_ADDR'] = '127.0.0.1';
            $_SERVER['SERVER_NAME'] = $_SERVER['HTTP_HOST'];
            return parent::frontControllerPath(
                $sitePath, $siteName, $uri
                );
        }
        return $sitePath.'/htdocs/index.php';
    }
    
    /**
     * Determine if the incoming request is for a static file.
     *
     * @param  string  $sitePath
     * @param  string  $siteName
     * @param  string  $uri
     * @return string|false
     */
    public function isStaticFile($sitePath, $siteName, $uri)
    {
        if ($this->isActualFile($staticFilePath = $sitePath.$uri)) {
            return $staticFilePath;
        }
        return false;
    }
}
