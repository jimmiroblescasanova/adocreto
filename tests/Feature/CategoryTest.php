<?php

use App\Models\Category;
use App\Filament\Resources\CategoryResource;
use App\Filament\Resources\CategoryResource\Pages\ManageCategories;

use function Pest\Livewire\livewire;

it('can render the category page', function () {
    $this->get(CategoryResource::getUrl('index'))->assertSuccessful();
});

it('has column', function (string $column) {
    livewire(ManageCategories::class)
        ->assertTableColumnExists($column);
})->with(['name', 'color', 'created_at', 'updated_at']);

it('can render column', function (string $column) {
    livewire(ManageCategories::class)
        ->assertCanRenderTableColumn($column);
})->with(['name', 'color', 'created_at', 'updated_at']);

it('can create a category from modal', function () {
    $category = Category::factory()->create();

    livewire(ManageCategories::class)
        ->assertActionExists('create')
        ->callAction('create', $category->toArray());

    $this->assertDatabaseHas(Category::class, [
        'name' => $category->name,
        'color' => $category->color,
        'description' => $category->description,
    ]);
});
