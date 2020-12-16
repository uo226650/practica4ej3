<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Calculadora RPN</title>
	<link rel="stylesheet" type="text/css" href="CalculadoraRPN.css">
</head>
<body>
	
    <main>
        <h1>Calculadora RPN</h1>
        <?php

        session_start();

        /**
         * Definición de la clase CalculadoraBasica
         * 
         * Los ceros a la izquierda de un 8 o 9 provocan un error debido a la base numérica Octal
         * que reconoce PHP desde su versión 7.x
         */
        class CalculadoraBasica{

            public function __construct(){

                $this->pantalla = "";
                $this->memoria = "";
                if( !isset( $_SESSION['calculadora'] ) ) {
                    
                    $_SESSION['calculadora']= $this;
                } else {
                    $_SESSION['calculadora']->accion();
                }
                   
            }

            public function accion(){
                if (count($_POST)>0){  
                //Pulsación de dígitos u operaciones
                if(isset($_POST['digito0'])) $_SESSION['calculadora']->pulsar("0"); 
                if(isset($_POST['digito1'])) $_SESSION['calculadora']->pulsar("1");
                if(isset($_POST['digito2'])) $_SESSION['calculadora']->pulsar("2");
                if(isset($_POST['digito3'])) $_SESSION['calculadora']->pulsar("3");
                if(isset($_POST['digito4'])) $_SESSION['calculadora']->pulsar("4");
                if(isset($_POST['digito5'])) $_SESSION['calculadora']->pulsar("5");
                if(isset($_POST['digito6'])) $_SESSION['calculadora']->pulsar("6");
                if(isset($_POST['digito7'])) $_SESSION['calculadora']->pulsar("7");
                if(isset($_POST['digito8'])) $_SESSION['calculadora']->pulsar("8");
                if(isset($_POST['digito9'])) $_SESSION['calculadora']->pulsar("9");
                if(isset($_POST['mas'])) $_SESSION['calculadora']->pulsar("+");
                if(isset($_POST['menos'])) $_SESSION['calculadora']->pulsar("-");
                if(isset($_POST['por'])) $_SESSION['calculadora']->pulsar("*");
                if(isset($_POST['entre'])) $_SESSION['calculadora']->pulsar("/");
                if(isset($_POST['punto'])) $_SESSION['calculadora']->pulsar(".");

                //Cálculo de resultado
                if(isset($_POST['igual'])) $_SESSION['calculadora']->evaluar();
                 
                if(isset($_POST['limpiar'])) $_SESSION['calculadora']->limpiar();

                //Operaciones de memoria
                if(isset($_POST['ms'])) $_SESSION['calculadora']->guardar();
                if(isset($_POST['mr'])) $_SESSION['calculadora']->leerMemoria();
                if(isset($_POST['mc'])) $_SESSION['calculadora']->borrarMemoria();
                if(isset($_POST['mmas'])) $_SESSION['calculadora']->sumarMemoria();
                if(isset($_POST['mmenos'])) $_SESSION['calculadora']->restarMemoria();
            }

            }

            public function pulsar($valor){
                $this->pantalla .= $valor;
            }

            public function limpiar(){
                $this->pantalla = "";
            }

            public function guardar(){
                if (is_numeric($this->pantalla)){
                    $this->memoria = (float)$this->pantalla;

                } else {
                    $this->pantalla = "Operación no permitida";
                }  
                
            }

            public function leerMemoria(){
                $this->pantalla = $this->memoria;
            }

            public function borrarMemoria(){
                $this->memoria = "";
                $this->pantalla = 0;
            }

            public function sumarMemoria(){

                if(is_numeric($this->pantalla)){ //Comprobar si es un number
                    $suma = $this->memoria + $this->pantalla;
                    $this->memoria = $suma;
                    $this->pantalla = $this->memoria;
                } else {
                    $this->pantalla = "Operación no permitida";
                }
                
            }

            /**
            * Resta el valor actual de pantalla al valor
            * almacenador en memoria
            */
            public function restarMemoria(){

                if(is_numeric($this->pantalla)){ //Comprobar si es un number
                    $resta = $this->memoria - $this->pantalla;
                    $this->memoria = $resta;
                    $this->pantalla = $this->memoria;
                } else {
                    $this->pantalla = "Operación no permitida";
                }

            }

            public function evaluar(){
                try{
                    $expresion = strval($this->pantalla);
                    $this->pantalla = eval("return $expresion ;");
                } catch (Throwable $e) {
                    $this->pantalla = "Error: " .$e->getMessage();
                }
            }

            public function getPantalla(){
                return $this->pantalla;
            }
        }

        /**
         * Definición de la clase CalculadoraCientifica
         * con las funciones específicas de la clase concreta
         */
        class CalculadoraCientifica extends CalculadoraBasica{

            public function __construct(){
                //parent::__construct();
                if( !isset( $_SESSION['calculadoraCientifica'] ) ) {
                    $this->pantalla = "";
                    $this->memoria = "";
                    $_SESSION['calculadoraCientifica']= $this;
                } else {
                    $_SESSION['calculadoraCientifica']->accion();
                }
                   
            }
        
            public function accion(){
                //Solo se ejecutará si se han enviado los datos desde el formulario al pulsar el boton Calcular
                if (count($_POST)>0) 
                {  
                    //Pulsación de dígitos u operaciones
                    if(isset($_POST['digito0'])) $_SESSION['calculadoraCientifica']->pulsar("0"); 
                    if(isset($_POST['digito1'])) $_SESSION['calculadoraCientifica']->pulsar("1");
                    if(isset($_POST['digito2'])) $_SESSION['calculadoraCientifica']->pulsar("2");
                    if(isset($_POST['digito3'])) $_SESSION['calculadoraCientifica']->pulsar("3");
                    if(isset($_POST['digito4'])) $_SESSION['calculadoraCientifica']->pulsar("4");
                    if(isset($_POST['digito5'])) $_SESSION['calculadoraCientifica']->pulsar("5");
                    if(isset($_POST['digito6'])) $_SESSION['calculadoraCientifica']->pulsar("6");
                    if(isset($_POST['digito7'])) $_SESSION['calculadoraCientifica']->pulsar("7");
                    if(isset($_POST['digito8'])) $_SESSION['calculadoraCientifica']->pulsar("8");
                    if(isset($_POST['digito9'])) $_SESSION['calculadoraCientifica']->pulsar("9");
                    if(isset($_POST['mas'])) $_SESSION['calculadoraCientifica']->pulsar("+");
                    if(isset($_POST['menos'])) $_SESSION['calculadoraCientifica']->pulsar("-");
                    if(isset($_POST['por'])) $_SESSION['calculadoraCientifica']->pulsar("*");
                    if(isset($_POST['entre'])) $_SESSION['calculadoraCientifica']->pulsar("/");
                    if(isset($_POST['punto'])) $_SESSION['calculadoraCientifica']->pulsar(".");
                    if(isset($_POST['abrirParentesis'])) $_SESSION['calculadoraCientifica']->pulsar("(");
                    if(isset($_POST['cerrarParentesis'])) $_SESSION['calculadoraCientifica']->pulsar(")");
                    if(isset($_POST['modulo'])) $_SESSION['calculadoraCientifica']->pulsar("%");
                    
                    //Cálculo de resultado
                    if(isset($_POST['igual'])) $_SESSION['calculadoraCientifica']->evaluar();
                    
                    if(isset($_POST['limpiar'])) $_SESSION['calculadoraCientifica']->limpiar();

                    //Operaciones de memoria
                    if(isset($_POST['ms'])) $_SESSION['calculadoraCientifica']->guardar();
                    if(isset($_POST['mr'])) $_SESSION['calculadoraCientifica']->leerMemoria();
                    if(isset($_POST['mc'])) $_SESSION['calculadoraCientifica']->borrarMemoria();
                    if(isset($_POST['mmas'])) $_SESSION['calculadoraCientifica']->sumarMemoria();
                    if(isset($_POST['mmenos'])) $_SESSION['calculadoraCientifica']->restarMemoria();

                    //Operaciones avanzadas

                    //Trigonométricas
                    if(isset($_POST['sin'])) $_SESSION['calculadoraCientifica']->seno();
                    if(isset($_POST['asin'])) $_SESSION['calculadoraCientifica']->arcseno();
                    if(isset($_POST['cos'])) $_SESSION['calculadoraCientifica']->coseno();
                    if(isset($_POST['acos'])) $_SESSION['calculadoraCientifica']->arccoseno();
                    if(isset($_POST['tan'])) $_SESSION['calculadoraCientifica']->tangente();
                    if(isset($_POST['atan'])) $_SESSION['calculadoraCientifica']->arctangente();
                    
                    //Exponentes y logaritmos
                    if(isset($_POST['cuadrado'])) $_SESSION['calculadoraCientifica']->cuadrado();
                    if(isset($_POST['raíz'])) $_SESSION['calculadoraCientifica']->raiz();
                    if(isset($_POST['logaritmo'])) $_SESSION['calculadoraCientifica']->logaritmo();
                    if(isset($_POST['log10'])) $_SESSION['calculadoraCientifica']->logBase10();
                    if(isset($_POST['potencia'])) $_SESSION['calculadoraCientifica']->pulsar('**');
                    if(isset($_POST['exponencial'])) $_SESSION['calculadoraCientifica']->exponencial();
                    if(isset($_POST['exp10'])) $_SESSION['calculadoraCientifica']->expBase10();
                    
                    //Constantes, signo, conversiones (rad y deg), borrar
                    if(isset($_POST['signo'])) $_SESSION['calculadoraCientifica']->signo();
                    if(isset($_POST['PI'])) $_SESSION['calculadoraCientifica']->PI();
                    if(isset($_POST['e'])) $_SESSION['calculadoraCientifica']->e();
                    if(isset($_POST['Rad'])) $_SESSION['calculadoraCientifica']->toRad();
                    if(isset($_POST['Deg'])) $_SESSION['calculadoraCientifica']->toDegrees();
                    if(isset($_POST['borrar'])) $_SESSION['calculadoraCientifica']->borrar();

                    //Factorial
                    if(isset($_POST['factorial'])) $_SESSION['calculadoraCientifica']->factorial();
                }
            }
            
            public function seno(){//Recibe valor en radianes por defecto

                $this->pantalla = sin((float)$this->pantalla);
                //Devuelve el valor en radianes
            }

            public function coseno(){//Recibe valor en radianes por defecto
                $this->pantalla = cos((float)$this->pantalla);
                //Devuelve el valor en radianes
            }

            public function tangente(){//Recibe valor en radianes por defecto
                $this->pantalla = tan((float)$this->pantalla);
                //Devuelve el valor en radianes
            }

            public function arcseno(){//Recibe valor en radianes por defecto
                $this->pantalla = asin((float)$this->pantalla);
                //Devuelve el valor en radianes
            }

            public function arccoseno(){//Recibe valor en radianes por defecto
                $this->pantalla = acos((float)$this->pantalla);
                //Devuelve el valor en radianes
            }

            public function arctangente(){//Recibe valor en radianes por defecto
                $this->pantalla = atan((float)$this->pantalla);
                //Devuelve el valor en radianes
            }
            
            public function logaritmo(){
                $this->pantalla = log((float)$this->pantalla);
                
            }

            
            public function logBase10(){
                $this->pantalla = log10((float)$this->pantalla);
                
            }

            
            public function exponencial(){
                $this->pantalla = exp((float)$this->pantalla);
                
            }

            
            public function expBase10(){
                $this->pantalla = pow( 10, (float)$this->pantalla);   
            }

            
            public function cuadrado(){
                $this->pantalla = pow((float)$this->pantalla, 2);
            }

            
            public function raiz(){
                $this->pantalla = sqrt((float)$this->pantalla);    
            }

            
            public function signo(){
                $this->pantalla = -(float)$this->pantalla;            
            }

            public function PI(){
                if(is_numeric($this->pantalla)){
                    $this->pantalla = pi();
                }else{
                    $this->pantalla .= pi();
                }
            }

            public function e(){
                if(is_numeric($this->pantalla)){
                    $this->pantalla = exp(1);
                }else{
                    $this->pantalla .= exp(1);
                }
            }

            public function toDegrees(){

                if(is_numeric($this->pantalla)){
                    $this->pantalla = rad2deg((float)$this->pantalla);
                } else{
                    $this->pantalla = "NAN, operación no permitida";
                }
            }

            public function toRad(){

                if(is_numeric($this->pantalla)){
                    $this->pantalla = deg2rad((float)$this->pantalla);
                } else{
                    $this->pantalla = "NAN, operación no permitida";
                }
            }

            public function borrar(){
                $this->pantalla = substr($this->pantalla, 0, strlen($this->pantalla)-1);
            }

            public function factorialCalculo($n){
                return $n ? $n * $this->factorialCalculo($n - 1) : 1;
            }
            public function factorial(){
                if($this->pantalla < 0){
                    $this->pantalla = "Introduzca un número positivo";
                }else{
                    $this->pantalla = $this->factorialCalculo($this->pantalla);
                }
            }
 
        }
        /**
         * Definición de la clase PilaLIFO
         */

        class PilaLIFO {

            protected $pila;

            public function __construct(){

                $this->pila = array();
                
            }

            /**
             * Introduce un valor a la pila
             */
            public function push($elemento) {
                // precondición: $elemento es un integer o float
                if (is_numeric($elemento)) { ////Previene un mal uso de la pila (que en nuestra aplicación solo acepta números). 
                    // inserta un elemento en la cabeza del array
                    array_unshift($this->pila, $elemento);
                } else { ////No se alcanza nunca ya que la propia implementación llamará a push teniendo solo números como input
                    throw new RunTimeException('El valor introducido debe ser un número');
                }
            }

            /**
             * Extrae un valor de la pila y lo devuelve
             */
            public function pop() {
                //precondición: comprueba que la pila no esté vacía    
                if ($this->vacia()) {
                    throw new RunTimeException('¡Pila vacía! No se pueden desapilar elementos');
                } else {
                    // desapila un elemento del inicio del array
                    return array_shift($this->pila);
                }
            }
            
            public function longitud(){
                //devuelve el número de elementos de la pila
                return count($this->pila);   
            }

            public function ultimo() {
                return current($this->pila);
            }

            public function vacia() {
                return empty($this->pila);
            }
                    
            public function ver(){
                $elements = "";
                for ($i = 0; $i < $this->longitud();  $i++)
                    $elements .= ($i+1) . ":" . "\t" . $this->pila[$i] . "\n" ;
                return $elements;
            } 

        }

        /**
        * Calculadora RPN instrucciones
        * 
        * En esta primera versión se asume que todos los operadores (+,-,*,/,%)
        * toman dos argumentos (y no más).
        * 
        * Las operaciones de un solo operando se realizan sobre el valor actual
        * de la pantalla (el último de la pila o el introducido nuevo), SIN añadirse
        * a la pila el resultado una vez calculado. Si se desea, se puede presionar
        * la tecla enter para introducir este nuevo valor calculado.
        *
        * v.1.0 - La pantalla siempre muestra el último valor introducido
        * o calculado. No se resetea en caso de que quiera utilizarse ese valor
        * en operaciones de un solo operando (pulsar n! o mod o función trigonométrica)
        * 
        * La tecla 'On' simula el encendido de la calculadora, por lo tanto
        * sirve para resetear los campos a su estado inicial (vacío) 
        *
        * Consecuencia: Para introducir un nuevo dígito independiente 
        * después de realizar una operación y que éste no es concatene
        * con el dígito mostrado actualmente en pantalla habrá de limpiarse primero
        * la pantalla (presionar la tecla C, y con la pantalla vacía introducir
         */
        class CalculadoraRPN extends CalculadoraCientifica {
            
            public function __construct($pila){
                //parent::__construct();
                $this->pantalla="";
                $this->memoria="";
                if( !isset( $_SESSION['calculadoraRPN'] ) ) {
                    $this->pila = $pila;
                    $this->pantallaPila = ""; 
                    $_SESSION['calculadoraRPN']= $this;
                } else {
                    $_SESSION['calculadoraRPN']->accion();
                }
                   
            }

            public function actualizarPila(){
                $elements = $this->pila->ver();
                $this->pila->pantallaPila = $elements;
            }

            public function enter(){

                $input = $this->getPantalla();
                if (!is_numeric($input))
                    $this->pantalla = "Only numbers can be stored in memory";
                else {
                    $this->pila->push((float)$input);
                    $this->actualizarPila();
                    $this->pantalla = $this->pila->ultimo();
                }                   
            }

            public function getPila(){
                    return $this->pila;
            }
        
           
        
            /**
             * Elimina el uso de eval() para el calculo de las expresiones
             * @param {String} op Caracter que representa la operación a realizar
             */
            public function operacionRPN($op){
                
                //if($this->pila->vacia()){ //Si se acciona un botón de operación con la pila vacía
                if($this->pila->vacia()){    
                    $this->pila->pantallaPila ="Pila vacía"; //Se informa a través de la pantalla de la calculadora
                    $this->pantalla = ""; //Resetea la pantalla para que el usuario pueda introducir el siguiente valor sin tener la necesidad de borrar el mensaje actual en pantalla
                    return; //No se realiza operación ninguna
        
                //} else if ($this->pila->longitud() < 2){ //Si solo hay un valor en la pila
                } else if ($this->pila->longitud() < 2){    
                    //Se informa de la necesidad de introducir otro antes de realizar la operación
                    $this->pila->pantallaPila .= "Introduce un segundo valor en la pila primero";
                    $this->pantalla = "";
                    return;
                }
        
                 //En caso de que haya dos valores o más en la pila:   
                $ultimoValor = $this->pila->pop();
                $penultimoValor = $this->pila->pop();
        
                switch ($op) { 
                    case '+': 
                        $this->pila->push($penultimoValor + $ultimoValor); 
                        break; 
          
                    case '-': 
                        $this->pila->push($penultimoValor - $ultimoValor); 
                        break; 
          
                    case '/': 
                        $this->pila->push($penultimoValor / $ultimoValor); 
                        break; 
          
                    case '*': 
                        $this->pila->push($penultimoValor * $ultimoValor); 
                        break;
        
                    case '%': 
                        $this->pila->push($penultimoValor % $ultimoValor); 
                        break;
        
                    case '**': 
                        $this->pila->push($penultimoValor ** $ultimoValor); 
                        break;
                    }
                $this->actualizarPila();
                $this->pantalla = $this->getPila()->ultimo();
            }
    
        
            /**
             * Para las funciones suma, resta, multiplicación, división, módulo y potencia
             * @override
             */
            public function operador($operador){
                $this->operacionRPN($operador);
            }

            public function resetear(){
                $this->pantalla = "";
                $this->pila = new PilaLIFO();
                $this->pila->pantallaPila = "";
            }

            public function accion(){
                if (count($_POST)>0) 
            {  
                //Pulsación de dígitos u operaciones
                if(isset($_POST['digito0'])) $_SESSION['calculadoraRPN']->pulsar("0"); 
                if(isset($_POST['digito1'])) $_SESSION['calculadoraRPN']->pulsar("1");
                if(isset($_POST['digito2'])) $_SESSION['calculadoraRPN']->pulsar("2");
                if(isset($_POST['digito3'])) $_SESSION['calculadoraRPN']->pulsar("3");
                if(isset($_POST['digito4'])) $_SESSION['calculadoraRPN']->pulsar("4");
                if(isset($_POST['digito5'])) $_SESSION['calculadoraRPN']->pulsar("5");
                if(isset($_POST['digito6'])) $_SESSION['calculadoraRPN']->pulsar("6");
                if(isset($_POST['digito7'])) $_SESSION['calculadoraRPN']->pulsar("7");
                if(isset($_POST['digito8'])) $_SESSION['calculadoraRPN']->pulsar("8");
                if(isset($_POST['digito9'])) $_SESSION['calculadoraRPN']->pulsar("9");
                if(isset($_POST['mas'])) $_SESSION['calculadoraRPN']->operador("+");
                if(isset($_POST['menos'])) $_SESSION['calculadoraRPN']->operador("-");
                if(isset($_POST['por'])) $_SESSION['calculadoraRPN']->operador("*");
                if(isset($_POST['entre'])) $_SESSION['calculadoraRPN']->operador("/");
                if(isset($_POST['punto'])) $_SESSION['calculadoraRPN']->pulsar(".");
                if(isset($_POST['abrirParentesis'])) $_SESSION['calculadoraRPN']->pulsar("(");
                if(isset($_POST['cerrarParentesis'])) $_SESSION['calculadoraRPN']->pulsar(")");
                if(isset($_POST['modulo'])) $_SESSION['calculadoraRPN']->operador("%");
                
                //Cálculo de resultado
                if(isset($_POST['enter'])) $_SESSION['calculadoraRPN']->enter();
                 
                if(isset($_POST['limpiar'])) $_SESSION['calculadoraRPN']->limpiar();

                //Operaciones de memoria
                if(isset($_POST['ms'])) $_SESSION['calculadoraRPN']->guardar();
                if(isset($_POST['mr'])) $_SESSION['calculadoraRPN']->leerMemoria();
                if(isset($_POST['mc'])) $_SESSION['calculadoraRPN']->borrarMemoria();
                if(isset($_POST['mmas'])) $_SESSION['calculadoraRPN']->sumarMemoria();
                if(isset($_POST['mmenos'])) $_SESSION['calculadoraRPN']->restarMemoria();

                //Operaciones avanzadas

                //Trigonométricas
                if(isset($_POST['sin'])) $_SESSION['calculadoraRPN']->seno();
                if(isset($_POST['asin'])) $_SESSION['calculadoraRPN']->arcseno();
                if(isset($_POST['cos'])) $_SESSION['calculadoraRPN']->coseno();
                if(isset($_POST['acos'])) $_SESSION['calculadoraRPN']->arccoseno();
                if(isset($_POST['tan'])) $_SESSION['calculadoraRPN']->tangente();
                if(isset($_POST['atan'])) $_SESSION['calculadoraRPN']->arctangente();
                
                //Exponentes y logaritmos
                if(isset($_POST['cuadrado'])) $_SESSION['calculadoraRPN']->cuadrado();
                if(isset($_POST['raíz'])) $_SESSION['calculadoraRPN']->raiz();
                if(isset($_POST['logaritmo'])) $_SESSION['calculadoraRPN']->logaritmo();
                if(isset($_POST['log10'])) $_SESSION['calculadoraRPN']->logBase10();
                if(isset($_POST['potencia'])) $_SESSION['calculadoraRPN']->operador('**');
                if(isset($_POST['exponencial'])) $_SESSION['calculadoraRPN']->exponencial();
                if(isset($_POST['exp10'])) $_SESSION['calculadoraRPN']->expBase10();
                
                //Constantes, signo, conversiones (rad y deg), borrar
                if(isset($_POST['signo'])) $_SESSION['calculadoraRPN']->signo();
                if(isset($_POST['PI'])) $_SESSION['calculadoraRPN']->PI();
                if(isset($_POST['e'])) $_SESSION['calculadoraRPN']->e();
                if(isset($_POST['Rad'])) $_SESSION['calculadoraRPN']->toRad();
                if(isset($_POST['Deg'])) $_SESSION['calculadoraRPN']->toDegrees();
                if(isset($_POST['borrar'])) $_SESSION['calculadoraRPN']->borrar();

                //Factorial
                if(isset($_POST['factorial'])) $_SESSION['calculadoraRPN']->factorial();
                if(isset($_POST['on'])) $_SESSION['calculadoraRPN']->resetear();
            }
            }

        
            /********************************************************/
        
        }
        
        $pila = new PilaLIFO();
        $calculadora = new CalculadoraRPN($pila);


        ?>

                <form action='#' method='post' name='calculadora'>
                        <label for='pantalla' class='visuallyhidden'>Pantalla:</label>
                        <div class='teclas'>
                            <?php
                            echo "<textarea id='pila' disabled>{$_SESSION['calculadoraRPN']->getPila()->ver()}</textarea>";
                            echo "<input type='text' id='pantalla' name='expresion' value='{$_SESSION['calculadoraRPN']->getPantalla()}' readonly/>";
                            ?>
                            <input type = 'submit' class='memoria' name = 'mmenos' value = 'M-'/>
                            <input type = 'submit' class='memoria' name = 'mmas' value = 'M+'/>
                            <input type = 'submit' class='memoria' name = 'mr' value = 'MR'/>
                            <input type = 'submit' class='memoria' name = 'mc' value = 'MC'/>
                            <input type = 'submit' class='memoria' name = 'ms' value = 'MS'/>
                            <input type = 'submit' class='operaciones' name = 'Rad' value = 'Rad'/>
                            <input type = 'submit' class='operaciones' name = 'Deg' value = 'Deg'/>

                            <input type = 'submit' class='avanzadas' name = 'sin' value = 'sin'/>
                            <input type = 'submit' class='avanzadas' name = 'cos' value = 'cos'/>
                            <input type = 'submit' class='avanzadas' name = 'tan' value = 'tan'/>
                            <input type = 'submit' class='avanzadas' name = 'cuadrado' value = 'x^2'/>
                            <input type = 'submit' class='avanzadas' name = 'potencia' value = 'x^y'/>
                            <input type = 'submit' class='avanzadas' name = 'exponencial' value = 'e^x'/>
                            <input type = 'submit' class='avanzadas' name = 'exp10' value = '10^x'/>

                            <input type = 'submit' class='avanzadas' name = 'asin' value = 'asin'/>
                            <input type = 'submit' class='avanzadas' name = 'acos' value = 'acos'/>
                            <input type = 'submit' class='avanzadas' name = 'atan' value = 'atan'/>
                            <input type = 'submit' class='avanzadas' name = 'raíz' value = 'raíz'/>
                            <input type = 'submit' class='avanzadas' name = 'logaritmo' value = 'log'/>
                            <input type = 'submit' class='avanzadas' name = 'log10' value = 'log_10'/>
                            <input type = 'submit' class='avanzadas' name = 'modulo' value = 'mod'/>
                            
                            <input type = 'submit' class='avanzadas' name = 'PI' value = 'PI'/>
                            <input type = 'submit' class='digito' name = 'digito7' value = '7'/>
                            <input type = 'submit' class='digito' name = 'digito8' value = '8'/>
                            <input type = 'submit' class='digito' name = 'digito9' value = '9'/>
                            <input type = 'submit' class='operaciones' name = 'menos' value = '-'/>
                            <input type = 'submit' class='operaciones' name = 'entre' value = '/'/>
                            <input type = 'submit' class='operaciones' name = 'abrirParentesis' value = '('/>

                            <input type = 'submit' class='avanzadas' name = 'e' value = 'e'/>
                            <input type = 'submit' class='digito' name = 'digito4' value = '4'/>
                            <input type = 'submit' class='digito' name = 'digito5' value = '5'/>
                            <input type = 'submit' class='digito' name = 'digito6' value = '6'/>
                            <input type = 'submit' class='operaciones' name = 'mas' value = '+'/>
                            <input type = 'submit' class='operaciones' name = 'por' value = '*'/>
                            <input type = 'submit' class='operaciones' name = 'cerrarParentesis' value = ')'/>

                            <input type = 'submit' class='avanzadas' name = 'factorial' value = 'n!'/>
                            <input type = 'submit' class='digito' name = 'digito1' value = '1'/>
                            <input type = 'submit' class='digito' name = 'digito2' value = '2'/>
                            <input type = 'submit' class='digito' name = 'digito3' value = '3'/>
                            <input type = 'submit' id='enter' class='operaciones' name = 'enter' value = 'Enter'/>
                            <input type = 'submit' class='operaciones' name = 'signo' value = '+/-'/>

                            <input type = 'submit' id='on' name = 'on' value = 'On'/>
                            <input type = 'submit' id='borrar' name = 'borrar' value = 'Del'/>
                            <input type = 'submit' class='digito' name = 'digito0' value = '0'/>
                            <input type = 'submit' class='digito' name = 'punto' value = '.'/>
                            <input type = 'submit' id='limpiar' name = 'limpiar' value = 'C'/>
                        </div>
                </form>
    </main>    
    <footer>
        <a href="https://validator.w3.org/check/referer" hreflang="en-us">
            <img src="data:image/png;base64,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"
                alt="¡HTML5 válido!" height="30" /></a>
        <a href="https://jigsaw.w3.org/css-validator/check/referer">
            <img style="border:0;width:88px;height:31px" src="https://jigsaw.w3.org/css-validator/images/vcss"
                alt="¡CSS Válido!" /></a>
        <a href="https://achecker.ca/checker/index.php?uri=referer&gid=WCAG2-AAA">
            <img src="https://achecker.ca/images/icon_W2_aaa.jpg" alt="WCAG 2.0 (Level AAA)" height="32" width="102" />
        </a>
    </footer>
</body>
</html>
