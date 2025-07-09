<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Tarifa;

class TarifasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Fibra 600
        if (Tarifa::where('tipo', 'fibra')->where('velocidad', 600)->count() == 0) {
            $tarifa1 = new Tarifa();
            $tarifa1->tipo = 'fibra';
            $tarifa1->descripcion = 'Fibra 600 Mbps simétrica, perfecta para tu hogar, juegos, series, películas, etc.';
            $tarifa1->velocidad = 600;
            $tarifa1->minutos = null;
            $tarifa1->gb = null;
            $tarifa1->precio = 20;
            $tarifa1->save();
        }

        // Fibra 300
        if (Tarifa::where('tipo', 'fibra')->where('velocidad', 300)->count() == 0) {
            $tarifa2 = new Tarifa();
            $tarifa2->tipo = 'fibra';
            $tarifa2->descripcion = 'Fibra 300 Mbps ideal para navegar y teletrabajo.';
            $tarifa2->velocidad = 300;
            $tarifa2->minutos = null;
            $tarifa2->gb = null;
            $tarifa2->precio = 15;
            $tarifa2->save();
        }

        // GB 50
        if (Tarifa::where('tipo', 'gb')->where('gb', 50)->count() == 0) {
            $tarifa3 = new Tarifa();
            $tarifa3->tipo = 'gb';
            $tarifa3->descripcion = '50GB para tu móvil, navega sin preocuparte.';
            $tarifa3->velocidad = null;
            $tarifa3->minutos = null;
            $tarifa3->gb = 50;
            $tarifa3->precio = 10;
            $tarifa3->save();
        }

        // GB 100
        if (Tarifa::where('tipo', 'gb')->where('gb', 100)->count() == 0) {
            $tarifa4 = new Tarifa();
            $tarifa4->tipo = 'gb';
            $tarifa4->descripcion = '100GB para los más exigentes.';
            $tarifa4->velocidad = null;
            $tarifa4->minutos = null;
            $tarifa4->gb = 100;
            $tarifa4->precio = 18;
            $tarifa4->save();
        }

        // Llamadas ilimitadas
        if (Tarifa::where('tipo', 'llamadas')->where('minutos', null)->count() == 0) {
            $tarifa5 = new Tarifa();
            $tarifa5->tipo = 'llamadas';
            $tarifa5->descripcion = 'Llamadas ilimitadas a fijos y móviles nacionales.';
            $tarifa5->velocidad = null;
            $tarifa5->minutos = -1;
            $tarifa5->gb = null;
            $tarifa5->precio = 5;
            $tarifa5->save();
        }

        // Llamadas 200 min
        if (Tarifa::where('tipo', 'llamadas')->where('minutos', 200)->count() == 0) {
            $tarifa6 = new Tarifa();
            $tarifa6->tipo = 'llamadas';
            $tarifa6->descripcion = '200 minutos en llamadas nacionales.';
            $tarifa6->velocidad = null;
            $tarifa6->minutos = 200;
            $tarifa6->gb = null;
            $tarifa6->precio = 3;
            $tarifa6->save();
        }

        // TV Estándar
        if (Tarifa::where('tipo', 'tv')->where('descripcion', 'TV Estándar con canales básicos.')->count() == 0) {
            $tarifa7 = new Tarifa();
            $tarifa7->tipo = 'tv';
            $tarifa7->descripcion = 'TV Estándar con canales básicos.';
            $tarifa7->velocidad = null;
            $tarifa7->minutos = null;
            $tarifa7->gb = null;
            $tarifa7->precio = 7;
            $tarifa7->save();
        }

        // TV Premium
        if (Tarifa::where('tipo', 'tv')->where('descripcion', 'TV Premium con deportes y cine.')->count() == 0) {
            $tarifa8 = new Tarifa();
            $tarifa8->tipo = 'tv';
            $tarifa8->descripcion = 'TV Premium con deportes y cine.';
            $tarifa8->velocidad = null;
            $tarifa8->minutos = null;
            $tarifa8->gb = null;
            $tarifa8->precio = 12;
            $tarifa8->save();
        }
    }
}
