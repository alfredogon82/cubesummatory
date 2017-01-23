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

  		for ($j=1; $j <= $t; $j++) { 

  			if($w>1){
  				$nxm = $info[$m+1];
  				
				$nxmExploded = $this->explodedSpace($nxm);
				$n = $nxmExploded[0];
				$m = $nxmExploded[1];
				
  			}

  			$matriz = $this->creaMatriz($n);

  			for ($i=0; $i <= $m ; $i++) { 
  				
	  			$valor = $this->explodedSpace($info[$w]);
	  			$instrAction = strtolower($valor[0]);
	  			switch ($instrAction) {
	  				case 'update':
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
