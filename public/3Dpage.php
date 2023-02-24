<?php

$title = "Overview";
require "../vendor/autoload.php";
require_once "../src/header.php";
?>


<!-- THREE JS LINKS FROM CODEPEN   -->
<script src="https://assets.codepen.io/4027472/three.min.js"></script>
<!--Orbit-->
<script src="https://assets.codepen.io/4027472/OrbitControls.js"></script>
<!--GLTFLoader-->
<script src="https://assets.codepen.io/4027472/GLTFLoader.js"></script>
<!--Gsap-->
<script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.11.4/gsap.min.js"></script>

<!--Font-->
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@500;900&display=swap" rel="stylesheet">

<!--global CSS-->
<link rel="stylesheet" href="/style/index.css">
<!--dropdown CSS-->
<link rel="stylesheet" href="/style/dropdown/dropdown.css">
<!--Chargement video CSS-->
<link rel="stylesheet" href="/style/chargement_page/chargement.css">

<!--Chargement video JS-->
<script src="/style/chargement_page/chargement.js"></script>
<!--dropdown JS-->
<script src="/style/dropdown/dropdown.js"></script>
<!--Check image JS-->
<script src="/style/checkImage/imageCheck.js"></script>




<!--Chargement video-->
<video id="background-video" autoplay muted>
    <source src="public/img/chargement.mp4" type="video/mp4">
</video>
<!-- light JS -->
<script src="/js/light.js"></script>

<!--Salles animation JS-->
<script src="/js/animation.js"></script>
<!--global JS-->
<script src="/js/threeJSCode.js"></script>
<?php
require "../src/footer.php";
?>
