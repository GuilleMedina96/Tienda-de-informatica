<?php

session_start();

session_destroy();


header("location: index.php"); // lo redirigimos al usuario al index donde no esta registrado ni ha iniciado sesion
exit();

?>