// Globalne zmienne
var Mapa;
var PointsOnMap = [];
var PointsToRemove = [];
// Inicjalizacja mapy
function TargeoMapInitialize() {
    var mapOptions = {
        container: 'TargeoMapContainer',
        z: 25,
        c: { y: 52.2565055, x: 21.0464574 },
        modArguments: {
            Ribbon: { controls: ['MapMenu', 'FTS', 'FindRoute'] },
            Buildings3D: { disabled: false, on: true },
            POI: { disabled: false, submit: true, correct: true, visible: true },
            FTS: { disabled: false },
            FindRoute: { disabled: false },
            Traffic: { disabled: false, visible: false },
            Layers: { modes: ['map', 'satellite'] }
        }
    };
    Mapa = new Targeo.Map(mapOptions);
    Mapa.initialize();
}
function refreshMap() {
    fetch('/ajax.php')
        .then(function (response) {
        if (!response.ok) {
            throw new Error('Network response was not ok ' + response.statusText);
        }
        PointsToRemove = PointsOnMap;
        PointsOnMap = [];
        return response.json();
    })
        .then(function (points) {
        points.forEach(function (point) {
            var mapPoint = new Targeo.MapObject.Point({ y: point.latitude / 1000000, x: point.longitude / 1000000 }, {
                imageUrl: 'https://mapa.targeo.pl/i/icons/pins/pin-r.png',
                w: 27,
                h: 28,
                coordsAnchor: { x: 9, y: 25 },
                z: {
                    24: { imageUrl: 'https://mapa.targeo.pl/i/icons/pins/pinbig-r.png', w: 38, h: 39, coordsAnchor: { x: 12, y: 36 } }
                }
            }, point.number, // ID punktu
            {
                name: "Linia: ".concat(point.line, ", Numer: ").concat(point.number),
                zIndex: parseInt(point.number, 10),
                draggable: false,
                balloon: { body: "Linia: ".concat(point.line, ", Numer: ").concat(point.number) }
            });
            PointsOnMap.push(mapPoint);
        });
        removeAllPoints();
        addPointsToMap();
    })["catch"](function (error) { return console.error('Błąd podczas odświeżania mapy:', error); });
}
function addPointsToMap() {
    PointsOnMap.forEach(function (point) {
        Mapa.getObjectManager().add(point);
    });
}
function removeAllPoints() {
    PointsToRemove.forEach(function (point) {
        Mapa.getObjectManager().remove(point.id);
    });
    PointsToRemove = [];
}
window.onload = function () {
    TargeoMapInitialize();
    refreshMap();
    setInterval(refreshMap, 15000);
};
