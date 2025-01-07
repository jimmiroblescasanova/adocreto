<?php

use App\Models\Category;
use Illuminate\Support\Str;
use function Pest\Livewire\livewire;

use App\Filament\Resources\CategoryResource;
use App\Filament\Resources\CategoryResource\Pages\ManageCategories;

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

it('can confirm name is required', function () {
    livewire(ManageCategories::class)
        ->callAction('create', [
            'name' => null,
        ])
        ->assertHasActionErrors(['name' => 'required']);
});

it('uses the default color value when none is provided', function () {
    $name = Str::title(fake()->sentence());

    livewire(ManageCategories::class)
        ->callAction('create', [
            'name' => $name,
        ]);
});

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

it('can edit a category from modal', function () {
    $category = Category::factory()->create();

    livewire(ManageCategories::class, ['record' => $category])
    ->callTableAction('edit', $category->id, [
        'name' => 'New Name',
    ]);

    $this->assertDatabaseHas(Category::class, [
        'name' => 'New Name',
    ]);
});

it('can delete a category from modal', function () {
    $category = Category::factory()->create();

    livewire(ManageCategories::class, ['record' => $category])
        ->callTableAction('delete', $category->id);

    $this->assertDatabaseMissing(Category::class, [
        'id' => $category->id,
    ]);
});