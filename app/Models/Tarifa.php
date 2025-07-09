<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tarifa extends Model
{
    use HasFactory;

    protected $table = 'tarifas';

    protected $fillable = [
        'tipo', 
        'descripcion',
        'velocidad', 
        'minutos',
        'gb',
        'precio'
    ];

    /**
     * Obtiene el icono correspondiente al tipo de tarifa
     */
    public function getIconAttribute()
    {
        return match($this->tipo) {
            'fibra' => 'fas fa-wifi',
            'gb' => 'fas fa-mobile-alt',
            'llamadas' => 'fas fa-phone',
            'tv' => 'fas fa-tv',
            default => 'fas fa-tag'
        };
    }

    /**
     * Obtiene el título formateado de la tarifa
     */
    public function getTituloAttribute()
    {
        return match($this->tipo) {
            'fibra' => $this->velocidad . ' Mbps',
            'gb' => $this->gb . ' GB',
            'llamadas' => $this->minutos == -1 ? 'Ilimitadas' : $this->minutos . ' min',
            'tv' => $this->descripcion,
            default => $this->descripcion
        };
    }
}