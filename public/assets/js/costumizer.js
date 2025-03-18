let renderer;


document.addEventListener("DOMContentLoaded", function () {
    const container = document.getElementById("canvas-container");

    const leftColorPicker = document.getElementById("leftColorPicker");
    const rightColorPicker = document.getElementById("rightColorPicker");
    const leftTextureUpload = document.getElementById("leftTextureUpload");
    const rightTextureUpload = document.getElementById("rightTextureUpload");
    const userDesignUpload = document.getElementById("userDesignUpload");
    const materialSelect = document.getElementById("materialSelect");
    const leftTextureSelect = document.getElementById("leftTextureSelect");
    const rightTextureSelect = document.getElementById("rightTextureSelect");

    const scene = new THREE.Scene();
    const camera = new THREE.PerspectiveCamera(45, container.clientWidth / container.clientHeight, 0.1, 1000);
    const renderer = new THREE.WebGLRenderer({ antialias: true, alpha: true });
    renderer.setSize(container.clientWidth, container.clientHeight);
    container.appendChild(renderer.domElement);

    const controls = new THREE.OrbitControls(camera, renderer.domElement);
    controls.enableDamping = true;
    controls.dampingFactor = 0.05;
    controls.maxDistance = 5;
    controls.minDistance = 1;

    const ambientLight = new THREE.AmbientLight(0xffffff, 1.5);
    scene.add(ambientLight);

    const directionalLight = new THREE.DirectionalLight(0xffffff, 3);
    directionalLight.position.set(3, 3, 5);
    scene.add(directionalLight);

    const backLight = new THREE.DirectionalLight(0xffffff, 1.5);
    backLight.position.set(-3, -3, -5);
    scene.add(backLight);

    const loader = new THREE.GLTFLoader();
    let iemModel, leftIEM, rightIEM;

    const loadingText = document.createElement("p");
    loadingText.innerText = "Loading IEM Model...";
    container.appendChild(loadingText);

    loader.load("assets/models/iem2.glb", function (gltf) {
        container.removeChild(loadingText);

        iemModel = gltf.scene;

        iemModel.traverse((child) => {
            if (child.isMesh) {
                child.material = new THREE.MeshStandardMaterial({
                    color: 0xffffff,
                    metalness: 0.8,
                    roughness: 0.2,
                });

                if (!leftIEM) {
                    leftIEM = child;
                } else {
                    rightIEM = child;
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
        camera.position.set(0, 0, 2.5); 
        camera.lookAt(0, 0, 0);
        animate();

        if (materialSelect) {
            materialSelect.value = "glossy";
        }
    }, undefined, function (error) {
        console.error("Error loading model:", error);
        loadingText.innerText = "Error loading model!";
    });

    leftColorPicker.addEventListener("input", () => {
        if (leftIEM) leftIEM.material.color.set(leftColorPicker.value);
    });

    rightColorPicker.addEventListener("input", () => {
        if (rightIEM) rightIEM.material.color.set(rightColorPicker.value);
    });

    
    function applyTextureFromFolder(textureName, object) {
        if (textureName !== "none" && object) {
            const texture = new THREE.TextureLoader().load(`assets/textures/${textureName}`);
            texture.wrapS = THREE.RepeatWrapping;
            texture.wrapT = THREE.RepeatWrapping;
            object.material.map = texture;
            object.material.needsUpdate = true;
        } else if (object) {
            object.material.map = null;
            object.material.needsUpdate = true;
        }
    }

    leftTextureSelect.addEventListener("change", () => {
        applyTextureFromFolder(leftTextureSelect.value, leftIEM);
        leftTextureUpload.value = "";
    });

    rightTextureSelect.addEventListener("change", () => {
        applyTextureFromFolder(rightTextureSelect.value, rightIEM);
        rightTextureUpload.value = "";
    });

    function applyUploadedTexture(event, object) {
        const file = event.target.files[0];
        if (file && object) {
            const reader = new FileReader();
            reader.onload = function (e) {
                const texture = new THREE.TextureLoader().load(e.target.result);
                texture.wrapS = THREE.RepeatWrapping;
                texture.wrapT = THREE.RepeatWrapping;
                object.material.map = texture;
                object.material.needsUpdate = true;
            };
            reader.readAsDataURL(file);
        }
    }

    leftTextureUpload.addEventListener("change", (event) => {
        applyUploadedTexture(event, leftIEM);
        leftTextureSelect.value = "none";
    });

    rightTextureUpload.addEventListener("change", (event) => {
        applyUploadedTexture(event, rightIEM);
        rightTextureSelect.value = "none";
    });

   
    userDesignUpload.addEventListener("change", function (event) {
        const file = event.target.files[0];
        if (file && rightIEM) {
            const reader = new FileReader();
            reader.onload = function (e) {
                const texture = new THREE.TextureLoader().load(e.target.result);
                texture.wrapS = THREE.RepeatWrapping;
                texture.wrapT = THREE.RepeatWrapping;
                texture.repeat.set(1, 1);

                rightIEM.material.map = texture;
                rightIEM.material.needsUpdate = true;
            };
            reader.readAsDataURL(file);
        }
    });

   
    materialSelect.addEventListener("change", function () {
        if (leftIEM && rightIEM) {
            const type = materialSelect.value;
            const roughness = type === "matte" ? 0.8 : 0.2;
            const metalness = type === "glossy" ? 0.8 : 0.2;

            leftIEM.material.roughness = roughness;
            leftIEM.material.metalness = metalness;
            rightIEM.material.roughness = roughness;
            rightIEM.material.metalness = metalness;
        }
    });

    
    function animate() {
        requestAnimationFrame(animate);
        controls.update();
        renderer.render(scene, camera);
    }

 
    window.addEventListener("resize", () => {
        camera.aspect = container.clientWidth / container.clientHeight;
        camera.updateProjectionMatrix();
        renderer.setSize(container.clientWidth, container.clientHeight);

        if (iemModel) {
            const newBox = new THREE.Box3().setFromObject(iemModel);
            const newCenter = newBox.getCenter(new THREE.Vector3());
            iemModel.position.sub(newCenter);
        }
    });
});
