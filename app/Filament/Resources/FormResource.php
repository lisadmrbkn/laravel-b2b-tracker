<?php

namespace App\Filament\Resources;

use App\Filament\Resources\FormResource\Pages;
//use App\Filament\Resources\FormResource\RelationManagers;
use App\InputType;
use App\Models\Form as FormModel;
use Filament\Forms;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\TagsInput;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class FormResource extends Resource
{
    protected static ?string $model = FormModel::class;

    protected static ?string $navigationIcon = 'heroicon-o-document-chart-bar';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Create a Form')->schema([
                    TextInput::make('title')->columnSpanFull()->required(),
                    Repeater::make('members')
                        ->relationship('questions')
                        ->columns()
                        ->schema([
                            TextInput::make('label')->required(),
                            Forms\Components\Select::make('input_type')
                                ->options(InputType::class)
                                ->live()
                                ->required(),
                            TagsInput::make('properties')
                                ->columnSpanFull()
                                ->visible(fn(Forms\Get $get) => $get('input_type') === 'select'),
                        ])
                        ->orderColumn('sort')
                        ->defaultItems(3),
                ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('title'),
                TextColumn::make('user.name'),
                TextColumn::make('created_at')->dateTime(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListForms::route('/'),
            'create' => Pages\CreateForm::route('/create'),
            'edit' => Pages\EditForm::route('/{record}/edit'),
        ];
    }
}
