<?php

    header("Content-type: image/jpeg;charset=utf-8");

    $file = 'https://api.dujin.org/bing/1366.php';                         //原图片文件
    $maxWidth = 700;
    $info = getimagesize($file);     //取得一个图片信息的数组，索引 0 包含图像宽度的像素值，索引
    $im = imagecreatefromjpeg($file);                      //根据图片的格式对应的不同的函数，在此不多赘述。
    $rate = $maxWidth/$info[0];                               //计算绽放比例
    $maxHeight = floor($info[1]*$rate);                    //计算出缩放后的高度
    $des_im = imagecreatetruecolor($maxWidth,$maxHeight);          //创建一个缩放的画布
    imagecopyresized($des_im,$im,0,0,0,0,$maxWidth,$maxHeight,$info[0],$info[1]); //缩放
    imagejpeg($des_im,'pic.jpg');


    $month = date('m',time());//获取月份
    $day = date('d',time());//获取日期

    /*
      月份转汉字
    */
    function Array_Month($month){
    $arr=array('一','二','三','四','五','六','七','八','九','十','十一','十二');
    foreach($arr as $key=>$val){
        if($key+1==$month){
            return $val;
            }
        }
    }

    $html = file_get_contents('http://localhost/font.php');//本地服务器地址加font.php

    $image = imagecreatetruecolor(750,1334);//画布大小

        //设置背景颜色
        $bgcolor = imagecolorallocate($image,0xFF,0xFF,0xFF);

        imagefill($image, 0, 0, $bgcolor);//应用画布颜色

        $textcolor = imagecolorallocate($image,0,0,0);//设置字体颜色

        $font = 'SimHei.ttf';//设置字体-黑体

        imagettftext($image, 200, 0, 235, 704, $textcolor, $font,$day);//日期
        imagettftext($image, 30, 0, 55, 550, $textcolor, $font, "二零一八");
        imagettftext($image, 50, 0, 85, 630, $textcolor, $font, Array_Month($month));//月份
        imagettftext($image, 50, 0, 85, 710, $textcolor, $font, "月");


        imagettftext($image, 30, 0, 555, 550, $textcolor, $font, "星期".mb_substr( "日一二三四五六",date("w"),1,"utf-8" ));//星期转汉字
        imagettftext($image, 50, 0, 580, 630, $textcolor, $font, "早");
        imagettftext($image, 50, 0, 580, 710, $textcolor, $font, "安");




        $s = '  '.$html;//文字
        /*
          文字固定宽度自动换行
        */

        $width = 650;
        for($i=0; $i<iconv_strlen($s); $i++) {
          $t = imagettfbbox(30, 0, $font, iconv_substr($s, 0, $i));
          if($t[2] - $t[0] > $width) {
            $r[] = iconv_substr($s, 0, $i-1);
            $s = iconv_substr($s, $i-1);
            $i = -1;
          }
        }
        if($s) $r[] = $s;
        foreach($r as $i=>$v) {
            imagettftext($image, 30, 0, 50, 900+ 50 * $i, $textcolor, $font, $v);
        }

        imageline($image,0,1184,750,1184,$textcolor);//绘制水平线

        $foot_color = imagecolorallocate($image,220,220,220);//创建一个颜色，以供使用
        imagefilledrectangle($image,0,1184,750,1334,$foot_color);//绘制矩形

        imagettftext($image, 20, 0, 250, 1250, $textcolor, $font, "广告位招募，详细扫码咨询");


        imagettftext($image, 15, 0, 200, 1310, $textcolor, $font, "长按图片识别二维码查看更多");


        imageline($image,29,1199,151,1199,$textcolor);
        imageline($image,29,1321,151,1321,$textcolor);
        imageline($image,29,1199,29,1321,$textcolor);
        imageline($image,151,1199,151,1321,$textcolor);


        $src_path = 'pic.jpg';//图片路径

        $src = imagecreatefromstring(file_get_contents($src_path));

        imagecopymerge($image, $src, 25, 30, 0, 0, 700, 400, 100);//绘制图片

        $qcode_path = 'qcode.jpg';

        $qcode = imagecreatefromstring(file_get_contents($qcode_path));

        imagecopymerge($image, $qcode, 30, 1200, 0, 0, 120, 120, 100);



        imagejpeg($image);//输出绘制的画布
        imagejpeg($image,'php_code.jpg');//保存绘制的画布到本地

 ?>
