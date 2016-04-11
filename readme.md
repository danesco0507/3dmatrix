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

Lo primero que se puede notar es que el código entregado es dificil de leer, pues no se encuentra documentación de lo que se hace en el método. En la refactorización que hice, me aseguré de indicar de que se trata cada paso lo cual facilita el mantenimiento del código.

Por otro lado se hacen muchas consultas similares a los datos que llegan por post, por ejemplo cuando se hace 

Input::get('driver_id')

En la refactorización se hace un solo llamado al parametro y se hace un solo llamado a la base de datos para obtener los registros del servicio y del conductor (salvo update), esto facilita el entendimiento del código y evita llamados inecesarios a la base de datos como se hace cuando se actualiza el valor del id del carro en el servicio.

También se hizo una corrección sobre los if que verifican el estatus del servicio y se cambia el segundo por un elseif, esto se hace por buenas practicas aun que no afecta mucho en el funcionaminto en este caso especifico (ya que existenclausulas return en cada bloque condicional.

Por último se cambia el retorno en caso de que el envío de la notificación sea exitoso, de lo contrario no es posible identificar en un caso de pruebas si el envío es exitoso o no se encontro un "uuid" para el usuario, lo cual tiene implicaciones distintas pero se está manejando igual. El código que se encuentra bajo comentarios se elimina para mejorar la facilidad de lectura del código.


##PREGUNTAS

### ¿En que consiste el principio de responsabilidad única? ¿Cual es su propósito?

Este principio consiste en diseñar e implementar correctamente la separación de responsabilidades de cada objeto, es decir que cada objeto que componga el funcionamiento del software debe tener su responsabilidad bien definida y no debe implementar funcionalidades de las que se puedan encargar otros objetos o entidades.

Por ejemplo uno puede pensar en una funcionalidad encargada de hacer una carga masiva, en la que al terminar se envíe un correo al usuario que la inició o a los interesados. Es posible implementar dicha funcionalidad en un solo objeto si así se quiere, pero enviar notificaciones por correo puede ser una funcionalidad por si sola que solo se preocupa por cual es el mensaje que debe enviar y a quien debe enviarlo. En este caso se tendrían 2 responsabilidades clave (entre otras), cargar datos y enviar correos, lo cual se debe separar para desacoplar las funcionalidades y hacer el software de paso más mantenible.  

### ¿Que características tiene según su opinion "buen" código o código limpio?

Un código limpio, entre otras cosas debe estar bien documentado para que cuando otra persona lo lea pueda entender que se hace en cada momento. Es importante también evitar repetir el código a lo largo del proceso, si algo se repite en alguna parte es probable que sea candidato para separarlo como una función o como una librería.

También pienso que por legibilidad es bueno que las funciones no sean muy largas y que no contengan código que no se usa por todas partes. La identación debe estar siempre presente para identificar los bloques de código y debe haber espacio entre unidades de código para poder identificar donde empieza o acaba un proceso.
