// Jungfrau
const jubgfrau = document.getElementById('roomTitle10')
const jubgfrauTl = gsap.timeline();
jubgfrau.addEventListener('click', function () {
    jubgfrauTl.to(camera.position, {
        z: 300,
        x: -40,
        y: 200,
        onUpdate: function () {
            // Pointer la caméra vers le cube
            camera.lookAt(0, 0, 300);
        }
    })
        .to(camera.position, {
            z: 300,
            x: -40,
            y: 20,
            onUpdate: function () {
                // Pointer la caméra vers le cube
                camera.lookAt(0, 300, 300);
            }
        });
});


// Wengen
const wengen = document.getElementById('roomTitle9')
const wengenTl = gsap.timeline();
wengen.addEventListener('click', function () {
    wengenTl.to(camera.position, {
        z: 300,
        x: 100,
        y: 200,
        onUpdate: function () {

            camera.lookAt(cube.position);

        }
    })
    wengenTl.to(camera.position, {
        z: 340,
        x: 120,
        y: 20,
        onUpdate: function () {

            camera.lookAt(cube.position);

        }
    })
});

// Pleiade
const pleiades = document.getElementById('roomTitle1')
const plaiadesTl = gsap.timeline();
pleiades.addEventListener('click', function () {
    plaiadesTl.to(camera.position, {
        z: 300,
        x: 100,
        y: 200,
        onUpdate: function () {

            camera.lookAt(cube.position);

        }
    })
    plaiadesTl.to(camera.position, {
        z: 340,
        x: 120,
        y: 20,
        onUpdate: function () {

            camera.lookAt(cube.position);

        }
    })
});

// Suchet
const suchet = document.getElementById('roomTitle2')
const suchetTL = gsap.timeline();
suchet.addEventListener('click', function () {
    suchetTL.to(camera.position, {
        z: 300,
        x: 100,
        y: 200,
        onUpdate: function () {

            camera.lookAt(cube.position);

        }
    })
    suchetTl.to(camera.position, {
        z: 340,
        x: 120,
        y: 20,
        onUpdate: function () {

            camera.lookAt(cube.position);

        }
    })
});

// Chasseron
const chasseron = document.getElementById('roomTitle3')
const chasseronTL = gsap.timeline();
chasseron.addEventListener('click', function () {
    chasseronTL.to(camera.position, {
        z: 300,
        x: 100,
        y: 200,
        onUpdate: function () {

            camera.lookAt(cube.position);

        }
    })
    chasseronTL.to(camera.position, {
        z: 340,
        x: 120,
        y: 20,
        onUpdate: function () {

            camera.lookAt(cube.position);

        }
    })
});

// Argntine
const argentine = document.getElementById('roomTitle4')
const argentineTL = gsap.timeline();
argentine.addEventListener('click', function () {
    argentineTL.to(camera.position, {
        z: 300,
        x: 100,
        y: 200,
        onUpdate: function () {

            camera.lookAt(cube.position);

        }
    })
    argentineTL.to(camera.position, {
        z: 340,
        x: 120,
        y: 20,
        onUpdate: function () {

            camera.lookAt(cube.position);

        }
    })
});

// Chamossaire
const chamossaire = document.getElementById('roomTitle5')
const chamossaireTL = gsap.timeline();
chamossaire.addEventListener('click', function () {
    chamossaireTL.to(camera.position, {
        z: 300,
        x: 100,
        y: 200,
        onUpdate: function () {

            camera.lookAt(cube.position);

        }
    })
    chamossaireTL.to(camera.position, {
        z: 340,
        x: 120,
        y: 20,
        onUpdate: function () {

            camera.lookAt(cube.position);

        }
    })
});

// Mönch
const monch = document.getElementById('roomTitle6')
const monchTL = gsap.timeline();
monch.addEventListener('click', function () {
    monchTL.to(camera.position, {
        z: 300,
        x: 100,
        y: 200,
        onUpdate: function () {

            camera.lookAt(cube.position);

        }
    })
    monchTL.to(camera.position, {
        z: 340,
        x: 120,
        y: 20,
        onUpdate: function () {

            camera.lookAt(cube.position);

        }
    })
});

// Eiger
const eiger = document.getElementById('roomTitle7')
const eigerTL = gsap.timeline();
eiger.addEventListener('click', function () {
    eigerTL.to(camera.position, {
        z: 300,
        x: 100,
        y: 200,
        onUpdate: function () {

            camera.lookAt(cube.position);

        }
    })
    eigerTL.to(camera.position, {
        z: 340,
        x: 120,
        y: 20,
        onUpdate: function () {

            camera.lookAt(cube.position);

        }
    })
});

// DentDuMidi
const dentDuMidi = document.getElementById('roomTitle8')
const dentDuMidiTL = gsap.timeline();
dentDuMidi.addEventListener('click', function () {
    dentDuMidiTL.to(camera.position, {
        z: 300,
        x: 100,
        y: 200,
        onUpdate: function () {

            camera.lookAt(cube.position);

        }
    })
    dentDuMidiTL.to(camera.position, {
        z: 340,
        x: 120,
        y: 20,
        onUpdate: function () {

            camera.lookAt(cube.position);

        }
    })
});
