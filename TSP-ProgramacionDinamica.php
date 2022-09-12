<?php

//Definiendo variables globales

$num_cities;
$num_subset;
$dist_vec = array();

class TSP_Dynamic_Programming
{
    function build_subsets(&$subdist,&$dist)
    {
        global $num_subset; //2^4
        global $num_cities; //4
        // Comience con el recorrido más corto posible (comenzando y terminando en la primera ciudad)
        $subdist[1][0]=0; // 4x4: 999
        // iterar todos los subconjuntos que incluyen la primera ciudad, con un tamaño superior a 2 (es decir, cada máscara de bits agregada, a partir de 3 (dec) u 11 (bin))
        for($s=3; $s<$num_subset; $s+=2){
            for($j=1; $j<$num_cities; $j++){
                // iterarciudades finales (excluyendo la primera ciudad)
                if(!($s & (1 << $j))){
                    continue;
                }
                //if(($s & ~(1 << $j)) < count($subdist)) 
                $t=$s & ~(1 << $j);
                for($i=0; $i<$num_cities; $i++)
                {
                    if($s & (1 << $i) && $i!=$j && $subdist[$t][$i]<999){
                        
                        $subdist[$s][$j]=min($subdist[$s][$j], $subdist[$t][$i]+$dist[$i][$j]);

                    }         
                }
            }
        }
    }

    function min_cycle(&$subdist,&$dist)
    {
        $cycle=array();
        $cycle[0]=0;
        $visited=array(); //tamaño del array cuadrado nxn
        global $num_cities; //6
        global $num_subset; //2^6 =  64
        for($i=0; $i<$num_cities;$i++) $visited[$i]=0;

        //el retroceso comienza con un subconjunto que contiene todas las ciudades
        $s=$num_subset-1;
        //marcar la primera ciudad como visitada
        $visited[0]=1; 
        for($i=0;$i<$num_cities-1;$i++)
        {
            $shortest;
            $min_dist=999;
            
            // encontrar la siguiente ciudad no visitada con la mejor subdistancia desde la ciudad anterior en el ciclo 
            for($j=0;$j<$num_cities;$j++){
                $back=$cycle[count($cycle)-1];
                if(!$visited[$j] && $subdist[$s][$j]+$dist[$back][$j] < $min_dist){
                    $min_dist=$subdist[$s][$j]+$dist[$back][$j];
                    $shortest=$j;
                
                } 
            } 
            



            
            //marcar la ciudad como visitada y excluirla del subconjunto
            $last=count($cycle);
            $cycle[$last]=$shortest;
            $visited[$shortest]=1;
            $s&= ~(1<<$shortest); 
        }
        $last=count($cycle);
        $cycle[$last]=0;
        return $cycle;
    }

    

    function CalcularPorProgramacionDinamica($Array)
    {
        //Crer matriz con solo los valores de las distancias
        $Arreglo=array();
        for($i=0; $i<count($Array)-1; $i++)
        {
            for($j=0; $j<count($Array)-1; $j++)
            {
                $I=$i+1;
                $J=$j+1;
                $Arreglo[$i][$j]=$Array[$I][$J];
            }
        }

        //TSP
        global $num_cities;
        $num_cities=count($Arreglo);

        global $num_subset;
        $num_subset= pow(2,$num_cities);

        $cycle=array();
        $cycle_dist=0;

        //Matriz de distancias
        $dist=array();
        //Subconjunto de subdistancias
        $subdist=array();

        //Completar con 999 a todos los valores del arreglo subdist
        for($i=0; $i<$num_subset; $i++)
        {
            for($j=0; $j<$num_subset; $j++)
            {
                $subdist[$i][$j]=999;
            }
        }

        //Copiar datos de array de entrada csv a matriz
        for($i=0; $i<count($Arreglo); $i++)
        {
            for($j=0; $j<count($Arreglo); $j++)
            {
                $dist[$i][$j]=$Arreglo[$i][$j];
            }
        }

        //Lamar a la funcion
        $Instancia3=new TSP_Dynamic_Programming();
        $Instancia3->build_subsets($subdist,$dist);
        $cycle=$Instancia3->min_cycle($subdist,$dist);

        //Obtener camindo
        echo 'Por Programacion dinamica: ';
        echo '<br>';
        echo 'Camino: ';
        for($i=0; $i<count($cycle); $i++)
        {   
            $valor=$cycle[$i];
            //echo $valor;  //Mostrar solo posicion de ubicacion
            echo $Array[$valor+1][0]; //Mostrar nombres de ubicaciones
            if($i!=count($cycle)-1) echo'->';
 
        }

        //costo
        echo '<br>'.'Costo: ';
        for($i=0; $i<count($cycle)-1; $i++)
        {   
            $valor=$cycle[$i];
            $valor2=$cycle[$i+1];
            $cycle_dist+=$dist[$valor][$valor2];
        }

        echo $cycle_dist;
    }
}
?>