<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <title>WEB SERVICE</title>
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
                <div class="post">
                <h2>Upload File PDF</h2>
                <?php
                include 'upload.php';
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