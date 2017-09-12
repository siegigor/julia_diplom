<aside class="main-sidebar">

    <section class="sidebar">

        <!-- Sidebar user panel -->
        <div class="user-panel">
                Меню
        </div>


        <?= dmstr\widgets\Menu::widget(
            [
                'options' => ['class' => 'sidebar-menu'],
                'items' => [
                    /*[
                        'label' => 'Регион, зона', 
                        'icon' => 'fa fa-dashboard', 
                        'url' => ['#'],
                        'items' => [
                            ['label' => 'Регион', 'icon' => 'fa fa-outdent', 'url' => ['/region']],
                            ['label' => 'Зона', 'icon' => 'fa fa-outdent', 'url' => ['/zona']],
                    
                        ],
                    ],*/
                    
                    
                    ['label' => 'Задачи', 'icon' => 'fa fa-puzzle-piece', 'url' => ['/task']],
                    ['label' => 'Категории', 'icon' => 'fa fa-tasks', 'url' => ['/category']],
                    ['label' => 'Пользователи', 'icon' => 'fa fa-users', 'url' => ['/user']],
                    ['label' => 'Решения', 'icon' => 'fa fa-cog', 'url' => ['/solution']],
                    ['label' => 'Соревнования', 'icon' => 'fa fa-list-ol', 'url' => ['/competition']]
                ],
            ]
        ) ?>

    </section>

</aside>
