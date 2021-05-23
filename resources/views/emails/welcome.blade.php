<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="preconnect" href="https://fonts.gstatic.com">
<link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,200;1,100&display=swap" rel="stylesheet">
    <style>
    body{
        font-family: 'Poppins', sans-serif;
        margin-left: 10%;
        margin-right: 10%;
        font-size: 12px;
    }
    a{
        padding: 10px 10px;
        background-color: #8069c6;
        color: white;
        text-decoration: none;
    }
    .hola{
        font-size: 20px;
    }
    </style>
</head>
<body>
<!--
    <h1>Recordatorio de cita</h1>
    <p>Hola <b>{{ $customer->cus_name }}</b>, te recordamos que hoy, día <b>{{ $today }}</b> tienes un cita en nuestro salón <b>{{ $saloon->sal_name }}</b></p>
    <p>Te esperan con muchas ganas de realizar un buen servicio! </p>
    
    
-->

          <img src="https://ucarecdn.com/d8d98f52-0aa6-428a-8e8d-0c20c20ab0b9/logoprovisional.png" width="115" height="115" border="0" alt="" />
          <br><br>
           <p class="hola">Hola <b>{{ $customer->cus_name }}</b>,</p>  
           <br>       
           <p>Te recordamos que hoy, día <b>{{ $today }}</b> tienes un cita en nuestro salón <b>{{ $saloon->sal_name }}</b></p>  
           <br>   
           <a href="https://carendar-ca.herokuapp.com/">Visita nuestra web</a>
           <br>    <br>   
           <p>Atentamente:</p>
           <p>El equipo de Carendar</p>     
</body>
</html>
