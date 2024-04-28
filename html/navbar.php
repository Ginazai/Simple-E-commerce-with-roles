<html lang="es">
  <head>
    <title>Serve.ware</title>
    <link rel="icon" type="image/png" sizes="70x70" href="html/assets/images/icons/icon.png">
    <meta charset="utf-8">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

    <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous"></script>

    <title>Helpdesk</title>

    <style>
      a {
        text-decoration: none !important;
      }
      html, body {
        height: 100%;
      }

      /* Chrome, Safari, Edge, Opera */
      input::-webkit-outer-spin-button,
      input::-webkit-inner-spin-button {
        -webkit-appearance: none;
        margin: 0;
      }

      /* Firefox */
      input[type=number] {
        -moz-appearance: textfield;
      }

      .card {
        box-shadow: 3px 4px 8px 0 rgba(0, 0, 0, 0.2) !important;
      }

      .card:hover {
        box-shadow: 3px 4px 14px 0 rgba(13, 202, 240, 0.3) !important;
        cursor: pointer;
        transform: scale(1.03) !important;
      }

      ul {
        list-style: none;
      }

      a {
        text-decoration: none;
      }

      .nav-link:hover {
        color:#0dcaf0 !important;
      }

      .nav-link.active {
        color:#0dcaf0 !important;
      }
    </style>

  </head>
  <body>
  <header class="container-fluid p-0">
    <div class="row flex-nowrap w-100">
      <div class="col-12 mx-auto text-center">
        <a class="blog-header-logo text-dark" href="<?= $home_url ?>" style="font-size: 2.25em;">Serve.ware<img class="mx-2" height="30" width="30" src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAADIAAAAyCAYAAAAeP4ixAAAACXBIWXMAAAsTAAALEwEAmpwYAAACTElEQVR4nO2ZsU4bQRCGPzi7pgw0pAqmgrPShTavQBmnSwPvEb8ENJDCRWgcp03JA9AEKFL7EBRgQxNstNJEWll7e2bv1rer+JdWPu3Je/Pvzsx/MwdL/D9oAz+BB+AeGAApkWEbGAPTmaHmWkSEMzG8B7yR0ZO570SETIxe1+Y2ZG5IJGhobqWMj45IA+gAV1pM9ORU1mNwrYaBwDUwMgT7KMRgbxgIqOvPck+l2h+SetXoA7sEhFVgH/itEfgDfBECwQtZUnACi7bHWciuF0wAMXjkIqw2IVskgX/ouwqrTcjGNcRA5iqsmUXI7lg87lyF9cwiZBPgBNj0bz+b8qyJq7C2LMH1JNfq9yuw5oHAmqytP2vsKqwmIduRXTrVdkm54QHQrIBAU9bKtNP/Brz1KazvgV/a7lyKQLriI3ChrXcO7FVhaBkDPlSwISvUAJNLnIobpqLCDzIG4hKzLnoDHFbkopUEaVcL0kdL0njUArnrKWlUljb/WhT5WU5EBXLwuLUoch3C6ows5lJ33jeEYEtdE1oiXrPBfh9iqVuEd8CRlmaPZC5aTGVEj2ldRNoVN5/LEmm72ONcI3sikrra41wjeyLS91GzD2sgkvmo2V2bD65EkjLNcJsiu7aDXkskAT5JfTKtumYflegwzkvERKBUMzyvRjY9aB5CRUTy1u34boa/tomdRySYZnhScEJbwLF271jmik6gNuT5dt7b71VoBObNNhsyegYC6j/BItHyf14zPGgCOpalbmiwCWt0pW4a+lfdJfCIF9JzmAbJezUhAAAAAElFTkSuQmCC"></a>
      </div>
    </div>

    <nav class="navbar navbar-expand-lg bg-dark" style="min-height:50px;">
        <div class="container-fluid">
          <a class="navbar-brand text-light" href="<?= $home_url ?>"><img width="35" height="35" src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAGQAAABkCAYAAABw4pVUAAAACXBIWXMAAAsTAAALEwEAmpwYAAAE20lEQVR4nO2dz48URRTHG5IFokTZJXqUC578A5QfkshZvHrzaMJVIBwkcvViwIsIQQ8cDQshHjm4qxeCIXJwgCWgiQkXDUscGBJ/wMeUU5NMamd6erq76lVXvU8yyWSmOvOqvtNd1fWd96YoFEVRFCUzgLeBs8Bt4Il9mOdfmvek48sGYAm4wmwum7bS8SYNsBPoUZ2fzTHScScLw2/9vCxLx50kwN4Jg/0dsB94wT7M85UJ7d6Sjj85gPPOIP8ELExotwDcdNqek4k6YYC7ziC/W9L2PaftnbDRZgAwcAb5lZK2rzptB2GjzQCg30CQx2GjTRzgJeCBM8iH5rhk3Q4bcdpCnAAeOgM8mtS3TDhmi07qYYUYZ8VuobxoHweAVTbyZtsxZgHVhZiHi9L9SlWIh8BJux1SFdNW97M8CHHCtLXHLFbcQrlk2vr8ImUthIvdJjljNxsf20fPvrZvwwHKRoDtwPEZQvSBT4EdOoaeUCEicejauDR1hWAOZh2HLjMhloI5mDUdupM5CCHiYNZ06JIXQsTBbOjQJS2EiIPZ0KFLVggxB7OhQ/cgVSHEHMyGDl2/SBxCO5gNP3C9SBzgUVAHE1hr4NDdKBIHuBHUwZwyaVV16P4CTqf4q0GG9x6nbR/rjk+tSX0P9R26EevAEWBr0XGArbYvpk8yDqb1FNrgF+B9YFPRMYBNNnbTB1kH056e8zh0vRmBX+uSVwHsszFP41fgVlAHcw6H7hvgZXtqH51xal8EdheRAuy2MU7DrLCO2b7umNHWj4NZ4tB9MWkroGTyi3biZ3bMfwOfT4rZbqWcsWfMk2gdTGAXcAF4PqWT69ZF3CYYo9ne+BD4veQbfhV4o0gFs7IAfijp8G/AB6EnfnP/ANwrieu6WS0VqRLLAFDtC2LOms1F6oxdIv4oGZBvfUz8FS6hj6QvoWI0mfgZLjLO2i2ekYd9x762v83Pyo6Ky8yjdpm5WPGG9ZJdko6W4e5m4DjLwOvS49DFG7G7c3rYpu39kvevTTqblPkn/qaIrOg6DdXu+Of1+NdHlz7p/nUWhpPxZ/bOt66H/RQ4pRN2u8Jcb+Bh/9hmLErx/yC7ly61lCWhmcevWbgeBFlzBlmzcCWhmcevpTU8CLKHjWgWriTU8/g1Czeyn/8veQtIKUYe/1clu7bY98yco3mKgc+Ww8CzMSGe2df0rJACB7FAlCEqSGSgZ0hckKsgsVaSJhJBos5Tz0kQOpCnvjMXQehInvpyRoJcDjY+XakkjZAgXctTP5eBIOeDjk9XKkkjJ0in8tQHGQgyCDo+DT/wzyJ9QfpdylMPVloDAUFEKm039LCDFZ8hoCCilbZbylP3LgwBBImm0naLeerehMEh6UrbNfLUTdtPQpb4wyH5Stt1KknbDn0cQhgcsqm0XaeSdIjqpLQgSHaVtn0WUqaBINkXePYxANQQJHshPF0iXrPlklw+Mu9NOSabAs8hJ9El4Gvg35Jj/rE/phtfZKgQnpaZParTy6nSdutQbY5pC/1bDA93yKvAO7ZAgLkfOAh8P+MYPSM8buYtxLbZmQVM3u7WStvCovQdQbTStrAggwaCaBauB0HWnEHWLFxJ0CzcuECzcOMDzcKNC+o5mJpv6FmURf0v3AihSw6doiiKohT++Q9icYUT76K8UwAAAABJRU5ErkJggg=="></a>
          <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
          </button>
          <div class="collapse navbar-collapse" id="navbarNavDropdown">
            <ul class="navbar-nav w-100 d-flex justify-content-center">
              <?php if(isset($_SESSION['user_data']['user_id'])):?>
                <?php if($_SESSION['user_data']['roles']['inventory']['read'] == 1) :?>
                <li class='nav-item'><a class='nav-link active text-light' href='<?= $customer_url ?>'>Catalogo</a></li>
                <?php endif;?>
                <?php if(false):?>
                <li class='nav-item'><a class='nav-link active text-light' href='<?= $index_url ?>'>Admin Compra</a></li>
                <?php endif;?>
              <?php if(false):?>
              <li class='nav-item'><a class='nav-link active text-light' href='<?= $index_url ?>'>Panel de admin</a></li>
              <li class="nav-item dropdown">
                <a class="nav-link text-light dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                  Crear nuevo...
                </a>
                <ul class="dropdown-menu">
                 
                    <li class="dropdown-item"><a href="<?= $ticket_url  ?>">Crear ticket</a></li>
                    <li class="dropdown-item"><a href="<?= $user_url  ?>">Crear usuario</a></li>
                    <li class="dropdown-item"><a href="<?= $category_url ?>">Crear categoria</a></li>                
                  
                </ul>
              </li>
              <?php endif;?>
              <?php endif;?>
              <!-- <li class="nav-item">
                <a class="nav-link text-light" href="#">Contacto</a>
              </li> -->
              <li class="nav-item ms-auto">
                <?= isset($_SESSION['user_data']["user_id"]) ? 
                "<button class='btn btn-outline-info float-end mx-2'><a class='text-info' href='$logout_url' style='text-decoration: none;'>Salir</a></button>" 
                  : 
                  "<button class='btn btn-outline-info float-end' type='submit' data-bs-toggle='modal' data-bs-target='#sign-modal'>Registrarse</button>
                  <button class='btn btn-outline-info float-end mx-2' type='submit' data-bs-toggle='modal' data-bs-target='#log-modal'>Ingresar</button>" ?>
              </li>
              </li>
            </ul>
          </div>
        </div>
      </nav>
  </header>
<?= isset($_SESSION['user_data']['user_id']) ? "" : 
"<!---------------------------------------------- Sign Modal ---------------------------------------------->
<div class='modal fade' id='sign-modal' tabindex='-1' aria-labelledby='modal-label' aria-hidden='true'>
  <div class='modal-dialog modal-dialog-centered'>
    <div class='modal-content'>
      <div class='modal-header bg-dark'>
        <h1 class='modal-title fs-5 text-white' id='modal-label'>Registrate</h1>
      </div>
      <div class='modal-body'>
        <div class='container-fluid justify-content-center form-signin'>
    <!--------------------------Sign-up Form -------------------------->
          <form id='registro' class='row g-3' role='form' name='registro' action='php/registro.php' method='post'>

            <div class='col-12 form-floating'>
                <input type='text' class='form-control' id='name' name='name' placeholder='Nombre'>
                <label for='name'>Nombre</label>
            </div>

            <div class='col-12 form-floating'>
                <input type='text' class='form-control' id='last-name' name='last-name' placeholder='Apellido'>
                <label for='last-name'>Apellido</label>
            </div>

            <div class='col-12 form-floating'>
              <input type='date' class='form-control' id='dob' name='dob' placeholder='Fecha de nacimiento'>
               <label for='dob'>Fecha de nacimiento</label>
            </div>

            <div class='col-12 form-floating'>
              <input type='email' class='form-control' id='email' name='email' placeholder='Correo Electronico'>
               <label for='email'>Correo Electronico</label>
            </div>

            <div class='input-group mb-3'>
              <span class='input-group-text'>+507</span>
              <input type='number' id='phone' name='phone' class='form-control' aria-label='Phone number'>
            </div>

            <div class='col-12 form-floating'>
              <input type='password' class='form-control' id='password' name='password' placeholder='Contrase&ntilde;a'>
               <label for='password'>Contrase&ntilde;a</label>
            </div>

            <div class='col-12 form-floating'>
              <input type='password' class='form-control' id='confirm_password' name='confirm_password' placeholder='Confirmar Contrase&ntilde;a'>
              <label for='confirm_password'>Repetir Contrase&ntilde;a</label>
            </div>
          </form>

<!--------------------------Sign-up Form -------------------------->
        </div>
      </div>

      <div class='modal-footer bg-dark'>
        <form>
          <button type='submit' form='registro' class='btn btn-info'>Registrarse</button>
          <button type='button' class='btn btn-secondary' data-bs-dismiss='modal'>Cerrar</button>
        </form>
      </div>
    </div>
  </div>
</div>
<!---------------------------------------------- Log in Modal ---------------------------------------------->
<div class='modal fade' id='log-modal' tabindex='-1' aria-labelledby='label' aria-hidden='true'>
  <div class='modal-dialog modal-dialog-centered'>
    <div class='modal-content'>
      <div class='modal-header bg-dark'>
        <h1 class='modal-title fs-5 text-white' id='label'>Ingresar</h1>
      </div>
      <div class='modal-body'>
        <div class='form-signin justify-content-center container-fluid'>

          <form id='login-form' class='row g-3' role='form' name='login-form' action='php/login.php' method='post'>
            <div class='form-floating'>
              <input type='text' class='form-control' id='email' name='email' placeholder='Email'>
              <label class='form-label' for='email'>Ingrese su direccion de correo electronico</label>
            </div>
            <div class='form-floating'>
              <input type='password' class='form-control' id='password' name='password' placeholder='Contrase&ntilde;a'>
              <label class='form-label' for='password'>Contrase&ntilde;a</label>
            </div>
          </form>

        </div>
      </div>
      <div class='modal-footer bg-dark'>
        <button type='submit' form='login-form' class='btn btn-info'>Acceder</button>
        <button type='button' class='btn btn-secondary' data-bs-dismiss='modal'>Cerrar</button>
      </div>
    </div>
  </div>
</div>
<!---------------------------------------------- Log in Modal ---------------------------------------------->" ?>