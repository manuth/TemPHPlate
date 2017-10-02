<?php

/**
 * @author Manuel Thalmann <m@nuth.ch>
 * @license Apache-2.0
 */
namespace System\IO;
use System\Environment;
{
    /**
     * Performs operations on `String` instances that contain file or directory path information. These operations are performed in a cross-platform manner.
     * 
     * @property-read string $DocumentRoot
     * fds
     */
    class Path
    {
        /**
         * Normalize a path.
         *
         * @param string $path
         * The path that is to be normalized.
         * 
         * @return string
         * The normalized path.
         */
        public static function Normalize(string $path)
        {
            $path = str_replace(array('/', '\\'), '/', $path);
            $outputStack = array();

            /**
             *  1. Determine whether the path is normalizable
             *     If the path contains a dot it's a normalizable path.
             */
            if (strpos($path, '.') === false)
            {
                $outputStack[] = $path;
            }
            else
            {
                $inputBuffer = $path;

                /**
                 * 2. Normalizing the path
                 */
                while (strlen($inputBuffer) > 0)
                {
                    /**
                     * 2.1 Add a root-node if the path is a root path.
                     */
                    if (strcmp(substr($inputBuffer, 0, 1), '/') == 0)
                    {
                        $inputBuffer = substr($inputBuffer, 1);
                        $outputStack[] = '/';
                    }
                    else if (preg_match('/^(\.\.?)(\/|$)/', $inputBuffer, $match) === 1)
                    {
                        $inputBuffer = substr($inputBuffer, strlen($match[0]));
                        
                        /**
                         * 2.1.1 Resolving dots
                         *       If the path contains nothing but slashes and dots, a '..' cannot be resolved.
                         */
                        if ($match[1] == '..')
                        {
                            if (trim(implode($outputStack), '/.') == '')
                            {
                                $outputStack[] = $match[0];
                            }
                            else
                            {
                                array_pop($outputStack);
                            }
                        }
                    }
                    /**
                     * 2.2 Adding normal path-segments
                     */
                    else if (preg_match('/^(.*?)(?:\/|$)/', $inputBuffer, $match) === 1)
                    {
                        $inputBuffer = substr($inputBuffer, strlen($match[0]));
                        $outputStack[] = $match[0];
                    }
                }
            }

            $result = str_replace(array('/', '\\'), DIRECTORY_SEPARATOR, preg_replace('/(\/+)/', '/', implode($outputStack)));

            if (strlen($result) == 0)
            {
                $result = '.';
            }

            return $result;
        }

        /**
         * Determines the difference between two paths.
         *
         * @param string $from
         * The path to compare the destination-path to.
         * 
         * @param string $to
         * The path to compare the source-path to.
         * 
         * @return string
         * The relative path.
         */
        public static function MakeRelativePath(string $from, ?string $to = null) : string
        {
            if (func_num_args() == 1)
            {
                $to = Environment::$DocumentRoot.DIRECTORY_SEPARATOR.$from;
                $from = Environment::$RequestDirectory;
            }

            $result = '';
            // Some compatibility fixes for Windows paths.
            $from = rtrim(self::Normalize($from), DIRECTORY_SEPARATOR);
            $to = rtrim(self::Normalize($to), DIRECTORY_SEPARATOR);
            $fromTree = explode(DIRECTORY_SEPARATOR, $from);
            $toTree = explode(DIRECTORY_SEPARATOR, $to);

            // Determining whether the paths have the same root node.
            if (count($fromTree) > 0 && count($toTree) > 0 && $fromTree[0] == $toTree[0])
            {
                $index = 0;
                for ( ; $index < min(count($fromTree), count($toTree)) && $fromTree[$index] == $toTree[$index]; $index++);

                if ($index == count($fromTree) && $index == count($toTree))
                {
                    $result = '.';
                }
                else
                {
                    $resultTree = array_merge(
                        array_fill(0, count($fromTree) - $index, '..'),
                        array_slice($toTree, $index));
                    $result = implode(DIRECTORY_SEPARATOR, $resultTree);
                }
            }
            else
            {
                $result = $to;
            }
            return self::Normalize($result);
        }

        /**
         * Determines the difference between two paths.
         *
         * @param string $from
         * The path to compare the destination-path to.
         * 
         * @param string $to
         * The path to compare the source-path to.
         * 
         * @return string
         * The relative path.
         */
        public static function MakeRelativeWebPath()
        {
            return str_replace(
                DIRECTORY_SEPARATOR,
                '/',
                call_user_func_array(array(__CLASS__, 'MakeRelativePath'), func_get_args()));
        }
    }
}
?>