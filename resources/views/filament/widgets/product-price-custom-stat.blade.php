<x-filament-widgets::widget>
    <div style="
        background: linear-gradient(178deg, rgba(6, 78, 59, 1) 0%, rgb(5 125 88) 100%);
        border-radius: 0.75rem; 
        padding: 1.25rem; 
        box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.1), 0 1px 2px -1px rgba(0, 0, 0, 0.1); 
        color: #ffffff; 
        display: flex; 
        flex-direction: column; 
        justify-content: space-between; 
        min-height: 220px;
        height: 100%;
        font-family: ui-sans-serif, system-ui, -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
    ">
        
        {{-- Bloque superior --}}
        <div>
            <p style="font-size: 0.75rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.05em; color: #ffffff; margin: 0;">
                Último Precio Registrado
            </p>
            
            <div style="margin-top: 1rem; display: flex; align-items: baseline; justify-content: space-between;">
                <span style="font-size: 2.25rem; font-weight: 800; letter-spacing: -0.025em; line-height: 2.5rem;">
                    {{ number_format($latestPrice, 2) }} <span style="font-size: 1.25rem; font-weight: 500; color: #a7f3d0;">Bs</span>
                </span>
                
                @if($trend !== 'none')
                    <div style="
                        display: flex; align-items: center; gap: 0.25rem; font-weight: 700; font-size: 1.125rem;
                        color: {{ $trend === 'up' ? '#6ee7b7' : '#fca5a5' }};
                    ">
                        <svg style="width: 1.25rem; height: 1.25rem;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            @if($trend === 'up')
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>
                            @else
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M13 17h8m0 0v-8m0 8l-8-8-4 4-6-6"></path>
                            @endif
                        </svg>
                        <span>{{ $trend === 'up' ? '+' : '-' }}{{ $formattedPercentage }}</span>
                    </div>
                @endif
            </div>
            
            <p style="font-size: 0.75rem; color: rgba(255, 255, 255, 0.877); margin-top: 0.25rem; margin-bottom: 0;">
                Variación según rango de fecha
            </p>
        </div>

        {{-- Caja inferior de Tendencia --}}
        <div style="
            margin-top: 1.25rem; 
            background-color: rgba(255, 255, 255, 0.822); 
            border-radius: 0.5rem; 
            padding: 0.75rem; 
            border: 1px solid rgba(255, 255, 255, 0.15); 
            display: flex; 
            align-items: start; 
            gap: 0.75rem;
        ">
            {{-- Círculo con el icono dinámico --}}
            <div style="
                display: flex; height: 2rem; width: 2rem; flex-shrink: 0; align-items: center; justify-content: center; border-radius: 9999px; 
                background-color: {{ $trend === 'up' ? 'rgba(16, 185, 129, 0.2)' : ($trend === 'down' ? 'rgba(239, 68, 68, 0.2)' : 'rgba(156, 163, 175, 0.2)') }}; 
                color: {{ $trend === 'up' ? '#004b16' : ($trend === 'down' ? '#810000' : '#d1d5db') }}; 
                border: 1px solid {{ $trend === 'up' ? 'rgba(16, 185, 129, 0.3)' : ($trend === 'down' ? 'rgba(239, 68, 68, 0.3)' : 'rgba(156, 163, 175, 0.3)') }};
            ">
                <svg style="width: 1rem; height: 1rem;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    @if($trend === 'up')
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>
                    @elseif($trend === 'down')
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M13 17h8m0 0v-8m0 8l-8-8-4 4-6-6"></path>
                    @else
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 12h14"></path>
                    @endif
                </svg>
            </div>
            
            {{-- Texto descriptivo dinámico --}}
            <div style="font-size: 0.75rem; line-height: 1rem;">
                <p style="font-weight: 700; text-transform: uppercase; letter-spacing: 0.025em; color: {{ $trend === 'up' ? '#004b16' : ($trend === 'down' ? '#810000' : '#d1d5db') }}; margin: 0;">
                    <span style="color: black">TENDENCIA GENERAL:</span> <span>{{ $trendTitle }}</span>
                </p>
                <p style="color: rgba(0, 0, 0, 0.8); margin-top: 0.125rem; margin-bottom: 0; line-height: 1.25rem;">
                    {{ $trendDescription }}
                </p>
            </div>
        </div>

    </div>
</x-filament-widgets::widget>