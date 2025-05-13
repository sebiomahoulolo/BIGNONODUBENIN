<?php
namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Category;
class CategoryController extends Controller
{
    public function index()
{
    $categories = Category::paginate(10); // Paginer les résultats
    return view('admin.categories.index', compact('categories'));
}

    

}
