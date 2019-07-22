<!DOCTYPE html>
<html lang="en">
<head>
<title>Course - Teachers</title>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="description" content="Course Project">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" type="text/css" href="styles/bootstrap4/bootstrap.min.css">
<link href="plugins/fontawesome-free-5.0.1/css/fontawesome-all.css" rel="stylesheet" type="text/css">
<link rel="stylesheet" type="text/css" href="styles/teachers_styles.css">
<link rel="stylesheet" type="text/css" href="styles/teachers_responsive.css">
</head>
<body>

<div class="super_container">

	<!-- Header -->

	<header class="header d-flex flex-row">
		<div class="header_content d-flex flex-row align-items-center">
			<!-- Logo -->
			<div class="logo_container">
				<div class="logo">
					<img src="images/logo.png" alt="">
					<span>course</span>
				</div>
			</div>

			<!-- Main Navigation -->
			<nav class="main_nav_container">
				<div class="main_nav">
					<ul class="main_nav_list">
						<li class="main_nav_item"><a href="index.html">home</a></li>
					</ul>
				</div>
			</nav>
		</div>
		<div class="header_side d-flex flex-row justify-content-center align-items-center">
			<img src="images/phone-call.svg" alt="">
			<span>+43 4566 7788 2457</span>
		</div>

		<!-- Hamburger -->
		<div class="hamburger_container">
			<i class="fas fa-bars trans_200"></i>
		</div>

	</header>
	
	<!-- Menu -->
	<div class="menu_container menu_mm">

		<!-- Menu Close Button -->
		<div class="menu_close_container">
			<div class="menu_close"></div>
		</div>

		<!-- Menu Items -->
		<div class="menu_inner menu_mm">
			<div class="menu menu_mm">
				<ul class="menu_list menu_mm">
					<li class="menu_item menu_mm"><a href="index.html">Home</a></li>
				</ul>

				<!-- Menu Social -->
				
				<div class="menu_social_container menu_mm">
					<ul class="menu_social menu_mm">
						<li class="menu_social_item menu_mm"><a href="#"><i class="fab fa-pinterest"></i></a></li>
						<li class="menu_social_item menu_mm"><a href="#"><i class="fab fa-linkedin-in"></i></a></li>
						<li class="menu_social_item menu_mm"><a href="#"><i class="fab fa-instagram"></i></a></li>
						<li class="menu_social_item menu_mm"><a href="#"><i class="fab fa-facebook-f"></i></a></li>
						<li class="menu_social_item menu_mm"><a href="#"><i class="fab fa-twitter"></i></a></li>
					</ul>
				</div>

				<div class="menu_copyright menu_mm">Colorlib All rights reserved</div>
			</div>

		</div>

	</div>
	
	<!-- Home -->

	<div class="home">
		<div class="home_background_container prlx_parent">
			<div class="home_background prlx" style="background-image:url(images/teachers_background.jpg)"></div>
		</div>
		<div class="home_content">
			<h1>Kepala Sekolah</h1>
		</div>
	</div>

	<!-- Teachers -->

	<div class="teachers page_section">
		<div class="container">
			<div class="row">
				
				<?php
include 'koneksi.php';
?>



<!-- mencari nilai max / min pada tiap kolom table penilaian -->
<?php

$sql = "SELECT MAX(nilai_un) AS maxUN FROM nilai;";
$result = $conn->query($sql);
$value = $result->fetch_assoc();
$maxUN = $value['maxUN'];


$sql = "SELECT MAX(penghasilan) AS maxPenghasilan FROM nilai;";
$result = $conn->query($sql);
$value = $result->fetch_assoc();
$maxPenghasilan = $value['maxPenghasilan'];


$sql = "SELECT MIN(saudara) AS minSaudara FROM nilai;";
$result = $conn->query($sql);
$value = $result->fetch_assoc();
$minSaudara = $value['minSaudara'];


$sql = "SELECT MIN(jarak) AS minJarak FROM nilai;";
$result = $conn->query($sql);
$value = $result->fetch_assoc();
$minJarak = $value['minJarak'];


$sql = "SELECT berat_kriteria as beratUN FROM kriteria WHERE nama_kriteria = 'nilai_un';";
$result = $conn->query($sql);
$value = $result->fetch_assoc();
$beratUN = $value['beratUN'];


$sql = "SELECT berat_kriteria as beratPenghasilan FROM kriteria WHERE nama_kriteria = 'penghasilan';";
$result = $conn->query($sql);
$value = $result->fetch_assoc();
$beratPenghasilan = $value['beratPenghasilan'];


$sql = "SELECT berat_kriteria as beratSaudara FROM kriteria WHERE nama_kriteria = 'saudara';";
$result = $conn->query($sql);
$value = $result->fetch_assoc();
$beratSaudara = $value['beratSaudara'];


$sql = "SELECT berat_kriteria as beratJarak FROM kriteria WHERE nama_kriteria = 'jarak';";
$result = $conn->query($sql);
$value = $result->fetch_assoc();
$beratJarak = $value['beratJarak'];


$sql = mysqli_query($conn, "SELECT * FROM nilai join pendaftaran WHERE nilai.id_siswa = pendaftaran.id_siswa");
$dataNilai = array(); 


$index = 0;
while($row = mysqli_fetch_assoc($sql)){ 
     $dataNilai[$index] = $row;
     $index++;
}


?>
<?php
$sql = "SELECT COUNT(id_nilai) as maxData FROM nilai";
$xxx = $conn->query($sql);
$maxData = $xxx->fetch_assoc();
?>

  <?php
  $x=0;
  $dataSiswa2 = array();
while($x < $maxData['maxData']) {
  $dataSiswa2[] = array("nama_siswa" => $dataNilai[$x]['nama_siswa'],
                        "asal_sekolah" => $dataNilai[$x]['asal_sekolah'],
                        "nilai_un" => $dataNilai[$x]['nilai_un']/$maxUN,
                        "penghasilan" => $dataNilai[$x]['penghasilan']/$maxPenghasilan,
                        "saudara" => $minSaudara/$dataNilai[$x]['saudara'],
                        "jarak" => $minJarak/$dataNilai[$x]['jarak']);
  $x++;
}
?>
  <?php
  $x=0;
  $dataSiswa3 = array();
while($x < $maxData['maxData']) {
  $dataSiswa3[] = array("nama_siswa" => $dataSiswa2[$x]['nama_siswa'], 
                        "asal_sekolah" => $dataNilai[$x]['asal_sekolah'],
                        "nilai_un" => $dataSiswa2[$x]['nilai_un']*$beratUN,
                        "penghasilan" => $dataSiswa2[$x]['penghasilan']*$beratPenghasilan,
                        "saudara" => $dataSiswa2[$x]['saudara']*$beratSaudara,
                        "jarak" => $dataSiswa2[$x]['jarak']*$beratJarak);
  $x++;
}
  ?>


  <?php
  $x=0;
  $dataSiswa4 = array();
while($x < $maxData['maxData']) {
  $dataSiswa4[] = array("nama_siswa" => $dataSiswa3[$x]['nama_siswa'],
                        "asal_sekolah" => $dataNilai[$x]['asal_sekolah'], 
                        "nilai_un" => $dataSiswa3[$x]['nilai_un'],
                        "penghasilan" => $dataSiswa3[$x]['penghasilan'],
                        "saudara" => $dataSiswa3[$x]['saudara'],
                        "jarak" => $dataSiswa3[$x]['jarak'],
                        "V" => $dataSiswa3[$x]['nilai_un']+$dataSiswa3[$x]['penghasilan']+$dataSiswa3[$x]['saudara']+$dataSiswa3[$x]['jarak']);
  $x++;
}
array_multisort(array_column($dataSiswa4, "V"), SORT_DESC, $dataSiswa4);
  ?>

<H1>Table Pendaftar</H1>

<table class="table table-striped">
    <thead>
      <tr style="background-color:black;color:white;">
        <th>No</th>
        <th>Nama</th>
        <th>Asal Sekolah</th>
        <th>Nilai UN</th>
        <th>Penghasilan Orang tua</th>
        <th>Saudara Kandung</th>
        <th>Jarak</th>
      </tr>
    </thead>

  <?php
  
  for($i = 0; $i<$maxData['maxData'];$i++){
    $no=$i+1;
?>

  <tbody>
      <tr>
        <th><?php echo $no; ?></th>
        <td><?php echo $dataNilai[$i]['nama_siswa']; ?></td>
        <td><?php echo $dataNilai[$i]['asal_sekolah']; ?></td>
        <td><?php echo $dataNilai[$i]['nilai_un']; ?></td>
        <td><?php echo $dataNilai[$i]['penghasilan']; ?></td>
        <td><?php echo $dataNilai[$i]['saudara']; ?></td>
        <td><?php echo $dataNilai[$i]['jarak']; ?></td>
      </tr>
      <tr>
      </tbody>
<?php
  }
?>
</table>
<br>
<hr>

<H1>Table Keputusan Kemahasiswaan</H1>
<table class="table table-bordered">
    <thead>
      <tr style="background-color:black;color:white;">
        <th>No</th>
        <th>Nama</th>
        <th>Asal Sekolah</th>
        <th>Nilai Perhitungan Akhir</th>
        <th>Status</th>
      </tr>
    </thead>

  <?php
  
  for($i = 0; $i<$maxData['maxData'];$i++){
    $no=$i+1;
?>

  <tbody>
      <tr>
        <th><?php echo $no; ?></th>
        <td><?php echo $dataSiswa4[$i]['nama_siswa']; ?></td>
        <td><?php echo $dataSiswa4[$i]['asal_sekolah']; ?></td>
        <td><?php echo $dataSiswa4[$i]['V']; ?></td>
        <td><?php 
        if($no<=3){
          echo "Lulus";
        }else{
          echo "Gagal";
        }
        
        ?></td>
      </tr>
      <tr>
      </tbody>
<?php
  }
?>
</table>

			</div>
		</div>
	</div>



<script src="js/jquery-3.2.1.min.js"></script>
<script src="styles/bootstrap4/popper.js"></script>
<script src="styles/bootstrap4/bootstrap.min.js"></script>
<script src="plugins/greensock/TweenMax.min.js"></script>
<script src="plugins/greensock/TimelineMax.min.js"></script>
<script src="plugins/scrollmagic/ScrollMagic.min.js"></script>
<script src="plugins/greensock/animation.gsap.min.js"></script>
<script src="plugins/greensock/ScrollToPlugin.min.js"></script>
<script src="plugins/scrollTo/jquery.scrollTo.min.js"></script>
<script src="plugins/easing/easing.js"></script>
<script src="js/teachers_custom.js"></script>

</body>
</html>