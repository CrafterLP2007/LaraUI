<?php

namespace CrafterLP2007\LaraUi\Builder\Chart;

class ChartBuilder
{
    protected array $config = [];

    protected array $seriesData = [];

    protected array $allLabels = [];

    protected bool $isDark = false;

    protected bool $showToolbar = false;

    protected bool $enableZoom = false;

    protected ?string $xAxisTitle = null;

    protected ?string $yAxisTitle = null;

    public static function make(): static
    {
        return new static;
    }

    public function setXAxisTitle(string $title): static
    {
        $this->xAxisTitle = $title;

        return $this;
    }

    public function setYAxisTitle(string $title): static
    {
        $this->yAxisTitle = $title;

        return $this;
    }

    public function dark(bool $isDark = true): static
    {
        $this->isDark = $isDark;

        if ($isDark) {
            $this->config['tooltip'] = [
                'theme' => 'dark',
                'style' => [
                    'background' => '#1f2937',
                ],
            ];
        }

        return $this;
    }

    public function height(int $height): static
    {
        $this->config['chart']['height'] = $height;

        return $this;
    }

    public function type(string $type): static
    {
        $this->config['chart']['type'] = $type;

        return $this;
    }

    public function addSeries(SeriesBuilder $series): static
    {
        $seriesData = $series->getSeries();
        $labels = $series->getLabels();

        if (! empty($labels)) {
            $this->allLabels = array_unique(array_merge($this->allLabels, $labels));
            $data = [];
            foreach ($this->allLabels as $label) {
                $index = array_search($label, $labels);
                $data[] = $index !== false ? $seriesData['data'][$index] : null;
            }
            $seriesData['data'] = $data;
        }

        // Get the series color
        $color = $seriesData['color'] ?? null;

        // Set gradient for this series if color exists
        if ($color) {
            $seriesData['fill'] = [
                'type' => 'gradient',
                'gradient' => [
                    'type' => 'vertical',
                    'shadeIntensity' => 0,
                    'gradientToColors' => ['#000000'],
                    'inverseColors' => false,
                    'opacityFrom' => $this->isDark ? 0.15 : 0.5,
                    'opacityTo' => $this->isDark ? 0 : 0.3,
                    'stops' => [0, 100],
                ],
            ];

            if (! isset($this->config['colors'])) {
                $this->config['colors'] = [];
            }
            $this->config['colors'][] = $color;
        }

        $this->seriesData[] = $seriesData;
        $this->config['xaxis']['categories'] = $this->allLabels;

        return $this;
    }

    public function setGradient(array $colorStops): static
    {
        $this->config['fill'] = [
            'type' => 'gradient',
            'gradient' => [
                'type' => 'vertical',
                'shadeIntensity' => 1,
                'opacityFrom' => 0.5,
                'opacityTo' => 0.3,
                'stops' => [0, 90, 100],
                'colorStops' => $colorStops,
            ],
        ];

        return $this;
    }

    public function setColors(array $colors): static
    {
        $this->config['colors'] = $colors;

        return $this;
    }

    public function showToolbar(bool $show = true): static
    {
        $this->showToolbar = $show;

        return $this;
    }

    public function enableZoom(bool $enable = true): static
    {
        $this->enableZoom = $enable;

        return $this;
    }

    public function build(): array
    {
        // Start with default config
        $config = $this->getDefaultConfig();

        // Merge user config
        $config = array_replace_recursive($config, $this->config);

        // Ensure toolbar and zoom settings are correct
        $config['chart']['toolbar']['show'] = $this->showToolbar;
        $config['chart']['zoom']['enabled'] = $this->enableZoom;

        // Add series data
        $config['series'] = $this->seriesData;

        return $config;
    }

    protected function getDefaultConfig(): array
    {
        $labelColor = $this->isDark ? '#d1d5db' : '#6b7280';

        return [
            'chart' => [
                'toolbar' => [
                    'show' => $this->showToolbar,
                ],
                'zoom' => [
                    'enabled' => $this->enableZoom,
                ],
            ],
            'legend' => ['show' => false],
            'dataLabels' => ['enabled' => false],
            'stroke' => [
                'curve' => 'straight',
                'width' => 2,
            ],
            'grid' => [
                'strokeDashArray' => 2,
                'borderColor' => $this->isDark ? '#374151' : '#e5e7eb',
            ],
            'xaxis' => [
                'type' => 'category',
                'tickPlacement' => 'on',
                'axisBorder' => ['show' => false],
                'axisTicks' => ['show' => false],
                'title' => [
                    'text' => $this->xAxisTitle,
                    'style' => [
                        'color' => $labelColor,
                        'fontSize' => '14px',
                        'fontFamily' => 'Inter, ui-sans-serif',
                        'fontWeight' => 500,
                    ],
                ],
                'labels' => [
                    'style' => [
                        'colors' => $labelColor,
                        'fontSize' => '13px',
                        'fontFamily' => 'Inter, ui-sans-serif',
                        'fontWeight' => 400,
                    ],
                ],
            ],
            'yaxis' => [
                'title' => [
                    'text' => $this->yAxisTitle,
                    'style' => [
                        'color' => $labelColor,
                        'fontSize' => '14px',
                        'fontFamily' => 'Inter, ui-sans-serif',
                        'fontWeight' => 500,
                    ],
                ],
                'labels' => [
                    'align' => 'left',
                    'minWidth' => 0,
                    'maxWidth' => 140,
                    'style' => [
                        'colors' => $labelColor,
                        'fontSize' => '13px',
                        'fontFamily' => 'Inter, ui-sans-serif',
                        'fontWeight' => 400,
                    ],
                ],
            ],
        ];
    }
}
