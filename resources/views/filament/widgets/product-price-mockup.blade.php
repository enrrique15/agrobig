<x-filament-widgets::widget>
    <div style="display: grid; grid-template-columns: repeat(1, minmax(0, 1fr)); gap: 1.5rem;height:100%">
        
        {{-- TARJETA ESTILO IAF BOLIVIA CON CSS EN LÍNEA --}}
        <div style="
            background-color: #064e3b; 
            border-radius: 0.75rem; 
            padding: 1.25rem; 
            box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.1), 0 1px 2px -1px rgba(0, 0, 0, 0.1); 
            color: #ffffff; 
            display: flex; 
            flex-direction: column; 
            justify-content: space-between; 
            min-height: 220px;
            font-family: ui-sans-serif, system-ui, -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
        ">
            
            {{-- Bloque superior: Título, Monto y Porcentaje --}}
            <div>
                <p style="
                    font-size: 0.75rem; 
                    font-weight: 700; 
                    text-transform: uppercase; 
                    letter-spacing: 0.05em; 
                    color: #a7f3d0; 
                    margin: 0;
                ">
                    Último Precio Registrado
                </p>
                
                <div style="
                    margin-top: 1rem; 
                    display: flex; 
                    align-items: baseline; 
                    justify-content: space-between;
                ">
                    <span style="font-size: 2.25rem; font-weight: 800; letter-spacing: -0.025em; line-height: 2.5rem;">
                        450.00 <span style="font-size: 1.25rem; font-weight: 500; color: #a7f3d0;">Bs</span>
                    </span>
                    
                    {{-- Porcentaje en línea --}}
                    <div style="
                        display: flex; 
                        align-items: center; 
                        gap: 0.25rem; 
                        color: #6ee7b7; 
                        font-weight: 700; 
                        font-size: 1.125rem;
                    ">
                        {{-- Icono Flecha Arriba --}}
                        <svg style="width: 1.25rem; height: 1.25rem;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>
                        </svg>
                        <span>+3.5%</span>
                    </div>
                </div>
                
                <p style="font-size: 0.75rem; color: rgba(167, 243, 208, 0.6); margin-top: 0.25rem; margin-bottom: 0;">
                    Variación semanal
                </p>
            </div>

            {{-- Bloque inferior: Caja contenedora de Tendencia General --}}
            <div style="
                margin-top: 1.25rem; 
                background-color: rgba(255, 255, 255, 0.12); 
                border-radius: 0.5rem; 
                padding: 0.75rem; 
                border: 1px solid rgba(255, 255, 255, 0.15); 
                display: flex; 
                align-items: start; 
                gap: 0.75rem;
            ">
                {{-- Círculo con el icono --}}
                <div style="
                    display: flex; 
                    height: 2rem; 
                    width: 2rem; 
                    flex-shrink: 0; 
                    align-items: center; 
                    justify-content: center; 
                    border-radius: 9999px; 
                    background-color: rgba(16, 185, 129, 0.2); 
                    color: #6ee7b7; 
                    border: 1px solid rgba(16, 185, 129, 0.3);
                ">
                    <svg style="width: 1rem; height: 1rem;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>
                    </svg>
                </div>
                
                {{-- Texto descriptivo --}}
                <div style="font-size: 0.75rem; line-height: 1rem;">
                    <p style="font-weight: 700; text-transform: uppercase; tracking-wide: 0.025em; color: #6ee7b7; margin: 0;">
                        TENDENCIA GENERAL: AL ALZA
                    </p>
                    <p style="color: rgba(209, 250, 229, 0.9); margin-top: 0.125rem; margin-bottom: 0; line-height: 1.25rem;">
                        El mercado muestra una tendencia creciente. Recomendamos anticipar compras.
                    </p>
                </div>
            </div>

        </div>

    </div>
</x-filament-widgets::widget>