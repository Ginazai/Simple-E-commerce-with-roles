<h1>E-commerce con modulo de administracion</h1>
<p>Aplicacion CRUD con modulo administrativo orientada a un E-commerce, pensado para integrarse con diversos departamentos mediante la gestion de roles y con una estructura de dato que se adapta a la estructura demografica del pais donde fue desarrollado (Panama).</p>
<h2>Tecnologias</h2>
<ul>
  <li>PHP 8.2.12</li>
  <li>XAMPP (Apache + MySQL + PHP)</li>
  <li>MySQL 15.1</li>
  <li>HTML/CSS/JavaScript</li>
  <li>Bootstrap 5.3.3</li>
  <li>JQuery 3.7.1</li>
</ul>
<h2>Instalacion</h2>
<ol>
  <li>Clona el repositorio: <code>git clone https://github.com/Ginazai/Simple-E-commerce-with-roles.git</code></li>
   <li>Copia el folder en el directorio <code>htdocs/</code> de XAMPP.</li>
   <li>Crea la base de datos en phpMyAdmin usando el archivo <code>registro.sql</code>.</li>
   <li>Inicia Apache y MySQL desde el panel de control de XAMPP.</li>
   <li>Accede a la aplicacion en la ruta <code>http://localhost/Simple-E-commerce-with-roles/index.php</code>.</li>
</ol>
<h2>Estado</h2>
<b>Finalizado</b>.<br>
Una mejor implementacion es un API para gestionar la base de datos y un middleware para facilitar la comunicacion de la pagina con el API. Lo anteriormente dicho podria ser un proyecto a futuro con tecnologia mas moderna como Laravel.
<h2>Galeria</h2>
<figure>
  <img width="100%" src="https://github.com/user-attachments/assets/197dde34-7911-4e22-a6a7-021735b78945">
  <figcaption>Fig.1: Modelo relacional</figcaption>
</figure>
<figure>
  <img width="100%" src="https://github.com/Ginazai/proyecto-final-p4/assets/67808421/6e498410-a37f-4c2f-9325-07d9ad0af212">
  <figcaption>Fig.2: Home page</figcaption>
</figure>
<figure>
  <img width="100%" src="https://github.com/Ginazai/proyecto-final-p4/assets/67808421/4df68faa-35ac-4128-8b2f-51f8870dd801">
  <figcaption>Fig.3: Inicio</figcaption>
</figure>
<h3>Usuarios (CRUD)</h3>
<p>Esta es la operacion con mayor complejidad. Posee aspectos refinados en el CRUD como la comprobacion de actualizacion de datos en el form, el monitoreo de la data que es actualizada y la asignacion de roles de usuario. (Vease el archivo <code>actions/create/crear_usuario.php</code>)</p>
<figure>
 <img width="100%" src="https://github.com/Ginazai/proyecto-final-p4/assets/67808421/d97bad76-7cea-46a5-bb23-f13b8e34dfbb">
  <figcaption>Fig.4: Crear</figcaption>
</figure>
<figure>
  <img width="100%" src="https://github.com/Ginazai/proyecto-final-p4/assets/67808421/4df68faa-35ac-4128-8b2f-51f8870dd801">
  <figcaption>Fig.5: Leer/Actualizar/Borrar</figcaption>
</figure>
<h3>Tickets (CRUD)</h3>
<figure>
  <img width="100%" src="https://github.com/Ginazai/proyecto-final-p4/assets/67808421/11e07241-359c-4c15-84de-1940aa82a965">
  <figcaption>Fig.6: Crear</figcaption>
</figure>
<figure>
  <img width="100%" src="https://github.com/Ginazai/proyecto-final-p4/assets/67808421/01dc8e71-3eb2-4ba2-96bc-f3b831536c69">
  <figcaption>Fig.7: Leer/Actualizar/Borrar</figcaption>
</figure>
<h3>Categorias (CRUD)</h3>
<figure>
  <img width="100%" src="https://github.com/Ginazai/proyecto-final-p4/assets/67808421/fe2ed18e-d17b-446c-9d0d-fdc2fd85f455">
  <figcaption>Fig.8: Crear</figcaption>
</figure>
<figure>
  <img width="100%" src="https://github.com/Ginazai/proyecto-final-p4/assets/67808421/73d5d30c-698a-48fc-8681-a89b1b64de35">
  <figcaption>Fig.9: Leer/Actualizar/Borrar</figcaption>
</figure>
