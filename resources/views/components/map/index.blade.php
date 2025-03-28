@props([
    'center' => [],
    'zoom' => 14,
    'minZoom' => 2,
    'maxZoom' => 19,
    'markers' => [],
    'map' => 'https://tile.openstreetmap.org/{z}/{x}/{y}.png',
    'attributions' => '© <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>',
])

@checkPluginInstalled('Map')

<div
    x-data="{
        center: @js($center),
        zoom: {{ $zoom }},
        minZoom: {{ $minZoom }},
        maxZoom: {{ $maxZoom }},
        markers: @js($markers),
        map: null,
        uuid: $id('map'),

        init() {
            this.$nextTick(() => {
                this.initMap();

                this.$watch('markers', () => {
                    this.updateMarkers();
                });
            });
        },

        initMap() {
            if (this.map) return;

            this.map = L.map(this.uuid, {
                center: this.center,
                zoom: this.zoom,
                maxBoundsViscosity: 1.0
            });

            L.tileLayer(@js($map), {
                maxZoom: this.maxZoom,
                minZoom: this.minZoom,
                attribution: @js($attributions)
            }).addTo(this.map);

            this.addMarkers();
        },

        updateMarkers() {
            if (!this.map) return;
            this.map.eachLayer((layer) => {
                if (layer instanceof L.Marker) {
                    layer.remove();
                }
            });
            this.addMarkers();
        },

        addMarkers() {
            if (!Array.isArray(this.markers) || this.markers.length === 0) {
                return;
            }

            this.markers.forEach(marker => {
                if (!marker.position) return;

                const m = L.marker(marker.position);
                if (marker.popup) {
                    m.bindPopup(marker.popup);
                }
                m.addTo(this.map);
            });
        },

        destroy() {
            if (this.map) {
                this.map.remove();
                this.map = null;
            }
        }
    }"
    x-init="init()"
    :id="uuid"
    class="h-100 hs-leaflet z-10"
></div>
