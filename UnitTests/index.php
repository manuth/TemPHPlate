<div class="container">
    <?php
    use System\Globalization\CultureInfo;
    {
        chdir(__DIR__);
        echo '<h1>Running UnitTests</h1>';
        include 'JavaScript.php';
        include 'StyleDefinition.php';
        include 'Templates.php';
        include 'Pages.php';
    }
    ?>
</div>