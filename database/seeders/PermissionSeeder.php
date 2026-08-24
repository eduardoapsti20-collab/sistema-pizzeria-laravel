<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class PermissionSeeder extends Seeder
{
    public function run(): void
    {
        $rolesPermissions = [
            'admin' => [
                'categorias.ver',
                'categorias.crear',
                'categorias.editar',
                'categorias.eliminar',
                'cajas.ver',
                'cajas.crear',
                'cajas.editar',
                'cajas.eliminar',
                'cajas.cerrar',
                'cajas.movimientos',
                'productos.ver',
                'productos.crear',
                'productos.editar',
                'productos.eliminar',
                'mesas.ver',
                'mesas.crear',
                'mesas.editar',
                'mesas.eliminar',
                'ordenes.ver',
                'ordenes.crear',
                'ordenes.cobrar',
                'ventas.ver',
                'ventas.reportes',
                'payment_methods.ver',
                'payment_methods.crear',
                'payment_methods.editar',
                'payment_methods.eliminar',
                'gastos.ver',
                'gastos.crear',
                'gastos.editar',
                'gastos.eliminar',
                'gastos.reportes',
                'usuarios.ver',
                'usuarios.crear',
                'usuarios.editar',
                'usuarios.eliminar',
                'empresa.editar',
                'empresa.tablero',
                'roles.ver', 'roles.editar',
                'reportes.financieros',
            ],
            'cajero' => [
                'ordenes.ver',
                'ordenes.cobrar',
                'ventas.ver',
                'ventas.reportes',
                'payment_methods.ver',
                'productos.ver',
                'cajas.ver',
                'cajas.cerrar',
                'cajas.movimientos',
                'cajas.crear',
                'cajas.editar',
            ],
            'cocinero' => [
                'ordenes.ver',
                'productos.ver',
            ],
            'mesero' => [
                'ordenes.ver',
                'ordenes.crear',
                'mesas.ver',
                'productos.ver',
                'productos.crear',
                'productos.editar',
                'productos.eliminar',
            ],
            // Rol de solo lectura para el contador externo: ve ventas, gastos
            // y el reporte financiero combinado, pero no puede crear, editar
            // ni eliminar nada del sistema operativo del restaurante.
            'contador' => [
                'empresa.tablero',
                'ventas.ver',
                'ventas.reportes',
                'gastos.ver',
                'gastos.reportes',
                'reportes.financieros',
            ],
        ];

        foreach ($rolesPermissions as $roleName => $permissions) {
            // Crear rol
            $role = Role::firstOrCreate(['name' => $roleName]);

            foreach ($permissions as $permName) {
                // Crear permiso si no existe
                $permission = Permission::firstOrCreate(['name' => $permName]);
                // Asignar permiso al rol
                $role->givePermissionTo($permission);
            }
        }
    }
}
