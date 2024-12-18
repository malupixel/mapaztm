interface Point {
    latitude: number;
    longitude: number;
    number: string;
    line: string;
}

interface TargeoMapOptions {
    container: string;
    z: number;
    c: { y: number; x: number };
    modArguments: Record<string, any>;
}

declare const Targeo: any;

// Globalne zmienne
let Mapa: any;
let PointsOnMap: any[] = [];
let PointsToRemove: any[] = [];

// Inicjalizacja mapy
function TargeoMapInitialize(): void {
    const mapOptions: TargeoMapOptions = {
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
            Layers: { modes: ['map', 'satellite'] },
        },
    };

    Mapa = new Targeo.Map(mapOptions);
    Mapa.initialize();
}

function refreshMap(): void {
    fetch('/ajax.php')
        .then(response => {
            if (!response.ok) {
                throw new Error('Network response was not ok ' + response.statusText);
            }
            PointsToRemove = PointsOnMap;
            PointsOnMap = [];
            return response.json();
        })
        .then((points: Point[]) => {
            points.forEach(point => {
                const mapPoint = new Targeo.MapObject.Point(
                    { y: point.latitude / 1000000, x: point.longitude / 1000000 },
                    {
                        imageUrl: 'https://mapa.targeo.pl/i/icons/pins/pin-r.png',
                        w: 27,
                        h: 28,
                        coordsAnchor: { x: 9, y: 25 },
                        z: {
                            24: { imageUrl: 'https://mapa.targeo.pl/i/icons/pins/pinbig-r.png', w: 38, h: 39, coordsAnchor: { x: 12, y: 36 } },
                        },
                    },
                    point.number, // ID punktu
                    {
                        name: `Linia: ${point.line}, Numer: ${point.number}`,
                        zIndex: parseInt(point.number, 10),
                        draggable: false,
                        balloon: { body: `Linia: ${point.line}, Numer: ${point.number}` },
                    }
                );
                PointsOnMap.push(mapPoint);
            });

            removeAllPoints();
            addPointsToMap();
        })
        .catch(error => console.error('Błąd podczas odświeżania mapy:', error));
}

function addPointsToMap(): void {
    PointsOnMap.forEach(point => {
        Mapa.getObjectManager().add(point);
    });
}

function removeAllPoints(): void {
    PointsToRemove.forEach(point => {
        Mapa.getObjectManager().remove(point.id);
    });
    PointsToRemove = [];
}

window.onload = (): void => {
    TargeoMapInitialize();
    refreshMap();
    setInterval(refreshMap, 15000);
};
