<?php
namespace Loid\Module\Manager\Logic;

use Illuminate\Http\Request;
use App\User as LaravelUser;
use Validator;
use DB;


class User{
    
    /**
     * 用户添加
     */
    public function add(array $params){
        
        Validator::extend('is_mobile', function($attribute, $value, $parameters, $validator) {
            return is_mobile($value);
        });
        $validator = Validator::make($params, [
            'name' => 'required|unique:users|is_mobile',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6|max:20',
            'role' => 'required|numeric|min:1'
        ], [
            'name.required' => '登录名不是正确的手机号',
            'name.unique' => '登录名重复',
            'name.is_mobile' => '登录名不是正确的手机号',
            
            'email.required' => '邮箱不正确',
            'email.unique' => '邮箱重复',
            'email.email' => '邮箱不正确',
            
            'password.required' => '密码必须为6-20的字符串',
            'password.min' => '密码必须为6-20的字符串',
            'password.max' => '密码必须为6-20的字符串',
            
            'role.min' => '角色不能为空',
            'role.required' => '角色不能为空',
            'role.numeric' => '角色不能为空',
        ]);
        if ($validator->fails()) {
            throw new \Exception($validator->errors()->first());
        }
        $user = LaravelUser::create([
            'name' => $params['name'],
            'email' => $params['email'],
            'password' => bcrypt($params['password']),
        ]);
        DB::table('system_manager_user_role')->insert([
            'role_id' => $params['role'],
            'user_id' => $user->id,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ]);
    }
    
    /**
     * 用户修改
     */
    public function modify(int $user_id, array $params){
        if (empty($params['password'])) unset($params['password']);
        
        $validator = Validator::make($params, [
            'email' => 'required|email|unique:users',
            'password' => 'sometimes|min:6|max:20',
            'role' => 'required|numeric|min:1'
        ], [
            'email.required' => '邮箱不正确',
            'email.unique' => '邮箱重复',
            'email.email' => '邮箱不正确',
            
            'password.required' => '密码必须为6-20的字符串',
            'password.min' => '密码必须为6-20的字符串',
            'password.max' => '密码必须为6-20的字符串',
            
            'role.min' => '角色不能为空',
            'role.required' => '角色不能为空',
            'role.numeric' => '角色不能为空',
        ]);
        if ($validator->fails()) {
            throw new \Exception($validator->errors()->first());
        }
        
        $user = LaravelUser::find($user_id);
        $user->email = $params['email'];
        if (isset($params['password'])) {
            $user->password = bcrypt($params['password']);
        }
        $user->updated_at = date('Y-m-d H:i:s');
        $user->save();
    }
}