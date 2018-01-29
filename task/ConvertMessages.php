<?php
/**
 * Created by PhpStorm.
 * User: salahat
 * Date: 29/01/18
 * Time: 01:40 ص
 */
class ConvertMessages{

    /**@var $row array*/
    private $row;

    public function __construct($is_final= false,$row){
        $this->setRow($row);
        if($is_final){
            $this->setRow('You have arrived at your final destination.');
        }
    }

    /**@return mixed */
    public function getRow(){
        return $this->row;
    }

    /**@return mixed
     *@param $index string
     */
    public function getRowIndex($index){
        return isset($this->row[$index])?$this->row[$index]:'';
    }

    /**@param mixed $row */
    public function setRow($row){
        $this->row = $row;
    }
}
class Plane extends ConvertMessages {

    public function final_message(){

        $message  =
            'From '.
            $this->getRowIndex('exit').
            ' take flight '.
            $this->getRowIndex('conveyance_number').
            ' to '.
            $this->getRowIndex('incoming').
            ' Gate '.
            $this->getRowIndex('gate').
            ', seat '.
            $this->getRowIndex('seat').
            ' Baggage will we automatically transferred from your last leg.';

        if(!empty($this->getRowIndex('baggage'))){
            $message.=' Baggage drop at ticket counter '.$this->getRowIndex('baggage').'.';
        }
        return $message;
    }

}
class Bus extends ConvertMessages {

    public function final_message(){
        $message  =
            'Take the airport bus from '.
            $this->getRowIndex('exit').
            ' to '.
            $this->getRowIndex('incoming').
            ' .No seat assignment.';
        return $message;
    }

}
class Train extends ConvertMessages {
    public function final_message(){
        $message  =
            'Take train ' .
            $this->getRowIndex('conveyance_number') .
            ' from '.
            $this->getRowIndex('exit').
            ' to '.
            $this->getRowIndex('incoming').'.';

        if(empty($this->getRowIndex('seat'))){
            $message .=' Sit in seat '.$this->getRowIndex('seat').'.';
        }
        return $message;
    }
}