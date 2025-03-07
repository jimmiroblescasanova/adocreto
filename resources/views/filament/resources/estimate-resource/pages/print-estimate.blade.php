<x-filament-panels::page>
    <div style="width: 100%; height: 100vh;">
        <object class="pdf w-full h-full" 
                data="{{ asset($pdfUrl) }}"
                style="width: 100%; height: 100%;">
        </object>
    </div>
</x-filament-panels::page>
