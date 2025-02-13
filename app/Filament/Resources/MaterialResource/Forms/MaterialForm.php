<?php

namespace App\Filament\Resources\MaterialResource\Forms;

use Filament\Forms;
use App\Enums\IsActive;
use Filament\Forms\Form;
use App\Enums\ProductType;
use Illuminate\Support\Str;
use Filament\Facades\Filament;
use Illuminate\Validation\Rules\Unique;
use App\Filament\Resources\CategoryResource;
use Filament\Forms\Components\Actions\Action;

class MaterialForm extends Form 
{
    public static function form(Form $form): Form
    {
        return $form
        ->schema([
            Forms\Components\Group::make([
                Forms\Components\Section::make('Información básica')
                ->schema([
                    Forms\Components\TextInput::make('code')
                    ->label('Código')
                    ->extraAlpineAttributes([
                        'oninput' => 'this.value = this.value.toUpperCase()',
                    ])
                    ->extraAttributes([
                        'onkeydown' => "if (event.key === ' ') return false;",
                    ])
                    ->required()
                    ->unique(ignoreRecord: true, modifyRuleUsing: function (Unique $rule) {
                        return $rule->where('company_id', Filament::getTenant()->id)
                            ->where('type', ProductType::Material);
                    }),

                    Forms\Components\ToggleButtons::make('active')
                    ->label('Estado')
                    ->options(IsActive::class)
                    ->default(true)
                    ->inline(),

                    Forms\Components\TextInput::make('name')
                    ->label('Nombre')
                    ->required()
                    ->columnSpanFull(),

                    Forms\Components\Select::make('unit_id')
                    ->label('Unidad base')
                    ->relationship(name: 'unit', titleAttribute: 'name')
                    ->searchable()
                    ->preload()
                    ->optionsLimit(10)
                    ->selectablePlaceholder(false)
                    ->required(),
                ])
                ->columns(),
            ])
            ->columnSpan(2), 

            Forms\Components\Group::make([
                Forms\Components\Section::make('Datos adicionales')
                ->schema([
                    Forms\Components\Select::make('category_id')
                    ->label('Categoría')
                    ->relationship(name: 'category', titleAttribute: 'name')
                    ->native(false)
                    ->searchable()
                    ->preload()
                    ->optionsLimit(10)
                    ->createOptionForm(
                        fn ($form) => CategoryResource::form($form)
                        ->columns(2)
                    )
                    ->createOptionAction(function (Action $action) {
                        $action->mutateFormDataUsing(function ($data) {
                            $data['company_id'] = Filament::getTenant()->id;
                            $data['name'] = Str::title($data['name']);
                    
                            return $data;
                        });
                    }),

                    Forms\Components\Textarea::make('description')
                    ->label('Descripción')
                    ->rows(5)
                    ->columnSpanFull(),
                ]),
            ])
        ])
        ->columns(3);
    }
}
