<?php

namespace App\Filament\Resources\MenuResource\Pages;

use App\Filament\Resources\MenuResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateMenu extends CreateRecord
{
    protected static string $resource = MenuResource::class;

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
