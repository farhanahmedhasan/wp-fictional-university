class OpenStreetMap {
    constructor(mapContainerId) {
        this.mapContainer = document.getElementById(mapContainerId);
        this.map = null; // Leaflet map instance
        this.bounds = []; // To store the bounds of the markers
    }

    init(center = [24,90], zoom = 7) {
        if (!this.mapContainer) {
            console.error(`Map container with ID "${mapContainerId}" not found.`);
            return;
        }

        // Create the map instance
        this.map = L.map(this.mapContainer).setView(center, zoom);

        // Add tile layer (OpenStreetMap)
        L.tileLayer("https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png", {
            attribution: 'DevThree',
        }).addTo(this.map);
    }

    // Add markers from data attributes
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

            // Add marker to the map
            const marker = L.marker([lat, lng]).addTo(this.map);

            // Optionally, bind popup content
            const popupContent = markerDiv.innerText || "Campus Location";
            marker.bindPopup(popupContent);

            // Add the coordinates to the bounds array
            this.bounds.push([lat, lng]);
        });
    }
}

document.addEventListener("DOMContentLoaded", () => {
    const openStreetMap = new OpenStreetMap("acf-map")
    openStreetMap.init();

    // Add markers from the HTML structure
    openStreetMap.addMarkers();
});

export default OpenStreetMap
