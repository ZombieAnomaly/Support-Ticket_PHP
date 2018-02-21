<?php

namespace App\libs\DataBaseInterfaces;

use App\libs\DataBaseInterfaces\CategoryI;
use App\Category;

class CategoryEloquent implements CategoryI {
    protected $categories;

    function __construct(Category $a) {
        $this->categories = $a;
    }
    
    public function getCategories(){
        return $this->categories->all();
    }

}