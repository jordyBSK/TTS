console.clear();
window.addEventListener('load', function () {
    if (!Detector.webgl) Detector.addGetWebGLMessage();

    var w = window.innerWidth,
        h = window.innerHeight;

    var container, renderer, scene, camera, controls;

    (function init() {
        // renderer
        renderer = new THREE.WebGLRenderer({
            antialias: true
        });
        renderer.setPixelRatio(window.devicePixelRatio);
        renderer.setSize(w, h);
        container = document.getElementById('container');
        container.appendChild(renderer.domElement);
        box
        scene = new THREE.Scene();
        scene.fog = new THREE.FogExp2(0x1E2630, 0.002);
        renderer.setClearColor(scene.fog.color);



        // cam
        camera = new THREE.PerspectiveCamera(60, w / h, 1, 2000);
        camera.position.x = 10;
        camera.position.y = 120;
        camera.position.z = 300;
        camera.lookAt(new THREE.Vector3(0, 0, 0));
        controls = new THREE.OrbitControls(camera, renderer.domElement);

        // Grid de la box
        var axes = new THREE.AxisHelper(50);
        scene.add(axes);
        var gridXZ = new THREE.GridHelper(400, 40);
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


        // box
        camera.position.y = 10;

        var boxGeometry = new THREE.BoxGeometry(20, 20, 20);

        var boxMaterial = new THREE.MeshPhongMaterial({
            color: 'green',
            transparent: true,
            opacity: 0.5,
            shading: THREE.FlatShading
        });
        var box = new THREE.Mesh(boxGeometry, boxMaterial);
        box.position.y = 10;
        var edges = new THREE.EdgesGeometry(boxGeometry);
        var lineMaterial = new THREE.LineBasicMaterial({
            color: 'black',
            linewidth: 2
        });
        var line = new THREE.LineSegments(edges, lineMaterial);
        box.add(line);
        box.up.set(0, 0, 1);
        scene.add(box);



        camera.lookAt(box.position);
        window.addEventListener('resize', onWindowResize, false);


        // box2
        camera.position.y = 10;

        var boxGeometry2 = new THREE.BoxGeometry(20, 20, 20);

        var boxMaterial = new THREE.MeshPhongMaterial({
            color: 'red',
            transparent: true,
            opacity: 0.5,
            shading: THREE.FlatShading
        });
        var box = new THREE.Mesh(boxGeometry2, boxMaterial);
        box.position.y = 10;
        box.position.z = 30;
        var edges = new THREE.EdgesGeometry(boxGeometry2);
        var lineMaterial = new THREE.LineBasicMaterial({
            color: 'black',
            linewidth: 2
        });
        var line = new THREE.LineSegments(edges, lineMaterial);
        box.add(line);
        box.up.set(0, 0, 1);
        scene.add(box);



        camera.lookAt(box.position);
        window.addEventListener('resize', onWindowResize, false);
    })();

    function onWindowResize() {
        w = window.innerWidth;
        h = window.innerHeight;

        camera.aspect = w / h;
        camera.updateProjectionMatrix();
        renderer.setSize(w, h);
    }

    (function animate() {
        requestAnimationFrame(animate);
        renderer.render(scene, camera);



    })(0);
});