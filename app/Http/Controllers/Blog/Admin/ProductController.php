<?php

namespace App\Http\Controllers\Blog\Admin;


use App\Models\Admin\Category;
use App\Repositories\Admin\ProductRepository;
use App\SBlog\Core\BlogApp;
use Illuminate\Http\Request;
use MetaTag;

class ProductController extends AdminBaseController
{
    private $productRepository;

    public function __construct() {
        parent::__construct();
        $this->productRepository = app(ProductRepository::class);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $perpage = 10;
        $getAllProducts = $this->productRepository->getAllProducts($perpage);
        $count = $this->productRepository->getCountProducts();

        MetaTag::setTags(['title' => 'Список продуктов']);
        return view('blog.admin.product.index', compact('getAllProducts', 'count'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $item = new Category();


        MetaTag::setTags(['title' => 'Добавление товара']);
        return view('blog.admin.product.create', [
            'categories' => Category::with('children')
                            ->where('parent_id', '0')
                            ->get(),
            'delimiter' => '-',
            'item' => $item,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }


    /**
     * @param Request $request
     * @return array|\Illuminate\Contracts\View\Factory|\Illuminate\View\View|string
     */
    public function ajaxImage(Request $request) {

        if ($request->isMethod('get')){
            return view('blog.admin.product.include.image_single_edit');
        }else {
            $validator = \Validator::make($request->all(),
             [
                 'file' => 'image|max:5000',
             ],
            [
                'filter.image' => 'Файл должен быть картинкой формата (jpeg, jpg, pgn, gif или svg)',
                'filter.max' => 'Ошибка! Максимальный размер файла 5мб',
            ]);
            if ($validator->fails()){
                return array (

                    'fail' => true,
                    'errors' => $validator->errors()
                );
            }

            $extension = $request->file('file')->getClientOriginalExtension();
            $dir = 'uploads/single/';
            $filename = uniqid() . '_' . time() . '.' . $extension;
            $request->file('file')->move($dir, $filename);
            $wmax = BlogApp::get_instance()->getProperty('img_width');
            $hmax = BlogApp::get_instance()->getProperty('img_height');
            $this->productRepository->uploadImg($filename, $wmax, $hmax);
            return $filename;
        }
    }

    /**
     * @param Request $request
     * @return array
     */
    public function gallery(Request $request) {

        $validator = \Validator::make($request->all(),
            [
                'file' => 'image|max:5000',
            ],
            [
                'filter.image' => 'Файл должен быть картинкой формата (jpeg, jpg, pgn, gif или svg)',
                'filter.max' => 'Ошибка! Максимальный размер файла 5мб',
            ]);
        if ($validator->fails()){
            return array (

                'fail' => true,
                'errors' => $validator->errors()
            );
        }

        if (isset($_GET['upload'])) {
            $wmax = BlogApp::get_instance()->getProperty('gallery_width');
            $hmax = BlogApp::get_instance()->getProperty('gallery_height');
            $name = $_POST['name'];
            $this->productRepository->uploadGallery($name, $wmax, $hmax);
        }
    }


    /**
     * @param $filename
     */
    public function deleteImage($filename){

        \File::delete('uploads/single/' . $filename);
    }


    public function deletegallery() {

        $id = isset($_POST['id']) ? $_POST['id'] : null;
        $src = isset($_POST['src']) ? $_POST['src'] : null;
        if (!$id || !$src) {
            return;
        }
        if(\DB::delete("DELETE FROM galleries WHERE product_id = ? AND img = ?", [$id, $src])){
            @unlink("uploads/gallery/$src");
            exit('1');
        }
        return;
    }


    /**
     * @param Request $request
     */
    public function related(Request $request) {

        $q = isset($request->q) ? htmlspecialchars(trim($request->q)) : '';
        $data['items'] = [];
        $products = $this->productRepository->getProducts($q);
        if ($products) {
            $i = 0;
            foreach ($products as $id => $title) {
                $data['items'][$i]['id'] = $title->id;
                $data['items'][$i]['text'] = $title->title;
                $i++;
            }
        }
        echo json_encode($data);
        die();
    }
}
