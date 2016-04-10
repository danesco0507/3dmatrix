<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;


class MatrixController extends Controller
{
    var $matrix;
    var $result;
    var $testCases;
    var $n_size;
    var $case_size;
    var $errors;

    public function __construct()
    {
        $this->matrix = array();
        $this->result = array();
        $this->errors = array();
	$this->testCases = 0;
        $this->n_size = 0;
        $this->case_size = 0;
    }

    public function index(Request $request)
    {
    	return view('basicform', [
        	'results' => $this->result,
    	]);
    }
    

    public function processData(Request $request){
    	unset($this->result);
    	$this->validate($request, [
            'data' => 'required',
    	]);

    	//leer datos

    	$data = $request->data;
    	$lines = explode("\r\n", $data);

    	$iter = 0;
    	foreach($lines as $line){

            if( $iter == 0){
            	$this->testCases = intval($line);
		if ($this->testCases > 50 || $this->testCases < 1){
			$this->returnWithError("El numero de casos no es valido");
            	}
	    }
	    if( $iter > $this->case_size){
                $iter = -1;
            }
            
            if( $iter == -1){
                    $case = explode(" ",$line);
                    $this->n_size = intval($case[0]);
                    $this->case_size = intval($case[1]);
		    
		    if ($this->n_size > 100 || $this->n_size < 1){
                        $this->returnWithError("El tamaño de la matriz no es valido");
                    }

		    if ($this->case_size > 1000 || $this->case_size < 1){
                        $this->returnWithError("El numero de operaciones no es valido");
                    }

		    if($this->case_size>0 && $this->n_size>0){
                    	$this->initializeMatrix($this->n_size);
			$iter = 1;
		    }
            }
            


            if($iter <= $this->case_size  and $iter>0 ){
                $values = explode(" ",$line);
                if(strcmp($values[0],"UPDATE") == 0){
		    $this->validateUpdate(intval($values[1]),intval($values[2]),intval($values[3]),intval($values[4]));
                    $this->update(intval($values[1]),intval($values[2]),intval($values[3]),intval($values[4]));
                    $iter++;
		}
                elseif(strcmp($values[0],"QUERY") == 0){
		    $this->validateQuery(intval($values[1]),intval($values[2]),intval($values[3]),intval($values[4]),intval($values[5]),intval($values[6]));
                    $this->result[] = $this->sum(intval($values[1]),intval($values[2]),intval($values[3]),intval($values[4]),intval($values[5]),intval($values[6]));
                    $iter++;
		}
            }
            else{
		$iter = -1;
	    }

        }
	if(count($this->errors)){
	    return redirect('/')->withErrors($this->errors);
	}
	else{
            return view('basicform', [
                'results' => $this->result,
            ]);
	}
    }

    private function initializeMatrix($N){
        unset($this->matrix);
        for($i=1;$i<=$N;$i++){
                for($j=1;$j<=$N;$j++){
                        for($k=1;$k<=$N;$k++){
                                $this->matrix["{$i},{$j},{$k}"]=0;
                        }
                }
        }
    }

    private function sum($x1,$y1,$z1,$x2,$y2,$z2){
        $sum = 0;
        for($i=$x1;$i<=$x2;$i++){
                for($j=$y1;$j<=$y2;$j++){
                        for($k=$z1;$k<=$z2;$k++){
                                $sum += $this->matrix["{$i},{$j},{$k}"];
                        }
                }
        }
        return $sum;
    }

    private function update($x1,$y1,$z1,$value){
        $this->matrix["{$x1},{$y1},{$z1}"]=$value;
    }

    private function returnWithError($message){
	$this->errors[] = $message;
    }

    private function validateQuery($x1,$y1,$z1,$x2,$y2,$z2){
        if($x1>$x2 ||$y1>$y2 ||$z1>$z2 || $x1>$this->n_size || $x1<1 ||$y1>$this->n_size || $y1<1 || $z1>$this->n_size || $z1<1 || $x2>$this->n_size || $x2<1 || $y2>$this->n_size || $y2<1 || $z2>$this->n_size || $z2<1 ){
	    returnWithError("Los vectores ({$x1},{$y1},{$z1}) y ({$x2},{$y2},{$z2}) no tienen el formato correcto");
	}
    }
    
    private function validateUpdate($x1,$y1,$z1, $value){
	if($x1>$this->n_size || $x1<1 ||$y1>$this->n_size || $y1<1 || $z1>$this->n_size || $z1<1){
	   returnWithError("El vector ({$x1},{$y1},{$z1}) no tiene el formato correcto");
	}

	if($value > pow(10,9) || $value < pow(10,-9)){
	   returnWithError("El valor a asignar no es valido");
	}
    }
}
