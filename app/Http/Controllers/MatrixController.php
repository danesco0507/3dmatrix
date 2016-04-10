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

    public function __construct()
    {
        $this->matrix = array();
        $this->result = array();
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
    	$this->result = array();

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
            }
	    if( $iter > $this->case_size){
                $iter = -1;
            }
            
            if( $iter == -1){
                    $case = explode(" ",$line);
                    $this->n_size = intval($case[0]);
                    $this->case_size = intval($case[1]);
//                    $this->result[] = "nuevo caso {$this->n_size} {$this->case_size}";
		    if($this->case_size>0 && $this->n_size>0){
                    	$this->initializeMatrix($this->n_size);
			$iter = 1;
		    }
            }
            


            if($iter <= $this->case_size  and $iter>0 ){
// $this->result[] = "iteracion {$iter} de {$this->case_size}";
                $values = explode(" ",$line);
                if(strcmp($values[0],"UPDATE") == 0){
                    $this->update(intval($values[1]),intval($values[2]),intval($values[3]),intval($values[4]));
                    $iter++;
		}
                elseif(strcmp($values[0],"QUERY") == 0){
                    $this->result[] = $this->sum(intval($values[1]),intval($values[2]),intval($values[3]),intval($values[4]),intval($values[5]),intval($values[6]));
                    $iter++;
		}
            }
            else{
		$iter = -1;
	    }

        }
        return view('basicform', [
                'results' => $this->result,
        ]);

        //return redirect('/');
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
}
