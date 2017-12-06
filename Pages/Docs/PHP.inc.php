---
Template: BootstrapTemplate
Title: PHP
CustomVariable: Custom
---
<h1><?=$this->Title?></h1>
<?php
    echo $this->Data['CustomVariable'].'<br />';
    foreach (range(0, 10) as $number)
    {
        echo $number.'<br />';
    }
?>