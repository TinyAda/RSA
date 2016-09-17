<?php namespace TinyAda\RSA;

use Illuminate\Support\Facades\Config;

class RSALib
{   
    /**
     * [私钥]
     * @var [type]
     */
    public $private_exp;

    /**
     * [私钥]
     * @var [type]
     */
    public $public_exp;

    /**
     * [模数]
     * @var [type]
     */
    public $modulus;

    /**
     * RSALib constructor.
     */
    public function __construct()
    {
        $this->private_exp = Config::get('rsa.private_exp');
        $this->public_exp = Config::get('rsa.public_exp');
        $this->modulus = Config::get('rsa.modulus');
    }

    /**
     * 模乘 ($p^$q)mod($r)
     * 依赖 php_gmp.dll
     * 
     * @param  string base
     * @param  string 指数
     * @param  string 取模
     * @return string
     */
    function powMod($p, $q, $r)
    {
        if(function_exists('gmp_powm')){
            return gmp_strval(gmp_powm($p,$q,$r));
        }
        // Extract powers of 2 from $q
        $factors = array();
        $div = $q;
        $power_of_two = 0;
        while(bccomp($div, "0") == 1) //define("BCCOMP_LARGER", 1);
        {
            $rem = bcmod($div, 2);
            $div = bcdiv($div, 2);
        
            if($rem) array_push($factors, $power_of_two);
            $power_of_two++;
        }
        // Calculate partial results for each factor, using each partial result as a
        // starting point for the next. This depends of the factors of two being
        // generated in increasing order.
        $partial_results = array();
        $part_res = $p;
        $idx = 0;
        foreach($factors as $factor)
        {
            while($idx < $factor)
            {
                $part_res = bcpow($part_res, "2");
                $part_res = bcmod($part_res, $r);
                $idx++;
            }
            
            array_push($partial_results, $part_res);
        }
        // Calculate final result
        $result = "1";
        foreach($partial_results as $part_res)
        {
            $result = bcmul($result, $part_res);
            $result = bcmod($result, $r);
        }
        return $result;
    }

    /**
     * 十进制转十六进制
     * 
     * @param  string 十进制数字字符串
     * @return string
     */
    function dec2Hex($number)
    {
        $hexvalues = array('0','1','2','3','4','5','6','7','8','9','A','B','C','D','E','F');
        $hexval = '';
        while($number != '0')
        {
            $hexval = $hexvalues[bcmod($number,'16')].$hexval;
            $number = bcdiv($number,'16',0);
        }
        return $hexval;
    }

    /**
     * 十六进制字符串转十进制字符串
     * 
     * @param  string 十六进制字符串
     * @return string 
     */
    function hex2Dec($number)
    {
        $decvalues = array('0'=>'0','1'=>'1','2'=>'2','3' => '3', '4' => '4', '5' => '5','6' => '6', '7' => '7', '8' => '8','9' => '9', 'A' => '10', 'B' => '11','C' => '12', 'D' => '13', 'E' => '14','F' => '15');
        $decval = '0';
        $number = strrev($number);
        for($i = 0; $i < strlen($number); $i++)
        {
        $decval = bcadd(bcmul(bcpow('16',$i,0),$decvalues[$number{$i}]), $decval);
        }
        return $decval;
    }

    /**
     * 字符串转十六进制
     * 
     * @param  string 字符串
     * @return string
     */
    function str2Hex($string)
    { 
        $hex="";
        for($i=0;$i<strlen($string);$i++){
            $hex.=substr("00".dechex(ord($string[$i])),-2);
        }
        $hex=strtoupper($hex);
        return $hex;
    }

    /**
     * 十六进制转成字符串
     * 
     * @param  string 十六进制字符串
     * @return string
     */
    function hex2Str($hex)//十六进制转字符串
    {   
        $string=""; 
        for($i=0;$i<strlen($hex)-1;$i+=2)
        $string.=chr(hexdec($hex[$i].$hex[$i+1]));
        return  $string;
    }

    /**
     * gbk转utf8
     * 
     * @param  string gbk编码的字符串
     * @return string
     */
    function gbk2Utf8($str){
        return mb_convert_encoding($str, 'utf-8', 'gbk');
    }
    
    /**
     * utf8转gbk
     * 
     * @param  string utf8编码的字符串
     * @return string 
     */
    function utf82Gbk($str){
        return mb_convert_encoding($str, 'gbk', 'utf-8');
    }

    /**
     * 设置公钥私钥和模数
     * @param array $arr [description]
     */
    function setKey(array $arr)
    {
        foreach ($arr as $key => $value) {
            $this->$$key = $value;
        }
    }

    /**
     * rsa解密
     * 
     * @param  string 待解密的密文
     * @return string
     */
    function decrypt($ciphertext)
    {
        $decrypted = $this->powMod($this->hex2Dec($ciphertext),$this->hex2Dec($this->private_exp),$this->hex2Dec($this->modulus));
        return $this->gbk2Utf8($this->hex2Str($this->dec2Hex($decrypted)));
    }

    /**
     * rsa加密
     * 
     * @param  string 明文
     * @return string 十六进制 
     */
    function encrypt($plaintext)
    {
        $plaintext = $this->utf82Gbk($plaintext);
        $plaintext = $this->hex2Dec($this->str2Hex($plaintext));
        $modulus = $this->hex2Dec($this->modulus);
        if($plaintext > $modulus){
            throw new \Exception("明文不能大于模数！！！");
        }
        $encrypted = $this->powMod($plaintext, $this->hex2Dec($this->public_exp),$modulus);
        return $this->dec2hex($encrypted);
    }

}
