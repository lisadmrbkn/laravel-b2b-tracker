<?php

namespace App;

use Filament\Support\Contracts\HasLabel;

enum InputType: string implements HasLabel
{
    case TEXT = 'text';
    case TEXTAREA = 'textarea';
    case SELECT = 'select';
    case FILE = 'file';

    public function getLabel(): ?string
    {
        return match ($this) {
            self::TEXT => 'Text',
            self::TEXTAREA => 'Textarea',
            self::SELECT => 'Select',
            self::FILE => 'File',
        };
    }
}
