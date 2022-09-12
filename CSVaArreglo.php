<?php
class ClaseCSVaArray{
    
    //Convertir CSV a una matriz cuadrada
    function CSV_a_Array($file){
        $tmp      = $file["tmp_name"];
        $size     = $file["size"];
        if ($size < 0) {
        
            throw new Exception("Selecciona un archivo válido por favor.");
        }
        $Arreglo=array();
        
        #Vamos abrir los archivos 
        if (($gestor = fopen($tmp, "r")) !== FALSE) {
            while (($datos = fgetcsv($gestor, 1000, ",")) !== FALSE) {
                $Arreglo[] = $datos;
            }
            fclose($gestor);
        }
        

        //Retornar matriz con solo las distancias
        return $Arreglo;
    }
    
    # Imprimir la matriz cuadrada en pantalla
    
    function ImprimirArray($Array){
        for($i=0; $i<count($Array); $i++)
        {
            for($j=0; $j<count($Array); $j++)
            {
                echo $Array[$i][$j].' ';
            }
            echo '<br>';
        }
    } 


}
?>