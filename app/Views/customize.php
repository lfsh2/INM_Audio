<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- @ICON -->
    <link rel="shortcut icon" href="<?= base_url('assets/img/logo.png') ?>" type="image/x-icon">
    <!-- CSS LINKS -->
    <link rel="stylesheet" href=" <?= base_url('assets/css/navbar.css') ?>">
    <link rel="stylesheet" href=" <?= base_url('assets/css/footer.css') ?>">
    <link rel="stylesheet" href=" <?= base_url('assets/css/customize.css') ?>">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <title>INM Costumization</title>
    <style>
        .size-guide {
            margin-top: 15px;
            text-align: center;
        }

        .size-guide img {
            max-width: 100%;
            max-height: 600px;
            border: 2px solid #ddd;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
    </style>
</head>

<body>

    <?php echo view("includes/header.php"); ?>

    <div class="main-container">
        <div id="canvas-container"></div>

        <div class="customization-panel">
            <div class="controls">
                <div class="control-group">
                    <label for="leftColorPicker">Back IEM Color:</label>
                    <input type="color" id="leftColorPicker" value="#ffffff">
                </div>
                <div class="control-group">
                    <label for="rightColorPicker">Front IEM Color:</label>
                    <input type="color" id="rightColorPicker" value="#ffffff">
                </div>
            </div>

            <div class="controls">
                <div class="control-group">
                    <label for="leftTextureSelect">Back IEM Texture:</label>
                    <select id="leftTextureSelect">
                        <option value="none">None</option>
                        <option value="carbon.jpeg">Carbon Fiber</option>
                        <option value="clouds.jpeg">Clouds</option>
                        <option value="pearls.jpeg">Pearlscent</option>
                        <option value="abstract.jpeg">Abstract No.1</option>
                        <option value="abstract2.jpeg">Abstract No.2</option>
                        <option value="anime1.jpeg">Akatsuki</option>
                        <option value="anime2.jpeg">Piattos</option>
                        <option value="anime3.jpeg">Noobies</option>
                        <option value="anime4.jpeg">Colorstic</option>
                        <option value="anime5.jpeg">Adult Gon</option>
                        <option value="beach.jpeg">Beach</option>
                        <option value="warning.jpeg">Yellow and Black Warning</option>
                        <option value="lol.jpeg">Skulls</option>
                        <option value="lux.jpeg">Luxury</option>
                        <option value="marb.jpeg">Marble Blue</option>
                        <option value="red2.jpeg">Katana</option>
                        <option value="wood.jpeg">Wood</option>
                        <option value="lacks.jpeg">Golden Shower</option>
                        <option value="fuc.jpeg">Dancing Lion</option>
                    </select>
                    <input type="file" id="leftTextureUpload" accept="image/*">
                </div>
                <div class="control-group">
                    <label for="rightTextureSelect">Front IEM Texture:</label>
                    <select id="rightTextureSelect">
                        <option value="none">None</option>
                        <option value="carbon.jpeg">Carbon Fiber</option>
                        <option value="clouds.jpeg">Clouds</option>
                        <option value="pearls.jpeg">Pearlscent</option>
                        <option value="abstract.jpeg">Abstract No.1</option>
                        <option value="abstract2.jpeg">Abstract No.2</option>
                        <option value="anime1.jpeg">Akatsuki</option>
                        <option value="anime2.jpeg">Piattos</option>
                        <option value="anime3.jpeg">Noobies</option>
                        <option value="anime4.jpeg">Colorstic</option>
                        <option value="anime5.jpeg">Adult Gon</option>
                        <option value="beach.jpeg">Beach</option>
                        <option value="warning.jpeg">Yellow and Black Warning</option>
                        <option value="lol.jpeg">Skulls</option>
                        <option value="lux.jpeg">Luxury</option>
                        <option value="p2.jpg">Luxury No.2</option>
                        <option value="marb.jpeg">Marble Blue</option>
                        <option value="red2.jpeg">Katana</option>
                        <option value="wood.jpeg">Wood</option>
                        <option value="lacks.jpeg">Golden Shower</option>
                        <option value="fuc.jpeg">Dancing Lion</option>
                    </select>
                    <input type="file" id="rightTextureUpload" accept="image/*">
                </div>
            </div>

            <div class="controls">
                <div class="control-group">
                    <label for="materialSelect">Material Type:</label>
                    <select id="materialSelect">
                        <option value="glossy">Glossy</option>
                        <option value="matte">Matte</option>
                    </select>
                </div>
            </div>

            <div class="controls">
                <div class="control-group">
                    <label for="sizeSelect">Select Size:</label>
                    <select id="sizeSelect">
                        <option value="none">None</option>
                        <option value="small">Small</option>
                        <option value="medium">Medium</option>
                        <option value="large">Large</option>
                        <option value="xl">XL</option>
                    </select>
                </div>
                <div class="size-guide">
                    <h3>Size Guide</h3>
                    <img src="<?= base_url('assets/img/size_guide.png') ?>" alt="IEM Size Guide" class="img-fluid">
                </div>
            </div>

            <div class="controls">
                <div class="control-group">
                    <label for="userDesignUpload">Upload Design:</label>
                    <input type="file" id="userDesignUpload" accept="image/*">
                </div>
            </div>

            <div class="controls">
                <div class="control-group">
                    <label for="categorySelect">Select Category:</label>
                    <select id="categorySelect">
                        <option value="none">None</option>
                        <option value="vanilla_series">Vanilla Series</option>
                        <option value="stage">Stage Series</option>
                        <option value="prestige">Prestige</option>
                    </select>
                </div>


                <div class="specs-section">
                    <h3>Specifications</h3>
                    <ul id="specsList"></ul>
                </div>
                <div class="sound-test">
                    <audio id="soundTest" controls></audio>
                    <canvas id="visualizer"></canvas>
                </div>
            </div>



            <div class="controls d-flex justify-content-center">
                <button id="saveDesign">Save Design</button>
            </div>
        </div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/three.js/r128/three.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/three/examples/js/loaders/GLTFLoader.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/three/examples/js/controls/OrbitControls.js"></script>
    <script defer src="<?= base_url('assets/js/costumizer.js') ?>"></script>
    <script>
        const categorySelect = document.getElementById("categorySelect");
        const soundTest = document.getElementById("soundTest");
        const canvas = document.getElementById("visualizer");
        const specsList = document.getElementById("specsList");
        const ctx = canvas.getContext("2d");

        const audioContext = new(window.AudioContext || window.webkitAudioContext)();
        const analyser = audioContext.createAnalyser();
        const source = audioContext.createMediaElementSource(soundTest);
        source.connect(analyser);
        analyser.connect(audioContext.destination);

        analyser.fftSize = 256;
        const bufferLength = analyser.frequencyBinCount;
        const dataArray = new Uint8Array(bufferLength);

        const specsData = {
            vanilla_series: [
                "Driver Type: Balanced Armature",
                "Cable Type: 3.5mm Silver-Plated Copper",
                "Frequency Range: 20Hz - 20kHz"
            ],
            stage: [
                "Driver Type: Dynamic Driver",
                "Cable Type: Detachable 2-pin",
                "Frequency Range: 15Hz - 30kHz"
            ],
            prestige: [
                "Driver Type: Tribid Premium Design",
                "Cable Type: Gold-Plated 2.5mm",
                "Frequency Range: 20Hz – 40kHz"
            ]
        };

        function drawVisualizer() {
            requestAnimationFrame(drawVisualizer);

            analyser.getByteFrequencyData(dataArray);

            ctx.clearRect(0, 0, canvas.width, canvas.height);

            const barWidth = (canvas.width / bufferLength) * 2.5;
            let x = 0;

            for (let i = 0; i < bufferLength; i++) {
                const barHeight = dataArray[i] / 2;

                ctx.fillStyle = `rgb(${barHeight + 100}, 50, 150)`;
                ctx.fillRect(x, canvas.height - barHeight, barWidth, barHeight);

                x += barWidth + 1;
            }
        }

        categorySelect.addEventListener("change", function() {
            const selectedCategory = categorySelect.value;
            let audioSrc = "";

            switch (selectedCategory) {
                case "vanilla_series":
                    audioSrc = "assets/sounds/vanilla.mp3";
                    break;
                case "stage":
                    audioSrc = "assets/sounds/stage.mp3";
                    break;
                case "prestige":
                    audioSrc = "assets/sounds/prestige.mp3";
                    break;
            }

            soundTest.src = audioSrc;
            soundTest.play();

            if (audioContext.state === "suspended") {
                audioContext.resume();
            }

            drawVisualizer();

            specsList.innerHTML = "";
            specsData[selectedCategory].forEach((spec) => {
                const li = document.createElement("li");
                li.textContent = spec;
                specsList.appendChild(li);
            });
        });
    </script>
    <script>
    document.getElementById("saveDesign").addEventListener("click", function () {
    fetch("/check-login")
        .then(response => response.json())
        .then(data => {
            if (!data.isLoggedIn) {
                alert("You must log in to save your customization.");
                window.location.href = "/login"; 
                return;
            }

            renderer.render(scene, camera);

            const imageDataURL = renderer.domElement.toDataURL("image/png");
            const formData = new FormData();

            fetch(imageDataURL)
                .then(res => res.blob())
                .then(blob => {
                    formData.append("captured_image", blob, "custom_design.png");

                    formData.append("category", document.getElementById("categorySelect").value);
                    formData.append("left_color", document.getElementById("leftColorPicker").value);
                    formData.append("right_color", document.getElementById("rightColorPicker").value);
                    formData.append("left_texture", document.getElementById("leftTextureSelect").value);
                    formData.append("right_texture", document.getElementById("rightTextureSelect").value);
                    formData.append("material", document.getElementById("materialSelect").value);
                    formData.append("size", document.getElementById("sizeSelect").value);

                    const uploadedDesign = document.getElementById("userDesignUpload").files[0];
                    if (uploadedDesign) {
                        formData.append("uploaded_image", uploadedDesign);
                    }

                    fetch("/save-customization", {
                        method: "POST",
                        body: formData,
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.status === "success") {
                            alert("Customization saved successfully!");
                            window.location.href = "/my-designs";
                        } else {
                            alert("Error: " + data.message);
                        }
                    })
                    .catch(error => console.error("Error:", error));
                });
        });
});

    </script>
</body>

</html>