let gltf = null;
let mixer = null;
let clock = new THREE.Clock();
let controls;
let camera;

init();
animate();

function init() {
    // Render size to match the browser
    width = window.innerWidth;
    height = window.innerHeight;

    // Create new scene
    scene = new THREE.Scene();

    // Lighting setup    
    let ambient = new THREE.AmbientLight(0xffffff);
    scene.add(ambient);
    const light = new THREE.SpotLight(0xFFFFFF, 2, 100, Math.PI / 4, 8);
    light.position.set(10, 25, 45);
    light.castShadow = true;
    scene.add(light);

    // Camera setup
    camera = new THREE.PerspectiveCamera(60, width / height, 0.01, 10000);
    camera.position.set(400, 1000, 800);
    let geometry = new THREE.BoxGeometry(100, 5, 100);
    let material = new THREE.MeshLambertMaterial({

    });

    let manager = new THREE.LoadingManager();
    manager.onProgress = function (item, loaded, total) {
        console.log(item, loaded, total);
    };

    let loader = new THREE.GLTFLoader();
    loader.setCrossOrigin('anonymous');

    // Import our GLTF model (must be hosted on codepen or CDN to load properly in my experience)
    let scale = 20;
    let url = "./gltfImport/jobtrek.glb";

    loader.load(url, function (data) {
        gltf = data;
        let object = gltf.scene;
        object.scale.set(scale, scale, scale);
        object.position.y = 0;
        object.position.x = 0;
        object.position.z = 0;
        object.castShadow = true;
        object.receiveShadow = true;

        let animations = gltf.animations;
        if (animations && animations.length) {
            mixer = new THREE.AnimationMixer(object);

        }
        scene.add(object);
    });

    // Create renderer and include antialiasing to smoothen edges
    renderer = new THREE.WebGLRenderer({ antialias: true });
    renderer.setClearColor(0xD0D3D4);
    renderer.shadowMap.enabled = true;

    // Allow user to orbit around object
    controls = new THREE.OrbitControls(camera, renderer.domElement);
    controls.userPan = false;
    controls.userPanSpeed = 0.0;


    //controls.autoRotate = true;



    renderer.setSize(width, height);
    renderer.gammaOutput = true;
    document.body.appendChild(renderer.domElement);
}

function animate() {
    requestAnimationFrame(animate);
    if (mixer) mixer.update(clock.getDelta());
    controls.update();
    render();
}
// Fire it up!
function render() {
    renderer.render(scene, camera);
}

// Grid de la box
var axes = new THREE.AxisHelper(50);
scene.add(axes);
var gridXZ = new THREE.GridHelper(1000, 40);
scene.add(gridXZ);

// lumières
light = new THREE.DirectionalLight(0xffffff);
light.position.set(1, 1, 1);
scene.add(light);
light = new THREE.DirectionalLight(0x002288);
light.position.set(-1, -1, -1);
scene.add(light);
light = new THREE.AmbientLight(0x222222);
scene.add(light);
scene.background = new THREE.Color(0xffffff);

function onWindowResize() {
    w = window.innerWidth;
    h = window.innerHeight;

    camera.aspect = w / h;
    camera.updateProjectionMatrix();
    renderer.setSize(w, h);
};
window.addEventListener('resize', onWindowResize, false);
