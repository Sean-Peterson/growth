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
                for($j = 0; $j<$sizes[$i+1]; $j++) {
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
            for ($i = 0; $i<$this->sizes[0]; $i++) {
                $this->activations[0][$i] = $a[$i];
            }

            for ($i = 1; $i<$this->num_layers; $i++){
                for($j = 0; $j<($this->sizes[$i]); $j++){
                    $interim_activations = [];
                    foreach($this->activations[$i-1] as $individual){
                        array_push($interim_activations, [$individual]);
                    }
                    $interim_weights = [$this->weights[$i-1][$j]];
                    $dot_product = Network::dot($interim_weights, $interim_activations);
                    $this->activations[$i][$j] = Network::sigmoid(($dot_product[0][0])+$this->biases[$i-1][$j]);
                }
            }
            $last = sizeof($this->activations);
            return $this->activations[$last-1];
        }

        function backprop($x, $y) {
            $activation = $x;
            $activations = [];
            $zs = [];
            $nabla_b = [];
            $nabla_w = [];

            for ($i = 0; $i<$this->sizes[0]; $i++) {
                $this->activations[0][$i] = $a[$i];
            }


            for ($i = 1; $i<$this->num_layers; $i++){
                for($j = 0; $j<($this->sizes[$i]); $j++){
                    $interim_activations = [];
                    foreach($this->activations[$i-1] as $individual){
                        array_push($interim_activations, [$individual]);
                    }
                    $interim_weights = [$this->weights[$i-1][$j]];
                    $dot_product = Network::dot($interim_weights, $interim_activations);
                    $z = Network::sigmoid(($dot_product[0][0])+$this->biases[$i-1][$j]);
                    $this->activations[$i][$j] = Network::sigmoid(($dot_product[0][0])+$this->biases[$i-1][$j]);

                    array_push($zs, $z);
                    $act = Network::sigmoid($z);
                    array_push($activations, $act);
                }
            }
            $last_a = sizeof($this->activations);
            $last_z = sizeof($zs);

            $delta = Network::cost_derivative($this->activations[$last_a-1], $y) * Network::sigmoid_prime($zs[$last_z-1]);
            

        }











        function cost_derivative($training_y){
            $last_layer = sizeof($this->activations) - 1;
            $output_activations = $this->activations[$last_layer];
            $cost_derivative_array = [];
            for($i=0;$i<sizeof($training_y);$i++) {
                array_push($cost_derivative_array, ($output_activations[$i]-$training_y[$i]));
            }
        }

        static function sigmoid($z) {
            $value =  1.0/(1.0+exp(-$z));
            return $value;
        }

        static function sigmoid_prime($z) {
            $value = Network::sigmoid($z)*(1-Network::sigmoid($z));
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
