<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?= base_url('assets/css/UserSide/userPurchase.css') ?>">
    <link rel="stylesheet" href="<?= base_url('assets/css/navbar.css') ?>">
    <link rel="stylesheet" href="<?= base_url('assets/css/UserSide/grid.css') ?>">
    <link rel="shortcut icon" href="<?= base_url('assets/img/logo.png') ?>" type="image/x-icon">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css"
        integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />

    <title>My Custom Designs</title>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/three.js/r128/three.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/three/examples/js/controls/OrbitControls.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/three/examples/js/loaders/GLTFLoader.js"></script>

    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f8f9fa;
            margin: 0;
            padding: 0;
        }

        h1 {
            text-align: center;
            font-size: 2rem;
            margin-top: 20px;
            color: #333;
        }

        .design-container {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            gap: 20px;
            padding: 20px;
        }

        .design-card {
            display: flex;
            flex-wrap: wrap;
            width: 90%;
            max-width: 900px;
            background: #ffffff;
            border-radius: 12px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.15);
            overflow: hidden;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .design-card:hover {
            transform: scale(1.02);
            box-shadow: 0 6px 20px rgba(0, 0, 0, 0.2);
        }

        .canvas-container {
            flex: 1;
            min-width: 50%;
            height: auto;
            background: #f0f0f0;
            border-right: 2px solid #ddd;
            display: flex;
            align-items: center;
            justify-content: center;
        }


        .design-details {
            flex: 1;
            padding: 20px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            gap: 8px;
        }

        .design-details h3 {
            margin: 0;
            font-size: 1.3rem;
            font-weight: bold;
            color: #222;
        }

        .design-details p {
            margin: 4px 0;
            font-size: 1rem;
            color: #555;
        }

        .spec-label {
            font-weight: bold;
            color: #222;
        }

        .spec-list {
            margin: 0;
            padding-left: 20px;
            list-style-type: disc;
            font-size: 0.95rem;
            color: #444;
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .design-card {
                flex-direction: column;
                align-items: center;
            }

            .canvas-container {
                width: 100%;
                height: 300px;
                border-right: none;
            }

            .design-details {
                width: 100%;
                text-align: center;
            }
        }
    </style>
</head>

<body>
    <?php echo view("includes/header.php"); ?>

    <h1>My Custom Designs</h1>

    <?php if (!empty($designs)): ?>
        <div class="design-container">
            <?php foreach ($designs as $design): ?>
                <div class="design-card">
                    <div id="canvas-container-<?= $design['id'] ?>" class="canvas-container"></div>

                    <div class="design-details">
                        <!--    <h3>Design #<?= $design['id'] ?></h3> -->
                        <p><span class="spec-label">Design Name:</span> <?= htmlspecialchars($design['design_name'] ?? 'Unnamed Design') ?></p>
                        <p><span class="spec-label">Material:</span> <?= ucfirst($design['material']) ?></p>
                        <p><span class="spec-label">Size:</span> <?= ucfirst($design['size']) ?></p>
                        <p><span class="spec-label">Category:</span> <?= ucfirst($design['category']) ?></p>

                        <h4>Specifications:</h4>
                        <p><span class="spec-label">Driver Configuration:</span></p>
                        <ul id="driverConfig-<?= $design['id'] ?>" class="spec-list"></ul>

                        <p><span class="spec-label">Sound Signature:</span></p>
                        <ul id="soundSignature-<?= $design['id'] ?>" class="spec-list"></ul>

                        <p><span class="spec-label">Frequency Response:</span>
                            <span id="frequencyResponse-<?= $design['id'] ?>"></span>
                        </p>

                        <p><span class="spec-label">Technical Specs:</span></p>
                        <ul id="technicalSpecs-<?= $design['id'] ?>" class="spec-list"></ul>
                    </div>
                </div>

                <script>
                    document.addEventListener("DOMContentLoaded", function() {
                        const gearSpecs = {
                            "Vanilla Series": {
                                driverConfig: [
                                    "Balanced Armature Drivers per side",
                                    "1 x Custom 9.2mm LSR Dynamic Driver – Delivers deep, punchy bass with natural warmth.",
                                    "1 x Knowles Balanced Armature Driver – Enhances clarity in mids and highs for a smooth, detailed sound.",
                                    "2-Way Crossover – Ensures a seamless transition between bass and mids/highs for a well-balanced sound signature."
                                ],
                                soundSignature: [
                                    "Balanced and natural tuning, suitable for a variety of genres",
                                    "Mild bass boost, keeping the low end warm yet controlled",
                                    "Clear mids, allowing vocals and instruments to shine",
                                    "Smooth highs, preventing harshness for extended listening comfort"
                                ],
                                frequencyResponse: "20Hz – 18kHz, tuned for a fun yet natural listening experience",
                                technicalSpecs: [
                                    "Frequency Response: 20Hz – 20kHz",
                                    "Sensitivity: 105dB @ 100mV @ 1kHz",
                                    "Impedance: 16Ω @ 1kHz"
                                ]
                            },
                            "Stage Series": {
                                driverConfig: [
                                    "3-Driver Hybrid System",
                                    "1 × Custom 9.2mm LSR Dynamic Driver – Produces powerful and controlled bass, ideal for live monitoring.",
                                    "1 × Knowles Balanced Armature for Mids – Ensures clear and natural midrange for instruments and vocals.",
                                    "1 × Sonion Balanced Armature for Highs – Provides extended treble for a crisp and detailed listening experience.",
                                    "3-Way Crossover – Separates lows, mids, and highs efficiently for precision in live performance scenarios."
                                ],
                                soundSignature: [
                                    "Enhanced bass for live-stage impact",
                                    "Crisp and clear vocals for maximum performance clarity",
                                    "Highs tuned to prevent fatigue during long sessions"
                                ],
                                frequencyResponse: "15Hz – 30kHz, ideal for stage performers and audiophiles",
                                technicalSpecs: [
                                    "Frequency Response: 15Hz – 30kHz",
                                    "Sensitivity: 102dB @ 1kHz",
                                    "Impedance: 12Ω @ 1kHz"
                                ]
                            },
                            'Prestige Series': {
                                driverConfig: [
                                    '5-Driver Tribrid Design',
                                    '1 x Custom 9.2mm LSR Dynamic Driver – Dedicated for powerful and controlled low frequencies.',
                                    '1 × Knowles ED-30000 Balanced Armature – Enhancing low-mid transitions for natural warmth.',
                                    '1 × Sonion 2300 Balanced Armature – Optimized for smooth and detailed mid-high frequencies.',
                                    '2 × New Generation Sonion Electrostatic Drivers – Delivering exceptional high-frequency extension and airiness.',
                                    '4-Way Crossover – Ensures precise frequency separation for a balanced and immersive sound.'
                                ],
                                soundSignature: [
                                    'Enhanced bass for live-stage impact',
                                    'Crisp and clear vocals for maximum performance clarity',
                                    'Highs tuned to prevent fatigue during long sessions'
                                ],
                                frequencyResponse: '15Hz – 30kHz, ideal for stage performers and audiophiles',
                                technicalSpecs: [
                                    'Frequency Response: 20Hz – 40kHz',
                                    'Sensitivity: 970dB @ 1kHz',
                                    'Impedance: 10Ω @ 1kHz'
                                ]
                            }
                        };

                        function populateSpecs(designId, category) {
                            if (gearSpecs[category]) {
                                const specs = gearSpecs[category];

                                function populateList(elementId, items) {
                                    const element = document.getElementById(elementId);
                                    if (element) {
                                        element.innerHTML = "";
                                        items.forEach(item => {
                                            const li = document.createElement("li");
                                            li.textContent = item;
                                            element.appendChild(li);
                                        });
                                    }
                                }

                                populateList(`driverConfig-${designId}`, specs.driverConfig);
                                populateList(`soundSignature-${designId}`, specs.soundSignature);
                                document.getElementById(`frequencyResponse-${designId}`).textContent = specs.frequencyResponse;
                                populateList(`technicalSpecs-${designId}`, specs.technicalSpecs);
                            }
                        }

                        <?php foreach ($designs as $design): ?>
                            populateSpecs("<?= $design['id'] ?>", "<?= $design['category'] ?>");
                        <?php endforeach; ?>
                    });
                </script>


                <script>
                    document.addEventListener("DOMContentLoaded", function() {
                        <?php foreach ($designs as $design): ?>
                                (function() {
                                    const container = document.getElementById("canvas-container-<?= $design['id'] ?>");

                                    container.innerHTML = "";

                                    const scene = new THREE.Scene();
                                    const camera = new THREE.PerspectiveCamera(45, container.clientWidth / container.clientHeight, 0.1, 1000);
                                    const renderer = new THREE.WebGLRenderer({
                                        antialias: true,
                                        alpha: true
                                    });

                                    renderer.setSize(container.clientWidth, container.clientHeight);
                                    renderer.setPixelRatio(window.devicePixelRatio);
                                    container.appendChild(renderer.domElement);

                                    const controls = new THREE.OrbitControls(camera, renderer.domElement);
                                    controls.enableDamping = true;
                                    controls.dampingFactor = 0.1;
                                    controls.autoRotate = true;
                                    controls.autoRotateSpeed = 2.0;
                                    controls.minDistance = 1;
                                    controls.maxDistance = 5;

                                    const ambientLight = new THREE.AmbientLight(0xffffff, 1.5);
                                    scene.add(ambientLight);

                                    const directionalLight = new THREE.DirectionalLight(0xffffff, 3);
                                    directionalLight.position.set(3, 3, 5);
                                    scene.add(directionalLight);

                                    const loader = new THREE.GLTFLoader();
                                    loader.load("<?= base_url('assets/models/iem2.glb') ?>", function(gltf) {
                                        const iemModel = gltf.scene;

                                        iemModel.traverse((child) => {
                                            if (child.isMesh) {
                                                child.material = new THREE.MeshStandardMaterial({
                                                    color: "<?= $design['left_color'] ?>",
                                                    metalness: "<?= $design['material'] === 'glossy' ? 0.9 : 0.3 ?>",
                                                    roughness: "<?= $design['material'] === 'matte' ? 0.8 : 0.1 ?>",
                                                    emissive: "#222222",
                                                    emissiveIntensity: 0.3,
                                                });

                                                if ("<?= $design['left_texture'] ?>" !== "none") {
                                                    const textureLoader = new THREE.TextureLoader();
                                                    const texture = textureLoader.load(`<?= base_url('assets/textures/') . $design['left_texture'] ?>`);
                                                    texture.wrapS = THREE.RepeatWrapping;
                                                    texture.wrapT = THREE.RepeatWrapping;
                                                    child.material.map = texture;
                                                    child.material.needsUpdate = true;
                                                }
                                            }
                                        });

                                        const box = new THREE.Box3().setFromObject(iemModel);
                                        const center = box.getCenter(new THREE.Vector3());
                                        iemModel.position.sub(center);

                                        const size = box.getSize(new THREE.Vector3()).length();
                                        const scaleFactor = 1.5 / size;
                                        iemModel.scale.set(scaleFactor, scaleFactor, scaleFactor);

                                        scene.add(iemModel);
                                        camera.position.set(0, 0, 3);
                                        camera.lookAt(0, 0, 0);

                                        function animate() {
                                            requestAnimationFrame(animate);
                                            controls.update();
                                            renderer.render(scene, camera);
                                        }
                                        animate();
                                    });

                                    function onWindowResize() {
                                        camera.aspect = container.clientWidth / container.clientHeight;
                                        camera.updateProjectionMatrix();
                                        renderer.setSize(container.clientWidth, container.clientHeight);
                                    }
                                    window.addEventListener("resize", onWindowResize);
                                })();
                        <?php endforeach; ?>
                    });
                </script>


            <?php endforeach; ?>
        </div>
    <?php else: ?>
        <p>No custom designs found.</p>
    <?php endif; ?>
</body>

</html>