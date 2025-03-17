@props([
    'center' => [51.5074, -0.1278],
    'zoom' => 14,
    'minZoom' => 2,
    'maxZoom' => 19,
    'markers' => []
])

<div
    x-data="{
        ...leafletMap({
            center: @js($center),
            zoom: {{ $zoom }},
            minZoom: {{ $minZoom }},
            maxZoom: {{ $maxZoom }},
            markers: @js($markers)
        }),
        uuid: $id('map')
    }"
    x-init="init()"
    :id="uuid"
    wire:ignore
    class="h-100 hs-leaflet z-10"
></div>

<script>
    document.addEventListener('alpine:init', () => {
        Alpine.data('leafletMap', (config) => ({
            center: config.center,
            zoom: config.zoom,
            minZoom: config.minZoom,
            maxZoom: config.maxZoom,
            markers: config.markers,
            map: null,

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
                    maxBounds: [
                        [40, -10],
                        [60, 10]
                    ],
                    maxBoundsViscosity: 1.0
                });

                L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
                    maxZoom: this.maxZoom,
                    minZoom: this.minZoom,
                    attribution: '© <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>'
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
        }))
    })
</script>
