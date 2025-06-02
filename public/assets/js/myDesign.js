document.addEventListener("DOMContentLoaded", function() {
    // ==========================
    // 📌 1. Gear Specifications
    // ==========================
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
        "Prestige Series": {
            driverConfig: [
                "5-Driver Tribrid Design",
                "1 x Custom 9.2mm LSR Dynamic Driver – Dedicated for powerful and controlled low frequencies.",
                "1 × Knowles ED-30000 Balanced Armature – Enhancing low-mid transitions for natural warmth.",
                "1 × Sonion 2300 Balanced Armature – Optimized for smooth and detailed mid-high frequencies.",
                "2 × New Generation Sonion Electrostatic Drivers – Delivering exceptional high-frequency extension and airiness.",
                "4-Way Crossover – Ensures precise frequency separation for a balanced and immersive sound."
            ],
            soundSignature: [
                "Enhanced bass for live-stage impact",
                "Crisp and clear vocals for maximum performance clarity",
                "Highs tuned to prevent fatigue during long sessions"
            ],
            frequencyResponse: "20Hz – 40kHz, ideal for stage performers and audiophiles",
            technicalSpecs: [
                "Frequency Response: 20Hz – 40kHz",
                "Sensitivity: 970dB @ 1kHz",
                "Impedance: 10Ω @ 1kHz"
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

    if (window.designsData) {
        window.designsData.forEach(design => {
            populateSpecs(design.id, design.category);
        });
    }

    // ==========================
    // 📌 2. Checkout Modal Handling
    // ==========================
    window.openCheckoutModal = function(designId, price) {
        document.getElementById('designId').value = designId;
        document.getElementById('designPrice').value = price;
        $('#checkoutModal').modal('show');
    };

    document.getElementById('checkoutForm').addEventListener('submit', function(event) {
        event.preventDefault();

        let formData = new FormData(this);

        fetch('/customization/checkout', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.status === 'success') {
                window.location.href = data.payment_url;
            } else {
                alert('Payment initialization failed.');
            }
        })
        .catch(error => console.error('Error:', error));
    });

    // ==========================
    // 📌 3. Shipping Address Modal
    // ==========================
    window.openModal = function() {
        document.getElementById('shippingModal').style.display = 'block';
    };

    window.closeModal = function() {
        document.getElementById('shippingModal').style.display = 'none';
    };

    window.onclick = function(event) {
        let modal = document.getElementById('shippingModal');
        if (event.target == modal) {
            modal.style.display = 'none';
        }
    };

    // ==========================
    // 📌 4. 3D Model Rendering (Three.js)
    // ==========================
    if (window.designsData) {
        window.designsData.forEach(design => {
            const container = document.getElementById(`canvas-container-${design.id}`);
            container.innerHTML = "";

            const scene = new THREE.Scene();
            const camera = new THREE.PerspectiveCamera(45, container.clientWidth / container.clientHeight, 0.1, 1000);
            const renderer = new THREE.WebGLRenderer({ antialias: true, alpha: true });

            renderer.setSize(container.clientWidth, container.clientHeight);
            renderer.setPixelRatio(window.devicePixelRatio);
            container.appendChild(renderer.domElement);

            const controls = new THREE.OrbitControls(camera, renderer.domElement);
            controls.enableDamping = true;
            controls.autoRotate = true;
            controls.autoRotateSpeed = 2.0;

            const light = new THREE.AmbientLight(0xffffff, 1.5);
            scene.add(light);

            const loader = new THREE.GLTFLoader();
            loader.load('/assets/models/iem2.glb', function(gltf) {
                const iemModel = gltf.scene;
                scene.add(iemModel);
                camera.position.set(0, 0, 3);
                animate();
            });

            function animate() {
                requestAnimationFrame(animate);
                controls.update();
                renderer.render(scene, camera);
            }
        });
    }
});
