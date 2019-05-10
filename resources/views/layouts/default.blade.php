<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Laravel Checkout Transparente - School of Net</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">

    <style>
    .credit_card
    {
        border: 1px solid;
    }
    </style>
</head>
<body>
    <header id="header" class="row">
        <nav>
            <div class="nav-wrapper col s12 black">
               <a href="#" class="brand-logo" >iStore</a> 
               <ul class="right">
                   <li><a href="#" >Minha Conta</a></li>
                   <li><a href="#" >Ajuda</a></li>
                   <li><a href="#" >Sair</a></li>
               </ul>
            </div>
        </nav>

        <div class="parallax-container">
            <div class="parallax">
                <img src="/img/fundo.png" alt="">
            </div>
        </div>
    </header>
    
    <main>
        <section class="container">
                @yield('content')
        </section>
    </main>
    

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.0/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>


<script>
$(document).ready(function(){
    $('.parallax').parallax();
});
</script>

@yield('script')

</body>
</html>