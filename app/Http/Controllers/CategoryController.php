<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCategoryRequest;
use App\Http\Requests\UpdateCategoryRequest;
use App\Models\ActivityLog;
use App\Services\CategoryService;
use Illuminate\Validation\ValidationException;

class CategoryController extends Controller
{
    public function __construct(protected CategoryService $categoryService)
    {
        // Seluruh aksi (termasuk melihat daftar) hanya bisa diakses role Admin.
        $this->middleware('role:Admin');
    }

    public function index()
    {
        $categories = $this->categoryService->getPaginatedCategories(10);

        return view('pages.categories.index', compact('categories'));
    }

    public function create()
    {
        return view('pages.categories.create');
    }

    public function store(StoreCategoryRequest $request)
    {
        $category = $this->categoryService->createCategory($request->validated());

        ActivityLog::record('create_category', "Menambahkan kategori: {$category->name}");

        return redirect()->route('categories.index')->with('success', 'Kategori berhasil ditambahkan.');
    }

    public function edit(int $id)
    {
        $category = $this->categoryService->getCategoryDetail($id);

        return view('pages.categories.edit', compact('category'));
    }

    public function update(UpdateCategoryRequest $request, int $id)
    {
        $this->categoryService->updateCategory($id, $request->validated());

        $category = $this->categoryService->getCategoryDetail($id);
        ActivityLog::record('update_category', "Mengubah kategori: {$category->name}");

        return redirect()->route('categories.index')->with('success', 'Kategori berhasil diperbarui.');
    }

    public function destroy(int $id)
    {
        try {
            $category = $this->categoryService->getCategoryDetail($id);
            ActivityLog::record('delete_category', "Menghapus kategori: {$category->name}");

            $this->categoryService->deleteCategory($id);
            return redirect()->route('categories.index')->with('success', 'Kategori berhasil dihapus.');
        } catch (ValidationException $e) {
            return redirect()->route('categories.index')->with('error', $e->getMessage());
        }
    }
}