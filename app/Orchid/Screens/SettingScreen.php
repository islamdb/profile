<?php

namespace App\Orchid\Screens;

use Orchid\Screen\Screen;

class SettingScreen extends Screen
{
    /**
     * Display header name.
     *
     * @var string
     */
    public $name = 'Setting';

    /**
     * Display header description.
     *
     * @var string|null
     */
    public $description = 'Change system or web setting';

    /**
     * Query data.
     *
     * @return array
     */
    public function query(): array
    {
        return [

        ];
    }

    /**
     * Button commands.
     *
     * @return \Orchid\Screen\Action[]
     */
    public function commandBar(): array
    {
        return [];
    }

    /**
     * Views.
     *
     * @return \Orchid\Screen\Layout[]|string[]
     */
    public function layout(): array
    {
        return [];
    }
}
