<?php
    /**
     * @author Manuel Thalmann <m@nuth.ch>
     * @license Apache-2.0
     */
    namespace System\Web;
    use System\Object;
    use System\Collections\ArrayList;
    {
        /**
         * Represents a collection of web-contents.
         */
        class WebContentCollection extends ArrayList
        {
            /**
             * Initializes a new instance of the WebContentCollection class.
             */
            public function WebContentCollection()
            {
            }

            /**
             * Draws the object.
             *
             * @return string
             * The content of the drawable object.
             */
            public function Draw() : string
            {
                $result = '';
                
                foreach ($this as $webContent)
                {
                    $result .= $webContent->Draw();
                }

                return $result;
            }
        }
    }
?>