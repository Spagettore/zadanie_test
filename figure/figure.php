<?php
function input_size(): array
{
    //ввод размеров фигуры
    while(true) {
        echo "введите размер x y\n";
        $input = readline();
        $space_pos = strpos($input, ' ');

        $num_one = substr($input, 0, $space_pos);
        $num_two = substr($input, $space_pos + 1);

        $size_x = intval($num_one);
        $size_y = intval($num_two);

        //проверка, что size_x $size_y цифры
        if(!$size_x || !$size_y) {
            echo "неверный ввод\n";
            continue;
        }
        //проверка что size_x больше или равно 32 и $size_y меньше или равно 2000 и не меньше или равно 0
        if($size_x < 32 || ($size_y <= 0 && $size_y > 2000)) {
            echo "Неверные размеры. 32 <= $size_x; $size_y <= 2000\n";
            continue;
        }
        echo "\n";
        return [$size_x, $size_y];
    }
}
function input_figure($size_x, $size_y): array
{
    //ввод фигуры построчно
    $figure = [];
    for($y = 0; $y < $size_y; $y++){
        echo "введите строку $y фигуры\n";
        $input = readline();

        //если ввод пустой заново пытаемся ввести строку
        if(!$input){
            echo "ввод пустой\n";
            $y--;
            continue;
        }

        //проверяем строку и возвращаем массив цифр 0 1
        $line_x = check_line($size_x, $size_y, $y, $input);
        if(!$line_x){
            $y--;
            continue;
        }

        $figure[] = $line_x;
    }
    return $figure;
}
function check_line($size_x, $size_y, $y, $input): ?array
{
    //обходим строку
    $line_x = [];
    for($x = 0; $x < $size_x; $x++){
        //значения пишутся через пробел, ищем позицию пробела
        $space_pos = strpos($input, ' ');
        $offset = $space_pos;

        //если не нашли пробел, то берем позицию конца строки
        if(!$space_pos) {
            //если не нашли пробел и получили меньше чисел чем нужно, то сообщаем об ошибке
            if($x < $size_x - 1) {
                echo "малое количество значений\n";
                return null;
            }
            $offset = strlen($input);
        }
        //обрезаем строку и получаем число
        $number = substr($input, 0, $offset);

        //проверка, что число соответствует 0 или 1
        if($number != 1 && $number != 0){
            echo "значения могут быть только 0 и 1\n";
            return null;
        }

        //условие, что на границах изображения всегда 0
        if($y == 0 || $y == $size_y - 1) {
            if($number != 0){
                echo "границы должны быть пустые\n";
                return null;
            }
        }
        //условие, что на границах изображения всегда 0
        if($x == 0 || $x == $size_x - 1) {
            if($number != 0){
                echo "границы должны быть пустые\n";
                return null;
            }
        }

        //добавляем число в массив чисел и обрезаем строку
        $line_x[] = intval($number);
        $input = substr($input, $offset + 1);
    }
    return $line_x;
}
function check_square($figure): bool
{
    //проверка на квадрат
    //берем размеры фигуры
    $size_y = count($figure);
    $size_x = count($figure[0]);

    //обходим фигуру построчно слева направо
    for($y = 1; $y < $size_y - 1; $y++){
        for($x = 1; $x < $size_x - 1; $x++){
            //ищем начало квадрата
            if($figure[$y][$x] != 1) {
                continue;
            }

            //запоминаем 1 найденную позицию
            $line_start_x = $x;
            $line_start_y = $y;

            //идем направо по линии пока не придем к ее концу
            while($figure[$y][$x+1] == 1){
                $x++;
            }
            $width1 = $x - $line_start_x;   //ширина линии

            //идем вниз по линии пока не придем к ее концу
            while($figure[$y+1][$x] == 1){
                $y++;
            }
            $height1 = $y - $line_start_y;  //высота линии

            //возвращаемся на 1 точку и проверяем остальные 2 строны
            $x = $line_start_x;
            $y = $line_start_y;

            //идем вниз по линии пока не придем к ее концу
            while($figure[$y+1][$x] == 1){
                $y++;
            }
            $height2 = $y - $line_start_y;  //высота линии

            //идем направо по линии пока не придем к ее концу
            while($figure[$y][$x+1] == 1){
                $x++;
            }
            $width2 = $x - $line_start_x;   //ширина линии

            //проверяем равны ли полученные значения ширины и высоты линий
            if($width1 != $width2 || $height1 != $height2 || $width1 != $height1){
                return false;
            }
            return true;
        }
    }
    return false;
}
function check_triangle(array $figure): bool
{
    //проверка на треугольник
    //берем размеры фигуры
    $size_y = count($figure);
    $size_x = count($figure[0]);

    $points = [];   //массив точек
    for($y = 1; $y < $size_y - 1; $y++) {
        for ($x = 1; $x < $size_x - 1; $x++) {
            //ищем начало треугольника
            if($figure[$y][$x] != 1) {
                continue;
            }
            //добавляем найденную точку в массив
            $points["start"] = [$y, $x];

            //ищем конечную точку по нижней линии
            while ($figure[$y + 1][$x] == 1) {
                $y++;
            }
            //если найденная точка не находится в том же месте, что и стартовая, то добавляем в массив
            if($points["start"][0] != $y) {
                $points["bottom"] = [$y, $x];
            }
            $y = $points["start"][0];

            //ищем конечную точку по правой линии
            while ($figure[$y][$x + 1] == 1) {
                $x++;
            }
            //если найденная точка не находится в том же месте, что и стартовая, то добавляем в массив
            if($points["start"][1] != $x) {
                $points["right"] = [$y, $x];
            }
            $y = $points["start"][0];

            //ищем конечную точку по диагонали вниз-налево
            while ($figure[$y + 1][$x - 1] == 1) {
                $y++;
                $x--;
            }
            //если найденная точка не находится в том же месте, что и стартовая, то добавляем в массив
            if($points["start"][0] != $y || $points["start"][1] != $x) {
                $points["left-bottom"] = [$y, $x];
            }
            $y = $points["start"][0];
            $x = $points["start"][1];

            //ищем конечную точку по диагонали вниз-направо
            while ($figure[$y + 1][$x + 1] == 1) {
                $y++;
                $x++;
            }
            //если найденная точка не находится в том же месте, что и стартовая, то добавляем в массив
            if($points["start"][0] != $y || $points["start"][1] != $x) {
                $points["right-bottom"] = [$y, $x];
            }

            //если не найдено 3 или 4 точки
            if(count($points) != 3 && count($points) != 4){
                return false;
            }

            //если у нас есть точки по нижней левой линии и по нижней правой, то проверяем находятся ли они на той же высоте, что и точка по нижней линии
            if(array_key_exists("left-bottom", $points) && array_key_exists("right-bottom", $points)) {
                if($points["left-bottom"][0] != $points["bottom"][0] || $points["right-bottom"][0] != $points["bottom"][0]) {
                    return false;
                }
            }
            return true;
        }
    }
    return false;
}
function check_circle(array $figure): bool
{
    //проверка на круг
    $size_y = count($figure);
    $size_x = count($figure[0]);

    $center = [0, 0];   //центр круга
    $is_odd = false;    //четный ли диаметр
    $radius = 0;    //радиус круга
    for($y = 1; $y < $size_y - 1; $y++){
        for($x = 1; $x < $size_x - 1; $x++){
            //ищем начало круга
            if($figure[$y][$x] != 1) {
                continue;
            }
            //поиск центра
            if(!$center[0]){
                //запоминаем найденные точки
                $line_start_x = $x;
                $line_start_y = $y;

                //ищем конечную точку по правой линии
                while($figure[$y][$x+1] == 1){
                    $x++;
                }
                //проверка четности и находим центр x
                if(($x - $line_start_x) % 2 != 0){
                    $is_odd = true;
                    $center[1] = $line_start_x + floor(($x - $line_start_x) / 2);
                }
                else{
                    $center[1] = $line_start_x + ($x - $line_start_x) / 2 - 1;
                }
                $x = $center[1];

                //ищем конечную точку по нижней линии
                while($figure[$y+1][$x] == 1){
                    $y++;
                }
                //проверка четности и находим центр y
                if($is_odd){
                    $center[0] = $line_start_y + floor(($y - $line_start_y) / 2);
                }
                else{
                    $center[0] = $line_start_y + ($y - $line_start_y) / 2 - 1;
                }

                //возвращаемся в 1 найденную точку
                $y = $line_start_y;
                $x = $line_start_x;

                //считаем радиус по линии от центра до верха круга с учетом смещения центра круга от центра координат
                $radius = floor(sqrt(pow(($center[1] - $center[1]), 2) + pow(($y - $center[0]), 2)));
            }

            //берем координаты центра круга, если у нас четный, то прибавляем +1 в зависимости от того на какой мы стороне
            $center_y = $center[0];
            $center_x = $center[1];
            if(!$is_odd){
                if($x > $center_x){
                    $center_x++;
                }
                if($y > $center_y){
                    $center_y++;
                }
            }

            //если найденная точка не является краем круга
            if($figure[$y][$x-1] == 1 && $figure[$y][$x+1] == 1 && $figure[$y-1][$x] == 1 && $figure[$y+1][$x] == 1){
                continue;
            }
            //считаем радиус по найденной точке
            $r = floor(sqrt(pow(($x - $center_x), 2) + pow(($y - $center_y), 2)));
            //если радиус не равен +-1 от найденного по центру, то это не круг
            if($radius < $r - 1 || $radius > $r + 1){
                return false;
            }
        }
    }
    return true;
}

    //вводим размер фигуры
    $size = input_size();
    $size_x = $size[0];
    $size_y = $size[1];

    //построчно вводим фигуру
    $figure = input_figure($size_x, $size_y);

    echo "введенная фигура:\n";
    foreach ($figure as $line) {
        foreach ($line as $pixel) {
            echo "$pixel ";
        }
        echo "\n";
    }

    echo "Фигура: ";

    if(check_square($figure)){
        echo "квадрат\n";
        return;
    }
    else if(check_triangle($figure)){
        echo "треугольник\n";
        return;
    }
    else if(check_circle($figure)){
        echo "круг\n";
        return;
    }
    echo "неизвестно\n";

