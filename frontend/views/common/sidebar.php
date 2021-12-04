<div class="page-sidebar-wrapper">
                    <!-- BEGIN SIDEBAR -->
                    <!-- DOC: Set data-auto-scroll="false" to disable the sidebar from auto scrolling/focusing -->
                    <!-- DOC: Change data-auto-speed="200" to adjust the sub menu slide up/down speed -->
                    <div class="page-sidebar navbar-collapse collapse">
                        <!-- BEGIN SIDEBAR MENU -->
                        <!-- DOC: Apply "page-sidebar-menu-light" class right after "page-sidebar-menu" to enable light sidebar menu style(without borders) -->
                        <!-- DOC: Apply "page-sidebar-menu-hover-submenu" class right after "page-sidebar-menu" to enable hoverable(hover vs accordion) sub menu mode -->
                        <!-- DOC: Apply "page-sidebar-menu-closed" class right after "page-sidebar-menu" to collapse("page-sidebar-closed" class must be applied to the body element) the sidebar sub menu mode -->
                        <!-- DOC: Set data-auto-scroll="false" to disable the sidebar from auto scrolling/focusing -->
                        <!-- DOC: Set data-keep-expand="true" to keep the submenues expanded -->
                        <!-- DOC: Set data-auto-speed="200" to adjust the sub menu slide up/down speed -->

                        <?php

//                        $controller = $this->context;
//                        $module = $controller->module;
//                        $action = $controller->action->id;

                        $user = Yii::$app->getUser();
                        $checkController = function ($route) {
                            return $route === $this->context->getUniqueId();
                        };

                        $checkControllerAction = function ($route) {
                            $path=($this->context->id."/".$this->context->action->id);
                            return $route == $path;
                        };


                        echo \common\widgets\AmzSideNav::widget([
                            'options'=>[
                                'class'=>"page-sidebar-menu  page-header-fixed",
                                'data-keep-expanded'=>"false",
                                'data-auto-scroll'=>"true",
                                'data-slide-speed'=>"200",
                                'style'=>"padding-top: 20px"
                            ],
                            'indMenuOpen' => '',
                            'indMenuClose' => '',
                            'heading'=>'',
                            'activeCssClass'=>'active open',
                            'submenuTemplate' =>"\n<ul class='sub-menu'>\n{items}\n</ul>\n",
                            'iconPrefix'=>'icon-',
                            'items' => [
                                [
                                    'label' => 'Dashboard',
                                    'url' => ['/site/index'],
//                                    'visible' => $user->can('frontend/site/index'),
                                    'active' => $checkControllerAction('site/index'),
                                    'icon' => 'home',
                                    'template'=>'<a href="{url}">{icon}<span class="title">{label}</span></a>',
                                    'options'=>['class'=>'nav-item']
                                ],
                                [
                                    'label' => 'Tools',
                                    'options'=>['class'=>'heading'],
                                    'template'=>'<h3 class="uppercase">{label}</h3>',
                                ],
                                [
                                    'label' => 'Reviewers',
                                    'url' => ['/seller/amz-reviewer/index'],
                                    'visible' => $user->can('seller/amz-reviewer/index'),
//                                    'active' => $controller->id === 'amz-reviewer',
                                    'active' => $checkController('seller/amz-reviewer'),
                                    'icon' => 'users',
                                    'template'=>'<a href="{url}">{icon}<span class="title">{label}</span></a>',
                                    'options'=>['class'=>'nav-item']
                                ],
                                [
                                    'label' => 'Seller Requests',
                                    'url' => ['/seller/amz-seller-request/index'],
                                    'visible' => $user->can('seller/amz-seller-request/index'),
                                    'active' => $checkController('seller/amz-seller-request'),
                                    'icon' => 'paper-plane',
                                    'template'=>'<a href="{url}">{icon}<span class="title">{label}</span></a>',
                                    'options'=>['class'=>'nav-item']
                                ],
                                [
                                    'label' => 'Index checker',
                                    'url' => ['/indexchecker/default/searchform'],
                                    'visible' => $user->can('indexchecker/default/searchform'),
                                    'active' => $checkController('indexchecker/default'),
                                    'icon' => 'check',
                                    'template'=>'<a href="{url}">{icon}<span class="title">{label}</span></a>',
                                    'options'=>['class'=>'nav-item']
                                ],
                                [
                                    'label' => 'Ad analyzer',
                                    'url' => ['/main/amz-ad/keyword-search'],
                                    'visible' => $user->can('main/amz-ad/keyword-search'),
                                    'active' => $checkController('main/amz-ad'),
                                    'icon' => 'present',
                                    'template'=>'<a href="{url}">{icon}<span class="title">{label}</span></a>',
                                    'options'=>['class'=>'nav-item']
                                ],
                                [
                                    'label' => 'Products',
                                    'url' => ['/main/amz-product-quality/index'],
                                    'visible' => $user->can('main/amz-product-quality/index'),
                                    'active' => $checkControllerAction('amz-product-quality/index'),
                                    'icon' => 'basket',
                                    'template'=>'<a href="{url}" class="nav-link">{icon}<span class="title">{label}</span></a>',
                                    'options'=>['class'=>'nav-item']

                                ],

                                [
                                    'label' => 'Monitor',
//                                        'visible' => $user->can('seller/amz-seller-request/index'),
                                    'active' => ($checkControllerAction('amz-product/index') || $checkControllerAction('amz-product/keyword-monitor') || $checkController('seller/amz-seller-monitor')),
                                    'icon' => 'bar-chart',
                                    'template'=>'<a href="{url}" class="nav-link nav-toggle">{icon}<span class="title">{label}</span></a>',
                                    'options'=>['class'=>'nav-item'],
                                    'items'=>[
                                        [
                                            'label' => ' Critical review',
                                            'url' => ['/main/amz-product/index'],
                                            'visible' => $user->can('main/amz-product/index'),
                                            'active' => $checkControllerAction('amz-product/index'),
                                            'icon' => 'feed',
                                            'template'=>'<a href="{url}" class="nav-link">{icon}<span class="title">{label}</span></a>',
                                            'options'=>['class'=>'nav-item']
                                        ],[
                                            'label' => ' Keyword position',
                                            'url' => ['/main/amz-product/keyword-monitor'],
                                            'visible' => $user->can('main/amz-product/keyword-monitor'),
                                            'active' => $checkControllerAction('amz-product/keyword-monitor'),
                                            'icon' => 'bar-chart',
                                            'template'=>'<a href="{url}" class="nav-link">{icon}<span class="title">{label}</span></a>',
                                            'options'=>['class'=>'nav-item']
                                        ],[
                                            'label' => ' Seller products',
                                            'url' => ['/seller/amz-seller-monitor/index'],
                                            'visible' => $user->can('seller/amz-seller-monitor/index'),
                                            'active' => $checkController('seller/amz-seller-monitor'),
                                            'icon' => 'basket',
                                            'template'=>'<a href="{url}" class="nav-link">{icon}<span class="title">{label}</span></a>',
                                            'options'=>['class'=>'nav-item']
                                        ],
                                    ]
                                ],



//                                [
//                                    'label' => 'Quality Monitor',
////                                        'visible' => $user->can('seller/amz-seller-request/index'),
//                                    'active' => ($checkControllerAction('amz-product-quality/index')),
//                                    'icon' => 'diamond',
//                                    'template'=>'<a href="{url}">{icon}<span class="title">{label}</span></a>',
//                                    'options'=>['class'=>'nav-item'],
//                                    'items'=>[
//                                        [
//                                            'label' => ' Product list',
//                                            'url' => ['/main/amz-product-quality/index'],
//                                            'visible' => $user->can('main/amz-product-quality/index'),
//                                            'active' => $checkControllerAction('amz-product-quality/index'),
//                                            'icon' => 'feed',
//                                            'template'=>'<a href="{url}" class="nav-link">{icon}<span class="title">{label}</span></a>',
//                                            'options'=>['class'=>'nav-item']
//                                        ],
//                                    ]
//                                ],
                                [
                                    'label' => 'Settings',
                                    'options'=>['class'=>'heading'],
                                    'template'=>'<h3 class="uppercase">{label}</h3>',
                                ],
                                [
                                    'label' => 'User',
//                                        'visible' => $user->can('seller/amz-seller-request/index'),
                                    'active' => ($checkControllerAction('settings/profile') || $checkControllerAction('settings/account') || $checkControllerAction('amz-product-quality/credentials')),
                                    'icon' => 'user',
                                    'options'=>['class'=>'nav-item'],
                                    'template'=>'<a href="{url}" class="nav-link nav-toggle">{icon}<span class="title">{label}</span></a>',
                                    'items'=>[
                                        [
                                            'label' => ' Mws Credentials',
                                            'url' => ['/main/amz-product-quality/credentials'],
                                            'visible' => $user->can('main/amz-product-quality/credentials'),
                                            'active' => $checkControllerAction('amz-product-quality/credentials'),
//                                            'icon' => 'bar-chart',
                                            'template'=>'<a href="{url}" class="nav-link">{icon}<span class="title">{label}</span></a>',
                                            'options'=>['class'=>'nav-item']
                                        ],
                                        [

                                            'label' => ' Profile Settings',
                                            'url' => ['/user/settings/profile'],
//                                            'visible' => $user->can('user/settings/profile'),
                                            'active' => $checkControllerAction('settings/profile'),
//                                            'icon' => 'user',
                                            'template'=>'<a href="{url}" class="nav-link">{icon}<span class="title">{label}</span></a>',
                                            'options'=>['class'=>'nav-item']
                                        ],
                                        [
                                            'label' => ' Account Settings',
                                            'url' => ['/user/settings/account'],
//                                            'visible' => $user->can('user/settings/account'),
                                            'active' => $checkControllerAction('settings/account'),
//                                            'icon' => 'bar-user',
                                            'template'=>'<a href="{url}" class="nav-link">{icon}<span class="title">{label}</span></a>',
                                            'options'=>['class'=>'nav-item']
                                        ],


                                        [
                                            'label' => ' Sign out',
                                            'url' => ['/user/security/logout'],
//                                            'visible' => $user->can('user/security/logout'),
                                            'active' => $checkControllerAction('security/logout'),
//                                            'icon' => 'bar-user',
                                            'template'=>'<a href="{url}" class="nav-link" data-method="post">{icon}<span class="title">{label}</span></a>',
                                            'options'=>['class'=>'nav-item']
                                        ]
                                    ]
                                ],

                            ]
                        ]);
                    ?>
        </div>
        <!-- END SIDEBAR -->
    </div>