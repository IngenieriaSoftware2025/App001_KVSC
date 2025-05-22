<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="build/js/app.js"></script>
    <link rel="shortcut icon" href="<?= asset('images/cora.png') ?>" type="image/x-icon">
    <link rel="stylesheet" href="<?= asset('build/styles.css') ?>">
    <title>App de María</title>
    <style>
        body{
            background-color:rgb(240, 199, 234);
        }
        .btn-thistle {
            background-color: palevioletred; 
            color: black; 
            border-color: pink; 
        }
        .btn-pink {
            background-color: papayawhip; 
            color: black; 
            border-color: purple; 
        }
        .btn-midni {
            background-color: midnightblue;
            color: white;
            border-color: thistle;
        }
        .table {
            border-radius: 8px;
            overflow: hidden;
        }

        .table thead th {
            background-color:rgb(11, 1, 56);
            color: white;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            font-size: 0.8rem;
            padding: 1rem;
            border: none;
        }

        .table tbody td {
            padding: 0.875rem;
            vertical-align: middle;
            border-color: #f3f4f6;
        }

        .table tbody tr:hover {
            background-color: #f9fafb;
        }
    </style>
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        
        <div class="container-fluid">

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarToggler" aria-controls="navbarToggler" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <a class="navbar-brand" href="/App001_KVSC/">
                <img src="<?= asset('./images/flor.png') ?>" width="50px'" alt="rose" >
                ¡Bienvenida a bordo!
            </a>
            <div class="collapse navbar-collapse" id="navbarToggler">
                
                <ul class="navbar-nav me-auto mb-2 mb-lg-0" style="margin: 0;">
                         <li class="nav-item">
                        <a class="nav-link" aria-current="page" href="/App001_KVSC/productos"><i class="bi bi-bookmark-star"></i> Productos</a>
                    </li>
                     <li class="nav-item">
                        <a class="nav-link" aria-current="page" href="/App001_KVSC/categoria"><i class="bi bi-card-checklist"></i> Categorias</a>
                    </li>
                         <li class="nav-item">
                        <a class="nav-link" aria-current="page" href="/App001_KVSC/"><i class="bi bi-emoji-heart-eyes-fill"></i> Bendecido sea tu día María</a>
                    </li>
                    </div> 

                </ul> 
                <div class="col-lg-1 d-grid mb-lg-0 mb-2">
                    <!-- Botón de acceso rápido a productos en la parte derecha -->
                    <a href="/App001_KVSC/productos" class="btn btn-pink">
                        <i class="bi bi-cart-check-fill"></i> Mi Lista
                    </a>
                </div>

            
            </div>
        </div>
        
    </nav>
    <div class="progress fixed-bottom" style="height: 6px;">
        <div class="progress-bar progress-bar-animated bg-danger" id="bar" role="progressbar" aria-valuemin="0" aria-valuemax="100"></div>
    </div>
    <div class="container-fluid pt-5 mb-4" style="min-height: 85vh">
        
        <?php echo $contenido; ?>
    </div>
    <div class="container-fluid" >
        <div class="row justify-content-center text-center">
            <div class="col-12">
                <p style="font-size:small; font-weight: bold;">
                        Sigue avanzando, cada paso cuenta. El mundo necesita tu luz, no dejes de brillar.
                </p>
            </div>
        </div>
    </div>
</body>
</html>