
<?php

Breadcrumbs::for('home', function ($trail) {
    $trail->push('Inicio', route('dashboard.index'));
});

// Home > Usuarios
Breadcrumbs::for('usuarios.index', function ($trail) {
    $trail->parent('home');
    $trail->push('Usuarios', route('usuarios.index'));
});

// Home > Usuarios > Nuevo
Breadcrumbs::for('usuarios.create', function ($trail) {
    $trail->parent('usuarios.index');
    $trail->push('Nuevo', route('usuarios.create'));
});

// Home > Usuarios > Editar
Breadcrumbs::for('usuarios.edit', function ($trail, $usuario) {
    // dd($usuario);
    $trail->parent('usuarios.index');
    $trail->push('Editar', route('usuarios.edit', $usuario));
});