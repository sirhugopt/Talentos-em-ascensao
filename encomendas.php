<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "sql_hugo_igr05_p";

// Crie a conexão
$conn = new mysqli($servername, $username, $password, $dbname);

// Verifique a conexão
if ($conn->connect_error) {
    die("Conexão falhou: " . $conn->connect_error);
}

// SQL para buscar os dados
$sql = "SELECT imagem_produto FROM loja";
$result = $conn->query($sql);

$images = [];
if ($result->num_rows > 0) {
    // Pegue todos os dados
    while($row = $result->fetch_assoc()) {
        $images[] = $row['imagem_produto'];
    }
} else {
    echo "0 resultados";
}
$conn->close();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Talentos em Ascensão</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="" name="keywords">
    <meta content="" name="description">

    <!-- Favicon -->
    <link href="img/favicon.ico" rel="icon">

    <!-- Google Web Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;500&family=Roboto:wght@500;700;900&display=swap" rel="stylesheet"> 

    <!-- Icon Font Stylesheet -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">

    <!-- Libraries Stylesheet -->
    <link href="lib/animate/animate.min.css" rel="stylesheet">
    <link href="lib/owlcarousel/assets/owl.carousel.min.css" rel="stylesheet">
    <link href="lib/tempusdominus/css/tempusdominus-bootstrap-4.min.css" rel="stylesheet" />

    <!-- Customized Bootstrap Stylesheet -->
    <link href="css/bootstrap.min.css" rel="stylesheet">

    <!-- Template Stylesheet -->
    <link href="css/style.css" rel="stylesheet">
    <link href="encomendas.css" rel="stylesheet">

    <style>
       /* ----- Variables ----- */
$color-primary: #4c4c4c;
$color-secondary: #a6a6a6;
$color-highlight: #ff3f40;

/* ----- Global ----- */
* {
	box-sizing: border-box;
}



h3 {
	font-size: 0.7em;
	letter-spacing: 1.2px;
	color: $color-secondary;
}

img {
			max-width: 100%;
			filter: drop-shadow(1px 1px 3px $color-secondary);
		}

/* ----- Product Section ----- */
.product {
	display: grid;
	grid-template-columns: 0.9fr 1fr;
	margin: auto;
	padding: 2.5em 0;
	min-width: 600px;
	background-color: white;
	border-radius: 5px;
}

/* ----- Photo Section ----- */
.product__photo {
	position: relative;
}

.photo-container {
	position: absolute;
	left: -2.5em;
	display: grid;
	grid-template-rows: 1fr;
	width: 100%;
	height: 100%;
	border-radius: 6px;
	box-shadow: 4px 4px 25px -2px rgba(0, 0, 0, 0.3);
}

.photo-main {
	border-radius: 6px 6px 0 0;
	background-color: #9be010;
	background: radial-gradient(#e5f89e, #96e001);

	.controls {
		display: flex;
		justify-content: space-between;
		padding: 0.8em;
		color: #fff;

		i {
			cursor: pointer;
		}
	}

	img {
		position: absolute;
		left: -3.5em;
		top: 2em;
		max-width: 110%;
		filter: saturate(150%) contrast(120%) hue-rotate(10deg)
			drop-shadow(1px 20px 10px rgba(0, 0, 0, 0.3));
	}
}

.photo-album {
	padding: 0.7em 1em;
	border-radius: 0 0 6px 6px;
	background-color: #fff;

	ul {
		display: flex;
		justify-content: space-around;
	}

	li {
		float: left;
		width: 55px;
		height: 55px;
		padding: 7px;
		border: 1px solid $color-secondary;
		border-radius: 3px;
	}
}

/* ----- Informations Section ----- */
.product__info {
	padding: 0.8em 0;
}

.title {
	h1 {
		margin-bottom: 0.1em;
		color: $color-primary;
		font-size: 1.5em;
		font-weight: 900;
	}

	span {
		font-size: 0.7em;
		color: $color-secondary;
	}
}

.price {
	margin: 1.5em 0;
	color: $color-highlight;
	font-size: 1.2em;

	span {
		padding-left: 0.15em;
		font-size: 2.9em;
	}
}

.variant {
	overflow: auto;

	h3 {
		margin-bottom: 1.1em;
	}

	li {
		float: left;
		width: 35px;
		height: 35px;
		padding: 3px;
		border: 1px solid transparent;
		border-radius: 3px;
		cursor: pointer;

		&:first-child,
		&:hover {
			border: 1px solid $color-secondary;
		}
	}

	li:not(:first-child) {
		margin-left: 0.1em;
	}
}

.description {
	clear: left;
	margin: 2em 0;

	h3 {
		margin-bottom: 1em;
	}

	ul {
		font-size: 0.8em;
		list-style: disc;
		margin-left: 1em;
	}

	li {
		text-indent: -0.6em;
		margin-bottom: 0.5em;
	}
}

.buy--btn {
	padding: 1.5em 3.1em;
	border: none;
	border-radius: 7px;
	font-size: 0.8em;
	font-weight: 700;
	letter-spacing: 1.3px;
	color: #fff;
	background-color: $color-highlight;
	box-shadow: 2px 2px 25px -7px $color-primary;
	cursor: pointer;

	&:active {
		transform: scale(0.97);
	}
}

/* ----- Footer Section ----- */
footer {
	padding: 1em;
	text-align: center;
	color: #fff;

	a {
		color: $color-primary;

		&:hover {
			color: $color-highlight;
		}
	}
}

    </style>
</head>

<body>
    <!-- Spinner Start -->
    <div id="spinner" class="show bg-white position-fixed translate-middle w-100 vh-100 top-50 start-50 d-flex align-items-center justify-content-center">
        <div class="spinner-grow text-primary" style="width: 3rem; height: 3rem;" role="status">
            <span class="sr-only">Loading...</span>
        </div>
    </div>
    <!-- Spinner End -->


    <!-- Topbar Start -->
    <div class="container-fluid bg-light p-0 wow fadeIn" data-wow-delay="0.1s">
        <div class="row gx-0 d-none d-lg-flex">
            <div class="col-lg-7 px-5 text-start">
                <div class="h-100 d-inline-flex align-items-center py-3 me-4">
                    <small class="fa fa-map-marker-alt text-primary me-2"></small>
                    <small>Rua São Francisco Xavier, Alto do Forte, 2635-195 Rio de Mouro</small>
                </div>
                <div class="h-100 d-inline-flex align-items-center py-3">
                    <small class="far fa-clock text-primary me-2"></small>
                    <small>Segunda - Sexta : 09.00 - 20:00</small>
                </div>
            </div>
            <div class="col-lg-5 px-5 text-end">
                <div class="h-100 d-inline-flex align-items-center py-3 me-4">
                    <small class="fa fa-phone-alt text-primary me-2"></small>
                    <small>+351 967 845 634</small>
                </div>
                <div class="h-100 d-inline-flex align-items-center">
                    <a class="btn btn-sm-square rounded-circle bg-white text-primary me-1" href=""><i class="fab fa-facebook-f"></i></a>
                    <a class="btn btn-sm-square rounded-circle bg-white text-primary me-1" href=""><i class="fab fa-twitter"></i></a>
                    <a class="btn btn-sm-square rounded-circle bg-white text-primary me-1" href=""><i class="fab fa-linkedin-in"></i></a>
                    <a class="btn btn-sm-square rounded-circle bg-white text-primary me-0" href=""><i class="fab fa-instagram"></i></a>
                </div>
            </div>
        </div>
    </div>
    <!-- Topbar End -->


    <!-- Navbar Start -->
    <nav class="navbar navbar-expand-lg bg-white navbar-light sticky-top p-0 wow fadeIn" data-wow-delay="0.1s">
        <a href="index.php" class="navbar-brand d-flex align-items-center px-4 px-lg-5">
            <h1 class="m-0 text-primary"><img src="img/5.png" alt="Seu Logo"style="width: 80px; height: 80px;"></i>Talentos em Ascensão</h1>
        </a>
        <button type="button" class="navbar-toggler me-4" data-bs-toggle="collapse" data-bs-target="#navbarCollapse">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarCollapse">
            <div class="navbar-nav ms-auto p-4 p-lg-0">
               <a href="index.php" class="nav-item nav-link">Início</a>
                <a href="about.html" class="nav-item nav-link">Sobre Nós</a>
                <a href="feature.html" class="nav-item nav-link">Instalações</a>
                <a href="sersocio.html" class="nav-item nav-link">Ser Sócio</a>
                <a href="contacto.php" class="nav-item nav-link">Contatos</a>
                <a href="Loginn.php" class="nav-item nav-link">LOGIN</i></a>

            </div>
            
          

    </nav>


    <!-- Page Header Start -->
    <!-- Page Header End -->


    <!-- About Start -->
    <div class="container-xxl py-5">
    <div class="container">
        <div class="row g-5">
            <div class="col-lg-6 wow fadeIn d-flex justify-content-center align-items-center" data-wow-delay="0.1s">
                <section class="product">
                    <div class="product__photo">
                        <div class="photo-container">
                            <div class="photo-main">
                                <div class="controls">
                                    <i class="material-icons">share</i>
                                    <i class="material-icons">favorite_border</i>
                                </div>
                                <img src="https://res.cloudinary.com/john-mantas/image/upload/v1537291846/codepen/delicious-apples/green-apple-with-slice.png" alt="green apple slice">
                            </div>
                            <div class="photo-album">
                                <ul>
                                    <li><img src="https://res.cloudinary.com/john-mantas/image/upload/v1537302064/codepen/delicious-apples/green-apple2.png" alt="green apple"></li>
                                    <li><img src="https://res.cloudinary.com/john-mantas/image/upload/v1537303532/codepen/delicious-apples/half-apple.png" alt="half apple"></li>
                                    <li><img src="https://res.cloudinary.com/john-mantas/image/upload/v1537303160/codepen/delicious-apples/green-apple-flipped.png" alt="green apple"></li>
                                    <li><img src="https://res.cloudinary.com/john-mantas/image/upload/v1537303708/codepen/delicious-apples/apple-top.png" alt="apple top"></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="product__info">
                        <div class="title">
                            <h1>Delicious Apples</h1>
                            <span>COD: 45999</span>
                        </div>
                        <div class="price">
                            R$ <span>7.93</span>
                        </div>
                        <div class="variant">
                            <h3>SELECT A COLOR</h3>
                            <ul>
                                <li><img src="https://res.cloudinary.com/john-mantas/image/upload/v1537302064/codepen/delicious-apples/green-apple2.png" alt="green apple"></li>
                                <li><img src="https://res.cloudinary.com/john-mantas/image/upload/v1537302752/codepen/delicious-apples/yellow-apple.png" alt="yellow apple"></li>
                                <li><img src="https://res.cloudinary.com/john-mantas/image/upload/v1537302427/codepen/delicious-apples/orange-apple.png" alt="orange apple"></li>
                                <li><img src="https://res.cloudinary.com/john-mantas/image/upload/v1537302285/codepen/delicious-apples/red-apple.png" alt="red apple"></li>
                            </ul>
                        </div>
                        <div class="description">
                            <h3>BENEFITS</h3>
                            <ul>
                                <li>Apples are nutricious</li>
                                <li>Apples may be good for weight loss</li>
                                <li>Apples may be good for bone health</li>
                                <li>They're linked to a lowest risk of diabetes</li>
                            </ul>
                        </div>
                        <button class="buy--btn">ADD TO CART</button>
                    </div>
                </section>
            </div>
        </div>
    </div>
</div>

    <!-- About End -->


    <!-- Feature Start -->
   

    <!-- Team Start -->
    
    <!-- Team End -->
        

    <!-- Footer Start -->
    <div class="container-fluid bg-dark text-light footer mt-5 pt-5 wow fadeIn" data-wow-delay="0.1s">
        <div class="container py-5">
            <div class="row g-5">
                <div class="col-lg-3 col-md-6">
                    <h5 class="text-light mb-4">Adereço</h5>
                    <p class="mb-2"><i class="fa fa-map-marker-alt me-3"></i>Rua São Francisco Xavier, Alto do Forte, 2635-195 Rio de Mouro</p>
                    <p class="mb-2"><i class="fa fa-phone-alt me-3"></i>+351 967 845 634</p>
                    <p class="mb-2"><i class="fa fa-envelope me-3"></i>talentosemascencao@afl.pt</p>
                    <div class="d-flex pt-2">
                        <a class="btn btn-outline-light btn-social rounded-circle" href=""><i class="fab fa-twitter"></i></a>
                        <a class="btn btn-outline-light btn-social rounded-circle" href=""><i class="fab fa-facebook-f"></i></a>
                        <a class="btn btn-outline-light btn-social rounded-circle" href=""><i class="fab fa-youtube"></i></a>
                        <a class="btn btn-outline-light btn-social rounded-circle" href=""><i class="fab fa-linkedin-in"></i></a>
                    </div>
             
    <!-- Footer End -->


    <!-- Back to Top -->
    <a href="#" class="btn btn-lg btn-primary btn-lg-square rounded-circle back-to-top"><i class="bi bi-arrow-up"></i></a>


    <!-- JavaScript Libraries -->
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="lib/wow/wow.min.js"></script>
    <script src="lib/easing/easing.min.js"></script>
    <script src="lib/waypoints/waypoints.min.js"></script>
    <script src="lib/counterup/counterup.min.js"></script>
    <script src="lib/owlcarousel/owl.carousel.min.js"></script>
    <script src="lib/tempusdominus/js/moment.min.js"></script>
    <script src="lib/tempusdominus/js/moment-timezone.min.js"></script>
    <script src="lib/tempusdominus/js/tempusdominus-bootstrap-4.min.js"></script>

    <!-- Template Javascript -->
    <script src="js/main.js"></script>
</body>

</html>