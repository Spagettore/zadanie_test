<?php
function generate_header($text, $url, $size = 250): string
{
    if(!strlen($text)){
        return $text;
    }
    $breaker = IntlBreakIterator::createSentenceInstance('ru_RU');
    $breaker->setText($text);
    $offset = $breaker->preceding($size);
    $header = $text;

    //если предложение найдено, берем его
    if($offset){
        $header = substr($text,0,$offset);
    }

    //удаляем пробел и знак препинания в конце строки
    while(ispunctorspace($header[strlen($header)-1])){
        $header = substr($header,0,-1);
    }

    //если не хватает символов для многоточия - удаляем последнее слово
    $breaker = IntlBreakIterator::createWordInstance('ru_RU');
    while(strlen($header) > $size - 3){
        $breaker->setText($header);
        $offset = $breaker->preceding($breaker->last());
        $header = substr($header,0,$offset);
    }

    //удаляем пробел и знак препинания в конце строки
    while(ispunctorspace($header[strlen($header)-1])){
        $header = substr($header,0,-1);
    }
    $breaker->setText($header);

    //ищем позицию третьего слова с конца для постановки ссылки
    $breaker->last();
    for($i = 0; $i < 3;){
        $offset = $breaker->previous();
        if(!ispunctorspace($header[$offset])){
            $i++;
        }
    }
    return substr_replace($header, " <a href='$url'>", $offset, 0) . '...</a>';
}
function ispunctorspace($char) {
    return preg_match('/^[\s\p{P}]+$/u', $char);
}
$text = "Капиба́ра — полуводное травоядное млекопитающее из подсемейства водосвинковых, представитель отряда грызунов. Научное название Hydrochoerus hydrochaeris переводится как «водяная свинья». Капибара является самый крупным грызуном в современном мире. Другой представитель рода — малая капибара (Hydrochoerus isthmius) сейчас рассматривается как отдельный вид. Близкими родственниками капибары являются также морские свинки и моко (горная свинка), а более дальними такие южноамериканские грызуны как агути, шиншилла и нутрия.";
$url = "https://znanierussia.ru/articles/капибара";

echo (generate_header($text, $url, 250));