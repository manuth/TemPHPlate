<?php
    namespace System\Web\Forms;
    {
        /**
         * Provides the functionallity to render a menubar.
         */
        interface IMenuBarRenderer
        {
            function RenderItem();
            function RenderGroup();
            function RenderLabel();
        }
    }
?>