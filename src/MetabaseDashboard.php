<?php

namespace Samfelgar\MetabaseDashboard;

use Illuminate\Contracts\Support\Arrayable;
use Illuminate\View\View;
use Laravel\Nova\Metable;
use Laravel\Nova\Nova;
use Laravel\Nova\Tool;
use Samfelgar\MetabaseDashboard\DataTransferObjects\Dashboard;

class MetabaseDashboard extends Tool implements Arrayable
{
    use Metable;

    private string $label = 'Metabase Dashboard';
    private string $title = 'Metabase Dashboard';

    private Dashboard $dashboard;

    public function __construct(Dashboard $dashboard)
    {
        parent::__construct();

        $this->dashboard = $dashboard;
    }

    /**
     * Perform any tasks that need to happen when the tool is booted.
     *
     * @return void
     */
    public function boot()
    {
        Nova::script('metabase-dashboard', __DIR__ . '/../dist/js/tool.js');
        Nova::style('metabase-dashboard', __DIR__ . '/../dist/css/tool.css');

        Nova::provideToScript([
            'metabaseDashboard' => $this->toArray(),
        ]);
    }

    /**
     * Build the view that renders the navigation links for the tool.
     *
     * @return View
     */
    public function renderNavigation(): View
    {
        return view('metabase-dashboard::navigation', [
            'label' => $this->label,
        ]);
    }

    public function label(string $label): MetabaseDashboard
    {
        $this->label = $label;

        return $this;
    }

    public function title(string $title): MetabaseDashboard
    {
        $this->title = $title;

        return $this;
    }

    public function toArray(): array
    {
        return [
            'label' => $this->label,
            'title' => $this->title,
        ];
    }
}
