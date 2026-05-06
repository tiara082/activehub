<?php

namespace App\Filament\Pages;

use Filament\Actions\Action;
use Filament\Pages\Dashboard as BaseDashboard;
use Illuminate\Support\Facades\Auth;

class Dashboard extends BaseDashboard
{
    protected function getActions(): array
    {
        return [
            Action::make('logout')
                ->label('Logout')
                ->icon('heroicon-m-arrow-left-on-rectangle')
                ->color('danger')
                ->action(function () {
                    Auth::logout();
                    session()->invalidate();
                    session()->regenerateToken();
                    
                    return redirect()->route('login');
                })
                ->requiresConfirmation(),
        ];
    }
}
