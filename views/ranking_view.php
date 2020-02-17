<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <title> Factura por fechas</title>
</head>
<body>
    <p class="h1"> Seleccione las fechas a revisar </p>
    <form action="" method="post">
        <label for="fecha1"> De: </label>
        <input type="date" name="fecha1" required>
        <label for="fecha2"> a: </label>
        <input type="date" name="fecha2" required>
        <input type="submit" value="Consultar" name="consultar">
    </form>
    <br>
</body>
</html>