

<?php
$input=array(array("graph_1"=>'A', "graph_2"=>'D',
"distance_km"=>80, "distance_km"=>180),

array("graph_1"=>'A',"graph_2"=>'C', "distance_km"=>110),

array("graph_1"=>'A',"graph_2"=>'E', "distance_km"=>330),

array("graph_1"=>'B',"graph_2"=>'F', "distance_km"=>340),

array("graph_1"=>'C',"graph_2"=>'D', 
"distance_km"=>60),

array("graph_1"=>'C',"graph_2"=>'E', "distance_km"=>205),

array("graph_1"=>'D',"graph_2"=>'F', "distance_km"=>192),

array("graph_1"=>'E',"graph_2"=>'F',
"distance_km"=>80));

$dist=array();
foreach($input as $node)
{ 
 $dist[$node['graph_1']][$node['graph_2']]=$node['distance_km'];
 $dist[$node['graph_2']][$node['graph_1']]=$node['distance_km'];
}
$result=Deykstra($dist,'A');
print "Маршрут от А до B путь : ".$result['B']['route'].", расстояние : ".$result['B']['metric']." км."." \n";

$result=Deykstra($dist,'B');
print "Маршрут от B до A путь : ".$result['A']['route'].", расстояние : ".$result['A']['metric']." км."." \n";

function Deykstra($dist,$from)
{
 $M=array(array("vert"=>$from, "metric"=>0, "route"=>$from)); // Массив вершин 
 $S=array($from=>0); // Массив номеров 
 for($i=0; $i<count($M); $i++) // Перебираем 
  {
   // Данные проверяемой вершины 
   $v1=$M[$i]['vert']; $route=$M[$i]['route']; $metric=$M[$i]['metric'];
   foreach($dist[$M[$i]['vert']] as $v2=>$m2)
    { // Перебираем все вершины до которых можно добраться напрямую
     if(!array_key_exists($v2,$S)) // Вершина назначения еще не встречалась
      {
       $S[$v2]=count($M); // Добавляем индекс по коду
       $M[]=array("vert"=>$v2, "metric"=>($metric+$m2), "route"=>"$route/$v2"); // И саму вершину
      } else
      { // Вершина уже встречалась, пересчитываем метрику
       $ind=$S[$v2];
       if($M[$ind]['metric']>($metric+$m2)) // Метрика вершины больше текущей
        { // ищем кратчайший путь
         $M[$ind]['metric']=$metric+$m2;
         $M[$ind]['route']="$route/$v2";
        }
      }
    }
  }
 // Из массива по номерам, делаем по именам городов
 foreach($S as $key=>$ind) $S[$key]=$M[$ind];
 return $S;
}
