<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Crear usuario RMC1 si no existe
        if (User::where('email', 'RMC1@email.RMC')->count() == 0) {
            $user1 = new User();
            $user1->name = 'RMC1';
            $user1->dni = '00000001A';
            $user1->email = 'RMC1@email.RMC';
            $user1->password = Hash::make('RMC1');
            $user1->email_verified_at = Carbon::now();
            $user1->rol = 'admin';
            $user1->tarifa = null;
            $user1->save();
        }

        // Crear usuario RMC2 si no existe
        if (User::where('email', 'RMC2@email.RMC')->count() == 0) {
            $user2 = new User();
            $user2->name = 'RMC2';
            $user2->dni = '00000002B';
            $user2->email = 'RMC2@email.RMC';
            $user2->password = Hash::make('RMC2');
            $user2->email_verified_at = Carbon::now();
            $user2->rol = 'usuario';
            $user2->tarifa = null;
            $user2->save();
        }

        // Crear usuario RMC3 con tarifa JSON
        if (User::where('email', 'RMC3@email.RMC')->count() == 0) {
            $user3 = new User();
            $user3->name = 'RMC3';
            $user3->dni = '00000003C';
            $user3->email = 'RMC3@email.RMC';
            $user3->password = Hash::make('RMC3');
            $user3->email_verified_at = Carbon::now();
            $user3->rol = 'usuario';
            $user3->tarifa = json_encode([
                'direccion' => [
                    'ciudad' => 'Madrid',
                    'calle' => 'Gran Vía',
                    'numero' => '10',
                    'cp' => '28013',
                ],
                'fibra' => [
                    'id_tarifa' => 1,
                    'velocidad' => 600,
                    'precio' => 20.00,
                ],
                'movil' => [
                    'lineas' => [
                        [
                            'id_tarifa' => 3,
                            'gb' => 50,
                            'precio' => 10.00,
                            'telefono' => '600123456',
                            'llamadas' => [
                                'id_tarifa' => 5,
                                'minutos' => -1, // Ilimitadas
                                'precio' => 5.00,
                            ]
                        ]
                    ]
                ],
                'tv' => [
                    'id_tarifa' => 7,
                    'tipo' => 'estandar',
                    'precio' => 7.00,
                ],
                'fecha_contratacion' => Carbon::now()->toDateString(),
                'precio_total' => 42.00, // 20€ fibra + 15€ móvil (10€ datos + 5€ llamadas) + 7€ TV
            ]);
            $user3->save();
        }

        // Crear usuario RMC4 sin fibra y con 3 líneas móviles diferentes
        if (User::where('email', 'RMC4@email.RMC')->count() == 0) {
            $user4 = new User();
            $user4->name = 'RMC4';
            $user4->dni = '00000004D';
            $user4->email = 'RMC4@email.RMC';
            $user4->password = Hash::make('RMC4');
            $user4->email_verified_at = Carbon::now();
            $user4->rol = 'usuario';
            $user4->tarifa = json_encode([
                'direccion' => [
                    'ciudad' => 'Barcelona',
                    'calle' => 'Rambla',
                    'numero' => '25',
                    'cp' => '08002',
                ],
                'movil' => [
                    'lineas' => [
                        [
                            'id_tarifa' => 3,
                            'gb' => 50,
                            'precio' => 10.00,
                            'telefono' => '600111111',
                            'llamadas' => [
                                'id_tarifa' => 5,
                                'minutos' => -1, // Ilimitadas
                                'precio' => 5.00,
                            ]
                        ],
                        [
                            'id_tarifa' => 4,
                            'gb' => 100,
                            'precio' => 18.00,
                            'telefono' => '600222222',
                            'llamadas' => [
                                'id_tarifa' => 6,
                                'minutos' => 200,
                                'precio' => 3.00,
                            ]
                        ],
                        [
                            'id_tarifa' => 3,
                            'gb' => 50,
                            'precio' => 10.00,
                            'telefono' => '600333333',
                            'llamadas' => [
                                'id_tarifa' => 5,
                                'minutos' => -1, // Ilimitadas
                                'precio' => 5.00,
                            ]
                        ]
                    ]
                ],
                'tv' => [
                    'id_tarifa' => 8,
                    'tipo' => 'premium',
                    'precio' => 12.00,
                ],
                'fecha_contratacion' => Carbon::now()->subDays(30)->toDateString(),
                'precio_total' => 68.00, // 0€ fibra + 56€ móviles (38€ datos + 18€ llamadas) + 12€ TV
            ]);
            $user4->save();
        }

        // Crear usuario RMC5 con configuración variada
        if (User::where('email', 'RMC5@email.RMC')->count() == 0) {
            $user5 = new User();
            $user5->name = 'RMC5';
            $user5->dni = '00000005E';
            $user5->email = 'RMC5@email.RMC';
            $user5->password = Hash::make('RMC5');
            $user5->email_verified_at = Carbon::now();
            $user5->rol = 'usuario';
            $user5->tarifa = json_encode([
                'direccion' => [
                    'ciudad' => 'Valencia',
                    'calle' => 'Carrer de Colón',
                    'numero' => '15',
                    'cp' => '46004',
                ],
                'fibra' => [
                    'id_tarifa' => 2,
                    'velocidad' => 300,
                    'precio' => 15.00,
                ],
                'movil' => [
                    'lineas' => [
                        [
                            'id_tarifa' => 4,
                            'gb' => 100,
                            'precio' => 18.00,
                            'telefono' => '600444444',
                            'llamadas' => [
                                'id_tarifa' => 5,
                                'minutos' => -1, // Ilimitadas
                                'precio' => 5.00,
                            ]
                        ],
                        [
                            'id_tarifa' => 3,
                            'gb' => 50,
                            'precio' => 10.00,
                            'telefono' => '600555555',
                            'llamadas' => [
                                'id_tarifa' => 6,
                                'minutos' => 200,
                                'precio' => 3.00,
                            ]
                        ]
                    ]
                ],
                'fecha_contratacion' => Carbon::now()->subDays(15)->toDateString(),
                'precio_total' => 56.00, // 15€ fibra + 41€ móviles (28€ datos + 13€ llamadas)
            ]);
            $user5->save();
        }
    }
}