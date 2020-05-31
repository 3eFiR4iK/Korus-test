<?php

require_once('generator.php');


$text = "{Важнейшую|Главную|Первостепенную} роль в создании прочного и долговечного {напольного покрытия|пола} играет эффективная гидроизоляция, {защищающая следующие слои от пагубного воздействия влаги|которая защищает верхние слои пола от влаги}.";
$generator = new StringGenerator($text);

echo "<pre>";
print_r($generator->generate(3));
print_r($generator->generate(3));
