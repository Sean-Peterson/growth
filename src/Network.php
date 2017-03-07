<?php
    class Network {
        public $num_layers;
        public $sizes;
        public $biases;
        public $weights;
        public $activations;

        function __construct($sizes) {
            $this->num_layers = sizeof($sizes);
            $this->sizes = $sizes;
            $this->biases = [];

            for($i = 0; $i<$this->num_layers-1; $i++) {
                array_push($this->biases, []);
                for($j = 0; $j<$sizes[$i]; $j++) {
                    array_push($this->biases[$i], rand(0,10000)/10000);
                }
            }

            $this->activations = [];
            for($i = 0; $i<$this->num_layers; $i++) {
                array_push($this->activations, []);
                for($j = 0; $j<$sizes[$i]; $j++) {
                    array_push($this->activations[$i], 0);
                }
            }

            $this->weights = [];
            for($i = 0; $i<$this->num_layers-1; $i++) {
                array_push($this->weights, []);
                for($j = 0; $j<$sizes[$i+1]; $j++) {
                    array_push($this->weights[$i], []);
                    for($k = 0; $k<$sizes[$i]; $k++){
                        array_push($this->weights[$i][$j], rand(-10000,10000)/10000);
                    }
                }
            }
        }


        function feedforward($a){
            for ($i = 0; $i<$this->size[0]; $i++) {
                $this->activations[0][$i] = $a[$i];
            }

            for ($i = 1; $i<$this->num_layers; $i++){
                for($j = 0; $j<($sizes[$i]); $j++){
                    $activations[$i][$j] = Network::sigmoid(Network::dot($this->weights[$i-1][$j], $this->activations[$i-1])+$this->bias[$i][$j]);
                }
            }
        }





        static function sigmoid($z) {
            $value =  1.0/(1.0+exp(-$z));
            return $value;
        }

        static function dot($array1, $array2){
            $result_array = [];
            for($i=0;$i<sizeof($array1);$i++){
                array_push($result_array, []);
                for($j=0;$j<sizeof($array2[0]);$j++){
                    array_push($result_array[$i], 0);
                }
            }

            for($i=0;$i<sizeof($array1);$i++){
                for($j=0;$j<sizeof($array2[0]);$j++){
                    for($k=0;$k<sizeof($array1[$i]);$k++){
                        $result_array[$i][$j] += ($array1[$i][$k]*$array2[$k][$j]);
                    }
                }
            }

            return $result_array;

        }

        // [
        //     [58,58]
        //     [154,154]
        // ]
        //
        // [
        //     [1,2,3]
        //     [4,5,6]
        // ]
        //
        // [
        //     [7,8]
        //     [9,10]
        //     [11,12]
        // ]


        function display_network() {
            foreach($sizes as $size) {
                echo ($size);
            }

            foreach($weights as $weight){
                echo($weight);
            }
        }


    }


?>
