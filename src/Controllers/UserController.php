<?php

namespace Loid\Module\Manager\Controllers;

use Illuminate\Http\Request;

use Loid\Frame\Controllers\Controller;
use Loid\Module\Manager\Role\Model\ManagerRole;
use Loid\Frame\Support\JqGrid;
use DB;
use Log;
use LogicUser;

class UserController extends Controller{
    
    private $moudle = 'loid-module-manager';
    
    public function __construct(){
        parent::__construct();
        if ($moudle = app()->moudle[$this->moudle]) {
            $this->view_prefix = $moudle->view_namespace . '::' . config('view.default.theme') . DIRECTORY_SEPARATOR;
        }
    }
    public function index(){
        return $this->view("{$this->view_prefix}/user/index", [
            'view_prefix' => $this->view_prefix,
            'rows' => $this->rows,
        ]);
    }
    
    public function _getList($type){
        $list = \Loid\Frame\Support\JqGrid::instance(['model'=> DB::table('users'),'vagueField'=>['name','email'],'filtField'=>['remember_token','password']])
            ->query(['id|<>'=>\Auth::user()->id]);
        //foreach ($list['rows'] as $key => $val) {
        //    $list['rows'][$key]['role'] = DB::table('system_manager_role')->where(function($query) use ($val){
        //        $query->where('role_id', DB::table('system_manager_user_role')->where('user_id', $val['id'])->value('role_id'));
        //    })->value('role_name');
        //}
        return $list;
    }
    
    public function modify(Request $request){
        $name = $request->input('name');
        $password = $request->input('password');
        $email = $request->input('email');
        $role = $request->input('role');
        
        $params = [
            'role' => $role,
            'name' => $name,
            'password' => $password,
            'email' => $email
        ];
        
        try {
            if ('add' == $request->input('oper')) {
                LogicUser::add($params);
            } else {
                LogicUser::modify((int)$request->input('id'), $params);
            }
        } catch (\Exception $e) {
            return $this->response(false, '', $e->getMessage());
        }
        return $this->response(true);
        
    }
}