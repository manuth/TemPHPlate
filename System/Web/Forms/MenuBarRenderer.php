<?php
    namespace System\Web\Forms;
    {
        abstract class MenuBarRenderer
        {
            abstract function RenderItem();
            abstract function RenderGroup();
            abstract function RenderLabel();
        }
    }
?>