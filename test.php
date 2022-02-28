<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- CSS only -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <title>Esto es una pestaña</title>
    <style>

            *{
                margin:0px;
            }

    </style>
</head>
<body>
    <div class="row justify-content-center">
    <div style="background-color:orange;" class="col-12 col-md-4 p-3">
    <h2>Esto es un titulo</h2>
    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Architecto excepturi molestiae quia assumenda eaque deserunt inventore doloribus consequuntur et in tempore illum, sunt repellat earum laboriosam quisquam eligendi laudantium odio.</p>
    <span>Esrto es un texto corto</span><br>
    <b>Esto es un texto en negritas</b>

    <h3>Elemetnos de un formulario</h3>
    <label for="usuario">Nombre de usuario</label>
    <input class="form-control" type="text" id="usuario" placeholder="usuario"><br>
    <label for="pass">Contraseña</label>
    <input class="form-control" type="password" placeholder="password"><br>
    <label for="edad">edad</label>
    <input class="form-control"  type="number" placeholder="0"><br>
    <label for="">Sexo</label>
    <input  type="radio" value="hombre" name="sex" id="hombre">Hombre 
    <input  type="radio" value="mujer" name="sex" id="mujer">Mujer
    Selecciona tus frutas favoritas
    <input  type="checkbox" value="">Fresa<input type="checkbox" value="">Naranja
    <input  type="checkbox" value="">melon
    <input  type="checkbox" value="">Papaya.
    <input class="form-control" type="date">
    <input class="form-control" type="file">
    <input type="button" onclick="Enviar();" value="Enviar">
    </div>
    </div>
        </div>
    
</body>
<!-- JavaScript Bundle with Popper -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
<script>

    function Enviar(){
        var usuario = document.getElementById("usuario").value;
        console.log(usuario);

        alert(usuario);
    }

    var usuario = document.getElementById("usuario");
    usuario.addEventListener("keyup", function(){
        key = this.value;
        console.log(key);
    })

    
</script>
</html>