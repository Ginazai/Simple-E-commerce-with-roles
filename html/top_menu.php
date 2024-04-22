<?php
$options = "";
if(in_array(1, $_SESSION['Roles'])){
$options .= "<option value='tickets'>Tickets</option>
            <option value='usuarios'>Usuarios</option>
            <option value='categorias'>Categorias</option>";

$vista == "tickets" ? $options = "<option value='tickets' selected>Tickets</option>
                                  <option value='usuarios'>Usuarios</option>
                                  <option value='categorias'>Categorias</option>" 
                                  : 
                                  "<option   value='tickets'>Tickets</option>
                                    <option value='usuarios'>Usuarios</option>
                                    <option value='categorias'>Categorias</option>";
$vista == "usuarios" ? $options = "<option value='tickets'>Tickets</option>
                                  <option value='usuarios' selected>Usuarios</option>
                                  <option value='categorias'>Categorias</option>" 
                                  : 
                                  "<option   value='tickets'>Tickets</option>
                                    <option value='usuarios'>Usuarios</option>
                                    <option value='categorias'>Categorias</option>";
$vista == "categorias" ? $options = "<option value='tickets'>Tickets</option>
                                  <option value='usuarios'>Usuarios</option>
                                  <option value='categorias' selected>Categorias</option>" 
                                  : 
                                  "<option   value='tickets'>Tickets</option>
                                    <option value='usuarios'>Usuarios</option>
                                    <option value='categorias'>Categorias</option>";
}
in_array(6, $_SESSION['Roles']) ? $options .= "<option value='compras'>Compras</option>" : "";
// $vista == "compras" ? $options = "<option value='compras' selected>Compras</option>" : "<option value='compras' selected>Compras</option>";
echo(
  "<div class='container'>
    <div class='row my-3'>
      <div class='col-md-6'>
        <form method='post' class=''>
          <div class='input-group'>
            <button class='btn btn-dark' type='submit'>Filtrar</button>
            <select class='form-select' name='vista'>
              <option selected disabled>Seleccione una vista</option>
              $options
            </select>
          </div>
        </form>
      </div>

      <div class='col-md-6'>
        <form method='post' class=''>
          <div class='input-group mr-3'>
            <button type='submit' name='submit' class='btn btn-dark'>Ver resultados</button>
            <input type='text' id='$vista' name='$vista' placeholder='Buscar $vista' class='form-control'>
          </div>
        </form>
      </div>
    </div>
  </div>");
?>