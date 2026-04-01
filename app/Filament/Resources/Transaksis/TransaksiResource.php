<?php

namespace App\Filament\Resources\Transaksis;

use App\Filament\Resources\Transaksis\Pages\CreateTransaksi;
use App\Filament\Resources\Transaksis\Pages\EditTransaksi;
use App\Filament\Resources\Transaksis\Pages\ListTransaksis;
use App\Filament\Resources\Transaksis\Schemas\TransaksiForm;
use App\Filament\Resources\Transaksis\Tables\TransaksisTable;
use App\Models\Transaksi;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Hidden;
use Filament\Tables\Filters\Filter;
use Filament\Forms\Components\DatePicker;

class TransaksiResource extends Resource
{
    protected static ?string $model = Transaksi::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $recordTitleAttribute = 'transaksi';

    public static function form(Schema $schema): Schema
    {
        return $form->schema([
            Select::make('kendaraan_id')
                ->relationship('kendaraan', 'plat_nomor')
                ->createOptionForm([ // Memungkinkan tambah kendaraan baru langsung 
                    TextInput::make('plat_nomor')->required(),
                    TextInput::make('warna'),
                    TextInput::make('pemilik'),
                ])->required(),
            Select::make('tarif_id')->relationship('tarif', 'jenis_kendaraan')->required(),
            Select::make('area_id')->relationship('area', 'nama_area')->required(),
            
            // Waktu masuk otomatis terisi saat buat transaksi baru
            DateTimePicker::make('waktu_masuk')
                ->default(now())
                ->required(),
            
            // Sembunyikan user_id, isi otomatis dengan ID petugas yang login
            Hidden::make('user_id')->default(auth()->id()),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
        ->filters([
            Filter::make('waktu_masuk')
                ->form([
                    DatePicker::make('dari_tanggal'),
                    DatePicker::make('sampai_tanggal'),
                ])
                ->query(function (Builder $query, array $data): Builder {
                    return $query
                        ->when($data['dari_tanggal'], fn ($q) => $q->whereDate('waktu_masuk', '>=', $data['dari_tanggal']))
                        ->when($data['sampai_tanggal'], fn ($q) => $q->whereDate('waktu_masuk', '<=', $data['sampai_tanggal']));
                })
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
            'index' => ListTransaksis::route('/'),
            'create' => CreateTransaksi::route('/create'),
            'edit' => EditTransaksi::route('/{record}/edit'),
        ];
    }
}
