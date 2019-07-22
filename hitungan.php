<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <style>
    table, th, td {
  border: 1px solid black;
}</style>
</head>
<body>
<?php
include 'koneksi.php';
?>



<!-- mencari nilai max / min pada tiap kolom table penilaian -->
<?php

$sql = "SELECT MAX(nilai_un) AS maxUN FROM nilai;";
$result = $conn->query($sql);
$value = $result->fetch_assoc();
$maxUN = $value['maxUN'];
// echo $maxUN;
// echo '<br>';

$sql = "SELECT MAX(penghasilan) AS maxPenghasilan FROM nilai;";
$result = $conn->query($sql);
$value = $result->fetch_assoc();
$maxPenghasilan = $value['maxPenghasilan'];
// echo $maxPenghasilan;
// echo '<br>';

$sql = "SELECT MIN(saudara) AS minSaudara FROM nilai;";
$result = $conn->query($sql);
$value = $result->fetch_assoc();
$minSaudara = $value['minSaudara'];
// echo $minSaudara;
// echo '<br>';

$sql = "SELECT MIN(jarak) AS minJarak FROM nilai;";
$result = $conn->query($sql);
$value = $result->fetch_assoc();
$minJarak = $value['minJarak'];
// echo $minJarak;
// echo '<br>';

$sql = "SELECT berat_kriteria as beratUN FROM kriteria WHERE nama_kriteria = 'nilai_un';";
$result = $conn->query($sql);
$value = $result->fetch_assoc();
$beratUN = $value['beratUN'];
// echo $beratUN;
// echo '<br>';

$sql = "SELECT berat_kriteria as beratPenghasilan FROM kriteria WHERE nama_kriteria = 'penghasilan';";
$result = $conn->query($sql);
$value = $result->fetch_assoc();
$beratPenghasilan = $value['beratPenghasilan'];
// echo $beratPenghasilan;
// echo '<br>';

$sql = "SELECT berat_kriteria as beratSaudara FROM kriteria WHERE nama_kriteria = 'saudara';";
$result = $conn->query($sql);
$value = $result->fetch_assoc();
$beratSaudara = $value['beratSaudara'];
// echo $beratSaudara;
// echo '<br>';

$sql = "SELECT berat_kriteria as beratJarak FROM kriteria WHERE nama_kriteria = 'jarak';";
$result = $conn->query($sql);
$value = $result->fetch_assoc();
$beratJarak = $value['beratJarak'];
// echo $beratJarak;
// echo '<br>';

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

<h2>Tabel Normalisasi Matrix</h2>
<table style="">
  <tr>
    <th>Nama</th>
    <th>C1 (Nilai Un)</th> 
    <th>C2 (Penghasilan)</th>
    <th>C3 (Jumlah Saudara)</th>
    <th>C4 (Jarak)</th>
  </tr>
  <?php
  for($i = 0; $i<$maxData['maxData'];$i++){
  ?>
  <tr>
    <td><?php echo $dataNilai[$i]['nama_siswa']; ?></td>
    <td><?php echo $dataNilai[$i]['nilai_un']; ?></td> 
    <td><?php echo $dataNilai[$i]['penghasilan']; ?></td>
    <td><?php echo $dataNilai[$i]['saudara']; ?></td>
    <td><?php echo $dataNilai[$i]['jarak']; ?></td>
  </tr>
<?php
  }
  $x=0;
  $dataSiswa2 = array();
while($x < $maxData['maxData']) {
  $dataSiswa2[] = array("nama_siswa" => $dataNilai[$x]['nama_siswa'], 
                        "nilai_un" => $dataNilai[$x]['nilai_un']/$maxUN,
                        "penghasilan" => $dataNilai[$x]['penghasilan']/$maxPenghasilan,
                        "saudara" => $minSaudara/$dataNilai[$x]['saudara'],
                        "jarak" => $minJarak/$dataNilai[$x]['jarak']);
  $x++;
}
?>
</table>
<hr>
<table>
<tr>

<th>~</th>
<th>C1</th>
<th>C2</th>
<th>C3</th>
<th>C4</th>

</tr>

<tr>
<th>Char</th>
<th>Ben</th>
<th>Ben</th>
<th>Cost</th>
<th>Cost</th>
</tr>

<tr>
<th>Max/Min</th>
<th><?php echo $maxUN ?></th>
<th><?php echo $maxPenghasilan ?></th>
<th><?php echo $minSaudara ?></th>
<th><?php echo $minJarak ?></th>
</tr>
</table>
<hr>
<table style="">
  <tr>
    <th>Nama</th>
    <th>C1 (Nilai Un)</th> 
    <th>C2 (Penghasilan)</th>
    <th>C3 (Jumlah Saudara)</th>
    <th>C4 (Jarak)</th>
  </tr>

  <?php
  for($i = 0; $i<$maxData['maxData'];$i++){
?>
  <tr>
    <td><?php echo $dataSiswa2[$i]['nama_siswa']; ?></td>
    <td><?php echo $dataSiswa2[$i]['nilai_un']; ?></td> 
    <td><?php echo $dataSiswa2[$i]['penghasilan']; ?></td>
    <td><?php echo $dataSiswa2[$i]['saudara']; ?></td>
    <td><?php echo $dataSiswa2[$i]['jarak']; ?></td>
  </tr>
  <?php
  }
  $x=0;
  $dataSiswa3 = array();
while($x < $maxData['maxData']) {
  $dataSiswa3[] = array("nama_siswa" => $dataSiswa2[$x]['nama_siswa'], 
                        "nilai_un" => $dataSiswa2[$x]['nilai_un']*$beratUN,
                        "penghasilan" => $dataSiswa2[$x]['penghasilan']*$beratPenghasilan,
                        "saudara" => $dataSiswa2[$x]['saudara']*$beratSaudara,
                        "jarak" => $dataSiswa2[$x]['jarak']*$beratJarak);
  $x++;
}
  ?>
</table>
<hr>
<table>
<tr>

<th>~</th>
<th>C1</th>
<th>C2</th>
<th>C3</th>
<th>C4</th>

</tr>

<tr>
<th>Weight</th>
<th><?php echo $beratUN ?></th>
<th><?php echo $beratPenghasilan ?></th>
<th><?php echo $beratSaudara ?></th>
<th><?php echo $beratJarak ?></th>
</tr>
</table>
<hr>
<h2>Tabel Weighted Normalized Matrix</h2>
<table style="">
  <tr>
    <th>Nama</th>
    <th>C1 (Nilai Un)</th> 
    <th>C2 (Penghasilan)</th>
    <th>C3 (Jumlah Saudara)</th>
    <th>C4 (Jarak)</th>
  </tr>

  <?php
  for($i = 0; $i<$maxData['maxData'];$i++){
?>
  <tr>
    <td><?php echo $dataSiswa3[$i]['nama_siswa']; ?></td>
    <td><?php echo $dataSiswa3[$i]['nilai_un']; ?></td> 
    <td><?php echo $dataSiswa3[$i]['penghasilan']; ?></td>
    <td><?php echo $dataSiswa3[$i]['saudara']; ?></td>
    <td><?php echo $dataSiswa3[$i]['jarak']; ?></td>
  </tr>

  <?php
  }
  $x=0;
  $dataSiswa4 = array();
while($x < $maxData['maxData']) {
  $dataSiswa4[] = array("nama_siswa" => $dataSiswa3[$x]['nama_siswa'], 
                        "nilai_un" => $dataSiswa3[$x]['nilai_un'],
                        "penghasilan" => $dataSiswa3[$x]['penghasilan'],
                        "saudara" => $dataSiswa3[$x]['saudara'],
                        "jarak" => $dataSiswa3[$x]['jarak'],
                        "V" => $dataSiswa3[$x]['nilai_un']+$dataSiswa3[$x]['penghasilan']+$dataSiswa3[$x]['saudara']+$dataSiswa3[$x]['jarak']);
  $x++;
}
array_multisort(array_column($dataSiswa4, "V"), SORT_DESC, $dataSiswa4);
  ?>
  </table>

  <h2>Tabel hasil Akhir</h2>
<table style="">
  <tr>
    <th>Nama</th>
    <th>C1 (Nilai Un)</th> 
    <th>C2 (Penghasilan)</th>
    <th>C3 (Jumlah Saudara)</th>
    <th>C4 (Jarak)</th>
    <th>V</th>
  </tr>

  <?php
  for($i = 0; $i<$maxData['maxData'];$i++){
?>
  <tr>
    <td><?php echo $dataSiswa4[$i]['nama_siswa']; ?></td>
    <td><?php echo $dataSiswa4[$i]['nilai_un']; ?></td> 
    <td><?php echo $dataSiswa4[$i]['penghasilan']; ?></td>
    <td><?php echo $dataSiswa4[$i]['saudara']; ?></td>
    <td><?php echo $dataSiswa4[$i]['jarak']; ?></td>
    <td><?php echo $dataSiswa4[$i]['V']; ?></td>
  </tr>
<?php
  }
?>
</table>
</body>
</html>