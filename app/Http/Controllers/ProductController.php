<?php
namespace App\Http\Controllers;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Models\ActivityLog;
use App\Models\Category;
use App\Models\Supplier;
use App\Services\ProductService;
use Illuminate\Http\Request;
class ProductController extends Controller
{
    public function __construct(protected ProductService $productService)
    {
    }
    public function index(Request $request)
    {
        $categoryId = $request->query('category_id');
        $products = $this->productService->getPaginatedProducts(10, $categoryId ? (int) $categoryId : null);
        $categories = Category::withCount('products')->get();
        return view('pages.products.index', compact('products', 'categories'));
    }
    public function create()
    {
        abort_unless(auth()->user()->isAdmin() || auth()->user()->isManajerGudang(), 403, 'Anda tidak memiliki akses untuk menambah produk.');
        $categories = Category::all();
        $suppliers = Supplier::all();
        return view('pages.products.create', compact('categories', 'suppliers'));
    }
    public function store(StoreProductRequest $request)
    {
        abort_unless(auth()->user()->isAdmin() || auth()->user()->isManajerGudang(), 403, 'Anda tidak memiliki akses untuk menambah produk.');
        $product = $this->productService->createProduct(
            $request->validated(),
            $request->file('image')
        );
        ActivityLog::record('create_product', "Menambahkan produk: {$product->name}");
        return redirect()->route('products.index')->with('success', 'Produk berhasil ditambahkan.');
    }
    public function show(int $id)
    {
        $product = $this->productService->getProductDetail($id);
        return view('pages.products.show', compact('product'));
    }
    public function edit(int $id)
    {
        abort_unless(auth()->user()->isAdmin() || auth()->user()->isManajerGudang(), 403, 'Anda tidak memiliki akses untuk mengedit produk.');
        $product = $this->productService->getProductDetail($id);
        $categories = Category::all();
        $suppliers = Supplier::all();
        return view('pages.products.edit', compact('product', 'categories', 'suppliers'));
    }
    public function update(UpdateProductRequest $request, int $id)
    {
        abort_unless(auth()->user()->isAdmin() || auth()->user()->isManajerGudang(), 403, 'Anda tidak memiliki akses untuk mengedit produk.');
        $this->productService->updateProduct(
            $id,
            $request->validated(),
            $request->file('image')
        );
        $product = $this->productService->getProductDetail($id);
        ActivityLog::record('update_product', "Mengubah produk: {$product->name}");
        return redirect()->route('products.index')->with('success', 'Produk berhasil diperbarui.');
    }
    public function destroy(int $id)
    {
        abort_unless(auth()->user()->isAdmin(), 403, 'Hanya Admin yang dapat menghapus produk.');
        $product = $this->productService->getProductDetail($id);
        ActivityLog::record('delete_product', "Menghapus produk: {$product->name}");
        $this->productService->deleteProduct($id);
        return redirect()->route('products.index')->with('success', 'Produk berhasil dihapus.');
    }
}