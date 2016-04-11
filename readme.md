#Prueba Técnica Grability/Rappi

Éste repositorio se crea con el propósito de resolver la prueba técnica para el cargo de backend developer en Grability.

## CODING CHALLENGE

El actual repositorio contiene un proyecto desarrollado en Laravel, en el cual se resuelve el ejercicio indicado en [este link](https://www.hackerrank.com/challenges/cube-summation). Para resolver el problema se usan las capas de Vista y Controlador, a continuación se describen las responsabilidades de cada una.

El programa usa como estructura de datos un array de php, pues está implementado como hash table y el acceso a sus elementos se hace en O(1). La matriz se inicia con todos sus valores en 0, usando un algoritmo de 3 loops anidados que tiene un orden O(n^3) y para obtener la suma se procesa de la misma forma.

Usé Laravel pues no estoy muy familiarizado con el framework ni con el lenguaje y decidí aprender al menos para realizar el ejercicio.

### VISTA
* El archivo ~/resources/views/basicform.blade.php es un template que contiene un formulario con un área de texto y un botón con el propósito de resivir los datos del usuario y de los casos de prueba. Sus responsabilidades son:
  * Imprime un formulario con un área de texto y un botón para enviar los datos
  * Obtiene el resultado del procesamiento realizado por el controlador
    * Si obtiene errores, en la parte superiór los muestra como una lista
    * Si el resultado es correcto, imprime en la parte inferior cada uno de los resultados de los QUERY separados por un salto de línea
* El archivo ~/resources/views/layouts/base.blade.php contiene el template base, con la sección donde se puede inyectar (y se hace) el template de una vista.

### CONTROLADOR
* El archivo ~/app/Http/Controllers/MatrixController.php contiene una clase controladora que se encargará de procesar los datos y retornar el resultado o los mensajes de error. Contiene 2 métodos públicos referidos en el archivo ~/app/Http/routes.php:
  * index: Método público encargado de mostrar inicialmente el formulario.
  * processData: Método público encargado de:
    * Leer los datos ingresados en el área de texto
    * Obtiene un arreglo con cada renglon de la entrada
    * Procesa cada línea según la estructura indicada en el ejecricio
    * Si hay un error con la instrucción indica el error
    * Envía un arreglo con los errores o un arreglo con el resultado.

### ROUTING

El archivo ~/app/Http/routes.php únicamente tiene dos enrutadores a las uri '/' y '/data', que apuntan a los métodos descritos anteriormente del controlador.

## CODE REFACTORING

En el archivo code_refactoring.txt de la raiz de este repositorio se encuentra la refactorización del código indicado en el ejercicio.


##PREGUNTAS
