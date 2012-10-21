<?php
    class Pearson {
        private $list =  array();
        
        public function __construct($list) {
            if(is_array($list)){
                $this->setList($list);
            }else{
                echo "O argumento passado no construtor não é um Array";
            }
        }
        
        private function setList($list){
            $this->list = $list;
        }
        
        public function calcula(){            
            //Calcula a soma dos produtos entre as notas
            for ($i = 0 ; $i < sizeof($this->list[0]); $i++){
                            $nota1 = $this->list[0][$i];
                            $nota2 = $this->list[1][$i];

                            @$valor1 += $nota1*$nota2;
                    };
            //Soma as notas de cada usuário entre si	
            $valor2 = array_sum($this->list[0]);
            $valor3 = array_sum($this->list[1]);

            //Calcula a soma dos quadrados das notas
            for ($p = 0; $p < sizeof($this->list[0]); $p++){
                            @$valor4 += pow($this->list[0][$p],2);
                            @$valor5 += pow($this->list[1][$p],2);
                    };


            //Calculo do COEFICIENTE DE PEARSON
            $n = count($this->list[0]);

            $coe1 = ($n * $valor1 - $valor2 * $valor3);
            $coe2 = sqrt(($n * $valor4 - pow($valor2,2))*($n * $valor5 - pow($valor3,2)));

            @$coeficiente = $coe1 / $coe2;

            //Retorna o resultado do cálculo
            return $coeficiente;
        }
    }