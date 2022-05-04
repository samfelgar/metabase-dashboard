<?php

namespace Samfelgar\MetabaseDashboard;

use Illuminate\Contracts\Support\Arrayable;
use Illuminate\View\View;
use Laravel\Nova\Nova;
use Laravel\Nova\Tool;
use Samfelgar\MetabaseDashboard\Services\Iframe;

class MetabaseDashboard extends Tool implements Arrayable
{
    private string $label = 'Metabase Dashboard';
    private string $title = 'Metabase Dashboard';

    private array $dashboard;

    public function __construct(array $dashboard)
    {
        parent::__construct();

        $this->dashboard = array_filter($dashboard, fn($dash) => $dash->authorizedToSee(request()));
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

        foreach ($this->toArray() as $data){
            Nova::provideToScript([
                $data["identifier"] => $data
            ]);
        }
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
            'dashboards' => $this->dashboard
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
        $data = [];
        foreach ($this->dashboard as $dash){
            $data[] = [
                'label' => $dash->getLabel(),
                'title' => $this->title,
                'url' => $this->iframeUrl($dash),
                'identifier' => $dash->getIdentifier()
            ];
        }
        return $data;
    }

    private function iframeUrl(Dashboard $dashboard): string
    {
        $iframe = new Iframe($dashboard);

        return $iframe->getUrl();
    }
}
