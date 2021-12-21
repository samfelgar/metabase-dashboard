<?php

namespace Samfelgar\MetabaseDashboard;

use Illuminate\Contracts\Support\Arrayable;
use Illuminate\View\View;
use Laravel\Nova\Nova;
use Laravel\Nova\Tool;
use Samfelgar\MetabaseDashboard\DataTransferObjects\Dashboard;
use Samfelgar\MetabaseDashboard\Services\Iframe;

class MetabaseDashboard extends Tool implements Arrayable
{
    private string $label = 'Metabase Dashboard';
    private string $title = 'Metabase Dashboard';
    private string $identifier;

    private Dashboard $dashboard;

    public function __construct(string $identifier, Dashboard $dashboard)
    {
        parent::__construct();

        $this->identifier = $identifier;
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
            $this->identifier => $this->toArray(),
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
            'identifier' => $this->identifier,
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
            'url' => $this->iframeUrl(),
        ];
    }

    private function iframeUrl(): string
    {
        $iframe = new Iframe($this->dashboard);

        return $iframe->getUrl();
    }
}
