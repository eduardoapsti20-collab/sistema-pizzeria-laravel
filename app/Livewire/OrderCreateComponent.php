<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Product;
use App\Models\ProductSize;
use App\Models\Category;
use App\Models\Order;
use App\Models\Sale;
use App\Models\OrderDetail;
use App\Models\PaymentMethod;
use App\Models\Setting;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Livewire\WithPagination;

class OrderCreateComponent extends Component
{
    use WithPagination;

    public $table;
    public $search = '';
    public $category_id = '';
    public $order;

    public $cart = [];
    public $cartTotal = 0;

    public $selectedDetails = [];
    public $showPaymentModal = false;
    public $paymentAmount = 0;
    public $payments = [];
    public $categories = [];
    public $detailsToPay = [];
    public $paymentMethods = [];
    public $selectedMethod = null;

    public $isOpenCustomerModal = false;
    public $searchCustomer = '';
    public $customer_id;
    public $customer_name = 'Consumidor Final';
    public $direct_printing = false;
    public $printer_name;
    public $separate_orders = false;
    public $kitchen_printer_name;

    public $newCustomer = [
        'name' => '',
        'document_number' => '',
        'phone' => ''
    ];

    protected $updatesQueryString = ['searchCustomer', 'search'];

    public function mount($table)
    {
        $this->table = $table;

        $setting = Setting::first();
        $this->direct_printing = $setting->direct_printing;
        $this->printer_name = $setting->printer_name;
        $this->kitchen_printer_name = $setting->kitchen_printer_name;
        $this->separate_orders = $setting->separate_orders;

        $this->order = Order::with('details.product')
            ->where('table_id', $this->table->id)
            ->where('status', 'abierto')
            ->first();

        $this->paymentMethods = PaymentMethod::all();
        $this->categories = Category::all();
    }

    public function updatingSearch()
    {
        $this->resetPage('pageProducts');
    }

    public function updatingSearchCustomer()
    {
        $this->resetPage('pageCustomers');
    }

    public function openCustomerModal()
    {
        $this->resetValidation();
        $this->isOpenCustomerModal = true;
    }

    public function closeCustomerModal()
    {
        $this->isOpenCustomerModal = false;
        $this->reset(['newCustomer', 'searchCustomer']);
    }

    public function selectCustomer($id)
    {
        $client = User::find($id);

        if ($client) {
            $this->customer_id = $client->id;
            $this->customer_name = $client->name;

            if ($this->order) {
                try {
                    $this->order->update([
                        'customer_id' => $client->id,
                        'customer_name' => $client->name,
                    ]);

                    $this->dispatch('swal', [
                        'title' => 'Cliente Vinculado',
                        'text' => 'La orden ahora pertenece a ' . $client->name,
                        'icon' => 'success',
                        'timer' => 1500
                    ]);
                } catch (\Exception $e) {
                    Log::error("Error al vincular cliente a orden: " . $e->getMessage());
                }
            }
        }

        $this->closeCustomerModal();
    }

    public function saveCustomer()
    {
        $this->validate([
            'newCustomer.name' => 'required|min:3',
            'newCustomer.document_number' => 'nullable|numeric|unique:users,document_number',
            'newCustomer.phone' => 'nullable'
        ]);

        $namePart = strtolower(explode(' ', trim($this->newCustomer['name']))[0]);
        $uniqueId = $this->newCustomer['document_number'] ?: rand(1000, 9999);

        $domain   = config('restaurant.customer.domain');
        $password = config('restaurant.customer.password');
        $type     = config('restaurant.customer.type');

        $email = $namePart . '_' . $uniqueId . '@' . $domain;

        $client = User::create([
            'name'              => $this->newCustomer['name'],
            'email'             => $email,
            'document_number'   => $this->newCustomer['document_number'],
            'phone'             => $this->newCustomer['phone'],
            'type'              => $type,
            'password'          => bcrypt($password),
            'email_verified_at' => now(),
        ]);

        $this->selectCustomer($client->id);
        $this->reset('newCustomer');
    }

    /**
     * Suma la cantidad total de un producto en el carrito, sin importar
     * el tamaño elegido (Familiar/Grande/XL cuentan para el mismo stock,
     * porque el stock se controla a nivel de `products`, no por tamaño).
     */
    private function getProductQtyInCart($productId): int
    {
        $total = 0;

        foreach ($this->cart as $item) {
            if ((int) $item['product_id'] === (int) $productId) {
                $total += (int) $item['quantity'];
            }
        }

        return $total;
    }

    /**
     * $sizeId es opcional: si el producto tiene tamaños (product_sizes),
     * se pasa el id del tamaño elegido y se arma una línea de carrito
     * distinta por cada combinación producto+tamaño. Si el producto no
     * tiene tamaños, se usa el precio único de `products.price` como antes.
     */
    public function addToOrder($productId, $sizeId = null)
    {
        $product = Product::find($productId);

        if (!$product || ($this->order && $this->order->status === 'cerrado')) return;

        $size = null;
        if ($sizeId) {
            $size = ProductSize::find($sizeId);

            // seguridad: el tamaño debe pertenecer realmente a este producto
            if (!$size || (int) $size->product_id !== (int) $product->id) {
                return;
            }
        }

        $cartKey = $size ? $productId . '_' . $size->id : (string) $productId;

        // VALIDAR STOCK (sumando todas las líneas de este producto, sin importar el tamaño)
        $totalQtyInCart = $this->getProductQtyInCart($productId);
        if ($product->stock <= $totalQtyInCart) {
            $this->dispatch('swal', [
                'title' => 'Sin stock',
                'text' => 'No hay suficiente stock para ' . $product->name,
                'icon' => 'warning'
            ]);
            return;
        }

        $price = $size ? (float) $size->price : (float) $product->price;
        $displayName = $size ? $product->name . ' (' . $size->name . ')' : $product->name;

        if (isset($this->cart[$cartKey])) {
            $this->cart[$cartKey]['quantity']++;
            $this->cart[$cartKey]['subtotal'] =
                $this->cart[$cartKey]['quantity'] * $this->cart[$cartKey]['price'];
        } else {
            $this->cart[$cartKey] = [
                'detail_id' => null,
                'product_id' => $product->id,
                'size_id' => $size->id ?? null,
                'size_name' => $size->name ?? null,
                'name' => $displayName,
                'price' => $price,
                'quantity' => 1,
                'subtotal' => $price,
                'requires_kitchen' => $product->requires_kitchen,
                'cooking_status' => 'pending'
            ];
        }

        $this->calculateCartTotal();

        $this->dispatch('swal', [
            'title' => 'Agregado al Carrito',
            'text' => $displayName . ' se añadió al carrito.',
            'icon' => 'success',
            'timer' => 1000
        ]);
    }

    public function increment($cartKey)
    {
        if (!isset($this->cart[$cartKey])) return;

        $product = Product::find($this->cart[$cartKey]['product_id']);

        if (!$product) return;

        // Stock total del producto ya sumado entre todos sus tamaños en el carrito
        $totalQtyInCart = $this->getProductQtyInCart($this->cart[$cartKey]['product_id']);

        if ($product->stock <= $totalQtyInCart) {
            $this->dispatch('swal', [
                'title' => 'Sin stock',
                'text' => 'No puedes agregar más de ' . $product->name,
                'icon' => 'warning'
            ]);
            return;
        }

        $this->cart[$cartKey]['quantity']++;
        $this->cart[$cartKey]['subtotal'] =
            $this->cart[$cartKey]['quantity'] * $this->cart[$cartKey]['price'];

        $this->calculateCartTotal();
    }

    public function decrement($cartKey)
    {
        if (isset($this->cart[$cartKey])) {
            if ($this->cart[$cartKey]['quantity'] > 1) {
                $this->cart[$cartKey]['quantity']--;
                $this->cart[$cartKey]['subtotal'] = $this->cart[$cartKey]['quantity'] * $this->cart[$cartKey]['price'];
            } else {
                if ($this->cart[$cartKey]['detail_id'] && $this->order) {
                    OrderDetail::destroy($this->cart[$cartKey]['detail_id']);
                }
                unset($this->cart[$cartKey]);
            }
            $this->calculateCartTotal();
            $this->checkEmptyOrder();
        }
    }

    public function removeItem($cartKey)
    {
        if (isset($this->cart[$cartKey])) {
            if ($this->cart[$cartKey]['detail_id'] && $this->order) {
                OrderDetail::destroy($this->cart[$cartKey]['detail_id']);
            }
            unset($this->cart[$cartKey]);
            $this->calculateCartTotal();
            $this->checkEmptyOrder();

            $this->dispatch('swal', [
                'title' => 'Producto Quitado',
                'text' => 'El ítem fue removido del listado.',
                'icon' => 'success'
            ]);
        }
    }

    private function calculateCartTotal()
    {
        $this->cartTotal = collect($this->cart)->sum('subtotal');
    }

    private function checkEmptyOrder()
    {
        if (empty($this->cart) && $this->order) {
            $this->order->delete();
            $this->table->update(['status' => 'libre']);
            $this->order = null;
            $this->reset(['customer_id', 'customer_name']);
        }
    }

    public function getItemsToPrintProperty()
    {
        if (!$this->order) {
            return collect();
        }

        $details = $this->order->details()
            ->where('cooking_status', 'pending')
            ->with(['product', 'productSize'])
            ->get();

        // Nombre a imprimir: "Pizza Margarita (Familiar)" si tiene tamaño,
        // o "Pizza Margarita" si es de precio único.
        $printName = fn($d) => $d->productSize
            ? $d->product->name . ' (' . $d->productSize->name . ')'
            : $d->product->name;

        if (!$this->separate_orders) {
            return collect([
                [
                    'requires_kitchen' => false,
                    'printer_name'     => $this->printer_name,
                    'items'            => $details->map(function ($d) use ($printName) {
                        return [
                            'id'       => $d->id,
                            'name'     => $printName($d),
                            'quantity' => $d->quantity,
                            'notes'    => $d->notes ?? ''
                        ];
                    })->toArray()
                ]
            ]);
        }

        return $details
            ->groupBy('requires_kitchen')
            ->map(function ($details, $requiresKitchen) use ($printName) {

                $printerName = $requiresKitchen
                    ? $this->kitchen_printer_name
                    : $this->printer_name;

                return [
                    'requires_kitchen' => (bool) $requiresKitchen,
                    'printer_name'     => $printerName,
                    'items'            => $details->map(function ($d) use ($printName) {
                        return [
                            'id'       => $d->id,
                            'name'     => $printName($d),
                            'quantity' => $d->quantity,
                            'notes'    => $d->notes ?? ''
                        ];
                    })->toArray()
                ];
            })
            ->values();
    }

    public function saveOrderTransaction()
    {
        if (empty($this->cart)) return;

        try {
            DB::beginTransaction();

            if (!$this->order) {
                $this->order = Order::create([
                    'table_id' => $this->table->id,
                    'customer_id' => $this->customer_id ?? null,
                    'user_id' => auth()->id(),
                    'customer_name' => $this->customer_name ?? 'Consumidor Final',
                    'status' => 'abierto',
                    'total' => $this->cartTotal,
                    'amount_pending' => $this->cartTotal,
                ]);
                $this->table->update(['status' => 'ocupada']);
            }

            foreach ($this->cart as $cartKey => $item) {

                $product = Product::find($item['product_id']);

                if (!$product) {
                    throw new \Exception("Producto no encontrado");
                }

                if ($item['detail_id']) {
                    $oldDetail = OrderDetail::find($item['detail_id']);

                    $difference = $item['quantity'] - $oldDetail->quantity;

                    // Validar stock si aumenta cantidad
                    if ($difference > 0 && $product->stock < $difference) {
                        throw new \Exception("Stock insuficiente para {$product->name}");
                    }

                    // actualizar stock
                    $product->stock -= $difference;
                    $product->save();

                    $oldDetail->update([
                        'quantity' => $item['quantity'],
                        'subtotal' => $item['subtotal'],
                        'notes'    => $item['notes'] ?? null
                    ]);
                } else {
                    if ($product->stock < $item['quantity']) {
                        throw new \Exception("Stock insuficiente para {$product->name}");
                    }

                    $product->stock -= $item['quantity'];
                    $product->save();

                    $newDetail = $this->order->details()->create([
                        'product_id' => $item['product_id'],
                        'product_size_id' => $item['size_id'] ?? null,
                        'quantity'   => $item['quantity'],
                        'price'      => $item['price'],
                        'subtotal'   => $item['subtotal'],
                        'notes'      => $item['notes'] ?? null,
                        'requires_kitchen' => $item['requires_kitchen'] ?? true,
                        'cooking_status' => $item['cooking_status'] ?? 'pending'
                    ]);

                    $this->cart[$cartKey]['detail_id'] = $newDetail->id;
                }
            }

            $newTotal = $this->order->details()
    ->where('cooking_status', '!=', 'cancelled')
    ->sum('subtotal');

            $this->order->update([
                'total' => $newTotal,
                'amount_pending' => $newTotal
            ]);

            DB::commit();

            $this->order->load('details.product.category');
            $this->dispatch(
                'auto-print-kitchen',
                $this->itemsToPrint->map(function ($catData) {

                    return [
                        'url' => route('orders.kitchen-print', [
                            'id' => $this->order->id
                        ]),
                        'printer_name' => $catData['printer_name'],
                        'requires_kitchen'  => $catData['requires_kitchen'],
                    ];
                })->toArray()
            );
            $this->dispatch('swal', [
                'title' => 'Orden Guardada',
                'text' => 'El pedido fue registrado exitosamente.',
                'icon' => 'success'
            ]);
            $this->reset('cart');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error("Error en saveOrderTransaction: " . $e->getMessage());
            $this->dispatch('swal', ['title' => 'Error', 'text' => 'No se pudo procesar la orden.', 'icon' => 'error']);
        }
    }

    public function markAsServed($detailId)
    {
        $detail = OrderDetail::find($detailId);
        if ($detail) {
            $detail->update(['cooking_status' => 'served']);

            foreach ($this->cart as $cartKey => $item) {
                if ($item['detail_id'] == $detailId) {
                    $this->cart[$cartKey]['cooking_status'] = 'served';
                    break;
                }
            }

            $this->dispatch('swal', [
                'title' => '¡Servido!',
                'text' => 'El producto ha sido marcado como entregado.',
                'icon' => 'success',
                'timer' => 1000
            ]);
        }
    }

    public function render()
    {
        $customers = User::where('type', 'client')
            ->where(function ($query) {
                $query->where('name', 'like', '%' . $this->searchCustomer . '%')
                    ->orWhere('document_number', 'like', '%' . $this->searchCustomer . '%');
            })
            ->orderBy('name', 'asc')
            ->paginate(5, ['*'], 'pageCustomers');

        $products = Product::with('sizes')
            ->where('status', 1)
            ->when($this->category_id, fn($q) => $q->where('category_id', $this->category_id))
            ->when($this->search, fn($q) => $q->where('name', 'like', '%' . $this->search . '%'))
            ->paginate(12, ['*'], 'pageProducts');

        return view('livewire.order-create-component', compact('customers', 'products'));
    }
}