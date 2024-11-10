<?php 
function isEmail($email) {
	return(preg_match("/^[-_.[:alnum:]]+@((([[:alnum:]]|[[:alnum:]][[:alnum:]-]*[[:alnum:]])\.)+(ad|ae|aero|af|ag|ai|al|am|an|ao|aq|ar|arpa|as|at|au|aw|az|ba|bb|bd|be|bf|bg|bh|bi|biz|bj|bm|bn|bo|br|bs|bt|bv|bw|by|bz|ca|cc|cd|cf|cg|ch|ci|ck|cl|cm|cn|co|com|coop|cr|cs|cu|cv|cx|cy|cz|de|dj|dk|dm|do|dz|ec|edu|ee|eg|eh|er|es|et|eu|fi|fj|fk|fm|fo|fr|ga|gb|gd|ge|gf|gh|gi|gl|gm|gn|gov|gp|gq|gr|gs|gt|gu|gw|gy|hk|hm|hn|hr|ht|hu|id|ie|il|in|info|int|io|iq|ir|is|it|jm|jo|jp|ke|kg|kh|ki|km|kn|kp|kr|kw|ky|kz|la|lb|lc|li|lk|lr|ls|lt|lu|lv|ly|ma|mc|md|me|mg|mh|mil|mk|ml|mm|mn|mo|mp|mq|mr|ms|mt|mu|museum|mv|mw|mx|my|mz|na|name|nc|ne|net|nf|ng|ni|nl|no|np|nr|nt|nu|nz|om|org|pa|pe|pf|pg|ph|pk|pl|pm|pn|pr|pro|ps|pt|pw|py|qa|re|ro|ru|rw|sa|sb|sc|sd|se|sg|sh|si|sj|sk|sl|sm|sn|so|sr|st|su|sv|sy|sz|tc|td|tf|tg|th|tj|tk|tm|tn|to|tp|tr|tt|tv|tw|tz|ua|ug|uk|um|us|uy|uz|va|vc|ve|vg|vi|vn|vu|wf|ws|ye|yt|yu|za|zm|zw)$|(([0-9][0-9]?|[0-1][0-9][0-9]|[2][0-4][0-9]|[2][5][0-5])\.){3}([0-9][0-9]?|[0-1][0-9][0-9]|[2][0-4][0-9]|[2][5][0-5]))$/i",$email));
}

if($_POST) {
	$salida = '';
	if (!defined("PHP_EOL")) 
		define("PHP_EOL", "\r\n");
	$name     	= $_POST["name"] ?? '';
	$fono    	= $_POST["fono"] ?? '';
	$email    	= $_POST["email"] ?? '';
	$curso    	= $_POST["curso"] ?? '';
	$comment 	= $_POST["comment"] ?? '';

	$name 		= trim($name);
	$fono 		= trim($fono);
	$email 		= trim($email);
	$curso 		= trim($curso);
	$comment 	= trim($comment);
	$comment 	= str_replace("\n", "<br>", $comment);
	
	$captcha = "";
	$response = "";
	if(isset($_POST['g-recaptcha-response']))
	  $captcha=$_POST['g-recaptcha-response']; 
	if($captcha == "")
	{
		$salida = '<div class="error_message" style="color:red !important;">Debes seleccionar el reCapcha de Google es por seguridad de tus datos y de nuestro sitio Advance.</div>'; 
	} 
/*	else 
	{ 
		$secret = '6LdY4KwUAAAAAO22zu-oz5URs6sH59ev0wv5glUO';
        $verifyResponse = file_get_contents('https://www.google.com/recaptcha/api/siteverify?secret='.$secret.'&response='.$_POST['g-recaptcha-response']);
		//https://www.google.com/recaptcha/api/siteverify?secret=6LdY4KwUAAAAAO22zu-oz5URs6sH59ev0wv5glUO&response=03AOLTBLRLXQbJb5aEkB-IZmfa7YMObiVkZDrRSkiSfSNxVMpEd85lD5t8LRZUpITSqsHSN7LJsiQPK5o11ik51_rXoX3aO9D4agsXa4d_9Mp85rFWqUvOBpP3_LsMm2Bzya7-oDTVvHuNLXi5Fh6WvugmMBTTZ7quIhtkzIRE6hxR-1KbydK-n8kMTM5SoOPSb3UYnWnieSiD--ux64cm67xffWel_IOvp1dzZrNuSZE4TWP4ILOKGrYcrZf_KkfOHKNWQZbpM_Sm7PSSGtDL0xdfGc6iwBnW5Yf6ou1DYT8sm2w2JdOQYGuZAtpRdeikmYS_9lfS2qGsbAhv_VknUjmjx29nEc5sTTDFzAA9lDCFhtKAvd2twkIhKwwaEcVuwbmaWP7lj7vwwOOGhclmLM7BUjDMu6YTyA
        $responseData = json_decode($verifyResponse);
        if($responseData->success)
		{
			$salida = '';
		}
		else
		{
			$salida = '<div class="error_message" style="color:red !important;">Debes seleccionar el reCapcha de Google para verificar que no eres un robot. </div>';
		}
		$salida = $salida.'<br><br><div class="error_message" style="color:blue !important;">robot:'.strval($response["success"]).'_  -    captcha:'.$captcha.'_</div>';
	}	
*/	
	if(trim($name) == '') {
		$salida = $salida.'<div class="error_message" style="color:red !important;">Favor ingresar tu nombre.</div>';
	} else
	if(trim($email) == '') {
		$salida = $salida.'<div class="error_message" style="color:red !important;">Favor ingresar una casilla de correo electrónico.</div>';
	} else
	if(!isEmail($email)) {
		$salida = $salida.'<div class="error_message" style="color:red !important;">Favor ingresar una casilla de correo electrónico válida.</div>';
	} else
	if(trim($comment) == '') {
		$salida = $salida.'<div class="error_message" style="color:red !important;">Favor ingresar un mensaje.</div>';
	}	
	
	if(trim($curso) == '') {
		$curso = ' -No Definido- ';
	}
	if(get_magic_quotes_gpc()) {
		$comment = stripslashes($comment);
	}

	if ($salida == '')
	{
		require 'PHPMailer_5.2.4/class.phpmailer.php';

		try {
			$mail = new PHPMailer(true);  
			$mail->CharSet = "UTF-8";

			$body1 =  "<strong>¡Te damos la bienvenida a la comunidad de aprendizaje de Otec Advance!</strong><br>Te agradecemos tu mensaje, lo canalizaremos y a la brevedad nos pondremos en contacto.<br><br>";
			$body2 =  "Datos Cliente: <strong>".$name."<".$email."></strong><br>Teléfono: ".$fono."<br>Curso referencial: ".$curso."<br>Mensaje: <br><i>".$comment."</i><br><br>";
			$body3 =  "¿Necesitas más ayuda? Nuestro equipo de asistencia puede resolver tus dudas para ponerte en marcha rápidamente. <br>Ponte en contacto con nosotros: <br>"; 
			$body4 =  "<ul><li>Mesa Central: +56 2 2300 1263</li><li>eMail: comercial@otecadvance.com</li><li>Asistencia Cursos: +56 9 9485 4094</li><li>eMail: seguimiento@otecadvance.com</li><li>Dirección:  Almirante Zegers #764, Providencia - Santiago.</li><li>http://OtecAdvance.com</li></ul>";
			$body5 =  "Atentamente,<br><strong>El Equipo Comercial Advance</strong>";
			
			$body = wordwrap( $body1 . $body2 . $body3 . $body4 . $body5, 70 );

			$body = preg_replace('/\\\\/','', $body);

			$mail->IsSMTP(); 
			$mail->Host = "ssl://smtp.gmail.com"; 
			$mail->Port = 465; 
			$mail->SMTPAuth = true;  
			$mail->Username   = "mazaad@otecadvance.com";      
			$mail->Password   = "emersoncito7.";           

			$mail->IsSendmail(); 
			$mail->From       = "mazaad@otecadvance.com";
			$mail->FromName   = "Advance Comercial";
			$mail->AddAddress($email);
			$mail->AddBCC("otecadvance@gmail.com");
			//$mail->AddBCC("marceazaad@hotmail.com");
			$mail->Subject  = "Contacto website Advance"; 
			$mail->WordWrap   = 80; 

			$mail->MsgHTML($body);
			$mail->IsHTML(true); 
			
			$mail->Send();
			$salida = "<div class='ok_message'><p>Gracias <strong>$name</strong>, tu mensaje ha sido enviado.</p></div>";
			
			if (!empty($_SERVER["HTTP_CLIENT_IP"]))
			  $ip = $_SERVER["HTTP_CLIENT_IP"];
			elseif (!empty($_SERVER["HTTP_X_FORWARDED_FOR"]))
			  $ip = $_SERVER["HTTP_X_FORWARDED_FOR"];
			else
			  $ip = $_SERVER["REMOTE_ADDR"];

			$mysql_user="otecadva_sa";
			$mysql_password="sa2015";
			$base_datos = "otecadva_evaluacion";

			$con = mysqli_connect("localhost", $mysql_user, $mysql_password, $base_datos);
			if (mysqli_connect_errno()) {
			  echo "Failed to connect to MySQL: " . mysqli_connect_error();
			  exit();
			}

			$queryInsert = "INSERT INTO contactoSitio (nombres, fono, email, curso, comentarios, ip, fecha) VALUES ('$name', '$fono', '$email', '$curso', '$comment', '$ip', CURRENT_TIMESTAMP)";
			//$resultInsert = mysql_query($queryInsert) or die ("Error Insert ($queryInsertContactos).");
			$resultInsert = mysqli_query($con, $queryInsert) or die ("Error Insert ($queryInsertContactos).");
					
			mysqli_close($con);
		} 
		catch (phpmailerException $e) {
			$salida = "<div class='error_message' style='color:red !important;'>Inconveniente en el envío: ".$e->errorMessage()."</div>"; 
		}
	}
}
else { //if($_POST)
	if(isset($_GET["email"])) {
		$mailPromo = htmlspecialchars($_GET["email"]);
		$mailPromo 	= trim($mailPromo);
		$mailPromo 	= str_replace("%20", "", $mailPromo);
		if(trim($mailPromo) != '') {
			$email = $mailPromo;
			$corte = explode("@",$email );
			$name = $corte[0];
		}
	} 
	if(isset($_GET["utm_campaign"])) {
		$nombrePromo = htmlspecialchars($_GET["utm_campaign"]);
		$nombrePromo 	= trim($nombrePromo );
		if(trim($nombrePromo ) != '') {
			$curso = $nombrePromo ;
		}
	} 
}

?>

<!DOCTYPE html>
<!--[if IE 8 ]><html class="ie ie8" lang="en"> <![endif]-->
<!--[if (gte IE 9)|!(IE)]><!--><html class="no-js" lang="en"> <!--<![endif]-->
<head>
	<meta http-equiv="content-type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
	<title>Instituto de Capacitación Advance   |  Formulario de Contacto</title>
	<meta name="description" content="Advance, equipo humano con vasta experiencia en capacitacion a distancia, nunca estaras solo durante el proceso de capacitacion. ">
	<meta name="keywords" content="capacitacion a distancia, e-learning,legislacion laboral, office, excel, macros, tablas dinamicas, estatuto administrativo, administracion del tiempo">
	<link rel="icon" type="image/png" href="favicon.png">

    <!-- CSS FILES -->
    <link rel="stylesheet" href="css/bootstrap.min.css"/>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" type="text/css" href="css/style.css" media="screen" data-name="skins">
    <link rel="stylesheet" href="css/layout/wide.css" data-name="layout">
	<link href="https://use.fontawesome.com/releases/v5.0.8/css/all.css" rel="stylesheet">
	<link href="https://use.fontawesome.com/releases/v5.0.8/css/all.css" rel="stylesheet">
	
	<script src="https://www.google.com/recaptcha/api.js" async defer></script> 
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js"></script>
	<script src="js/jquery.flexslider.js"></script>
	<script src="js/default.js"></script>
 
    <script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-60444977-1', 'auto');
  ga('send', 'pageview');

</script> 
</head>
<body>
<!--Start Header-->
<header id="header">
    <div id="top-bar">
        <div class="container">
            <div class="row">
                	&nbsp;<span><i class="fas fa-phone" style="font-size:1em; color:#F79522;"></i>&nbsp;Mesa Central:&nbsp; <a href="tel:+56229848435" style="color:#FFF">+56 2 2984 8435</a></span>
					&nbsp;&nbsp;&nbsp;<span><i class="fas fa-mobile" style="font-size:1em; color:#F79522;"></i>&nbsp;Ventas Mobile:&nbsp;<a href="tel:+56985963405" style="color:#FFF">+56 9 85963405</a></span> 
					&nbsp;&nbsp;&nbsp;<span><i class="fas fa-envelope" style="font-size:1em; color:#F79522;"></i>&nbsp;eMail:&nbsp;<a href="mailto:comercial@otecadvance.com" style="color:#FFF">comercial@otecadvance.com</a></span> 
					&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 
                
            </div>
        </div>
    </div>
    <!-- LOGO bar -->
    <div id="logo-bar" class="clearfix">
        <!-- Container -->
        <div class="container">
            <div class="row">
                <!-- Logo / Mobile Menu -->
                <div class="col-xs-12">
					<table width="100%">
					<tr>
						<td align="left" width="200px">
						<h1><a href="index.html"><img src="images/logo_250px.png" alt="Advance logo..." /></a></h1><br/>
						</td>
						<td align="right">
						<img src="images/slogan.gif" alt="Advance slogan" />
						</td>
					</tr>
					</table>
                     
                </div>
            </div>
        </div>
        <!-- Container / End -->
    </div>
    <!--LOGO bar / End-->

    <!-- Navigation
================================================== -->
    <div class="navbar navbar-default navbar-static-top container" role="navigation">
        <!--  <div class="container">-->
        <div class="row">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
            </div>
            <div class="navbar-collapse collapse">
                <ul class="nav navbar-nav">
                    <li class="active"><a href="index.html">Inicio</a></li>

                    <li><a href="#">Listado de Cursos</a>
                       <ul class="dropdown-menu">
                            <li><a href="presentacion_advance.php" title="Presentación de la empresa">Presentación de la empresa</a></li>
                            <li><a href="listado_advance.php" title="Listado de cursos actualizados">Listado de cursos actualizados</a></li> 
                        </ul>
                    </li>

                   
                    <li><a href="medio_pago_todos.html">Formas de Pago</a></li>
                    <li><a href="contact.php">Contacto</a></li>
                </ul>
            </div>
        </div><!--/.row -->
        <!--</div>--><!--/.container -->
    </div>
</header>
<!--End Header-->
	
	<!--start wrapper-->
	<section class="wrapper">
		<section class="page_head" data-href="images/page_heade_contact.jpg">
			<div class="container">
				<div class="row">
					<div class="col-lg-12 col-md-12 col-sm-12">
                        <div class="page_title">
                            <h2>Contáctenos</h2>
                            <span class="sub_heading"><a href="tel:+56229848435">+56 2 2984 8435</a></span>
                        </div>
						<nav id="breadcrumbs">
							<ul>
								<li>Estás aquí:</li>
								<li><a href="index.html">Inicio</a></li>
								<li>Contacto</li>
							</ul>
						</nav>
					</div>
				</div>
			</div>
		</section>

		<section class="content contact">
			<div class="container">
				<div class="row sub_content">
					<div class="col-lg-8 col-md-8 col-sm-8">
						<div class="dividerHeading">
							<h4><span>Formulario de Contacto</span></h4>
						</div>
						<p>Si tienes dudas, inquietudes, preguntas o simplemente quieres dejarnos tus comentarios, comunícate por este medio y te responderemos a la brevedad, tus observaciones son sumamente importantes para nosotros.</p>
						
						
	<fieldset>
	<a name="anclaForm" id="anclaForm"></a>
	<form method="post" action="contact.php#anclaForm" class="form contact-form">
	<div class="exito";>
	  <?
		echo "<strong>".$salida."</strong>";
		?>        
	</div>
	
	<div class="alert alert-error hidden" id="contactError">
	  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
	  <strong>Error!</strong> There was an error sending your message.
	</div>
	<div id="message"></div>
		<div class="row">
			<div class="form-group">
				<div class="col-lg-6 ">
					<input type="text" id="name" name="name" class="form-control" maxlength="100" data-msg-required="Favor ingresar un nombre de contacto." value="<?php echo $name; ?>" placeholder="Nombre" >
				</div>
				<div class="col-lg-6 ">
					<input type="fono" id="fono" name="fono" class="form-control" maxlength="50" value="<?php echo $fono; ?>" placeholder="Teléfono" >
				</div>
			</div>
		</div>
		<div class="row">
			<div class="form-group">
				<div class="col-md-12">
					<!-- <input type="text" id="subject" name="subject" class="form-control" maxlength="100" data-msg-required="Please enter the subject." value="" placeholder="Asunto"> -->
					<input type="email" id="email" name="email" class="form-control" maxlength="100" data-msg-email="Favor ingresar una casilla de correo váida." data-msg-required="Favor ingresar una casilla de correo." value="<?php echo $email; ?>" placeholder="eMail" >
				</div>
			</div>
		</div>
		<div class="row">
			<div class="form-group">
				<div class="col-md-12">
					<input type="text" id="curso" name="curso" class="form-control" maxlength="200" 
					data-msg-email="Ingresar un nombde de curso referencial." data-msg-required="Favor ingresar un nombre del curso referencial." 
					value="<?php echo $curso; ?>" placeholder="Curso o área de interés" >
				</div>
			</div>
		</div>
		<div class="row"> 
			<div class="form-group">
				<div class="col-md-12">
					<textarea id="comment" class="form-control" name="comment" rows="10" cols="50" data-msg-required="Favor ingresar un mensaje." maxlength="5000" placeholder="Mensaje"></textarea>
				</div>
			</div>
		</div>		
	 	<div class="row">
			<div class="col-md-12">
				 <div class="g-recaptcha" data-sitekey="6LdY4KwUAAAAAKjkxvfHOasYqmjSuKQAgOnsX_Ak"></div>
			</div>
		</div>  
	<br/>
		<div class="formRow">
			<input type="submit" data-loading-text="cargando..." class="btn btn-default btn-lg" value="Enviar Mensaje">
		</div>
	</form>
	 
	</fieldset>
					</div>
					
					<div class="col-lg-4 col-md-4 col-sm-4">
						<div class="sidebar">
							<div class="widget_info">
							  <div class="dividerHeading">
							    <div class="dividerHeading">
							      <h4><span>Información de Contacto</span></h4>
						        </div>
							  </div>
							  <ul class="widget_info_contact">
									<li><i class="fa fa-map-marker" style="color:#F79522;"></i> <p><strong>Dirección</strong>: Almirante Zegers #764<br/>&nbsp;&nbsp;Providencia - Santiago</p></li>
									<li><i class="fa fa-user" style="color:#F79522;"></i> <p><strong>Central</strong>: <a href="tel:+56229848435">+56 2 2984 8435</a></p></li>
									<li><i class="fa fa-user" style="color:#F79522;"></i> <p><strong>Ventas</strong>: <a href="tel:+56985963405">+56 9 8596 3405</a></p></li>
									<li><i class="fa fa-envelope" style="color:#F79522;"></i> <p><strong>eMail</strong>: <a href="mailto:comercial@otecadvance.com">comercial@otecadvance.com</a></p></li>
								</ul>
								<ul class="widget_info_contact">
									<li><i class="fa fa-user" style="color:#F79522;"	></i> <p><strong>Asistencia</strong>: <a href="tel:+56994854094">+56 9 9485 4094</a></p></li>
									<li><i class="fa fa-envelope" style="color:#F79522;"></i> <p><strong>eMail</strong>: <a href="mailto:seguimiento@otecadvance.com">seguimiento@otecadvance.com</a></p></li>
								</ul>
								<ul class="widget_info_contact">
									<li><i class="fa fa-globe" style="color:#F79522;"></i> <p><strong>Web</strong>: <a href="https://otecadvance.com/" data-placement="bottom" data-toggle="tooltip" title="www.otecadvance.com">OtecAdvance.com</a></p></li>
								</ul>
								
							</div>
							 
						</div>
					</div>
					
				</div>
				
			</div>
			
			<div class="row sub_content">
				<div class="col-lg-12 col-md-12 col-sm-12">
				 <div >
						<div ><a href="https://www.google.com/maps/place/Almirante+Zegers+764,+Providencia,+Regi%C3%B3n+Metropolitana,+Chile/@-33.4340673,-70.6237458,17z/data=!4m5!3m4!1s0x9662c58711aa12f5:0x7d21277ed4fe3de8!8m2!3d-33.4342822!4d-70.6237673"><img src="images/mapa_zegers.png" alt="Advance ubicación..." /></a></div>
					 </div >
				</div>
			</div>
		</section>
	</section>
	<!--end wrapper-->

	
	<section class="footer_bottom">
    <div class="container">
        <div class="row">
            <div class="col-lg-6 ">
                <p class="copyright">&copy; Copyright 2014-2019 Instituto de Capacitación Advance<br/>Todos los Derechos Reservados </p>
            </div>

          
        </div>
    </div>
</section>

    <script type="text/javascript" src="js/jquery-1.10.2.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/jquery.easing.1.3.js"></script>
    <script src="js/retina-1.1.0.min.js"></script>
    <script type="text/javascript" src="js/jquery.cookie.js"></script> <!-- jQuery cookie -->
    <script type="text/javascript" src="js/styleswitch.js"></script> <!-- Style Colors Switcher -->
    <script type="text/javascript" src="js/jquery.smartmenus.min.js"></script>
    <script type="text/javascript" src="js/jquery.smartmenus.bootstrap.min.js"></script>
    <script type="text/javascript" src="js/jquery.jcarousel.js"></script>
    <script type="text/javascript" src="js/jflickrfeed.js"></script>
    <script type="text/javascript" src="js/jquery.magnific-popup.min.js"></script>
    <script type="text/javascript" src="js/jquery.isotope.min.js"></script>
    <script type="text/javascript" src="js/swipe.js"></script>
    <script type="text/javascript" src="js/jquery-scrolltofixed-min.js"></script>
    <script type="text/javascript" src="js/jquery.validate.js"></script>
    <script type="text/javascript" src="js/view.contact.js"></script>
    <script type="text/javascript" src="js/jquery.gmap.js"></script>
    <script type="text/javascript" src="js/jquery.blurr.js"></script>

    <script src="js/main.js"></script> 
</body>
</html>