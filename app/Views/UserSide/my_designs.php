<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?= base_url('assets/css/UserSide/userPurchase.css') ?>">
    <link rel="stylesheet" href="<?= base_url('assets/css/navbar.css') ?>">
    <link rel="stylesheet" href="<?= base_url('assets/css/UserSide/grid.css') ?>">
    <link rel="stylesheet" href="<?= base_url('assets/css/UserSide/myDesign.css') ?>">
    <link rel="shortcut icon" href="<?= base_url('assets/img/logo.png') ?>" type="image/x-icon">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css"
        integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />

    <title>My Custom Designs</title>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/three.js/r128/three.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/three/examples/js/controls/OrbitControls.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/three/examples/js/loaders/GLTFLoader.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">



    <style>
        .modal {
            display: none;
            position: fixed;
            z-index: 1050;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgba(0, 0, 0, 0.4);
        }

        .modal-dialog {
            margin: 10% auto;
            z-index: 1051;
        }


        .modal-header {
            background-color: #007bff;
            color: white;
            padding: 15px;
            border-bottom: 1px solid #ddd;
        }

        .modal-header .close {
            color: white;
            font-size: 20px;
            border: none;
            background: none;
        }

        .modal-body {
            padding: 20px;
        }

        .modal-body input,
        .modal-body textarea {
            width: 100%;
            padding: 10px;
            margin-top: 5px;
            border: 1px solid #ddd;
            border-radius: 5px;
        }

        .modal-body button {
            width: 100%;
            background-color: #28a745;
            color: white;
            padding: 10px;
            margin-top: 10px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        .modal-body button:hover {
            background-color: #218838;
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
                        <p><strong>Price:</strong> ₱<?= number_format($design['price'], 2) ?></p>

                        <button class="delete-btn" onclick="deleteDesign(<?= $design['id'] ?>)">Delete</button>
                        <button class="checkout-btn" onclick="openCheckoutModal(<?= $design['id'] ?>, <?= $design['price'] ?>)">Checkout</button>

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


                <div id="checkoutModal" class="modal fade" tabindex="-1" role="dialog">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Shipping Details</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <form id="checkoutForm">
                                    <input type="hidden" id="designId" name="design_id">
                                    <input type="hidden" id="designPrice" name="price">

                                    <div class="form-group">
                                        <label for="fullname">Full Name</label>
                                        <input type="text" id="fullname" name="fullname" class="form-control" required>
                                    </div>

                                    <div class="form-group">
                                        <label for="phone">Phone Number</label>
                                        <input type="text" id="phone" name="phone" class="form-control" required>
                                    </div>

                                    <div class="form-group">
                                        <label for="address">Full Address</label>
                                        <textarea id="address" name="address" class="form-control" required></textarea>
                                    </div>

                                    <div class="text-center">
                                        <button type="submit" class="btn btn-success">
                                            <span id="btnText">Proceed to Payment</span>
                                            <span id="loader" class="spinner-border spinner-border-sm d-none"></span>
                                        </button>
                                    </div>

                                </form>
                            </div>
                        </div>
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
                    function openCheckoutModal(designId, price) {
                        document.getElementById('designId').value = designId;
                        document.getElementById('designPrice').value = price;

                        document.getElementById('fullname').value = "<?= session()->get('firstname') . ' ' . session()->get('lastname') ?>";
                        document.getElementById('phone').value = "<?= session()->get('phone_number') ?>";
                        document.getElementById('address').value = "<?= session()->get('address') ?>";

                        $('#checkoutModal').modal('show');
                    }

                    document.getElementById('checkoutForm').addEventListener('submit', function(event) {
                        event.preventDefault();

                        let formData = new FormData(this);

                        let submitButton = document.querySelector("#checkoutForm button[type='submit']");
                        let btnText = submitButton.innerHTML;
                        submitButton.innerHTML = 'Processing... <span class="spinner-border spinner-border-sm"></span>';
                        submitButton.disabled = true;

                        fetch('<?= base_url("customization/checkout") ?>', {
                                method: 'POST',
                                body: formData
                            })
                            .then(response => response.json())
                            .then(data => {
                                if (data.status === 'success') {
                                    window.location.href = data.payment_url;
                                } else {
                                    alert('Payment failed. ' + (data.message || 'Please try again.'));
                                }
                            })
                            .catch(error => {
                                console.error('Error:', error);
                                alert('An error occurred while processing your request.');
                            })
                            .finally(() => {
                                submitButton.innerHTML = btnText;
                                submitButton.disabled = false;
                            });
                    });


                    $(document).ready(function() {
                        $(".checkout-btn").click(function() {
                            let designId = $(this).data("design-id");
                            let price = $(this).data("price");
                            openCheckoutModal(designId, price);
                        });
                    });
                </script>

                <script>
                    function deleteDesign(designId) {
                        if (!confirm("Are you sure you want to delete this design?")) {
                            return;
                        }

                        fetch('<?= base_url("customization/delete") ?>/' + designId, {
                                method: 'DELETE'
                            })
                            .then(response => response.json())
                            .then(data => {
                                if (data.status === 'success') {
                                    alert("Design deleted successfully.");
                                    document.getElementById("canvas-container-" + designId).closest(".design-card").remove();
                                } else {
                                    alert("Failed to delete design: " + data.message);
                                }
                            })
                            .catch(error => {
                                console.error("Error:", error);
                                alert("An error occurred while deleting the design.");
                            });
                    }
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
                                                    const leftTexture = textureLoader.load(`<?= base_url('assets/textures/') . $design['left_texture'] ?>`);
                                                    leftTexture.wrapS = THREE.RepeatWrapping;
                                                    leftTexture.wrapT = THREE.RepeatWrapping;
                                                    child.material.map = leftTexture;
                                                    child.material.needsUpdate = true;
                                                }

                                                if ("<?= $design['right_texture'] ?>" !== "none" && child.name.includes("Right")) {
                                                    const textureLoader = new THREE.TextureLoader();
                                                    const rightTexture = textureLoader.load(`<?= base_url('assets/textures/') . $design['right_texture'] ?>`);
                                                    rightTexture.wrapS = THREE.RepeatWrapping;
                                                    rightTexture.wrapT = THREE.RepeatWrapping;
                                                    child.material.map = rightTexture;
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
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>