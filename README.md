<h1>Helpdesk</h1>
<p>En el estado actual, esta es una aplicacion sencilla de CRUD (create, read, update and delete) para la generacion de tickets de IT. Posteriormente se pretende implementar la funcionalidad de tienda en linea y la generacion de tickets en relacion a los productos comprados.</p>
<h3>Entendiendo el layout</h3>
<p>Para empezar, nos veremos por defecto en la pesta&ntilde;a de "Hogar" (siguiendo el orden de las opciones en el Navbar) donde se despliega la funcionalidad basica de la pagina para el usuario. Luego tenemos la pagina "Inicio" donde se encuentra el admon de admin (en caso de que el rol del usario loggeado sea admin), en el mismo, existe un boton para filtrar las vistas y para buscar contenido especifico, ademas de paginaci&oacute;n. Luego tenemos la opcion de "Servicios" donde esta la funcionalidad "crear" de nuestro CRUD. "Contacto" que esta actualmente deshabilitado y "Salir" que como su nombre indica es el logout. En resumen, las opciones CRUD se encuentran en: 
<pre>
-Create/Crear: Dropdown de "Servicios"
-Read/Leer: vistas en "Inicio"
-Update/Actualizar: opcion de "Editar" (aparece en cada
elemento de las vistas. La pantalla editar es escencialmente
igual a la de "Crear")
-Delete/Borrar: opcion de "Borrar" (aparece en cada
elemento de las vistas)
</pre>
</p>
<h3>Hogar</h3>
<img width="100%" src="https://github.com/Ginazai/proyecto-final-p4/assets/67808421/6e498410-a37f-4c2f-9325-07d9ad0af212">
<h3>Inicio</h3>
<img width="100%" src="https://github.com/Ginazai/proyecto-final-p4/assets/67808421/4df68faa-35ac-4128-8b2f-51f8870dd801">
<h3>Usuarios (CRUD)</h3>
<p>Esta es la operacion con mayor complejidad por el momento. Posee aspectos refinados en el CRUD como la comprobacion de actualizacion de datos en el form, el monitoreo de la data que es actualizada y la asignacion de roles de usuario.</p>
<h6>Crear</h6>
<img width="100%" src="https://github.com/Ginazai/proyecto-final-p4/assets/67808421/d97bad76-7cea-46a5-bb23-f13b8e34dfbb">
<h6>Leer/Actualizar/Borrar</h6>
<img width="100%" src="https://github.com/Ginazai/proyecto-final-p4/assets/67808421/4df68faa-35ac-4128-8b2f-51f8870dd801">
<h3>Tickets (CRUD)</h3>
<h6>Crear</h6>
<img width="100%" src="https://github.com/Ginazai/proyecto-final-p4/assets/67808421/11e07241-359c-4c15-84de-1940aa82a965">
<h6>Leer/Actualizar/Borrar</h6>
<img width="100%" src="https://github.com/Ginazai/proyecto-final-p4/assets/67808421/01dc8e71-3eb2-4ba2-96bc-f3b831536c69">
<h3>Categorias (CRUD)</h3>
<h6>Crear</h6>
<img width="100%" src="https://github.com/Ginazai/proyecto-final-p4/assets/67808421/fe2ed18e-d17b-446c-9d0d-fdc2fd85f455">
<h6>Leer/Actualizar/Borrar</h6>
<img width="100%" src="https://github.com/Ginazai/proyecto-final-p4/assets/67808421/73d5d30c-698a-48fc-8681-a89b1b64de35">
