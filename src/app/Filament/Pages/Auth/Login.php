<?php

namespace App\Filament\Pages\Auth;

use Filament\Pages\Auth\Login as BaseLogin;
use Filament\Forms\Form;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Component;
use Illuminate\Contracts\Support\Htmlable;

/**
 * Custom Login Page override for Gate Operations landing page.
 */
class Login extends BaseLogin
{
    /**
     * Heading text displayed on the landing login card.
     */
    public function getHeading(): string | Htmlable
    {
        return 'Gate Operations Portal';
    }

    /**
     * Subheading text under the login title.
     */
    public function getSubheading(): string | Htmlable | null
    {
        return 'Sign in with your security credentials to access gate entry/exit management.';
    }

    /**
     * Customize form inputs if needed (uses email and password by default).
     */
    protected function getForms(): array
    {
        return [
            'form' => $this->form(
                $this->makeForm()
                    ->schema([
                        $this->getEmailFormComponent(),
                        $this->getPasswordFormComponent(),
                        $this->getRememberFormComponent(),
                    ])
                    ->statePath('data'),
            ),
        ];
    }
}