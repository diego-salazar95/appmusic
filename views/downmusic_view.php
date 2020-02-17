<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <title> Download available: </title>
</head>
<body>
    <p class="h1"> Download available: </p>
    <form action="" method="post">
        <label for="cancion"> <p class="h4">  Available songs: </p> </label> <br>
        <select name="cancion" size='15'>
            <?php
                foreach ($canciones as $cancion) {
                    echo "<option> $cancion </option>";
                    }
            ?> 
        </select>
        <br>
        <br>
        <input type="submit" value="Add Song" name="boton_descargar" class="btn btn-primary">
        <input type="submit" value="Buy" name="boton_realizar" class="btn btn-primary">
        </form>
        <br>
    <p class="h4"> Songs added to download: </p> <br>
</body>
</html>