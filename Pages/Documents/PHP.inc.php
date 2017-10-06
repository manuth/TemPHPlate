---
Template: BootstrapTemplate
Title: PHP
---
<?php
    echo '<h1>'.$this->Data['Title'].'</h1>';
    foreach (range(0, 10) as $number)
    {
        echo $number.'<br />';
    }
?>