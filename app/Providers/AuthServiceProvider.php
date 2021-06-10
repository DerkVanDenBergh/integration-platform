<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

use App\Models\Role;
use App\Models\Processable;
use App\Models\Connection;
use App\Models\Authentication;
use App\Models\Endpoint;
use App\Models\DataModel;
use App\Models\DataModelField;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        // 'App\Models\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();
        
        // TODO: make policies out of these

        Gate::define('manage', function ($user) {
            $role = Role::find($user->role_id);

            return $role->can_manage_users || $role->can_manage_functions || $role->can_manage_roles || $role->can_manage_templates;
        });

        Gate::define('manage_users', function ($user) {
            $role = Role::find($user->role_id);

            return $role->can_manage_users;
        });

        Gate::define('manage_roles', function ($user) {
            $role = Role::find($user->role_id);

            return $role->can_manage_roles;
        });

        Gate::define('manage_functions', function ($user) {
            $role = Role::find($user->role_id);

            return $role->can_manage_functions;
        });

        Gate::define('manage_templates', function ($user) {
            $role = Role::find($user->role_id);

            return $role->can_manage_templates;
        });

        Gate::define('mutate_or_view_connection', function ($user, Connection $connection) {
            return $user->id === $connection->user_id;
        });

        Gate::define('mutate_or_view_authentication', function ($user, Authentication $authentication) {
            $connection = Connection::find($authentication->connection_id);
            
            return $user->id === $connection->user_id;
        });

        Gate::define('mutate_or_view_endpoint', function ($user, Endpoint $endpoint) {
            $connection = Connection::find($endpoint->connection_id);
            
            return $user->id === $connection->user_id;
        });

        Gate::define('mutate_or_view_data_model', function ($user, DataModel $dataModel) {
            return $user->id === $dataModel->user_id;
        });

        Gate::define('mutate_or_view_data_model_field', function ($user, DataModelField $dataModelField) {
            $dataModel = DataModel::find($dataModelField->model_id);
            
            return $user->id === $dataModel->user_id;
        });

        Gate::define('mutate_or_view_processable', function ($user, Processable $processable) {
            return $user->id === $processable->user_id;
        });
    }
}
