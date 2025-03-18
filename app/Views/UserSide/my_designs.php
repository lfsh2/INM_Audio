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
      crossorigin="anonymous" referrerpolicy="no-referrer"/>

<title>My Custom Designs</title>

<script src="https://cdnjs.cloudflare.com/ajax/libs/three.js/r128/three.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/three/examples/js/controls/OrbitControls.js"></script>
<script src="https://cdn.jsdelivr.net/npm/three/examples/js/loaders/GLTFLoader.js"></script>

<style>
    .design-container {
        display: flex;
        flex-wrap: wrap;
        gap: 20px;
    }

    .design-card {
        display: flex;
        width: 100%;
        background: #fff;
        border: 2px solid #ddd;
        border-radius: 12px;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
        overflow: hidden;
        transition: transform 0.3s ease;
    }

    .design-card:hover {
        transform: scale(1.03);
    }

    .canvas-container {
        width: 60%;
        height: 400px;
        background: #f0f0f0;
        border-right: 2px solid #ddd;
    }

    .design-details {
        width: 40%;
        padding: 20px;
        display: flex;
        flex-direction: column;
        justify-content: center;
        gap: 10px;
    }

    .design-details h3 {
        margin-top: 0;
        font-weight: bold;
    }

    .design-details p {
        margin: 0;
        font-size: 1rem;
        color: #555;
    }

    .spec-label {
        font-weight: bold;
        color: #222;
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
                <!-- 3D Model Canvas (Left Side) -->
                <div id="canvas-container-<?= $design['id'] ?>" class="canvas-container"></div>

                <!-- Design Details (Right Side) -->
                <div class="design-details">
                    <h3>Design #<?= $design['id'] ?></h3>
                    <p><span class="spec-label">Material:</span> <?= ucfirst($design['material']) ?></p>
                    <p><span class="spec-label">Size:</span> <?= ucfirst($design['size']) ?></p>
                    <p><span class="spec-label">Category:</span> <?= ucfirst($design['category']) ?></p>
                </div>
            </div>

            <!-- 3D Model Rendering Script -->
            <script>
                document.addEventListener("DOMContentLoaded", function () {
                    const container = document.getElementById("canvas-container-<?= $design['id'] ?>");

                    const scene = new THREE.Scene();
                    const camera = new THREE.PerspectiveCamera(45, container.clientWidth / container.clientHeight, 0.1, 1000);
                    const renderer = new THREE.WebGLRenderer({ antialias: true, alpha: true });

                    renderer.setSize(container.clientWidth, container.clientHeight);
                    renderer.setClearColor(0xe0e0e0); 
                    container.appendChild(renderer.domElement);

                    const controls = new THREE.OrbitControls(camera, renderer.domElement);
                    controls.enableDamping = true;
                    controls.dampingFactor = 0.1;
                    controls.minDistance = 1;
                    controls.maxDistance = 5;

                    // Lighting for improved visuals
                    const ambientLight = new THREE.AmbientLight(0xffffff, 1.5);
                    scene.add(ambientLight);

                    const directionalLight = new THREE.DirectionalLight(0xffffff, 3);
                    directionalLight.position.set(3, 3, 5);
                    scene.add(directionalLight);

                    const backLight = new THREE.DirectionalLight(0xffffff, 1.5);
                    backLight.position.set(-3, -3, -5);
                    scene.add(backLight);

                    const loader = new THREE.GLTFLoader();
                    loader.load("<?= base_url('assets/models/iem2.glb') ?>", function (gltf) {
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

                                const textureLoader = new THREE.TextureLoader();
                                if ("<?= $design['left_texture'] ?>" !== "none") {
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
                });
            </script>
        <?php endforeach; ?>
    </div>
<?php else: ?>
    <p>No custom designs found.</p>
<?php endif; ?>
</body>
</html>
