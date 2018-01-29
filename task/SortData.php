<?php
/**
 * Created by PhpStorm.
 * User: salahat
 * Date: 28/01/18
 * Time: 12:19 PM
 */
class SortData{
    private $data = [];
    private $number_row = 0;
    public function __construct($data){
        $this->setData($data);
        $this->setNumberRow(count($data));
    }
    public function preparationCard(){
        foreach ($this->getData() as $index=>$item) {
            $has_parent = false;
            $is_final = true;
            //for to find parent
            foreach ($this->getData() as $index_row => $rows) { // check and get step one
                $global_exit =strtolower($this->getIndexData($index)['exit']);
                $loop_incoming =strtolower($rows['incoming']);
                if (($global_exit==$loop_incoming) and ($global_exit===$loop_incoming)) {
                    $has_parent = true;
                }
            }
            //for to find parent
            foreach ($this->getData() as $index_row => $rows) { //check and get last step
                $global_incoming = strtolower($this->getIndexData($index)['incoming']);
                $loop_exit =strtolower($rows['exit']);
                if (($global_incoming==$loop_exit) and ($global_incoming===$loop_exit)) {
                    $is_final = false;
                }
            }
            if (!$has_parent) {
                array_unshift($this->data, $this->getIndexData($index));
                $this->RemoveIndexData($index);
            }
            elseif ($is_final) {
                array_push($this->data, $this->getIndexData($index));
                $this->RemoveIndexData($index);
            }
        }//for order first and last


        $this->data = array_merge($this->data);
        /*print_r($this->data);*/
        foreach ($this->getData() as $index=>$item) {
            //for to find parent
            foreach ($this->getData() as $index_row => $rows) { // check and get step one
                $global_incoming =strtolower($this->getIndexData($index)['incoming']);
                $loop_exit =strtolower($rows['exit']);

                if (($global_incoming==$loop_exit) and ($global_incoming===$loop_exit)) {
                    /*echo '$global_incoming <b>'.$global_incoming.'</b> '.$index.'<br>';
                    echo '$loop_exit <b>'.$loop_exit.'</b> '.$index_row.'<br>';*/
                    $found = false;

                    $shift_index = $index_row+1;
                    if(isset($this->data[$shift_index])){
                        $temp=$this->data[$shift_index];
                        $d = $rows;
                        $this->data[$index_row] = $temp;
                        $this->data[$shift_index] = $d;
                        $found= true;
                    }
                    if($found)
                        break;
                }
            }
        }//for order first and last
    }



    private function RemoveIndexData($index){
        unset($this->data[$index]);
    }

    /**
     * @return array
     * @param $index integer
     */
    private function getIndexData($index){
        return $this->data[$index];
    }

    /**
     * @return array
     */
    public function getData(){
        return $this->data;
    }

    /**
     * @return int
     */
    public function getNumberRow(){
        return $this->number_row;
    }

    /**
     * @param array $data
     */
    private function setData($data){
        $this->data = $data;
    }

    /**
     * @param int $number_row
     */
    private function setNumberRow($number_row){
        $this->number_row = $number_row;
    }
}