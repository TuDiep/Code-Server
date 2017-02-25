	<?php
	
	include_once ("config.php");
	$maloaicha = $_POST["maloaicha"];
	$truyvan = "SELECT * FROM loaisanpham WHERE MALOAI_CHA = '".$maloaicha."'";
	$ketqua = mysqli_query($conn,$truyvan);
	$chuoijson=array();
	echo "{";
	echo "\"LOAISANPHAM\":";
	if ($ketqua) {
		while ($dong=mysqli_fetch_array($ketqua)) {
			$chuoijson[]=$dong;
			// array_push($chuoijson,array("TENLOAISANPHAM"=>$dong["TENLOAISP"],"MALOAISP"=>$dong["MALOAISP"]));
		}
		echo json_encode($chuoijson,JSON_UNESCAPED_UNICODE);
	}
	echo "}";
?>