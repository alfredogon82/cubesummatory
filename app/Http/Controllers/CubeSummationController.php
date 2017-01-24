<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class cubeSummationController extends Controller{

	public function creaMatriz($tamano){

		for ($x = 0; $x <= $tamano; $x++) {
	        for ($y = 0; $y <= $tamano; $y++) {
	            for ($z = 0; $z <= $tamano; $z++) {
	                $matriz[$x][$y][$z] = 0;
	            }
	        }
	    }
	    return $matriz;
	}

	function actualizaMatriz($x, $y, $z, $valor, $matriz){
		$matriz[$x][$y][$z] = $valor;
		return $matriz;
	}


	function sumaBloques($x1, $y1, $z1, $x2, $y2, $z2, $matriz){

	  $sum = array();

	    //porque los valores van "entre" los dos parametros, no sobre ellos (between)

	  	$x2 = $x2+1;
	  	$y2 = $y2+1;
	  	$z2 = $z2+1;

	    for ($i=$x1; $i < $x2; $i++) {
		    for ($j=$y1; $j < $y2; $j++) { 
		        for ($k=$z1; $k < $z2; $k++) { 
		          	array_push($sum, $matriz[$i][$j][$k]);
		        }
		    }
	  	}
	  	$total = array_sum($sum);
	  	
	  	return $total;
	}

	public function explodedSpace($string){
		$string = trim($string);
		$explodedString = explode(" ", $string);
		return $explodedString;	
	}

    
    public function postAction(Request $request){
    	$this->validate($request, [
            'numero' => 'required|integer|between:1,50'
        ]);


    	$rslt = array();
     	
     	$cubeInput = trim($request['cubeInput']);
     	$t = $request['numero'];
  		$info = explode(PHP_EOL, $cubeInput);



  		$nxm = $info[0];
  		$nxmExploded = $this->explodedSpace($nxm);
		$n = $nxmExploded[0];
		$m = $nxmExploded[1];
		$w = 0;
		$q = 1;

		if($n<1){
			return response()->json("Error - El valor de n debe ser mayor a 1");
		}

		if($n>100){
			return response()->json("Error - El valor de n debe ser menor a 100");
		}

		if($m<1){
			return response()->json("Error - El valor de m debe ser mayor a 1");
		}

		if($n>1000){
			return response()->json("Error - El valor de m debe ser menor a 1000");
		}

		

		

  		for ($j=1; $j <= $t; $j++) { 

  			if($w>1){
  				
  				$nxm = $info[$m+$q];
  				
				$nxmExploded = $this->explodedSpace($nxm);
				$n = $nxmExploded[0];
				$m = $nxmExploded[1];

				if($n<1){
					return response()->json("Error - El valor de n debe ser mayor a 1");
				}

				if($n>100){
					return response()->json("Error - El valor de n debe ser menor a 100");
				}

				if($m<1){
					return response()->json("Error - El valor de m debe ser mayor a 1");
				}

				if($n>1000){
					return response()->json("Error - El valor de m debe ser menor a 1000");
				}
				
				$q++;
  			}

  			$matriz = $this->creaMatriz($n);

  			for ($i=0; $i <= $m ; $i++) { 
  				
	  			$valor = $this->explodedSpace($info[$w]);
	  			$instrAction = strtolower($valor[0]);
	  			switch ($instrAction) {
	  				case 'update':
						if($valor[1]<1){
							return response()->json("Error - El valor de x debe ser mayor o igual a 1");
						}

						if($valor[1]>$n){
							return response()->json("Error - El valor de x debe ser menor o igual a n");
						}

						if($valor[2]<1){
							return response()->json("Error - El valor de y debe ser mayor o igual a 1");
						}

						if($valor[2]>$n){
							return response()->json("Error - El valor de y debe ser menor o igual a n");
						}

						if($valor[3]<1){
							return response()->json("Error - El valor de z debe ser mayor o igual a 1");
						}

						if($valor[3]>$n){
							return response()->json("Error - El valor de z debe ser menor o igual a n");
						}


	  					$matriz = $this->actualizaMatriz($valor[1], $valor[2], $valor[3], $valor[4], $matriz);
	  				break;
	  				case 'query':
	  					
	  					$ans = $this->sumaBloques($valor[1], $valor[2], $valor[3], $valor[4], $valor[5], $valor[6], $matriz);
	  					array_push($rslt, $ans);
	  				break;
	  				
	  			}
	  		$w++;
  			}
  			
  		}
  		//return $rslt;
  		return view('cube.result', compact('rslt'));
    }
}
