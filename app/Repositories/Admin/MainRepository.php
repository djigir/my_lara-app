<?php
/**
 * Created by PhpStorm.
 * User: 1
 * Date: 21.07.2020
 * Time: 21:22
 */

namespace App\Repositories\Admin;


use App\Repositories\CoreRepository;
use Illuminate\Database\Eloquent\Model;

class MainRepository extends CoreRepository {


    /**
     * @return string
     */
    protected function getModelClass()
    {
        return Model::class;
    }


    /**Get count all orders
     *
     * @return int
     */
    public static function getCountOrders() {

        $count = \DB::table('orders')
            ->where('status', '0')
            ->get()
            ->count();
        return $count;
    }


    /**Get count all users
     *
     * @return int
     */
    public static function getCountUsers() {

        $users = \DB::table('users')
            ->get()
            ->count();
        return $users;
    }


    /**Get count all products
     *
     * @return int
     */

    public static function getCountProducts() {

        $prod = \DB::table('products')
            ->get()
            ->count();
        return $prod;
    }


    /**Get count all categories
     *
     * @return int
     */
    public static function getCountCategories() {

        $cat = \DB::table('categories')
            ->get()
            ->count();
        return $cat;
    }


}