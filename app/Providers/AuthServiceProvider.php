use App\Models\Producto;
use App\Models\Venta;
use App\Models\User;

use App\Policies\ProductoPolicy;
use App\Policies\VentaPolicy;
use App\Policies\UsuarioPolicy;

protected $policies = [
    Producto::class => ProductoPolicy::class,
    Venta::class => VentaPolicy::class,
    User::class => UsuarioPolicy::class,
];

public function boot()
{
    $this->registerPolicies();
}