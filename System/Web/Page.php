<?php
    /**
     * @author Manuel Thalmann <m@nuth.ch>
     * @license Apache-2.0
     */
    namespace System\Web;
    {
        class Page extends WebContent
        {
            protected function PrintInternal()
            {
                return (string)$this->Locale;
            }
        }
    }
?>