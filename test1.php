<?php
//Необходимо создать страницу, на которой в режиме реального времени
//(периодичность опроса источника 10 сек), будет выводиться текущий
// курс доллара по отношению к российскому рублю.
//1. Источники для получения курса:
//http://www.cbr.ru/scripts/XML_daily.asp
//и
//https://query.yahooapis.com/v1/public/yql?q=select+*+from+yahoo.finance.xchange+where+pair+=+%22USDRUB,EURRUB%22&format=json&env=store%3A%2F%2Fdatatables.org%2Falltableswithkeys&callback=
//предполагается, что список может быть расширен.
//2. Должен быть задан порядок опроса источников.
//3. В случае, если источник недоступен, необходимо переключиться на
// прием данных с другого источника.
//Идеально, если бы пример был реализован на Symfony и были
// продемонстрированы навыки владения методологией ООП.
//

include 'Rate.php';
date_default_timezone_set('Europe/Moscow');
$usd  = new Rate;
$usd->CurrencyCode = 'USD';
echo $usd->printRate();
echo ' Checked at: '.date("H:i:s");

?>