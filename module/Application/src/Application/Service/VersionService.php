<?php
namespace Application\Service;

class VersionService
{
    /**
     * @var string|null $version Caches the version number
     */
    public static $version = null;

    /**
     * Returns the version string for the currently checked out version
     * if it can be determined. Otherwise it will return an empty string.
     *
     * This method can not only be called statically but also on an instance
     * of this class according to the PHP manual, so explicitly implementing
     * that functionality through the __call method is not necessary.
     * {@see http://php.net/manual/en/language.oop5.static.php}
     *
     * @return string
     */
    public static function getVersion()
    {
        if(null === self::$version)
        {
            $filename = 'data/version';

            // check whether the git executable exists in PATH and if it can
            // describe this directory
            if('' != exec('git --version')
                && '' != exec('git describe --tags --always'))
            {
                $version = '';
                // Get the name of the current branch
                $branch = exec('git rev-parse --abbrev-ref HEAD');
                // If this is not the master branch, we prepend the name of the branch
                // to the version string
                if('master' != $branch)
                {
                    $version = $branch;
                }

                // get git version description and append it to the version string
                $git_describe = exec('git describe --tags --always');

                // We have to add a separator ("-") after the branch name
                // if a branch name has been prepended to the version
                if('' != $version)
                {
                    $version .= '-';
                }
                // now append the actual version description
                $version .= $git_describe;

                // write the version to the version file
                $file = fopen($filename, 'w');
                fputs($file, $version, 100);
                fclose($file);

                self::$version = $version;
            }
            elseif(is_file($filename) && is_readable($filename))
            {
                // read only the first line of the version file
                $file          = fopen($filename, 'r');
                self::$version = fgetss($file, 100);
                fclose($file);
            }
            else
            {
                self::$version = '';
            }
        }

        return self::$version;
    }
}