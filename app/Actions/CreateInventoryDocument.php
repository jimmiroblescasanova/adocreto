<?php 

namespace App\Actions;

use App\Models\Document;
use App\Models\Transfer;
use App\Models\Production;
use App\Enums\DocumentType;
use Illuminate\Support\Str;
use App\Enums\DocumentStatus;
use Lorisleiva\Actions\Concerns\AsAction;

class CreateInventoryDocument
{
    use AsAction;

    /**
     * Generate the title of the document
     * 
     * @param Transfer|Production $source
     * @return string
     */
    private function generateTitle(Transfer|Production $source, DocumentType $type): string
    {
        $modelId = $source->folio ?? $source->id;
        $sourceType = $source instanceof Transfer ? 'traspaso' : 'producción';
        
        return match ($type) {
            DocumentType::InventoryIn => "Entrada de inventario por {$sourceType}. [ID#{$modelId}]",
            DocumentType::InventoryOut => "Salida de inventario por {$sourceType}. [ID#{$modelId}]",
            default => throw new \InvalidArgumentException('Tipo de documento no válido'),
        };
    }

    /**
     * Get the warehouse id
     * 
     * @param Transfer|Production $source
     * @param DocumentType $type
     * @return int
     */
    private function getWarehouseId(Transfer|Production $source, DocumentType $type): int
    {
        if ($source instanceof Production) {
            return $source->warehouse_id;
        }

        return match ($type) {
            DocumentType::InventoryIn => $source->destination_warehouse_id,
            DocumentType::InventoryOut => $source->warehouse_id,
            default => throw new \InvalidArgumentException('Tipo de documento no válido'),
        };
    }

    /**
     * Create the document creation
     * 
     * @param Transfer|Production $source
     * @param DocumentType $type
     * @return Document
     */
    public function handle(Transfer|Production $source, DocumentType $type): Document
    {
        $data = [
            'company_id' => $source->company_id,
            'type' => $type,
            'user_id' => $source->created_by ?? $source->user_id,
            'warehouse_id' => $this->getWarehouseId($source, $type),
            'date' => now(),
            'folio' => Document::getNextFolio($type),
            'title' => $this->generateTitle($source, $type),
            'status' => DocumentStatus::Locked,
            'uuid' => Str::uuid(),
            'external_model' => $source::class,
            'external_id' => $source->id,
        ];
        
        return Document::create($data);
    }
}