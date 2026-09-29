<?php
namespace App\Filament\Admin\Resources\SocialLinkResource\Pages;
use App\Filament\Admin\Resources\SocialLinkResource;
use Filament\Resources\Pages\CreateRecord;
class CreateSocialLink extends CreateRecord { protected static string $resource = SocialLinkResource::class; protected function getRedirectUrl(): string { return $this->getResource()::getUrl('index'); } }
