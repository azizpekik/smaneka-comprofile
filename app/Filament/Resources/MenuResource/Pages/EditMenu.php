<?php

namespace App\Filament\Resources\MenuResource\Pages;

use App\Filament\Resources\MenuResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditMenu extends EditRecord
{
    protected static string $resource = MenuResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make()
                ->visible(fn () => !$this->getRecord()->page_id && !in_array(ltrim($this->getRecord()->url, '/'), config('protected-slugs'))),
        ];
    }

    protected function mutateFormDataBeforeFill(array $data): array
    {
        // If menu URL points to a page, find and set page_id
        if (!empty($data['url']) && $data['url'] !== '#') {
            $slug = ltrim($data['url'], '/');
            $page = \App\Models\Page::where('slug', $slug)->first();
            if ($page) {
                $data['page_id'] = $page->id;
            }
        }
        
        return $data;
    }

    protected function mutateFormDataBeforeSave(array $data): array
    {
        // If page_id is set, ensure URL matches the page slug
        if (!empty($data['page_id'])) {
            $page = \App\Models\Page::find($data['page_id']);
            if ($page) {
                $data['url'] = '/' . $page->slug;
            }
        }
        
        return $data;
    }
}
