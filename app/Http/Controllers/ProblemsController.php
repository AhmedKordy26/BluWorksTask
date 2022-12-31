<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ProblemsController extends Controller
{
    //////////// first problem
    ///// Time complexity O(2^log(N))
    ////  Space complexity O(2^log(N))
    public function allNumbersBut5($left,$right){
        if($left<0 && $right<0){
            $newLeft=abs($right);
            $newRight=abs($left);
            return $this->countFrom0ToN((string)($newRight),0,false)-$this->countFrom0ToN((string)($newLeft-1),0,false);
        }
        else if($left<0 && $right>=0)
            return $this->countFrom0ToN((string)(abs($left)),0,false)+$this->countFrom0ToN((string)($right),0,false)-1;
        else{
            $leftVal=$left>0?$this->countFrom0ToN((string)($left-1),0,false):0;
            $rightVal=$this->countFrom0ToN((string)($right),0,false);
            return $rightVal-$leftVal;
        }
    }
    function countFrom0ToN($num_string,$indx,$isAll){
        if($indx==strlen($num_string)) 
            return 1;

        if($isAll==true) 
            return 9*$this->countFrom0ToN($num_string,$indx+1,$isAll);

        $num=ord($num_string[$indx])-ord('0'); // get charachter index in the alphabet(using ASCII code)
        
        if($num==5) 
            return $num*$this->countFrom0ToN($num_string,$indx+1,true);
        else if($num>5) 
            return ($num-1)*$this->countFrom0ToN($num_string,$indx+1,true)+$this->countFrom0ToN($num_string,$indx+1,false);
        else // $num<5
            return $num*$this->countFrom0ToN($num_string,$indx+1,true)+$this->countFrom0ToN($num_string,$indx+1,false);

    }

    //////////////////////// second problem ////////////
    ///// Time complexity O(N)
    ////  Space complexity O(1)
    public function getStringIndex($inputString){
        $answer=1;
        $stringLen=strlen($inputString);
        for($i=1;$i<$stringLen;$i++){
            $answer+=pow(26,$i);
        }
        for($i=0;$i<$stringLen;$i++){

            $toAdd=ord($inputString[$i])-ord('A'); // get charachter index in the alphabet(using ASCII code)
            $toAdd*=pow(26,($stringLen-1-$i));
            $answer+=$toAdd;
        }
        return $answer;
    }
    ////////////////////////////////////////////////////////////


    //////////////////////// third problem ////////////////////
    ///// Time complexity O(N*X)  //N array size //X array element     
    // worst Case (N*X) when every element is prime number and every number occurs once
    // average Case Complexity (N*sqrt(X))
    ////  Space complexity O(N)
    public function stepsToZero(Request $request){
        $arr_length=$request['N'];
        $arr = $request['Q'];
        $savedNumber=[];
        $answerArr=[];
        for($i=0;$i<$arr_length;$i++){
            if(isset($savedNumber[$arr[$i]])==true){
                array_push($answerArr,$savedNumber[$arr[$i]]);
            }
            else {
                $steps=0;
                $num=$arr[$i];
                while($num>0){
                    $steps++;
                    $largestDiv=$this->findLargestDivisor($num); // O(sqrt(N))
                    if($largestDiv>1){
                        $num=$largestDiv;
                    }
                    else{
                        $num--;
                    }
                }
                $savedNumber[$arr[$i]]=$steps; // if we calculate steps of a number once we never calculate it again
                array_push($answerArr,$steps);
            }
        }
        return $answerArr;
    }
    function findLargestDivisor($num){// O(sqrt(N))
        for($i=2;($i*$i)<=$num;$i++){  // iterate to square root only
            if($num%$i==0){
                return ($num/$i);
            }
        }
        return 1;
    }
    
    
}
