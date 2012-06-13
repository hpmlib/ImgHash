<?php
Function getImgHM($filename,$x=8,$y=8){
    list($width, $height) = getimagesize($filename);
    $new_width = $x;
    $new_height = $y;
    $image_p = imagecreatetruecolor($new_width, $new_height);
    $image = imagecreatefromjpeg($filename);
    imagecopyresampled($image_p, $image, 0, 0, 0, 0, $new_width, $new_height, $width, $height);
    imagefilter($image_p,IMG_FILTER_GRAYSCALE);
    $result = '';
    For($x=0;$x<$new_width;$x++){
        For($y=0;$y<$new_height;$y++){
           $P = getP($image_p,$x,$y);
           $result = ($P + $result) ;
           }
    }
    $std = $result/($new_width*$new_height);
    $HM = '';
    For($x=0;$x<$new_width;$x++){
        For($y=0;$y<$new_height;$y++){
           $C = getP($image_p,$x,$y);
           if($C < $std){
                $HM .= 0;
           }else{
                $HM .= 1;
           }
        }
    }
    imagedestroy($image_p);
    RETURN $HM;
}
    function getP($image,$x,$y){
        $Color_arr = imagecolorsforindex($image,imagecolorat($image,$x,$y));
        $P = ($Color_arr["red"] + $Color_arr["blue"] + $Color_arr["green"])/3;
        return $P;
    }
Function checkHM($search,$path){
    $HM = getImgHM($search);
    $HM_2 = getImgHM($path);
    echo $search.':'.$HM.'<br>'.$path.':'.$HM_2.'<br>';
    $diff= '';
    For($i=0;$i<64;$i++){
        if($HM[$i] == $HM_2[$i]){
            $diff++;
        }
    }
    $diff = $diff/64;
    echo $diff;
}
checkHM("demo.jpg","demo2.jpg");
