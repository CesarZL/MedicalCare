<?php
use App\Models\Medico;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CitaController;
use App\Http\Controllers\VentaController;
use App\Http\Controllers\CompraController;
use App\Http\Controllers\MedicoController;
use App\Http\Controllers\PacienteController;
use App\Http\Controllers\ProductoController;
use App\Http\Controllers\CategoriaController;
use App\Http\Controllers\InventarioController;


// rutas publicas
Route::get('/', function () {
    $medicos = Medico::inRandomOrder()->limit(4)->get();
    return view('welcome', compact('medicos'));
})->name('welcome');

// rutas publicas
Route::get('/contacto', function () {
    return view('contacto');
})->name('contacto');

// rutas publicas
Route::get('/productos', [ProductoController::class, 'PublicIndex'])->name('productos');
Route::get('/productos/{producto}', [ProductoController::class, 'show'])->name('productos.show');
Route::get('/medicos', [MedicoController::class, 'PublicIndex'])->name('medicos');

Route::middleware([
    'auth:sanctum',
    'paciente',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    // rutas que solo el paciente puede acceder
    Route::post('/carrito', [VentaController::class, 'storeCart'])->name('carrito.store');
    Route::get('/carrito-productos', [VentaController::class, 'getCarritoProductos']);
    Route::delete('/carrito-productos/{productoId}', [VentaController::class, 'removeProducto']);
    Route::get('/medicos/citas/{medico}', [CitaController::class, 'citasDisponibles'])->name('citas.medico');
    Route::post('/citas', [CitaController::class, 'reservar'])->name('citas.reservar');
    Route::get('/citas/mis-citas', [CitaController::class, 'PacienteMisCitas'])->name('citas.paciente.mis-citas');
    Route::put('/citas/mis-citas/cancelar/{cita}', [CitaController::class, 'CitaCancelar'])->name('cita.cancelar');
    Route::get('/checkout', [VentaController::class, 'checkout'])->name('checkout.index');
    Route::post('/checkout', [VentaController::class, 'chstore'])->name('checkout.store');
    Route::get('/compra/detalle/{venta}', [VentaController::class, 'compradetail'])->name('detalle.compra');
    Route::get('/compra/{venta}/pdf', [VentaController::class, 'comprapdf'])->name('ticket.compra');
    Route::get('/compras/mis-compras', [VentaController::class, 'misCompras'])->name('compras.mis-compras');
    Route::get('/compras/mis-compras/{venta}', [VentaController::class, 'compradetail'])->name('compras.mis-compras.detalle');
    Route::get('/compras/mis-compras/{venta}/pdf', [VentaController::class, 'comprapdf'])->name('compras.mis-compras.pdf');
    Route::get('/citas/mis-citas/chat/{cita}', [CitaController::class, 'PacienteCitaChat'])->name('cita.chat-paciente');
});

Route::middleware([
    'auth:sanctum',
    'medico',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    // rutas que solo el medico puede acceder
    Route::get('/medico/mis-citas', [CitaController::class, 'MedicoMisCitas'])->name('citas.medico.mis-citas');
    Route::put('/medico/mis-citas/aceptar/{cita}', [CitaController::class, 'CitaAceptar'])->name('cita.aceptar');
    Route::put('/medico/mis-citas/completar/{cita}', [CitaController::class, 'CitaCompletar'])->name('cita.completar');
    Route::get('/medico/mis-citas/chat/{cita}', [CitaController::class, 'MedicoCitaChat'])->name('cita.chat-medico');
});

Route::middleware([
    'auth:sanctum',
    'admin',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {

    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    //admin routes
    Route::get('/admin/productos', [ProductoController::class, 'index'])->name('productos.index');
    Route::get('/admin/productos/create', [ProductoController::class, 'create'])->name('productos.create');
    Route::post('/admin/productos', [ProductoController::class, 'store'])->name('productos.store');
    Route::get('/admin/productos/{producto}/edit', [ProductoController::class, 'edit'])->name('productos.edit');
    Route::put('/admin/productos/{producto}', [ProductoController::class, 'update'])->name('productos.update');
    Route::delete('/admin/productos/{producto}', [ProductoController::class, 'destroy'])->name('productos.destroy');

    //admin routes
    Route::get('/admin/ventas', [VentaController::class, 'index'])->name('ventas.index');
    Route::get('/admin/ventas/create', [VentaController::class, 'create'])->name('ventas.create');
    Route::post('/admin/ventas', [VentaController::class, 'store'])->name('ventas.store');
    Route::get('/admin/ventas/detail/{venta}', [VentaController::class, 'detail'])->name('ventas.detail');
    Route::get('/admin/ventas/{venta}', [VentaController::class, 'show'])->name('ventas.show');
    Route::put('/admin/ventas/{venta}', [VentaController::class, 'update'])->name('ventas.update');
    Route::get('/admin/ventas/{venta}/pdf', [VentaController::class, 'pdf'])->name('ventas.pdf');
    Route::delete('/admin/ventas/{venta}', [VentaController::class, 'destroy'])->name('ventas.destroy');

    //admin routes
    Route::get('/admin/inventarios', [InventarioController::class, 'index'])->name('inventarios.index');
    Route::get('/admin/inventarios/create', [InventarioController::class, 'create'])->name('inventarios.create');
    Route::post('/admin/inventarios', [InventarioController::class, 'store'])->name('inventarios.store');
    Route::get('/admin/inventarios/{inventario}', [InventarioController::class, 'show'])->name('inventarios.show');
    Route::get('/admin/inventarios/{inventario}/edit', [InventarioController::class, 'edit'])->name('inventarios.edit');
    Route::put('/admin/inventarios/{inventario}', [InventarioController::class, 'update'])->name('inventarios.update');
    Route::delete('/admin/inventarios/{inventario}', [InventarioController::class, 'destroy'])->name('inventarios.destroy');

    //admin routes
    Route::get('/admin/pacientes', [PacienteController::class, 'index'])->name('pacientes.index');
    Route::get('/admin/pacientes/create', [PacienteController::class, 'create'])->name('pacientes.create');
    Route::post('/admin/pacientes', [PacienteController::class, 'store'])->name('pacientes.store');
    Route::get('/admin/pacientes/{paciente}', [PacienteController::class, 'show'])->name('pacientes.show');
    Route::get('/admin/pacientes/{paciente}/edit', [PacienteController::class, 'edit'])->name('pacientes.edit');
    Route::put('/admin/pacientes/{paciente}', [PacienteController::class, 'update'])->name('pacientes.update');
    Route::delete('/admin/pacientes/{paciente}', [PacienteController::class, 'destroy'])->name('pacientes.destroy');

    //admin routes
    Route::get('/admin/medicos', [MedicoController::class, 'index'])->name('medicos.index');
    Route::get('/admin/medicos/create', [MedicoController::class, 'create'])->name('medicos.create');
    Route::post('/admin/medicos/admin', [MedicoController::class, 'store'])->name('medicos.store');
    Route::get('/admin/medicos/{medico}', [MedicoController::class, 'show'])->name('medicos.show');
    Route::get('/admin/medicos/{medico}/edit', [MedicoController::class, 'edit'])->name('medicos.edit');
    Route::put('/admin/medicos/{medico}', [MedicoController::class, 'update'])->name('medicos.update');
    Route::delete('/admin/medicos/{medico}', [MedicoController::class, 'destroy'])->name('medicos.destroy');
    
    //admin routes
    Route::get('/admin/categorias', [CategoriaController::class, 'index'])->name('categorias.index');
    Route::get('/admin/categorias/create', [CategoriaController::class, 'create'])->name('categorias.create');
    Route::post('/admin/categorias', [CategoriaController::class, 'store'])->name('categorias.store');
    Route::get('/admin/categorias/{categoria}', [CategoriaController::class, 'show'])->name('categorias.show');
    Route::get('/admin/categorias/{categoria}/edit', [CategoriaController::class, 'edit'])->name('categorias.edit');
    Route::put('/admin/categorias/{categoria}', [CategoriaController::class, 'update'])->name('categorias.update');
    Route::delete('/admin/categorias/{categoria}', [CategoriaController::class, 'destroy'])->name('categorias.destroy');

    //admin routes
    Route::get('/admin/compras', [CompraController::class, 'index'])->name('compras.index');
    Route::get('/admin/compras/create', [CompraController::class, 'create'])->name('compras.create');
    Route::post('/admin/compras', [CompraController::class, 'store'])->name('compras.store');
    Route::get('/admin/compras/{compra}', [CompraController::class, 'show'])->name('compras.show');
    Route::get('/admin/compras/{compra}/edit', [CompraController::class, 'edit'])->name('compras.edit');
    Route::put('/admin/compras/{compra}', [CompraController::class, 'update'])->name('compras.update');
    Route::delete('/admin/compras/{compra}', [CompraController::class, 'destroy'])->name('compras.destroy');
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::post('/mensaje/enviar', [CitaController::class, 'enviarMensaje'])->name('mensaje.enviar');
});
    



// 404: Not Found
Route::fallback(function () {
    return response()->view('404', [], 404);
});





