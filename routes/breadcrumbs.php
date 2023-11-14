
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

// Home > Conductores
Breadcrumbs::for('conductores.index', function ($trail) {
    $trail->parent('home');
    $trail->push('Conductores', route('conductores.index'));
});

// Home > Socios
Breadcrumbs::for('socios.index', function ($trail) {
    $trail->parent('home');
    $trail->push('Socios', route('socios.index'));
});

// Home > Mototaxis
Breadcrumbs::for('mototaxis.index', function ($trail) {
    $trail->parent('home');
    $trail->push('Mototaxis', route('mototaxis.index'));
});

// Home > Mototaxis > Nuevo
Breadcrumbs::for('mototaxis.create', function ($trail) {
    $trail->parent('mototaxis.index');
    $trail->push('Nuevo', route('mototaxis.create'));
});

// Home > Mototaxis > Editar
Breadcrumbs::for('mototaxis.edit', function ($trail, $mototaxi) {
    $trail->parent('mototaxis.index');
    $trail->push('Editar', route('mototaxis.edit', $mototaxi));
});

// Home > Reportes
Breadcrumbs::for('reportes.index', function ($trail) {
    $trail->parent('home');
    $trail->push('Reportes', route('reportes.index'));
});

// Home > Reporteria
Breadcrumbs::for('reporteria.index', function ($trail) {
    $trail->parent('home');
    $trail->push('Reporteria', route('reporteria.index'));
});