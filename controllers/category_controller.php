<?php
require_once 'config/db_info.php';
require_once 'models/CategoryModel.php';

class CategoryController {
    private $categoryModel;

    public function __construct() {
        $this->categoryModel = new CategoryModel();
    }

    public function addCategory($name,$image) {
        return $this->categoryModel->addCategory($name);
        return $this->categoryModel->addCategory($image);
    }

    public function index() {
        $categories = $this->categoryModel->getAllCategories();
        include 'views/admin/list_categories.php';
    }


}
?>
