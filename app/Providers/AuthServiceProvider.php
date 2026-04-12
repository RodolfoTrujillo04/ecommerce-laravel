use Illuminate\Support\Facades\Gate;

public function boot()
{
    $this->registerPolicies();

    Gate::define('esAdmin', function ($user) {
        return $user->rol === 'administrador';
    });
}