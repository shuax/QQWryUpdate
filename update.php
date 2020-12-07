<?php
	/*
		纯真数据库自动更新原理实现
		www.shuax.com 2014.03.27
	*/
	ini_set('user_agent', 'Mozilla/3.0 (compatible; Indy Library)');  
	$copywrite = file_get_contents("http://update.cz88.net/ip/copywrite.rar");
	$qqwry = file_get_contents("http://update.cz88.net/ip/qqwry.rar");
	$key = unpack("V6", $copywrite)[6];
/*
//copywrite.rar 总计280字节
{

uint32_t sign;// "CZIP" uint32_t version;//一个和日期有关的值 uint32_t unknown1;// 0x01 uint32_t size;// qqwry.rar大小 uint32_t unknown2; uint32_t key;// 解密qqwry.rar前0x200字节所需密钥 char text[128];//提供商 char link[128];//网址
}
*/

	for($i=0; $i<0x200; $i++)
	{
		$key *= 0x805;
		$key ++;
		$key = $key & 0xFF;
		$qqwry[$i] = chr( ord($qqwry[$i]) ^ $key );
	}

	$qqwry = gzuncompress($qqwry);

	$fp = fopen("qqwry.dat", "wb");
	if($fp)
	{
		fwrite($fp, $qqwry);
		fclose($fp);
	}
?>
