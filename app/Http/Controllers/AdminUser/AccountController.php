<?php
/**
 * Created by PhpStorm.
 * User: Mr Zhou
 * Date: 2020/3/22
 * Time: 1:24
 * Emali: 363905263@qq.com
 */

namespace App\Http\Controllers\AdminUser;


use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use App\Repositories\Auth\UserPermission;
use App\Repositories\AdminHandleLog\AdminLogHandle;
use Illuminate\Http\Request;
use App\Models\AdminUsers;
use App\Models\Role;

class AccountController extends Controller
{

    /**
     * 首页登录判断
     */
    public function login()
    {
        if (Auth::check()) {
            return redirect('/home');
        }
        return view('auth.login');
    }

    /**
     * 用户登录
     */
    public function doLogin(Request $request, AdminUsers $adminUsers)
    {
        $validator = Validator::make($request->all(),
            ['name' => 'required', 'password' => 'required'],
            ['name.required' => '请填写用户名', 'email.required' => '请填写密码']
        );
        if ($validator->fails()) {
            return redirect('login')
                ->withErrors($validator)
                ->withInput();
        }
        $userName = $request->input('name');
        $passWord = $request->input('password');
        $user = $adminUsers->where('name', $userName)->first();
        if (!$user) {
            return redirect('login')->with('error', '用户名或密码错误');
        }
        if (Hash::check($passWord, $user->password)) {
            if($user->freeze==1){
                return redirect('login')->with('error', '该账户已被冻结请联系管理员');
            }
            Auth::login($user);
            return redirect('home');
        } else {
            return redirect('login')->with('error', '用户名或密码错误');
        }
    }

    /**
     * 退出登录
     */
    public function logout()
    {
        Auth::logout();
        return redirect('/login');
    }

    public function list(Request $request)
    {
        $name = $request->input('name');
        $email = $request->input('email');
        $user = AdminUsers::select('*')->with('roleUser.role')
            ->when($name, function ($query) use ($name) {
                $query->where('name', 'like', $name . '%');
            })->when($email, function ($query) use ($email) {
                $query->where('email', 'like', $email . '%');
            })->orderByDesc('id')->paginate(10);
        return view('userAdmin.list', ['list' => $user, 'user_id' => Auth::id(), 'name' => $name, 'email' => $email]);
    }

    public function edit(Request $request)
    {
        $id = $request->input('id');
        $user = AdminUsers::find($id) ?? null;
        $role = Role::all();
        if ($user) {
            $user_role = $user->roleUser->map(function ($value) {
                return $value->role->id;
            });
        } else {
            $user_role = collect([]);
        }
        return view('userAdmin.add-edit', ['data' => $user, 'roles' => $role, 'user_role' => $user_role]);
    }

    public function save(Request $request, UserPermission $userPermission)
    {
        try {
            $validator = Validator::make($request->all(),
                ['name' => 'required'],
                ['name.required' => '请填写用户名']
            );
            if ($validator->fails()) {
                $validatorError = json_encode($validator->getMessageBag());
                throw new \Exception($validatorError, 4002);
            }
            $id = $request->input('id');
            $name = $request->input('name');
            $email = $request->input('email');
            $password = $request->input('password');
            if ($id > 0) {
                $name_exist = AdminUsers::where('id', '!=', $id)->where('name', $name)->first() && true;
                $user = AdminUsers::find($id);
            } else {
                $name_exist = AdminUsers::where('name', $name)->first() && true;
                $user = new AdminUsers();
            }
            if ($name_exist) {
                $validatorError = ['name' => '用户名已存在'];
                $validatorError = json_encode($validatorError);
                throw new \Exception($validatorError, 4002);
            }
            if (!empty($password)) {
                $user->password = Hash::make($password);
            }
            $user->name = $name;
            $user->email = $email;
            $user->save();
            if ($id > 0) {
                AdminLogHandle::write('编辑用户');
            } else {
                AdminLogHandle::write('添加用户');
            }
            $userPermission->saveUserRole($user, $request->input('roles'));
            return redirect('admin_user/list');
        } catch (\Exception $e) {
            $error = $e->getCode() == 4002 ? json_decode($e->getMessage()) : $e->getMessage();
            return redirect('admin_user/edit?id=' . $request->input('id'))
                ->withErrors($error)
                ->withInput();
        }

    }

    public function deleteUser($id)
    {
        $user = AdminUsers::find($id);
        $user->delete();
        AdminLogHandle::write();
        return success('删除成功');
    }

    public function changeUserStatus($id)
    {
        $user = AdminUsers::find($id);
        $user->freeze = $user->freeze == 0 ? 1 : 0;
        $user->save();
        AdminLogHandle::write();
        return success('操作成功');
    }

    public function editUser()
    {
        $user = Auth::user();
        return view('userAdmin.editUser', ['userInfo' => $user]);
    }

    public function saveUser(Request $request, UserPermission $userPermission)
    {
        try {
            $validator = Validator::make($request->all(),
                ['name' => 'required', 'email' => 'required|email'],
                ['name.required' => '请填写用户名', 'email.required' => '请填写邮箱', 'email.email' => '请填写正确邮箱']
            );
            if ($validator->fails()) {
                $validatorError = json_encode($validator->getMessageBag());
                throw new \Exception($validatorError, 4002);
            }
            $id = Auth::user()->id;
            $name = $request->input('name');
            $email = $request->input('email');
            $password = $request->input('password');
            if ($id > 0) {
                $name_exist = AdminUsers::where('id', '!=', $id)->where('name', $name)->first() && true;
                $user = AdminUsers::find($id);
            } else {
                $name_exist = AdminUsers::where('name', $name)->first() && true;
                $user = new AdminUsers();
            }
            if ($name_exist) {
                $validatorError = ['name' => '用户名已存在'];
                $validatorError = json_encode($validatorError);
                throw new \Exception($validatorError, 4002);
            }
            if (!empty($password)) {
                $user->password = Hash::make($password);
            }
            $user->name = $name;
            $user->email = $email;
            $user->save();
            AdminLogHandle::write('编辑用户');
            $userPermission->saveUserRole($user, $request->input('roles'));
            return view('userAdmin.editUser', ['userInfo' => $user,'result'=>'yes']);
        } catch (\Exception $e) {
            $error = $e->getCode() == 4002 ? json_decode($e->getMessage()) : $e->getMessage();
            return redirect('edit_user')
                ->withErrors($error)
                ->withInput();
        }

    }
}
