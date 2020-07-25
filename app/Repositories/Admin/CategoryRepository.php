<?php
/**
 * Created by PhpStorm.
 * User: 1
 * Date: 23.07.2020
 * Time: 16:36
 */

namespace App\Repositories\Admin;


use App\Repositories\CoreRepository;
use App\Models\Admin\Category as Model;
use Menu as LavMenu;

class CategoryRepository extends CoreRepository {

    public function __construct() {

        parent::__construct();
    }

    /**
     * @return string
     */
    protected function getModelClass() {

        return Model::class;
    }

    /**
     * @param $arrMenu
     * @return \Lavary\Menu\Builder
     */
    public function buildMenu($arrMenu) {

        $mBuilder = LavMenu::make('MyNav', function ($m) use ($arrMenu){
            foreach ($arrMenu as $item){
                if ($item->parent_id == 0){
                    $m->add($item->title, $item->id)->id($item->id);
                }else {

                    if ($m->find($item->parent_id)){
                        $m->find($item->parent_id)
                            ->add($item->title, $item->id)
                            ->id($item->id);
                    }
                }
            }
        });
        return $mBuilder;
    }


    /**
     * @param $id
     * @return mixed
     */
    public function checkChildren($id){

        $children = $this->startConditions()
            ->where('parent_id', $id)
            ->count();
        return $children;
    }


    /**
     * @param $id
     * @return int
     */
    public function checkParentsProducts($id){

        $parents = \DB::table('products')
            ->where('category_id', $id)
            ->count();
        return $parents;
    }


    /**
     * @param $id
     * @return mixed
     */
    public function deleteCategory($id){

        $delete = $this->startConditions()
            ->find($id)
            ->forceDelete();
        return $delete;
    }


    public function getComboBoxCategories(){

        $columns = implode(',', [
            'id',
            'parent_id',
            'title',
            'CONCAT (id, ". ", title) AS combo_title',
        ]);
        $result = $this->startConditions()
            ->selectRaw($columns)
            ->toBase()
            ->get();
        return $result;
    }

    public function checkUniqueName($name, $parent_id){

        $name = $this->startConditions()
            ->where('title', $name)
            ->where('parent_id', $parent_id)
            ->exists();
        return $name;
    }

}