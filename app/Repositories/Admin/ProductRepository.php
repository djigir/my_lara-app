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
}