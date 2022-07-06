<?php

return [
    'admin-user' => [
        'title' => 'Users',

        'actions' => [
            'index' => 'Users',
            'create' => 'New User',
            'edit' => 'Edit :name',
            'edit_profile' => 'Edit Profile',
            'edit_password' => 'Edit Password',
        ],

        'columns' => [
            'id' => 'ID',
            'last_login_at' => 'Last login',
            'first_name' => 'First name',
            'last_name' => 'Last name',
            'email' => 'Email',
            'password' => 'Password',
            'password_repeat' => 'Password Confirmation',
            'activated' => 'Activated',
            'forbidden' => 'Forbidden',
            'language' => 'Language',
                
            //Belongs to many relations
            'roles' => 'Roles',
                
        ],
    ],

    'help' => [
        'title' => 'Helps',

        'actions' => [
            'index' => 'Helps',
            'create' => 'New Help',
            'edit' => 'Edit :name',
        ],

        'columns' => [
            'id' => 'ID',
            'ci' => 'Ci',
            'name' => 'Name',
            'user' => 'User',
            'dependency' => 'Dependency',
            'fone' => 'Fone',
            'problem' => 'Problem',
            
        ],
    ],

    'state' => [
        'title' => 'States',

        'actions' => [
            'index' => 'States',
            'create' => 'New State',
            'edit' => 'Edit :name',
        ],

        'columns' => [
            'id' => 'ID',
            'name' => 'Name',
            
        ],
    ],

    'category' => [
        'title' => 'Categories',

        'actions' => [
            'index' => 'Categories',
            'create' => 'New Category',
            'edit' => 'Edit :name',
        ],

        'columns' => [
            'id' => 'ID',
            
        ],
    ],

    'category' => [
        'title' => 'Categories',

        'actions' => [
            'index' => 'Categories',
            'create' => 'New Category',
            'edit' => 'Edit :name',
        ],

        'columns' => [
            'id' => 'ID',
            'name' => 'Name',
            
        ],
    ],

    'assist' => [
        'title' => 'Assists',

        'actions' => [
            'index' => 'Assists',
            'create' => 'New Assist',
            'edit' => 'Edit :name',
        ],

        'columns' => [
            'id' => 'ID',
            'heritage' => 'Heritage',
            'id_user' => 'Id user',
            'date' => 'Date',
            'id_state' => 'Id state',
            'id_category' => 'Id category',
            
        ],
    ],

    'detail-assist' => [
        'title' => 'Detail Assist',

        'actions' => [
            'index' => 'Detail Assist',
            'create' => 'New Detail Assist',
            'edit' => 'Edit :name',
        ],

        'columns' => [
            'id' => 'ID',
            
        ],
    ],

    'detail-assist' => [
        'title' => 'Detail Assists',

        'actions' => [
            'index' => 'Detail Assists',
            'create' => 'New Detail Assist',
            'edit' => 'Edit :name',
        ],

        'columns' => [
            'id' => 'ID',
            'id_assist' => 'Id assist',
            'id_user' => 'Id user',
            'id_state' => 'Id state',
            'solution' => 'Solution',
            'date' => 'Date',
            
        ],
    ],

    's-i-g008' => [
        'title' => 'Sig008',

        'actions' => [
            'index' => 'Sig008',
            'create' => 'New Sig008',
            'edit' => 'Edit :name',
        ],

        'columns' => [
            'id' => 'ID',
            
        ],
    ],

    'detail-help' => [
        'title' => 'Detail Helps',

        'actions' => [
            'index' => 'Detail Helps',
            'create' => 'New Detail Help',
            'edit' => 'Edit :name',
        ],

        'columns' => [
            'id' => 'ID',
            'assist_id' => 'Assist',
            'user_id' => 'User',
            'state_id' => 'State',
            'solution' => 'Solution',
            'date' => 'Date',
            
        ],
    ],

    'detail-help' => [
        'title' => 'Detail Helps',

        'actions' => [
            'index' => 'Detail Helps',
            'create' => 'New Detail Help',
            'edit' => 'Edit :name',
        ],

        'columns' => [
            'id' => 'ID',
            
        ],
    ],

    'detail-help' => [
        'title' => 'Detail Helps',

        'actions' => [
            'index' => 'Detail Helps',
            'create' => 'New Detail Help',
            'edit' => 'Edit :name',
        ],

        'columns' => [
            'id' => 'ID',
            'help_id' => 'Help',
            'user_id' => 'User',
            'state_id' => 'State',
            'solution' => 'Solution',
            'date' => 'Date',
            
        ],
    ],

    'detail-help' => [
        'title' => 'Detail Helps',

        'actions' => [
            'index' => 'Detail Helps',
            'create' => 'New Detail Help',
            'edit' => 'Edit :name',
        ],

        'columns' => [
            'id' => 'ID',
            'help_id' => 'Help',
            'user_id' => 'User',
            'state_id' => 'State',
            'solution' => 'Solution',
            'date' => 'Date',
            'category_id' => 'Category',
            
        ],
    ],

    'r-h-m006' => [
        'title' => 'Rhm006',

        'actions' => [
            'index' => 'Rhm006',
            'create' => 'New Rhm006',
            'edit' => 'Edit :name',
        ],

        'columns' => [
            'id' => 'ID',
            
        ],
    ],

    'r-h-m0066' => [
        'title' => ' R H M0066',

        'actions' => [
            'index' => ' R H M0066',
            'create' => 'New  R H M0066',
            'edit' => 'Edit :name',
        ],

        'columns' => [
            'id' => 'ID',
            'FuncNro' => 'FuncNro',
            'FuncNom' => 'FuncNom',
            'FUsuCod' => 'FUsuCod',
            
        ],
    ],

    'functionary' => [
        'title' => 'Functionaries',

        'actions' => [
            'index' => 'Functionaries',
            'create' => 'New Functionary',
            'edit' => 'Edit :name',
        ],

        'columns' => [
            'id' => 'ID',
            'ci' => 'Ci',
            'full_name' => 'Full name',
            'user_name' => 'User name',
            
        ],
    ],

    // Do not delete me :) I'm used for auto-generation
];