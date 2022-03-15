<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <title>AJAX Crud</title>
    <style>
        .tabla{
            max-height: 800px;
            overflow: auto;
        }
    </style>
</head>
<body>
    <div class="container">
        <label for="ciudad">Ciudad:</label>
        <input type="text" id="ciudad">
        <label for="direccion">Direccion:</label>
        <input type="text" id="direccion">
        <label for="telefono">Telefono:</label>
        <input type="number" id="telefono">
        <button type="button" id="enviar">Crear</button>
        <br>
        <hr>
        <br>
        <div class="container">
            <div class="row">
                <div class="col-8 tabla">
                    <table class="table-light">
                        <thead>
                            <tr>
                                <th scope="col">Id</th>
                                <th scope="col">Ciudad</th>
                                <th scope="col">Direccion</th>
                                <th scope="col">Telefono</th>
                                <th scope="col">Acciones</th>
                            </tr>
                        </thead>
                        <tbody id="cuerpoTabla"></tbody>
                    </table>
                </div>
                <div class="col-4 d-flex flex-column actualizar">
                </div>
            </div>
        </div>
    </div>
    <script type="text/javascript">
        
        seleccionar();

        function Crear_Funciones(id){
        // Crear botones de acción
          const botonEliminar = document.createElement("button");
            botonEliminar.id = "Borrar";
            botonEliminar.innerHTML = "Eliminar";
            botonEliminar.classList = "btn btn-danger";
          const botonActualizar = document.createElement("button");
            botonActualizar.id = "Editar";
            botonActualizar.innerHTML = "Actualizar";
            botonActualizar.classList = "btn btn-secondary";
          const contenido = document.createDocumentFragment();

          botonActualizar.addEventListener('click', () =>{editar(id);});

          botonEliminar.addEventListener('click', () => {eliminar(id);});
            
          contenido.appendChild(botonActualizar);
          contenido.appendChild(botonEliminar);

          return contenido;
        }

        function borrarFormEditar(div){
        // Borrar formulario Actualizar
            while (div.firstChild){
              div.removeChild(div.firstChild);
            }
        }

        function editar(id){
        // Editar
          fetch(`http://localhost/PruebaAPIrest/AJAXCrud/EditarContacto.php?id=${id}`, {
              method: "GET"
          })
          .then(function(response){
              if(response.ok){
                return response.text();
              }else{
                return "Error";
              }
          })
          .then(function(texto){
            
            const contenido = document.createDocumentFragment(),
                  div = document.querySelector('.actualizar');

            borrarFormEditar(div);
            
            const campoCiudad = document.createElement("input");
                    campoCiudad.type = "text";
                    campoCiudad.classList = "mt-3 form-control";
                    campoCiudad.id = "actCiudad";
            const campoDireccion = document.createElement("input");
                    campoDireccion.type = "text";
                    campoDireccion.classList = "mt-3 form-control";
                    campoDireccion.id = "actDireccion";
            const campoTelefono = document.createElement("input");
                    campoTelefono.type = "number";
                    campoTelefono.classList = "mt-3 form-control";
                    campoTelefono.id = "actTelefono";
            const btnActualizar = document.createElement("button");
                    btnActualizar.type = "button";
                    btnActualizar.classList = "btn btn-primary mt-3 form-control";
                    btnActualizar.innerHTML = "Actualizar";

            let json = JSON.parse(texto);
            json.forEach(element => {
              campoCiudad.value = element["Ciudad"];
              contenido.appendChild(campoCiudad);
              campoDireccion.value = element["Direccion"];
              contenido.appendChild(campoDireccion);
              campoTelefono.value = element["Telefono"];
              contenido.appendChild(campoTelefono);
              contenido.appendChild(btnActualizar);
              
              btnActualizar.addEventListener('click', () => {
                actualizar(id, div);
              });
            });
            div.appendChild(contenido);
          });
        }

        function seleccionar(){
        // Seleccionar
          fetch(`http://localhost/PruebaAPIrest/AJAXCrud/Seleccionar.php`, {
            method: "GET"
          })
          .then(function(response){
            if(response.ok){
              return response.text();
            }else{
              return "Error";
            }
          })
          .then(function(texto){
            const contentElements = document.querySelector('#cuerpoTabla'),
            $tempContent = document.createDocumentFragment();

            while (contentElements.firstChild){
              contentElements.removeChild(contentElements.firstChild);
            }

            let json = JSON.parse(texto);
            json.forEach(element => {
              const $tr = document.createElement("tr");

              const $td_id = document.createElement("td");
              $td_id.innerHTML = element["Id_Contacto"];
              $tr.appendChild($td_id);
                    
              const $td_ciudad = document.createElement("td");
              $td_ciudad.innerHTML = element["Ciudad"];
              $tr.appendChild($td_ciudad);

              const $td_direccion = document.createElement("td");
              $td_direccion.innerHTML = element["Direccion"];
              $tr.appendChild($td_direccion);

              const $td_telefono = document.createElement("td");
              $td_telefono.innerHTML = element["Telefono"];
              $tr.appendChild($td_telefono);

              const $td_Acciones = Crear_Funciones(element["Id_Contacto"]);
              $tr.appendChild($td_Acciones);

              $tempContent.appendChild($tr);
            });
            contentElements.appendChild($tempContent);
          });
        }

        document.querySelector('#enviar').addEventListener('click', () => {  
        // Insertar  
          let $ciudad = document.querySelector('#ciudad').value,
          $direccion = document.querySelector('#direccion').value,
          $telefono = document.querySelector('#telefono').value;

          let ciudad = document.querySelector('#ciudad'),
          direccion = document.querySelector('#direccion'),
          telefono = document.querySelector('#telefono');

          $ciudad = $ciudad.replace(/ /g, '%20');
          $direccion = $direccion.replace(/ /g, '%20');

          fetch(`http://localhost/PruebaAPIrest/AJAXCrud/CrearContacto.php?ciudad=${$ciudad}&direccion=${$direccion}&telefono=${$telefono}`, {
            method: "GET"
          })
          .then(function(response){
            if(response.ok){
              seleccionar();
              ciudad.value = "";
              direccion.value = "";
              telefono.value = "";
            }else{
              return "Error";
            }
          })
        });

        function eliminar (id){
        // Eliminar
          fetch(`http://localhost/PruebaAPIrest/AJAXCrud/BorrarContactos.php?id=${id}`,{
            method: "GET"
          })
          .then(function(response){
            if(response.ok){
              seleccionar();
            }else{
              return "Error";
            }
          });
        }

        function actualizar(id, div){
          let ciudad = document.querySelector('#actCiudad').value,
                direccion = document.querySelector('#actDireccion').value,
                telefono = document.querySelector('#actTelefono').value;

          ciudad = ciudad.replace(/ /g, '%20');
          direccion = direccion.replace(/ /g, '%20');

          fetch(`http://localhost/PruebaAPIrest/AJAXcrud/ActualizarContacto.php?id=${id}&ciudad=${ciudad}&direccion=${direccion}&telefono=${telefono}`, {
            method: "GET"
          })
          .then(function(response){
              if(response.ok){
                borrarFormEditar(div);
                seleccionar();
              }else{
                return "Error";
              }
          });
        }
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js" integrity="sha384-7+zCNj/IqJ95wo16oMtfsKbZ9ccEh31eOz1HGyDuCQ6wgnyJNSYdrPa03rtR1zdB" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js" integrity="sha384-QJHtvGhmr9XOIpI6YVutG+2QOK9T+ZnN4kzFN1RtK3zEFEIsxhlmWl5/YESvpZ13" crossorigin="anonymous"></script>
</body>
</html>