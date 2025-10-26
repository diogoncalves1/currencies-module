<?php

namespace Modules\Permission\Http\Controllers;

use App\Http\Controllers\ApiController;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Modules\Permission\Http\Requests\RoleRequest;
use Modules\Permission\Http\Requests\UpdateRolePermissionsRequest;
use Modules\Permission\Repositories\PermissionRepository;
use Modules\Permission\Repositories\RoleRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use Modules\Permission\DataTables\RoleDataTable;

class RoleController extends ApiController
{
    private  RoleRepository $repository;
    private $permissionRepository;

    public function __construct(RoleRepository $repository, PermissionRepository $permissionRepository)
    {
        $this->repository = $repository;
        $this->permissionRepository = $permissionRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @param RoleDataTable
     * @throws AuthorizationException
     */
    public function index(RoleDataTable $dataTable)
    {
        $this->allowedAction('viewRole');

        return $dataTable->render('permission::roles.index');
    }

    /**
     * Show the form for create a new resource.
     *
     * @return Renderable
     * @throws AuthorizationException
     */
    public function create(): Renderable
    {
        $this->allowedAction('createRole');

        return view('permission::roles.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param RoleRequest $request
     * @return RedirectResponse
     * @throws AuthorizationException
     */
    public function store(RoleRequest $request): RedirectResponse
    {
        $this->allowedAction('createRole');

        $this->repository->store($request);

        return redirect()->route('admin.roles.index');
    }


    public function edit(string $id)
    {
        // $this->allowedAction('editRole');
        Session::flash('page', 'roles');

        $role = $this->repository->show($id);

        return view('permission::roles.create', ["role" => $role]);
    }

    /**
     * Update the specified resource in storage.
     * @param RoleRequest $request
     * @param string $id
     * @return RedirectResponse
     * @throws AuthorizationException
     */
    public function update(RoleRequest $request, string $id): RedirectResponse
    {
        $this->allowedAction('editRole');

        $this->repository->update($request, $id);

        return redirect()->route('admin.roles.index');
    }

    /**
     * Remove the specified resource from storage.
     * @param string $id
     * @return JsonResponse
     */
    public function destroy(string $id): JsonResponse
    {
        try {
            $this->allowedAction('destroyRole');

            $role = $this->repository->destroy($id);

            return $this->ok($role, "Perfil apagado com sucesso!");
        } catch (\Exception $e) {
            Log::error($e);
            return $this->fail("Erro ao tentar apagar esse perfil.", $e, $e->getCode());
        }
    }

    public function showManageForm(string $id)
    {
        // $this->allowedAction('manageRolePermissions');

        Session::flash('page', 'roles');

        $rolePermissionsIds = $this->repository->getRolePermissionsIds($id);

        $permissionsGrouped = $this->permissionRepository->getPermissionsGrouped();

        $data = [
            "rolePermissionsIds" => $rolePermissionsIds,
            "permissionsGrouped" => $permissionsGrouped,
            "roleId" => $id
        ];

        return view('permission::roles.manage', $data);
    }

    public function manage(UpdateRolePermissionsRequest $request, string $id)
    {
        // $this->allowedAction('manageRolePermissions');

        $this->repository->managePermissions($request, $id);

        return redirect()->route('admin.roles.index');
    }
}
