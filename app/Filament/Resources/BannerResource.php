<?php

namespace App\Filament\Resources;

use App\Filament\Resources\BannerResource\Pages;
use App\Filament\Resources\BannerResource\RelationManagers;
use App\Models\Banner;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class BannerResource extends Resource
{
    protected static ?string $model = Banner::class;

    protected static ?string $navigationIcon = 'heroicon-o-presentation-chart-bar';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('English Content')
                    ->schema([
                        Forms\Components\TextInput::make('title.en')
                            ->label('Title (EN)')
                            ->required(),
                        Forms\Components\TextInput::make('subtitle.en')
                            ->label('Subtitle (EN)')
                            ->required(),
                        Forms\Components\TextInput::make('cta_text.en')
                            ->label('CTA Text (EN)')
                            ->required(),
                    ])->columnSpan(1),
                Forms\Components\Section::make('Arabic Content')
                    ->schema([
                        Forms\Components\TextInput::make('title.ar')
                            ->label('Title (AR)')
                            ->required(),
                        Forms\Components\TextInput::make('subtitle.ar')
                            ->label('Subtitle (AR)')
                            ->required(),
                        Forms\Components\TextInput::make('cta_text.ar')
                            ->label('CTA Text (AR)')
                            ->required(),
                    ])->columnSpan(1),
                Forms\Components\Section::make('Settings')
                    ->schema([
                        Forms\Components\FileUpload::make('image_url')
                            ->image()
                            ->required(fn (string $context): bool => $context === 'create'),
                        Forms\Components\TextInput::make('link_url'),
                        Forms\Components\Select::make('type')
                            ->options([
                                'hero' => 'Main Hero Slider',
                                'side' => 'Side Banner',
                            ])
                            ->required(),
                        Forms\Components\Toggle::make('is_active')
                            ->default(true)
                            ->required(),
                        Forms\Components\TextInput::make('sort_order')
                            ->numeric()
                            ->default(0)
                            ->required(),
                    ])->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('image_url'),
                Tables\Columns\TextColumn::make('link_url')
                    ->searchable(),
                Tables\Columns\TextColumn::make('type')
                    ->searchable(),
                Tables\Columns\IconColumn::make('is_active')
                    ->boolean(),
                Tables\Columns\TextColumn::make('sort_order')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
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
            'index' => Pages\ListBanners::route('/'),
            'create' => Pages\CreateBanner::route('/create'),
            'edit' => Pages\EditBanner::route('/{record}/edit'),
        ];
    }
}
