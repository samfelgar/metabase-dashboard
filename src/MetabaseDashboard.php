<?php

namespace Samfelgar\MetabaseDashboard;

use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Laravel\Nova\Menu\MenuItem;
use Laravel\Nova\Menu\MenuSection;
use Laravel\Nova\Nova;
use Laravel\Nova\Tool;
use Samfelgar\MetabaseDashboard\Services\Iframe;

class MetabaseDashboard extends Tool implements Arrayable
{
    private string $label = 'Metabase Dashboard';
    private string $title = 'Metabase Dashboard';

    /** @var Dashboard[] */
    private array $dashboards;

    /**
     * @param Dashboard[] $dashboard
     */
    public function __construct(array $dashboard)
    {
        parent::__construct();

        $this->dashboards = array_filter($dashboard, fn($dash) => $dash->authorizedToSee(request()));
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

        foreach ($this->toArray() as $dashboardInfo) {
            Nova::provideToScript([
                $dashboardInfo['identifier'] => $dashboardInfo
            ]);
        }
    }


    /**
     * Build the menu that renders the navigation links for the tool.
     *
     * @param \Illuminate\Http\Request $request
     * @return mixed
     */
    public function menu(Request $request)
    {
        return MenuSection::make(__('Statistics'), $this->subMenus())
            ->collapsable()
            ->icon('server');
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
        return array_map(function (Dashboard $dashboard) {
            return [
                'label' => $dashboard->getLabel(),
                'title' => $this->title,
                'url' => $this->iframeUrl($dashboard),
                'identifier' => $dashboard->getIdentifier()
            ];
        }, $this->dashboards);
    }

    public function subMenus(): array
    {
        return array_map(function (Dashboard $dashboard) {
            return MenuItem::make($dashboard->getLabel(), $dashboard)
                ->path('/metabase-dashboard/'  . $dashboard->getIdentifier());
        }, $this->dashboards);
    }

    private function iframeUrl(Dashboard $dashboard): string
    {
        $iframe = new Iframe($dashboard);

        return $iframe->getUrl();
    }
}
