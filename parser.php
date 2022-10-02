<?php
header('Content-Type: application/json; charset=utf-8');
include 'simple_html_dom.php';


$url = 'https://lapkins.ru/dog/'; // сайт, с которого происходит парсинг
$urlForLinks = 'https://lapkins.ru'; // url сайта для соединения с ссылками на источник сайта
$resultFileName = "dogBreeds.js"; // название файла, в который будет помещена json переменная

$html = file_get_html($url); // читаем сайт
$breedElements = $html->find('a.poroda-element'); // получения массива элементов с данными о породах

$resultArr = Array(); // массив, который будет сконвертирован в JSON
foreach($breedElements as $breed) {
	// добавление в массив данных о породе
    $resultArr[] = Array(
    	"breed" => $breed->find('span', 0)->plaintext, // порода
    	"link" => $urlForLinks.$breed->href, // ссылка на статью о породе
    	"img" => $urlForLinks.$breed->find('img', 0)->src // ссылка на изображение
    );
}

$json = json_encode($resultArr, JSON_UNESCAPED_UNICODE|JSON_UNESCAPED_SLASHES ); // кодирование массива в json-объект
$json = 'breeds='.$json; // добавление в начало файла названия переменной, чтобы файл можно было открыть, как переменную js
file_put_contents($resultFileName, $json); // запись в файл

echo "Данные записаны в файл ".$resultFileName
?>