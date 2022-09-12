<?php
$AllPermutation = array();
class TSP_FuerzaBruta
{
    function PermutacionesPosibles($str, $l, $r) 
    {
        //Array para guardar todas las permutaciones
        global $AllPermutation;

        $Instancia=new TSP_FuerzaBruta();
        if ($l == $r)
        {
            $str='0'.$str.'0';
            $str=(string) $str;
            $AllPermutation[count($AllPermutation)]=$str;
        }
            
        else
        { 
            for ($i = $l; $i <= $r; $i++) 
            { 
                $str = $Instancia->swap($str, $l, $i); 
                $Instancia->PermutacionesPosibles($str, $l + 1, $r); 
                $str = $Instancia->swap($str, $l, $i); 
            } 
        } 

    } 
    function swap($a, $i, $j) 
    { 
        $temp; 
        $charArray = str_split($a); 
        $temp = $charArray[$i] ; 
        $charArray[$i] = $charArray[$j]; 
        $charArray[$j] = $temp; 
        return implode($charArray); 
    } 



    function CalcularPorFuerzaBruta($Array)
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

        
        //Obtener todas las permutaciones
        for($i=1; $i<count($Arreglo); $i++){
            $aux=$i-1;
            $str[$aux]=$i;
        }
        $Permutacion=implode($str); //convertir a string
        //Obtener todas las permutaciones
        $Instancia2=new TSP_FuerzaBruta();
        $n = strlen($Permutacion); 
        
        $Instancia2->PermutacionesPosibles($Permutacion, 0, $n - 1); 
        global $AllPermutation;
        
        //Una vez tengamos todas las permutaciones se calcula la menos distancias
        $menor=PHP_INT_MAX;
        echo '<br>';

        for($i=0; $i<count($AllPermutation); $i++)
        {
            $Convinacion=$AllPermutation[$i];
            $num=count($Arreglo);
            $Costo=0;
            for($j=0; $j<$num; $j++)
            {
                $Costo+=$Arreglo[$Convinacion[$j]][$Convinacion[$j+1]];
            }

            if ($Costo<$menor) 
            {
                $menor=$Costo;
                $Camino=$Convinacion;
            }
        }

        echo '<br>';
        echo 'Por fuerza bruta: ';
        echo '<br>';
        echo 'Camino: ';
        $Len = strlen($Camino); 
        for($i=0; $i<$Len; $i++)
        {   
            $valor=$Camino[$i];
            echo $Array[$valor+1][0]; 
            if($i!=$Len-1) echo'->';
        } 
        echo '<br>';
        echo 'Costo: '.$menor;
    }

}

?>