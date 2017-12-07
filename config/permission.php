<?php

return [
    /*不用登陆就能访问的方法*/
    'no_login_method' => [],
    
    /*不用授权就能访问的类*/
    'no_auth_class' => [],
    
    /*不用授权就能访问的方法*/
    'no_auth_method' => ['getjQGridList'],
    
    /*不用授权就能访问的类方法*/
    'no_auth_class_method' => [],
    
    /*菜单权限配置*/
    
    'menus' => [
        'user' => [
            'label' => '系统用户',
            'icon'  => 'fa-users',
            'menu'  => array(
                array('label' => '用户信息','display'=>true, 'alias' => 'manage.user', 'method' => 'get'),
                array('label' => '用户修改','display'=>false, 'alias' => 'manage.user.modify', 'method' => 'post'),
            ),
            
        ],
    ],
];