<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ProductResource\Pages;
use App\Filament\Resources\ProductResource\RelationManagers;
use App\Models\Product;
use Filament\Forms;
use Filament\Forms\Form;
use App\Enums\ProductTypeEnum;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ProductResource extends Resource
{
    protected static ?string $model = Product::class;

    protected static ?string $navigationIcon = 'heroicon-o-bolt';
    // protected static ?string $navigationLabel = 'Products';
    protected static ?string $navigationGroup = 'Shop';

     //^ THE FORM
    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                //* first group
              forms\Components\Group::make()
              ->schema([
                forms\Components\Section::make()
                ->schema([
                    forms\Components\TextInput::make(name:'name')
                    ->required()
                    ->live()
                    ->unique()
                    ->afterStateUpdated(fn (Forms\Set $set, ?string $state) => $set('slug', Str::slug($state)))
               ,
                    forms\Components\TextInput::make(name:'slug')
                    ->disabled()
                    ->dehydrated()
                    ->required()
                    ->unique()
                 
                    
                    ,
                    Forms\Components\MarkdownEditor::make('description')
                    ->columnSpan('full'),
                
                    ])->columns(columns:2),

                    forms\Components\Group::make()
                    ->schema([
                        forms\Components\Section::make(heading:'pricing& inventory')
                      ->schema([
                          forms\Components\TextInput::make(name:'sku')
                          ->label('SKU(Stock Keeping Unite)')
                          ->unique()
                          ->required()
                          ,
                          forms\Components\TextInput::make(name:'price')
                          ->numeric()
                          ->rules(rules:'regex:/^\d(1,6)(\.\d{0,2})?$/')
                          ->required()
                          ,
                          Forms\Components\TextInput::make(name:'quantity') 
                          ->numeric()
                          ->minValue(0)
                          ->maxValue(1000)
                          ->required()
                          ,
                         
                          Forms\Components\Select::make(name:'type')
                          ->options([
                            'downloadable'=>ProductTypeEnum::DOWNLOADABLE->value,
                            'deliverable'=>ProductTypeEnum::DELIVERABLE->value,
                          ])  ->required()
                      
                      
                          ])->columns(columns:2)
                ])
            ]),

                //* second group
              forms\Components\Group::make()
              ->schema([
                forms\Components\Section::make(heading:'status')
                ->schema([
                    forms\Components\Toggle::make('is_visible')
                    ->label('visability')
                    ->helperText('Enable or desable product visability')
                    ->default(true)
                    ,
                    forms\Components\Toggle::make('is_featured')
                    ->label('Featured')
                    ->helperText('Enable or desable product featured status')
                   
                    ,
                    forms\Components\DatePicker::make('published_at')
                    ->label('availability')
                    ->default(now())
                ]),
                forms\Components\Section::make(heading:'Image')
             

                ->schema([
                    forms\Components\FileUpload::make('image')
                    ->directory('form-attachments')
                    ->preserveFilenames()
                    ->image()
                    ->imageEditor()
                ]) ->collapsible(),
                forms\Components\Section::make(heading:'Association')
                ->schema([
                    forms\Components\Select::make('brand_id')
                 ->relationship(name:'brand',titleAttribute:'name')
                  ])
              ])
            ]);
    }


    //^ THE TABLE
    public static function table(Table $table): Table
    {
        return $table
            ->columns([
              Tables\Columns\ImageColumn::make(name:'image'),
              Tables\Columns\TextColumn::make(name:'name')
              ->searchable()
              ->sortable(),
              Tables\Columns\TextColumn::make(name:'brand.name')
              ->searchable()
              ->sortable()
              ->toggleable(),
              Tables\Columns\BooleanColumn::make('is_visible')
              ->sortable()
              ->toggleable()
              ->label('Visibility') ,
              Tables\Columns\TextColumn::make(name:'price')
              ->searchable()
              ->sortable()
              ->toggleable(),
              Tables\Columns\TextColumn::make(name:'quantity')
              ->sortable()
              ->toggleable(),
              Tables\Columns\TextColumn::make(name:'published_at')
              ->date()
              ->sortable() ,
              Tables\Columns\TextColumn::make(name:'type'),
            ])
            ->filters([
                Tables\Filters\TernaryFilter::make('is_visible')
                ->label('Visibility') 
               ->boolean()
               ->truelabel('Only Visible Products') 
               ->falselabel('Only Hidden Products')
               ->native(false) ,

               Tables\Filters\SelectFilter::make('brand')
               ->relationship('brand','name')
               ,

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
            'index' => Pages\ListProducts::route('/'),
            'create' => Pages\CreateProduct::route('/create'),
            'edit' => Pages\EditProduct::route('/{record}/edit'),
        ];
    }
}
