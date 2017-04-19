<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\CreatePermissionRequest;
use App\Http\Requests\CreateRoleRequest;
use App\Repositories\PermissionRepository;
use App\Repositories\RoleRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

/**
 * Class AclController
 * @package App\Http\Controllers\Admin
 */
class AclController extends Controller
{
    /**
     * @var RoleRepository
     * @author Luoyan
     */
    protected $role;

    /**
     * @var PermissionRepository
     * @author Luoyan
     */
    protected $permission;

    /**
     * 注入
     *
     * AclController constructor.
     * @param RoleRepository $role
     * @param PermissionRepository $permissionRepository
     * @author Luoyan
     */
    public function __construct
    (
        RoleRepository $role,
        PermissionRepository $permissionRepository
    )
    {
        $this->role = $role;
        $this->permission = $permissionRepository;
    }

    /**
     * 角色列表
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @author: Luoyan
     */
    public function index()
    {
        return view('admin.acl.index');
    }

    /**
     * 创建角色
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @author: Luoyan
     */
    public function create()
    {
        return view('admin.acl.insert');
    }

    /**
     * 添加权限表单
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @author: Luoyan
     */
    public function permissionForm()
    {
        return view('admin.acl.permission');
    }

    /**
     * 添加权限
     *
     * @param CreatePermissionRequest $request
     * @return $this|\Illuminate\Http\RedirectResponse
     * @author: Luoyan
     */
    public function permission(CreatePermissionRequest $request)
    {
        // 添加角色并且判读是否成功
        if ($this->permission->createRole($request->all())) {
            // 成功跳转角色列表
            return back()->with('success', '添加成功!');
        }

        // 失败返回错误信息
        return back()->withErrors('角色添加失败!')->withInput();
    }

    /**
     * 创建角色
     *
     * @param CreateRoleRequest $request
     * @return $this|\Illuminate\Http\RedirectResponse
     * @author: Luoyan
     */
    public function store(CreateRoleRequest $request)
    {
        // 添加角色并且判读是否成功
        if ($this->role->createRole($request->all())) {
            // 成功跳转角色列表
            return redirect()->route('acl.index');
        }

        // 失败返回错误信息
        return back()->withErrors('角色添加失败!')->withInput();
    }

    /**
     * 角色分页列表
     *
     * @param Request $request
     * @return mixed
     * @author: Luoyan
     */
    public function aclList(Request $request)
    {
        // 获取分页或搜索后的数据
        return $this->role->aclPaginate($request->get('perPage'), $request->get('where'));
    }

    /**
     * 根据 id 修改信息
     *
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     * @author: Luoyan
     */
    public function update(Request $request, $id)
    {
        // 除去请求中得 _token 字段
        $data = $request->except(['_token']);
        // 修改分类数据, 判断返回结果
        if ($this->role->updateById($id, $data)) {
            // 查询更新后的值
            $data = $this->role->findById($id);

            // 成功返回修改数据
            return responseMsg($data, 200);
        }

        // 修改失败
        return responseMsg('修改失败!', 400);
    }

    /**
     * 获取一个角色的权限列表
     *
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     * @author: Luoyan
     */
    public function show($id)
    {
        // 获取所有权限
        $permissions = $this->permission->fetchPermissions();
        // 判断是否有权限数据
        if (!$permissions->toArray()) {
            // 暂无权限
            return responseMsg([]);
        }
        // 查询角色已有权限
        $ids = $this->role->fetchPermissionsTheIds($id)->toArray();

        // 判断该角色是否有权限
        if (!$ids) {
            // 返回所有权限
            return responseMsg($permissions);
        }

        // 给已有的权限打个标记
        foreach ($permissions as $v) {
            if (in_array($v->id, $ids)) {
                $v->checked = true;
            }
        }

        // 返回权限列表数据
        return responseMsg($permissions);
    }

    /**
     * 同步角色权限
     *
     * @param Request $request
     * @param $id
     * @author: Luoyan
     */
    public function syncPermissions(Request $request, $id)
    {
        // 查询当前角色
        $role = $this->role->findById($id);
        // 同步角色权限
        $role->syncPermissions($request->all());
    }
}