<div class="card border-success mb-3 shadow-sm lineaMovil" data-index="{{ $index }}">
    <div class="card-header bg-success text-white">
        <span class="titulo-linea">Línea móvil #{{ $index + 1 }}</span>
    </div>
    <div class="card-body">
        {{-- Conservar número --}}
        <label>¿Quieres conservar tu número anterior?</label><br>
        <input type="radio" name="lineas[{{ $index }}][conservar]" value="si"> Sí
        <input type="radio" name="lineas[{{ $index }}][conservar]" value="no" checked> No

        <div class="campo-numero" style="display: none;">
            <label>Número anterior:</label>
            <input type="tel" name="lineas[{{ $index }}][numero]" placeholder="Ej: 612345678">
        </div>

        {{-- Gb --}}
        <h4>GB</h4>
        @foreach ($tarifasGb as $tarifa)
        <input type="radio" name="lineas[{{ $index }}][tarifa_gb]" value="{{ $tarifa->id }}" required>
        <label>{{ $tarifa->gb }} GB - {{ $tarifa->descripcion }} - {{ $tarifa->precio }} €/mes</label><br>
        @endforeach

        {{-- Llamadas --}}
        <h4>Llamadas</h4>
        @foreach ($tarifasLlamadas as $tarifa)
        <input type="radio" name="lineas[{{ $index }}][tarifa_llamadas]" value="{{ $tarifa->id }}" required>
        <label> @if ($tarifa->minutos < 0)
                Minutos Ilimitados - {{ $tarifa->descripcion }} - <span class="precio">{{ $tarifa->precio }} €/mes</span>
                @else
                {{ $tarifa->minutos }} Minutos {{ $tarifa->descripcion }} - <span class="precio">{{ $tarifa->precio }} €/mes</span>
                @endif
        </label><br>
        @endforeach

        <button type="button" class="btn btn-danger eliminar-linea mt-2">Eliminar</button>
    </div>
</div>