	<?php
	
	include_once ("config.php");

	$ham = $_POST["ham"];
	switch ($ham) {
		case 'LayDanhSachCacThuongHieuLon':
			$ham();
			break;

			case 'LayDanhSachMenu':
			$ham();
			break;

			case 'LayDanhSachTopDienThoaiVaMayTinhBang':
			$ham();
			break;

			case 'LayDanhSachTopPhuKien':
			$ham();
			break;
		
		
		default:
			# code...
			break;
	}

	function LayDanhSachPhuKien(){
			global $conn;

			//lấy danh sách phụ kiện cha
			$truyvancha = "SELECT *  FROM loaisanpham lsp WHERE lsp.TENLOAISP LIKE 'phụ kiện điện thoại%'";
			$ketqua = mysqli_query($conn,$truyvancha);
			$chuoijson = array();

			echo "{";
			echo "\"DANHSACHPHUKIEN\":";
			if($ketqua){
				while ($dong=mysqli_fetch_array($ketqua)) {
					
					//Lấy danh sách phụ kiện con
					$truyvanphukiencon = "SELECT *  FROM loaisanpham lsp, sanpham sp WHERE lsp.MALOAI_CHA = ".$dong["MALOAISP"]." AND lsp.MALOAISP = sp.MALOAISP ORDER BY sp.LUOTMUA DESC LIMIT 10";
			
					$ketquacon = mysqli_query($conn,$truyvanphukiencon);	
					
					if($ketquacon){
						while ($dongphukiencon = mysqli_fetch_array($ketquacon)) {
							array_push($chuoijson, array("MASP"=>$dongphukiencon["MALOAISP"],'TENSP' => $dongphukiencon["TENLOAISP"],'GIATIEN'=>$dongphukiencon["GIA"],'HINHSANPHAM'=>"http://".$_SERVER['SERVER_NAME']."/appshop".$dongphukiencon["ANHLON"]));
					
						}
					}
					
				}

				
			}

			echo json_encode($chuoijson,JSON_UNESCAPED_UNICODE);
			echo "}";
	}

	function LayDanhSachTopPhuKien(){
		global $conn;
		
		$truyvan = "SELECT *  FROM loaisanpham lsp WHERE lsp.TENLOAISP LIKE 'phụ kiện điện thoại%'";
		$ketqua = mysqli_query($conn,$truyvan);
		$chuoijson=array();
		echo "{";
		echo "\"TOPPHUKIEN\":";
		if ($ketqua) {
			while ($dong=mysqli_fetch_array($ketqua)) {
				
				$truyvanphukiencon = "SELECT *  FROM loaisanpham lsp, sanpham sp WHERE lsp.MALOAI_CHA = ".$dong["MALOAISP"]." AND lsp.MALOAISP = sp.MALOAISP ORDER BY sp.LUOTMUA DESC LIMIT 10";
			
				$ketquacon = mysqli_query($conn,$truyvanphukiencon);
				if($ketquacon){
						while ($dongphukiencon = mysqli_fetch_array($ketquacon)) {
							array_push($chuoijson,array("MASP"=>$dongphukiencon["MASP"],"TENSP"=>$dongphukiencon["TENSP"],"GIATIEN"=>$dongphukiencon["GIA"],"HINHSANPHAM"=>"http://".$_SERVER['SERVER_NAME']."/appshop".$dongphukiencon["ANHLON"]));
					
						}
					}

			}
			
		}
		
		echo json_encode($chuoijson,JSON_UNESCAPED_UNICODE);
		echo "}";
	}


	function LayDanhSachTopDienThoaiVaMayTinhBang(){
		global $conn;
		//truy vấn điện thoại
		$truyvan = "SELECT * FROM loaisanpham lsp,sanpham sp WHERE lsp.TENLOAISP LIKE  'điện thoại%' AND lsp.MALOAISP = sp.MALOAISP ORDER BY sp.LUOTMUA DESC LIMIT 10 ";
		$ketqua = mysqli_query($conn,$truyvan);
		$chuoijson=array();
		echo "{";
		echo "\"TOPDIENTHOAIVAMAYTINHBANG\":";
		if ($ketqua) {
			while ($dong=mysqli_fetch_array($ketqua)) {
				
				array_push($chuoijson,array("MASP"=>$dong["MASP"],"TENSP"=>$dong["TENSP"],"GIATIEN"=>$dong["GIA"],"HINHSANPHAM"=>"http://".$_SERVER['SERVER_NAME']."/appshop".$dong["ANHLON"]));
			}
			
		}
		// 
			// truy vấn máy tính bảng
			$truyvan = "SELECT * FROM loaisanpham lsp,sanpham sp WHERE lsp.TENLOAISP LIKE  'máy tính bảng%' AND lsp.MALOAISP = sp.MALOAISP ORDER BY sp.LUOTMUA DESC LIMIT 10 ";
		$ketquamtb = mysqli_query($conn,$truyvan);
		if ($ketquamtb) {
			while ($dongmtb=mysqli_fetch_array($ketquamtb)) {
				
				array_push($chuoijson,array("MASP"=>$dongmtb["MASP"],"TENSP"=>$dongmtb["TENSP"],"GIATIEN"=>$dongmtb["GIA"],"HINHSANPHAM"=>"http://".$_SERVER['SERVER_NAME']."/appshop".$dongmtb["ANHLON"]));
			}
			
		}
		echo json_encode($chuoijson,JSON_UNESCAPED_UNICODE);
		echo "}";
	}
	
	function LayDanhSachCacThuongHieuLon(){	
		global $conn;

		$truyvan = "SELECT * FROM thuonghieu th,chitietthuonghieu cth WHERE th.MATHUONGHIEU=cth.MATHUONGHIEU";
		$ketqua = mysqli_query($conn,$truyvan);
		$chuoijson=array();
		echo "{";
		echo "\"DANHSACHTHUONGHIEU\":";
		if ($ketqua) {
			while ($dong=mysqli_fetch_array($ketqua)) {
				
				array_push($chuoijson,array("MATHUONGHIEU"=>$dong["MATHUONGHIEU"],"TENTHUONGHIEU"=>$dong["TENTHUONGHIEU"],"HINHTHUONGHIEU"=>"http://".$_SERVER['SERVER_NAME']."/appshop".$dong["HINHTHUONGHIEU"]));
			}
			echo json_encode($chuoijson,JSON_UNESCAPED_UNICODE);
		}
		echo "}";

	}
	function LayDanhSachMenu(){
		global $conn;
		if (isset($_POST["maloaicha"])){	
			$maloaicha= $_POST["maloaicha"];
		
		}

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

		mysqli_close($conn);

	}
?>