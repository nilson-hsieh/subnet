<?php
include('../config/counter.php');
count_people(ip_counter);
include_once("./function.php");
if(isset($_POST['submit'])){
	$ip_value=$_POST['ip'];
	$ms_value=$_POST['mask'];
	$ipNum = ip2long($ip_value);
    if(!$ipNum==""){
         $msNum = ip2long($ms_value);
         if(!$msNum==""){
    		//判斷輸入數值是否正確
       		$ip_add = (string)$_POST['ip'];
    		$ip_add = str_replace("."," ",$ip_add); 
   			$ip_arr=mb_split("\s",$ip_add);
   			//***********轉換成2進位**************
   			$ip_a = decbin($ip_arr[0]);
   			$ip_b = decbin($ip_arr[1]);
   			$ip_c = decbin($ip_arr[2]);
   			$ip_d = decbin($ip_arr[3]);
    		if(strlen($ip_a)<8){
     			$ip_a= str_pad($ip_a, 8, "0", STR_PAD_LEFT);
  			}
  			if(strlen($ip_b)<8){
     			$ip_b= str_pad($ip_b, 8, "0", STR_PAD_LEFT);
  			}
  			if(strlen($ip_c)<8){
     			$ip_c= str_pad($ip_c, 8, "0", STR_PAD_LEFT);
  			}
  			if(strlen($ip_d)<8){
     			$ip_d= str_pad($ip_d, 8, "0", STR_PAD_LEFT);
  			}
  			//將IP儲存到陣列
  			$a_ip_b_arr = preg_split('//', $ip_a, -1, PREG_SPLIT_NO_EMPTY);
  			$b_ip_b_arr = preg_split('//', $ip_b, -1, PREG_SPLIT_NO_EMPTY);
  			$c_ip_b_arr = preg_split('//', $ip_c, -1, PREG_SPLIT_NO_EMPTY);
  			$d_ip_b_arr = preg_split('//', $ip_d, -1, PREG_SPLIT_NO_EMPTY);
  			//計算主機數量
   			$ms_add = (string)$_POST['mask'];
    		$ms_add = str_replace("."," ",$ms_add); 
   			$ms_arr=mb_split("\s",$ms_add);
  		    if($ms_arr[0]==255&&$ms_arr[1]==255&&$ms_arr[2]==255&&$ms_arr[3]==255){
        		$max_host=1;
    		}else if($ms_arr[0]==255&&$ms_arr[1]==255&&$ms_arr[2]==255){
        		if($ms_arr[3]==254){ 
            		$max_host=2;
        		}else if($ms_arr[3]==254){
             		$max_host=4;
        		}else if($ms_arr[3]==252){
             		$max_host=8;
        		}else if($ms_arr[3]==248){
             		$max_host=16;
        		}else if($ms_arr[3]==224){
             		$max_host=32;
        		}else if($ms_arr[3]==192){
             		$max_host=64;
        		}else if($ms_arr[3]==128){
             		$max_host=128;
        		}else if($ms_arr[3]==0){
             		$max_host=256;
        		}
    		}else if($ms_arr[0]==255&&$ms_arr[1]==255){
        		if($ms_arr[2]==254){ 
            		$max_host=512;
        		}else if($ms_arr[2]==254){
             		$max_host=1024;
        		}else if($ms_arr[2]==252){
             		$max_host=2048;
        		}else if($ms_arr[2]==248){
             		$max_host=4096;
        		}else if($ms_arr[2]==224){
             		$max_host=8192;
        		}else if($ms_arr[2]==192){
             		$max_host=16384;
        		}else if($ms_arr[2]==128){
             		$max_host=32768;
        		}else if($ms_arr[2]==0){
             		$max_host=65535;
        		}
    		}else if($ms_arr[0]==255){
        		if($ms_arr[1]==254){ 
            		$max_host=131072;
        		}else if($ms_arr[1]==254){
             		$max_host=262144;
        		}else if($ms_arr[1]==252){
             		$max_host=524288;
        		}else if($ms_arr[1]==248){
             		$max_host=1048576;
        		}else if($ms_arr[1]==224){
             		$max_host=2097152;
        		}else if($ms_arr[1]==192){
             		$max_host=4194304;
        		}else if($ms_arr[1]==128){
             		$max_host=8388608;
        		}else if($ms_arr[1]==0){
             		$max_host=16777216;
        		}
    		}else{;}
  			//計算主機位置
			$ip_add_d=ip2long ( $_POST['ip'] );
			$ms_add_d=ip2long ( $_POST['mask'] );
			$netNum = ($ip_add_d & $ms_add_d);
			do{
    			$f_netNum = ($ip_add_d & $ms_add_d);
    			$ip_add_d--;
			}while($netNum==$f_netNum);
			$f_ip_add=long2ip ($ip_add_d +2);
			$f_use_ip_add=long2ip ($ip_add_d +3);
			$final_use_ip_add=long2ip ($ip_add_d +$max_host);
			$broadcast_add = long2ip ($ip_add_d +($max_host+1));
     	}else{
        	echo '<script language="javascript">alert("數值錯誤")</script>';
        }
    }else{
         echo '<script language="javascript">alert("數值錯誤")</script>';
    }
}else{
	$ip_value='';
    $ms_value='';
}
?>
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
		<title>IP計算機</title>
		<meta name="viewport" content="width=device-width, initial-scale=1" />
		<link rel="shortcut icon" href="../web.ico">
		<link rel="stylesheet" href="assets/css/main.css" />
	</head>
	<body>
		<div id="wrapper">
			<section id="intro" class="main" >
				<form action="#" method="post">
					<table border="0">
						<tr>
							<td align="center">
								<h4 >IP位置</h4>
							</td>
</tr>
<tr>
<td>
    <input type="text" name="ip" value="<?echo $ip_value;?>">
</td>
</tr>
<tr>
<td id="h4" align="center">
    <h4>子網路遮罩</h4>
</td>
</tr>
<tr>
<td>
    <input type="text" name="mask" value="<?echo $ms_value; ?>">
</td>
</tr>
</table>
<input type="submit" name="submit" value="&nbsp轉換&nbsp;">
</form>
	</body>
	<?php
if(!isset($_POST['submit'])){
  exit;  
}
?>
<table border="0">
<tr>
<td align="center">
<h4 >網路</h4>
</td>
<td>
    <input type="text" readonly="readonly" value="<? echo $f_ip_add;?>" >
</td>
</tr>
<tr>
<td id="h4" align="center">
    <h4>遮罩</h4>
</td>
<td>
    <input type="text" name="mask" readonly="readonly" value="<? echo $_POST['mask'];?>">
</td>
</tr>
<tr>
<td align="center">
<h4 >第一個可用位置</h4>
</td>
<td>
    <input type="text" readonly="readonly" value="<? echo $f_use_ip_add;?>">
</td>
</tr>
<tr>
<td id="h4" align="center">
    <h4>最後可用位置</h4>
</td>
<td>
    <input type="text" readonly="readonly" value="<?echo $final_use_ip_add;?>">
</td>
</tr>
<tr>
<td align="center">
<h4 >廣播位置</h4>
</td>
<td>
    <input type="text" readonly="readonly" value="<?echo $broadcast_add;?>">
</td>
</tr>
<tr>
<td id="h4" align="center">
    <h4>可用位置數</h4>
</td>
<td>
    <input type="text" readonly="readonly" value="<?echo $max_host-2;?>">
</td>
</tr>
</table>
</html>
