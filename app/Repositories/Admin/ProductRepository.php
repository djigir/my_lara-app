<?php
/**
 * Created by PhpStorm.
 * User: 1
 * Date: 22.07.2020
 * Time: 13:06
 */

namespace App\Repositories\Admin;


use App\Repositories\CoreRepository;
use App\Models\Admin\Product as Model;

class ProductRepository extends CoreRepository {

    public function __construct() {

        parent::__construct();
    }

    protected function getModelClass() {

        return Model::class;
    }

    public function getLastProducts($perpage) {

        $get = $this->startConditions()
            ->orderBy('id', 'DESC')
            ->limit($perpage)
            ->paginate($perpage);

        return $get;
    }

    public function getAllProducts($perpage) {

        $get_all = $this->startConditions()
            ->join('categories', 'products.category_id', '=', 'categories.id')
            ->select('products.*', 'categories.title AS cat')
            ->orderBy(\DB::raw('LENGTH(products.title)','products.title'))
            ->limit($perpage)
            ->paginate($perpage);

        return $get_all;
    }

    public function getCountProducts(){

        $count = $this->startConditions()
            ->count();
        return $count;
    }

    public function getProducts($q) {

        $products = \DB::table('products')
            ->select('id', 'title')
            ->where('title', 'LIKE', ["%{$q}%"])
            ->limit(8)
            ->get();
        return $products;
    }

    public function uploadImg($name, $wmax, $hmax){

        $uploaddir = 'uploads/single/';
        $ext = strtolower(preg_replace("#.+\.{[a-z]+}$#i", "$1", $name));
        $uploadfile = $uploaddir . $name;
        \Session::put('single', $name);
        self::resize($uploadfile, $uploadfile, $wmax, $hmax, $ext);

    }

    /**
     * @param $target
     * @param $dest
     * @param $wmax
     * @param $hmax
     * @param $ext
     */
    public static function resize($target, $dest, $wmax, $hmax, $ext) {
        list($w_orig, $h_orig) = getimagesize($target);
        $ratio = $w_orig / $h_orig;

        if (($wmax / $hmax) > $ratio){
            $wmax = $hmax * $ratio;
        }else {
            $hmax = $wmax / $ratio;
        }

        $img = "";

        switch ($ext) {
            case ("gif"):
                $img = imagecreatefromgif($target);
                break;
            case ("png"):
                $img = imagecreatefrompng($target);
                break;
            default:
                $img = imagecreatefromjpeg($target);
        }
        $newImg = imagecreatetruecolor($wmax, $hmax);
        if ($ext == "png") {
            imagesavealpha($newImg, true);
            $transPng = imagecolorallocatealpha($newImg, 0, 0, 0, 127);
            imagefill($newImg, 0, 0, $transPng);
        }
        imagecopyresampled($newImg, $img, 0, 0, 0, 0, $wmax, $hmax, $w_orig, $h_orig);
        switch ($ext){
            case ("gif"):
                imagegif($newImg, $dest);
                break;
            case ("png"):
                imagepng($newImg, $dest);
                break;
            default:
                imagejpeg($newImg, $dest);
        }
        imagedestroy($newImg);
    }


    /**
     * @param $name
     * @param $wmax
     * @param $hmax
     */
    public function uploadGallery($name, $wmax, $hmax){

        $uploaddir = 'uploads/gallery/';
        $ext = strtolower(preg_replace("#.+\.{[a-z]+}$#i", "$1", $_FILES[$name]['name']));
        $new_name = md5(time()) . ".$ext";
        $uploadfile = $uploaddir . $new_name;
        \Session::push('gallery', $new_name);
        if (move_uploaded_file($_FILES[$new_name]['tmp_name'], $uploadfile)){
            self::resize($uploadfile, $uploadfile, $wmax, $hmax, $ext);
            $res = array('file' => $new_name);
            echo json_encode($res);
        }
    }
}