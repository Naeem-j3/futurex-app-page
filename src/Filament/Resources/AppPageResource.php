<?php

namespace FutureX\AppPage\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use FutureX\AppPage\Models\AppPage;
use Illuminate\Support\Str;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\FileUpload;
class AppPageResource extends Resource
{
    protected static ?string $model = AppPage::class;

    protected static ?string $navigationIcon = 'heroicon-o-device-phone-mobile';

    protected static ?string $navigationLabel = 'App Pages';

    protected static ?string $navigationGroup = 'FutureX';

    public static function form(Form $form): Form
    {
        return $form->schema([

            // 🔹 Basic Info
            Forms\Components\Section::make('Basic Info')
                ->schema([
                    Forms\Components\TextInput::make('name')
                        ->required()
                        ->live(onBlur: true)
                        ->afterStateUpdated(fn ($state, callable $set) =>
                        $set('slug', Str::slug($state))
                        ),

                    Forms\Components\TextInput::make('slug')
                        ->required()
                        ->unique(ignoreRecord: true)
                        ->helperText('Used in URL'),

                    Forms\Components\FileUpload::make('logo')
                        ->image()
                        ->directory('app-logos'),

                    Forms\Components\Textarea::make('description')
                        ->rows(4),
                ])->columns(2),

            // 🔹 Links
            Forms\Components\Section::make('App Links')
                ->schema([
                    Forms\Components\TextInput::make('google_play_url')
                        ->url(),

                    Forms\Components\TextInput::make('apple_store_url')
                        ->url(),

                    Forms\Components\TextInput::make('direct_download_url')
                        ->url(),

                    Forms\Components\TextInput::make('website_url')
                        ->url(),
                ])->columns(2),

            Forms\Components\Section::make('App Features')
                ->schema([

                    Repeater::make('features')
                        ->relationship()
                        ->schema([

                            Forms\Components\TextInput::make('title')
                                ->label('Feature Title')
                                ->required()
                                ->maxLength(100)
                                ->placeholder('e.g. Fast Performance')
                                ->columnSpan(2),

                            Forms\Components\Textarea::make('description')
                                ->label('Feature Description')
                                ->rows(2)
                                ->placeholder('Short description of this feature...')
                                ->columnSpan(2),

                            Forms\Components\Select::make('icon')
                                ->label('Icon')
                                ->options(self::getIconOptions())
                                ->allowHtml()
                                ->searchable()
                                ->preload()
                                ->placeholder('Select an icon')
                                ->columnSpan(1),

                            Forms\Components\TextInput::make('order')
                                ->label('Display Order')
                                ->numeric()
                                ->default(0)
                                ->columnSpan(1),

                            Forms\Components\Toggle::make('is_active')
                                ->label('Active')
                                ->default(true)
                                ->inline(false)
                                ->columnSpan(2),

                        ])
                        ->columns(2)
                        ->reorderable('order')
                        ->collapsible()
                        ->itemLabel(fn (array $state): ?string =>
                            $state['title'] ?? 'New Feature'
                        )
                        ->addActionLabel('Add Feature'),

                ]),
            // 🔹 Branding
            Forms\Components\Section::make('Branding')
                ->schema([
                    Forms\Components\ColorPicker::make('theme_color')
                        ->default('#2563eb'),

                    Forms\Components\ColorPicker::make('secondary_color')
                        ->default('#111827'),
                ])->columns(2),
            Forms\Components\Section::make('App Screenshots')
                ->schema([

                    Repeater::make('images')
                        ->relationship()
                        ->schema([
                            FileUpload::make('image')
                                ->image()
                                ->required()
                                ->directory('app-screenshots'),

                            Forms\Components\TextInput::make('order')
                                ->numeric()
                                ->default(0),
                        ])
                        ->reorderable()
                        ->collapsible()
                        ->columns(2),

                ]),
            // 🔹 Contact Info
            Forms\Components\Section::make('Contact Info')
                ->schema([
                    Forms\Components\TextInput::make('email')
                        ->email(),

                    Forms\Components\TextInput::make('phone'),

                    Forms\Components\TextInput::make('address'),
                ])->columns(2),

            // 🔹 Settings
            Forms\Components\Section::make('Settings')
                ->schema([
                    Forms\Components\Toggle::make('is_active')
                        ->default(true),
                ]),

        ]);
    }

    public static function table(Table $table): Table
    {
        return $table->columns([

            Tables\Columns\TextColumn::make('name')
                ->searchable(),

            Tables\Columns\IconColumn::make('is_active')
                ->boolean(),

            Tables\Columns\TextColumn::make('created_at')
                ->dateTime(),

        ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])->headerActions([
                Tables\Actions\CreateAction::make()
                    ->label('add App info')
            ]);

    }

    public static function getPages(): array
    {
        return [
            'index' => \FutureX\AppPage\Filament\Resources\AppPageResource\Pages\ListAppPages::route('/'),
            'create' => \FutureX\AppPage\Filament\Resources\AppPageResource\Pages\CreateAppPage::route('/create'),
            'edit' => \FutureX\AppPage\Filament\Resources\AppPageResource\Pages\EditAppPage::route('/{record}/edit'),
        ];
    }
    public static function shouldRegisterNavigation(): bool
    {
        return true;
    }
    public static function canCreate(): bool
    {
        return AppPage::count()==0;
    }
    private static function getIconOptions(): array
    {
        $icons = [

            // 🚀 Core Features
            'bolt' => 'High Performance',
            'rocket-launch' => 'Fast Growth',
            'sparkles' => 'Smart Features',
            'cpu-chip' => 'AI Powered',

            // 🔐 Security
            'shield-check' => 'Security',
            'lock-closed' => 'Privacy',
            'finger-print' => 'Biometric Security',
            'key' => 'Authentication',

            // 📊 Data & Analytics
            'chart-bar' => 'Analytics',
            'presentation-chart-line' => 'Reports',
            'chart-pie' => 'Insights',

            // 📱 Platform
            'device-phone-mobile' => 'Mobile Friendly',
            'device-tablet' => 'Tablet Support',
            'computer-desktop' => 'Desktop Support',

            // ☁️ Cloud & Sync
            'cloud' => 'Cloud Sync',
            'cloud-arrow-up' => 'Backup',
            'arrow-path' => 'Auto Sync',

            // 👥 Users & Social
            'user' => 'User Profile',
            'user-group' => 'Team Collaboration',
            'users' => 'Community',

            // 🔔 Communication
            'bell' => 'Notifications',
            'chat-bubble-left-right' => 'Messaging',
            'envelope' => 'Email Integration',
            'phone' => 'Call Support',

            // 🌍 Global
            'globe-alt' => 'Global Access',
            'language' => 'Multi-language',
            'map-pin' => 'Location Services',

            // 💳 Payments & Business
            'credit-card' => 'Payments',
            'banknotes' => 'Billing',
            'receipt-percent' => 'Discounts',
            'shopping-cart' => 'E-commerce',

            // 🎁 Engagement
            'gift' => 'Rewards',
            'fire' => 'Trending',
            'star' => 'Top Rated',
            'heart' => 'Favorites',

            // ⚙️ System
            'cog-6-tooth' => 'Customization',
            'wrench-screwdriver' => 'Advanced Settings',
            'puzzle-piece' => 'Integrations',
            'code-bracket' => 'API Access',

            // 📁 Files & Media
            'photo' => 'Image Support',
            'video-camera' => 'Video Features',
            'document-text' => 'Documents',
            'folder' => 'File Manager',

            // 🌐 Connectivity
            'wifi' => 'Online Access',
            'signal' => 'Network Strength',
            'arrow-down-tray' => 'Downloads',
            'arrow-up-tray' => 'Uploads',

            // ⏱️ Performance & Time
            'clock' => 'Real-time',
            'calendar-days' => 'Scheduling',
//            'stopwatch' => 'Tracking',

            // 🧠 Productivity
            'check-badge' => 'Verified',
            'clipboard-document-check' => 'Task Management',
            'light-bulb' => 'Ideas & Tips',
        ];

        $result = [];

        foreach ($icons as $slug => $label) {
            $icon = svg('heroicon-o-' . $slug, 'w-4 h-4 inline-block mr-2')->toHtml();
            $result[$slug] = $label . $icon;
        }

        return $result;
    }

}
