<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <title>STBI UNISBANK</title>
    <meta name="keywords" content="" />
    <meta name="description" content="" />
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="language" content="en" />
    <link href="style.css" rel="stylesheet" type="text/css" />

<!-- Image Preloader -->
<script type="text/javascript" src="http://ajax.googlesapi.com/ajax/libs/jquery/jquery.min.js"></script>
  
</head>
<body>
    <div id="page">
        <div id="header">
            <h1><a href="index.php">SISTEM TEMU KEMBALI</a></h1><h1>INFORMASI</h1>
        </div>        
        <div id="main">
            <div id="sidebar">
                <form id="search" method="get" action="#">
                    <div id="searchtxt">
                    <input type="text" class="text" /></div>
                    <input type="submit" class="submit" value="" />
                </form>
                <h2>Artikel Lainnya</h2>
                <ul>
                    <li>&raquo;<a  href="http://stbiunisbank2017.blogspot.co.id/2017/09/makalah-tentang-tokenisasistopword.html">BLOG</a></li>
                   
                </ul>
                <h2>Informasi</h2>
                <div class="box">
                    <p>Website ini ditujukan untuk menampung tugas - tugas yang telah dibuat 
                    dan sebagai tempat menjalankan file tugas</p>
                </div>
            </div><!-- sidebar -->               
            <div id="content">
                <div id="menu">
                    <ul>
                        <li><a href="index.php">HOME</a></li>
                        <li><a href="profil.php">PROFIL</a></li>
                        <li><a href="upload1.php">UPLOAD</a></li>
                         <li><a href="upload3.php">CARI QUERYTF</a></li>
                        
                    </ul>
                </div>
 <?php
////
function hitungsim($query) {
  //ambil jumlah total dokumen yang telah diindex (tbindex atau tbvektor), n
$host='localhost';
$user='root';
$pass='';
$database='dbstbi';

//echo "hitung sim";

$conn=($GLOBALS["___mysqli_ston"] = mysqli_connect($host, $user, $pass));
mysqli_select_db($GLOBALS["___mysqli_ston"], $database);

  $resn = mysqli_query($GLOBALS["___mysqli_ston"], "SELECT Count(*) as n FROM tbvektor");
  $rown = mysqli_fetch_array($resn);  
  $n = $rown['n'];
  //echo "hasil tbvektor";
  
  print_r($resn);
  
  //terapkan preprocessing terhadap $query
  $aquery = explode(" ", $query);
  
  //hitung panjang vektor query
  $panjangQuery = 0;
  $aBobotQuery = array();
  
  for ($i=0; $i<count($aquery); $i++) {
    //hitung bobot untuk term ke-i pada query, log(n/N);
    //hitung jumlah dokumen yang mengandung term tersebut
    $resNTerm = mysqli_query($GLOBALS["___mysqli_ston"], "SELECT Count(*) as N from tbindex WHERE Term like '%$aquery[$i]%'");
//    echo "query >SELECT Count(*) as N from tbindex WHERE Term like '%$aquery[$i]%'";
    $rowNTerm = mysqli_fetch_array($resNTerm);  
    $NTerm = $rowNTerm['N'] ;
    
    $idf = log($n/$NTerm);
    
    //simpan di array   
    $aBobotQuery[] = $idf;
    
    $panjangQuery = $panjangQuery + $idf * $idf;    
  }
  
  $panjangQuery = sqrt($panjangQuery);
  
  $jumlahmirip = 0;
  
  //ambil setiap term dari DocId, bandingkan dengan Query
  $resDocId = mysqli_query($GLOBALS["___mysqli_ston"], "SELECT * FROM tbvektor ORDER BY DocId");
  while ($rowDocId = mysqli_fetch_array($resDocId)) {
  
    $dotproduct = 0;
      
    $docId = $rowDocId['DocId'];
    $panjangDocId = $rowDocId['Panjang'];
    
    $resTerm = mysqli_query($GLOBALS["___mysqli_ston"], "SELECT * FROM tbindex WHERE DocId = '$docId'");
  //  echo "query ->SELECT * FROM tbindex WHERE DocId = '$docId'".'<br>';
    
    
    while ($rowTerm = mysqli_fetch_array($resTerm)) {
      for ($i=0; $i<count($aquery); $i++) {
        //jika term sama
        //echo "1-->".$rowTerm['Term'];
      //  echo "2-->".  $aquery[$i].'<br>';
        
        if ($rowTerm['Term'] == $aquery[$i]) {
          $dotproduct = $dotproduct + $rowTerm['Bobot'] * $aBobotQuery[$i];   
    //      echo "hasil =".$dotproduct.'<br>';
      //    echo "1-->".$rowTerm['Term'];
      //  echo "2-->".  $aquery[$i].'<br>';
          
        } //end if
          else
          {
          }
      } //end for $i    
    } //end while ($rowTerm)
    
    if ($dotproduct != 0) {
      $sim = $dotproduct / ($panjangQuery * $panjangDocId); 
      //echo "insert >>INSERT INTO tbcache (Query, DocId, Value) VALUES ('$query', '$docId', $sim)";
      //simpan kemiripan > 0  ke dalam tbcache
      $resInsertCache = mysqli_query($GLOBALS["___mysqli_ston"], "INSERT INTO tbcache (Query, DocId, Value) VALUES ('$query', '$docId', $sim)");
      $jumlahmirip++;
    } 
      
  if ($jumlahmirip == 0) {
    $resInsertCache = mysqli_query($GLOBALS["___mysqli_ston"], "INSERT INTO tbcache (Query, DocId, Value) VALUES ('$query', 0, 0)");
  } 
  } //end while $rowDocId
  
    
} //end hitungSim()





////
$host='localhost';
$user='root';
$pass='';
$database='dbstbi';
$keyword=$_POST['keyword'];;
$conn=($GLOBALS["___mysqli_ston"] = mysqli_connect($host, $user, $pass));
mysqli_select_db($GLOBALS["___mysqli_ston"], $database);
$resCache = mysqli_query($GLOBALS["___mysqli_ston"], "SELECT *  FROM tbcache WHERE Query = '$keyword' ORDER BY Value DESC");
  $num_rows = mysqli_num_rows($resCache);
  if ($num_rows >0) {

    //tampilkan semua berita yang telah terurut
    while ($rowCache = mysqli_fetch_array($resCache)) {
      $docId = $rowCache['DocId'];
      $sim = $rowCache['Value'];
          
        //ambil berita dari tabel tbberita, tampilkan
        //echo ">>>SELECT nama_file,deskripsi FROM upload WHERE nama_file = '$docId'";
        $resBerita = mysqli_query($GLOBALS["___mysqli_ston"], "SELECT nama_file,deskripsi FROM upload WHERE nama_file = '$docId'");
        $rowBerita = mysqli_fetch_array($resBerita);
          
        $judul = $rowBerita['nama_file'];
        $berita = $rowBerita['deskripsi'];
          
        print($docId . ". (" . $sim . ") <font color=blue><b><a href=" . $judul . "> </b></font><br />");
        print($berita . "<hr /></a>");    
      
    }//end while (rowCache = mysql_fetch_array($resCache))
  }
    else
    {
    hitungsim($keyword);
    //pasti telah ada dalam tbcache   
    $resCache = mysqli_query($GLOBALS["___mysqli_ston"], "SELECT *  FROM tbcache WHERE Query = '$keyword' ORDER BY Value DESC");
    $num_rows = mysqli_num_rows($resCache);
    
    while ($rowCache = mysqli_fetch_array($resCache)) {
      $docId = $rowCache['DocId'];
      $sim = $rowCache['Value'];
          
        //ambil berita dari tabel tbberita, tampilkan
        $resBerita = mysqli_query($GLOBALS["___mysqli_ston"], "SELECT nama_file,deskripsi FROM upload WHERE nama_file = '$docId'");
        $rowBerita = mysqli_fetch_array($resBerita);
          
        $judul = $rowBerita['nama_file'];
        $berita = $rowBerita['deskripsi'];
          
        print($docId . ". (" . $sim . ") <font color=blue><b><a href=" . $judul . "> </b></font><br />");
        print($berita . "<hr /></a>");
    
    } //end while
    }

?>

                </div>                      
            </div><!-- content -->            
            <div class="clearing">&nbsp;</div>   
        </div><!-- main -->
    </div><!-- page -->
    <div id="footer">
    
    </div>
</body>
</html>