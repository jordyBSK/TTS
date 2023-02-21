


// script pour json : 

const positions = [
    {
        roomName: "lausanne.pleiades@jobtrek.ch",
        position: { x: -20, y: 100, z: -20 }
    },
    {
        roomName: "lausanne.suchet@jobtrek.ch",
        position: { x: 20, y: 1000, z: 10 }
    },
    {
        roomName: "lausanne.chasseron@jobtrek.ch",
        position: { x: 20, y: 1000, z: 10 }
    },
    {
        roomName: "lausanne.argentine@jobtrek.ch",
        position: { x: 20, y: 1000, z: 10 }
    },
    {
        roomName: "lausanne.chamossaire@jobtrek.ch",
        position: { x: 20, y: 1000, z: 10 }
    },
    {
        roomName: "lausanne.monch@jobtrek.ch",
        position: { x: 20, y: 1000, z: 10 }
    },
    {
        roomName: "lausanne.eiger@jobtrek.ch",
        position: { x: 20, y: 1000, z: 10 }
    },
    {
        roomName: "lausanne.dent-du-midi@jobtrek.ch",
        position: { x: 20, y: 1000, z: 10 }
    },

    {
        roomName: "lausanne.wengen@jobtrek.ch",
        position: { x: 20, y: 1000, z: 10 }
    },

    {
        roomName: "lausanne.jungfrau@jobtrek.ch",
        position: { x: 20, y: 1000, z: 10 }
    }
]

// Récupération des données via une requête HTTP GET
fetch('/schedules.json')
    .then(response => response.json())
    .then(salles => {
        // Création de la liste
        console.log(salles)
        for (let salle of positions) {

            console.log(salle)

            let room = salles.find(s => {
                return s.roomName === salle.roomName
            })

            addLight(salle.position, room.availability)

        }
    });



function addLight(position, disponibilité) {

    let couleur = disponibilité === "Available" ? 'green' : 'red'

    let spotLight = new THREE.SpotLight(couleur, 300);

    spotLight.position.set(position.x, position.y, position.z);

    spotLight.angle = Math.PI / 2;
    spotLight.penumbra = 0.5;
    spotLight.decay = 2;
    spotLight.distance = 100;

    scene.add(spotLight);
    currentSpotLight = spotLight;


    const lightHelper = new THREE.SpotLightHelper(spotLight);
    scene.add(lightHelper);
}


    // Créer toute les lumières avec leur position
    // stocker chaque limière dans un tableau


    // boucler sur les lumières et changer leur coueleur en fonction du room.json