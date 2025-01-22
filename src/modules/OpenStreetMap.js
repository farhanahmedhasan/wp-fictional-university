class OpenStreetMap {
    constructor(mapContainerId) {
        this.mapContainer = document.getElementById(mapContainerId);
        this.map = null;
        this.bounds = [];
    }

    init(center = [24,90], zoom = 7) {
        if (!this.mapContainer) {
            console.error(`Map container with ID "${mapContainerId}" not found.`);
            return;
        }

        this.map = L.map(this.mapContainer).setView(center, zoom);

        L.tileLayer("https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png", {
            attribution: 'DevThree',
        }).addTo(this.map);
    }

    addMarkers() {
        if (!this.map) {
            console.error("Map is not initialized. Call init() first.");
            return;
        }

        const markers = document.querySelectorAll(".marker");

        if (markers.length === 0) {
            console.warn("No markers found.");
            return;
        }

        markers.forEach((markerDiv) => {
            const lat = parseFloat(markerDiv.getAttribute("data-lat"));
            const lng = parseFloat(markerDiv.getAttribute("data-lng"));

            const marker = L.marker([lat, lng]).addTo(this.map);

            const popupContent = markerDiv.innerHTML || "Campus Location";
            marker.bindPopup(popupContent);

            this.bounds.push([lat, lng]);
        });
    }
}

document.addEventListener("DOMContentLoaded", () => {
    if (document.body.classList.contains('page-campuses')){
        const openStreetMap = new OpenStreetMap("acf-map")
        openStreetMap.init();

        openStreetMap.addMarkers();
    }
});

export default OpenStreetMap
