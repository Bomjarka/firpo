<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<!--
Design by Free CSS Templates
http://www.freecsstemplates.org
Released for free under a Creative Commons Attribution 3.0 License

Name       : Accumen
Description: A two-column, fixed-width design with dark color scheme.
Version    : 1.0
Released   : 20120712

Modified by VitalySwipe
-->
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta http-equiv="content-type" content="text/html; charset=utf-8" />
		<meta name="description" content="" />
		<meta name="keywords" content="" />
		<title>Firpo Test</title>
		<link href="http://fonts.googleapis.com/css?family=Open+Sans" rel="stylesheet" type="text/css" />
		<link href="http://fonts.googleapis.com/css?family=Kreon" rel="stylesheet" type="text/css" />
		<link rel="stylesheet" type="text/css" href="/css/style.css" />

        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
	</head>
	<body>
		<div id="wrapper">
			<div id="header">
				<div id="logo">
                    <span class="cms"><a href="/">Firpo Test Case</span></a>
				</div>
				<div id="menu">
					<ul>
						<li class="first active"><a href="/">Главная</a></li>
						<li><a href="/cabinet">Кабинет</a></li>
						<li class="last"><a href="/contacts">Контакты</a></li>
                        <?php if (isset($_SESSION['is_admin']) && $_SESSION['is_admin'] == 'yes') {
                            echo '<li><a href="/admin">Админка</a></li>';
                        } ?>
                        <?php if (isset($_SESSION['user_id'])) {
                            echo '<li><a href="/data_import">Импорт данных</a></li>';
                        } ?>
					</ul>
					<br class="clearfix" />
				</div>
			</div>
			<div id="page">
				<div id="sidebar">
					<div class="side-box">
						<h3>Основное меню</h3>
						<ul class="list">
							<li class="first "><a href="/">Главная</a></li>
							<li><a href="/cabinet">Кабинет</a></li>
							<li class="last"><a href="/contacts">Контакты</a></li>
						</ul>
					</div>
				</div>
				<div id="content">
					<div class="box">
						<?php include 'application/views/'. $content_view; ?>
						<!--
						<h2>Welcome to Accumen</h2>
						<img class="alignleft" src="images/pic01.jpg" width="200" height="180" alt="" />
						<p>
							This is <strong>Accumen</strong>, a free, fully standards-compliant CSS template by <a href="http://www.freecsstemplates.org/">Free CSS Templates</a>. The images used in this template are from <a href="http://fotogrph.com/">Fotogrph</a>. This free template is released under a <a href="http://creativecommons.org/licenses/by/3.0/">Creative Commons Attributions 3.0</a> license, so you are pretty much free to do whatever you want with it (even use it commercially) provided you keep the footer credits intact. Aside from that, have fun with it :)
						</p>
						-->
					</div>
					<br class="clearfix" />
				</div>
				<br class="clearfix" />
			</div>
			<div id="page-bottom">
				<div id="page-bottom-sidebar">
					<h3>Мои контакты</h3>
					<ul class="list">
						<li class="first">telegram: @alexandereho</li>
						<li>phone: 89609213096</li>
						<li class="last">e-mail: sashaxamas@gmail.com</li>
					</ul>
				</div>
				<div id="page-bottom-content">
					<h3>Обо мне</h3>
                    <p>
                        Занимаю должность младшего программиста в отделе технической поддержки компании
                        <a href="https://robo.finance/" target="_blank">ROBOFINANCE</a>
                        Работаю с базами данных (POSTGRESQL), пишу различные запросы для выгрузок данных.
                        Так же разрабатываем часть функционала для систем (PHP + Laravel). Имею базовые представления о Docker.
                    </p>
				</div>
				<br class="clearfix" />
			</div>
		</div>
		<div id="footer">
			<a href=https:/vk.com/xamas27 target="_blank">Чиркин Александр</a> &copy; 2022</a>
		</div>
	</body>
</html>