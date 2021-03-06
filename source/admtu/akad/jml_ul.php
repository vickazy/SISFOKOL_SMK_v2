<?php
///////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////
/////// SISFOKOL SMK v2.0 							///////
/////// (Sistem Informasi Sekolah untuk SMK v2.0) 	///////
///////////////////////////////////////////////////////////
/////// Dibuat oleh : 								///////
/////// Agus Muhajir, S.Kom 						///////
/////// URL 	: http://sisfokol.wordpress.com 	///////
/////// E-Mail	: hajirodeon@yahoo.com 				///////
/////// HP/SMS	: 081-829-88-54 					///////
///////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////


session_start();

//fungsi - fungsi
require("../../inc/config.php");
require("../../inc/fungsi.php");
require("../../inc/koneksi.php");
require("../../inc/cek/admtu.php");
$tpl = LoadTpl("../../template/index.html"); 


nocache;

//nilai
$filenya = "jml_ul.php";
$judul = "Jumlah Ulangan";
$judulku = "[$tu_session : $nip5_session.$nm5_session] ==> $judul";
$judulx = $judul;
$s = nosql($_REQUEST['s']);
$keakd = nosql($_REQUEST['keakd']);
$kelkd = nosql($_REQUEST['kelkd']);
$jnskd = nosql($_REQUEST['jnskd']);
$mapelkd = nosql($_REQUEST['mapelkd']);
$ke = "$filenya?keakd=$keakd&kelkd=$kelkd&jnskd=$jnskd&mapelkd=$mapelkd";


	
	
//focus...
if (empty($keakd))
	{
	$diload = "document.formx.keahlian.focus();";
	}
else if (empty($kelkd))
	{
	$diload = "document.formx.kelas.focus();";
	}
else if (empty($jnskd))
	{
	$diload = "document.formx.jenis.focus();";
	}
else if (empty($mapelkd))
	{
	$diload = "document.formx.mapel.focus();";
	}









//PROSES ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
if ($HTTP_POST_VARS['btnSMP'])
	{
	//nilai
	$keakd = nosql($_POST['keakd']);
	$kelkd = nosql($_POST['kelkd']);
	$jnskd = nosql($_POST['jnskd']);
	$mapelkd = nosql($_POST['mapelkd']);
	$total = nosql($_POST['total']);
	$kolom = "4";
	
	//ambil semua
	for ($j=1; $j<=$total;$j++) 
		{
		$xsp = "aspekkd";
		$xsp1 = "$xsp$j";
		$xspxx = nosql($_POST["$xsp1"]);
	
		$xsmt = "1smtkd";
		$xsmt1 = "$xsmt$j";
		$xsmtxx = nosql($_POST["$xsmt1"]);

		$xsmtx = "2smtkd";
		$xsmtx1 = "$xsmtx$j";
		$xsmtxxx = nosql($_POST["$xsmtx1"]);
		
		$xuh = "1uh";
		$xuh1 = "$xuh$j";
		$xuhxx = nosql($_POST["$xuh1"]);
		
		$xua = "2ua";
		$xua1 = "$xua$j";
		$xuaxx = nosql($_POST["$xua1"]);

		$xuhx = "3uh";
		$xuhx1 = "$xuhx$j";
		$xuhxxx = nosql($_POST["$xuhx1"]);
		
		$xuax = "4ua";
		$xuax1 = "$xuax$j";
		$xuaxxx = nosql($_POST["$xuax1"]);
			
		//jika semester SATU
		if ((substr($xsmt,0,1) == "1"))
			{
			//random
			$xrnd1 = rand(1,1000000);
			$xx1 = md5("1$x$j$xrnd");
		
			//cek
			$qc = mysql_query("SELECT * FROM ulangan_jml ".
								"WHERE kd_keahlian = '$keakd' ".
								"AND kd_kelas = '$kelkd' ".
								"AND kd_prog_pddkn = '$mapelkd' ".
								"AND kd_aspek = '$xspxx' ".
								"AND kd_smt = '$xsmtxx'");
			$tc = mysql_num_rows($qc);

			//update
			if ($tc != 0)
				{
				//update
				mysql_query("UPDATE ulangan_jml SET jml_hr = '$xuhxx', ".
								"jml_akhir = '$xuaxx' ".
								"WHERE kd_keahlian = '$keakd' ".
								"AND kd_kelas = '$kelkd' ".
								"AND kd_prog_pddkn = '$mapelkd' ".
								"AND kd_aspek = '$xspxx' ".
								"AND kd_smt = '$xsmtxx'");
				}
			else //insert
				{
				mysql_query("INSERT INTO ulangan_jml(kd, kd_keahlian, kd_kelas, kd_prog_pddkn, kd_aspek, kd_smt, ".
								"jml_hr, jml_akhir) VALUES ".
								"('$xx1', '$keakd', '$kelkd', '$mapelkd', '$xspxx', '$xsmtxx', ".
								"'$xuhxx', '$xuaxx')");
				}	
			}
		
		//jika semester DUA
		if ((substr($xsmtx,0,1) == "2"))
			{
			//random
			$xrnd2 = rand(1,1000000);
			$xx2 = md5("2$x$j$xrnd");

			//cek
			$qc = mysql_query("SELECT * FROM ulangan_jml ".
								"WHERE kd_keahlian = '$keakd' ".
								"AND kd_kelas = '$kelkd' ".
								"AND kd_prog_pddkn = '$mapelkd' ".
								"AND kd_aspek = '$xspxx' ".
								"AND kd_smt = '$xsmtxxx'");
			$tc = mysql_num_rows($qc);

			//update
			if ($tc != 0)
				{
				mysql_query("UPDATE ulangan_jml SET jml_hr = '$xuhxxx', ".
								"jml_akhir = '$xuaxxx' ".
								"WHERE kd_keahlian = '$keakd' ".
								"AND kd_kelas = '$kelkd' ".
								"AND kd_prog_pddkn = '$mapelkd' ".
								"AND kd_aspek = '$xspxx' ".
								"AND kd_smt = '$xsmtxxx'");
				}
			else //insert
				{
				mysql_query("INSERT INTO ulangan_jml(kd, kd_keahlian, kd_kelas, kd_prog_pddkn, kd_aspek, kd_smt, ".
								"jml_hr, jml_akhir) VALUES ".
								"('$xx2', '$keakd', '$kelkd', '$mapelkd', '$xspxx', '$xsmtxxx', '$xuhxxx', '$xuaxxx')");
				}	
			}		
		}
	
	//re-direct
	xloc($ke);
	}
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////


//isi *START
ob_start();

//js
require("../../inc/js/jumpmenu.js");
require("../../inc/js/swap.js");
require("../../inc/js/number.js");
require("../../inc/menu/admtu.php");
xheadline($judul);

echo '<form name="formx" method="post" action="'.$filenya.'">
<table bgcolor="'.$warnaover.'" width="100%" border="0" cellspacing="0" cellpadding="3">
<tr>
<td>
Keahlian : ';
echo "<select name=\"keahlian\" onChange=\"MM_jumpMenu('self',this,0)\">";

//terpilih
$qkeax = mysql_query("SELECT * FROM m_keahlian ".
						"WHERE kd = '$keakd'");
$rowkeax = mysql_fetch_assoc($qkeax);

$keax_kd = nosql($rowkeax['kd']);
$keax_bid = nosql($rowkeax['bidang']);
$keax_pro = nosql($rowkeax['program']);

echo '<option value="'.$keax_kd.'">'.$keax_bid.' - '.$keax_pro.'</option>';

$qkea = mysql_query("SELECT * FROM m_keahlian ".
						"WHERE kd <> '$keakd' ".
						"ORDER BY bidang ASC");
$rowkea = mysql_fetch_assoc($qkea);
				
do
	{
	$kea_kd = nosql($rowkea['kd']);
	$kea_bid = nosql($rowkea['bidang']);
	$kea_pro = nosql($rowkea['program']);
	
	echo '<option value="'.$filenya.'?keakd='.$kea_kd.'">'.$kea_bid.' - '.$kea_pro.'</option>';
	}
while ($rowkea = mysql_fetch_assoc($qkea));

echo '</select>, 

Kelas : ';
echo "<select name=\"kelas\" onChange=\"MM_jumpMenu('self',this,0)\">";

//terpilih
$qbtx = mysql_query("SELECT * FROM m_kelas ".
						"WHERE kd = '$kelkd'");
$rowbtx = mysql_fetch_assoc($qbtx);

$btxkd = nosql($rowbtx['kd']);
$btxkelas = nosql($rowbtx['kelas']);

echo '<option value="'.$btxkd.'">'.$btxkelas.'</option>';

$qbt = mysql_query("SELECT * FROM m_kelas ".
						"WHERE kd <> '$kelkd' ".
						"ORDER BY no ASC");
$rowbt = mysql_fetch_assoc($qbt);
				
do
	{
	$btkd = nosql($rowbt['kd']);
	$btkelas = nosql($rowbt['kelas']);
	
	echo '<option value="'.$filenya.'?keakd='.$keakd.'&kelkd='.$btkd.'">'.$btkelas.'</option>';
	}
while ($rowbt = mysql_fetch_assoc($qbt));

echo '</select>, 

<br>

Jenis : ';
echo "<select name=\"jenis\" onChange=\"MM_jumpMenu('self',this,0)\">";

//terpilih
$qjnx = mysql_query("SELECT * FROM m_prog_pddkn_jns ".
						"WHERE kd = '$jnskd'");
$rowjnx = mysql_fetch_assoc($qjnx);

$jnx_kd = nosql($rowjnx['kd']);
$jnx_jns = nosql($rowjnx['jenis']);

echo '<option value="'.$jnx_kd.'">'.$jnx_jns.'</option>';

//jenis
$qjn = mysql_query("SELECT * FROM m_prog_pddkn_jns ".
						"WHERE kd <> '$jnskd' ".
						"ORDER BY jenis ASC");
$rowjn = mysql_fetch_assoc($qjn);
				
do
	{
	$jn_kd = nosql($rowjn['kd']);
	$jn_jns = balikin($rowjn['jenis']);
	
	echo '<option value="'.$filenya.'?keakd='.$keakd.'&kelkd='.$kelkd.'&jnskd='.$jn_kd.'">'.$jn_jns.'</option>';
	}
while ($rowjn = mysql_fetch_assoc($qjn));

echo '</select>, 

Program Pendidikan : ';
echo "<select name=\"mapel\" onChange=\"MM_jumpMenu('self',this,0)\">";

//terpilih
$qstx = mysql_query("SELECT * FROM m_prog_pddkn ".
						"WHERE kd_jenis = '$jnskd' ".
						"AND kd = '$mapelkd'");
$rowstx = mysql_fetch_assoc($qstx);
$txkd = nosql($rowstx['kd']);
$txpel = balikin($rowstx['prog_pddkn']);

echo '<option value="'.$txkd.'">'.$txpel.'</option>';

$qst = mysql_query("SELECT m_prog_pddkn.*, m_prog_pddkn.kd AS mpkd, m_prog_pddkn_kelas.* ".
						"FROM m_prog_pddkn, m_prog_pddkn_kelas ".
						"WHERE m_prog_pddkn.kd = m_prog_pddkn_kelas.kd_prog_pddkn ".
						"AND m_prog_pddkn_kelas.kd_keahlian = '$keakd' ".
						"AND m_prog_pddkn_kelas.kd_kelas = '$kelkd' ".
						"AND m_prog_pddkn.kd_jenis = '$jnskd' ".
						"AND m_prog_pddkn.kd <> '$mapelkd' ".
						"ORDER BY m_prog_pddkn.prog_pddkn ASC");
$rowst = mysql_fetch_assoc($qst);
				
do
	{
	$mapelkd = nosql($rowst['mpkd']);
	$stpel = balikin2($rowst['prog_pddkn']);
	
	echo '<option value="'.$filenya.'?keakd='.$keakd.'&kelkd='.$kelkd.'&jnskd='.$jnskd.'&mapelkd='.$mapelkd.'">'.$stpel.'</option>';
	}
while ($rowst = mysql_fetch_assoc($qst));

echo '</select>
</td>
</tr>
</table>
<br>';

//nilai
$keakd = nosql($_REQUEST['keakd']);
$kelkd = nosql($_REQUEST['kelkd']);
$jnskd = nosql($_REQUEST['jnskd']);
$mapelkd = nosql($_REQUEST['mapelkd']);

//nek drg
if (empty($keakd))
	{
	echo '<font color="#FF0000"><strong>KEAHLIAN Belum Dipilih...!</strong></font>';
	}
else if (empty($kelkd))
	{
	echo '<font color="#FF0000"><strong>KELAS Belum Dipilih...!</strong></font>';
	}
else if (empty($jnskd))
	{
	echo '<font color="#FF0000"><strong>JENIS PROGRAM PENDIDIKAN Belum Dipilih...!</strong></font>';
	}
else if (empty($mapelkd))
	{
	echo '<font color="#FF0000"><strong>PROGRAM PENDIDIKAN Belum Dipilih...!</strong></font>';
	}
else
	{
	//query	  
	$q = mysql_query("SELECT m_aspek_prog_pddkn.*, m_aspek.*, m_aspek.kd AS mskd ".
						"FROM m_aspek_prog_pddkn, m_aspek ".
						"WHERE m_aspek_prog_pddkn.kd_aspek = m_aspek.kd ".
						"AND m_aspek_prog_pddkn.kd_keahlian = '$keakd' ".
						"AND m_aspek_prog_pddkn.kd_kelas = '$kelkd' ".
						"AND m_aspek_prog_pddkn.kd_prog_pddkn = '$mapelkd'");
	$row = mysql_fetch_assoc($q);
	$total = mysql_num_rows($q);
	
	echo '<table width="700" border="1" cellpadding="3" cellspacing="0">
    <tr bgcolor="'.$warnaheader.'"> 
    <td rowspan="2"><div align="center"><strong>Aspek</strong></div></td>
    <td colspan="2"><div align="center"><strong>SEMESTER 1</strong></div></td>
    <td colspan="2"><div align="center"><strong>SEMESTER 2</strong></div></td>
    </tr>
    <tr bgcolor="'.$warnaheader.'"> 
    <td width="10%"><div align="center"><strong>Ulangan Harian</strong></div></td>
    <td width="10%"><div align="center"><strong>Ulangan Akhir</strong></div></td>
    <td width="10%"><div align="center"><strong>Ulangan Harian</strong></div></td>
    <td width="10%"><div align="center"><strong>Ulangan Akhir</strong></div></td>
    </tr>';
	
	
	if ($total != 0)
		{
		do
  			{
			if ($warna_set ==0)
				{
				$warna = $warna01;
				$warna_set = 1;
				}
			else
				{
				$warna = $warna02;
				$warna_set = 0;
				}

			$nomer = $nomer + 1;
		
			$kd = nosql($row['mskd']);
			
			echo "<tr valign=\"top\" bgcolor=\"$warna\" onmouseover=\"this.bgColor='$warnaover';\" onmouseout=\"this.bgColor='$warna';\">";
			echo '<td valign="top"><input name="aspekkd'.$nomer.'" type="hidden" value="'.$kd.'">'.balikin2($row['aspek']).'</td>
      		<td valign="top"><div align="center">';
			
			
		  	//smt satu
		  	$smt = "1";
		  
			//smt
			$qsmt = mysql_query("SELECT * FROM m_smt ".
		  							"WHERE smt = '$smt'");
			$rsmt = mysql_fetch_assoc($qsmt);
			$smtkd = nosql($rsmt['kd']);
			
			echo '<input name="1smtkd'.$nomer.'" type="hidden" value="'.$smtkd.'">';
			
			//terpilih
			$qe = mysql_query("SELECT * FROM ulangan_jml ".
								"WHERE kd_kelas = '$kelkd' ".
								"AND kd_prog_pddkn = '$mapelkd' ".
								"AND kd_aspek = '$kd' ".
								"AND kd_smt = '$smtkd'");
			$re = mysql_fetch_assoc($qe);
			$jmlx = nosql($re['jml_hr']);
			$jmlx1 = nosql($re['jml_akhir']);
			
			//nek null
			if (empty($jmlx))
				{
				$jmlx = "1";
				}
			
			if (empty($jmlx1))
				{
				$jmlx1 = "1";
				}
			
			echo '<input name="1uh'.$nomer.'" type="text" onKeyPress="return numbersonly(this, event)" value="'.$jmlx.'" size="1" maxlength="1">
        	</div></td>
	      	<td valign="top"><div align="center">
	        <input name="1smtkd'.$nomer.'" type="hidden" value="'.$smtkd.'">
	        <input name="2ua'.$nomer.'" type="text" onKeyPress="return numbersonly(this, event)" value="'.$jmlx1.'" size="1" maxlength="1">
	        </div></td>
	      	<td valign="top"><div align="center">';
			
		  	//smt dua
		  	$smtx = "2";
		  
			//smt
			$qsmtx = mysql_query("SELECT * FROM m_smt ".
		  							"WHERE smt = '$smtx'");
			$rsmtx = mysql_fetch_assoc($qsmtx);
			$smtkdx = nosql($rsmtx['kd']);
			
			echo '<input name="2smtkd'.$nomer.'" type="hidden" value="'.$smtkdx.'">';
			
			
			//terpilih
			$qex = mysql_query("SELECT * FROM ulangan_jml ".
									"WHERE kd_keahlian = '$keakd' ".
									"AND kd_kelas = '$kelkd' ".
									"AND kd_prog_pddkn = '$mapelkd' ".
									"AND kd_aspek = '$kd' ".
									"AND kd_smt = '$smtkdx'");
			$rex = mysql_fetch_assoc($qex);
			$jmlxx = nosql($rex['jml_hr']);
			$jmlxx1 = nosql($rex['jml_akhir']);
			
			//nek null
			if (empty($jmlxx))
				{
				$jmlxx = "1";
				}
			
			if (empty($jmlxx1))
				{
				$jmlxx1 = "1";
				}
			
			echo '<input name="3uh'.$nomer.'" type="text" onKeyPress="return numbersonly(this, event)" value="'.$jmlxx.'" size="1" maxlength="1">
	        </div></td>
    	  	<td valign="top"><div align="center">
	        <input name="2smtkd'.$nomer.'" type="hidden" value="'.$smtkdx.'">
	        <input name="4ua'.$nomer.'" type="text" onKeyPress="return numbersonly(this, event)" value="'.$jmlxx1.'" size="1" maxlength="1">
	        </div></td>
	    	</tr>';
  			}
		while ($row = mysql_fetch_assoc($q));
		}
	echo '</table>
  	<table width="700" border="0" cellspacing="0" cellpadding="1">
    <tr>
    <td align="right"> 
    <input name="keakd" type="hidden" value="'.$keakd.'">
	<input name="kelkd" type="hidden" value="'.$kelkd.'">
	<input name="jnskd" type="hidden" value="'.$jnskd.'">
    <input name="mapelkd" type="hidden" value="'.$mapelkd.'">
    <input name="total" type="hidden" value="'.$total.'">
    <input name="btnSMP" type="submit" value="SIMPAN">
    </td>
    </tr>
  	</table>';
	}

echo '</form>
<br>
<br>
<br>';
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////


//isi
$isi = ob_get_contents();
ob_end_clean();


require("../../inc/niltpl.php");
?>