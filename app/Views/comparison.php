<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gear Library Comparison</title>
    <link rel="shortcut icon" href="<?= base_url('assets/img/logo.png') ?>" type="image/x-icon">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA==" crossorigin="anonymous" referrerpolicy="no-referrer"/>
    <link rel="stylesheet" href="<?= base_url('assets/css/comparison.css') ?>">
    <link rel="stylesheet" href="<?= base_url('assets/css/navbar.css') ?>">
    <link rel="stylesheet" href="<?= base_url('assets/css/footer.css') ?>">
    <style>
        .modal {
            display: none;
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%) scale(0.8);
            width: 80%;
            max-width: 90%;
            background-color: #ffffff;
            border: none;
            border-radius: 15px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.3);
            opacity: 0;
            transition: transform 0.3s ease, opacity 0.3s ease;
            z-index: 10;
        }

        .modal.show {
            display: block;
            transform: translate(-50%, -50%) scale(1);
            opacity: 1;
        }

        #iemList {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 15px;
            padding: 20px;
            max-height: 60vh;
            overflow-y: auto;
        }

        .iem-item {
            padding: 10px;
            background-color: #f7f7f7;
            border: 2px solid #ddd;
            border-radius: 15px;
            text-align: center;
            display: flex;
            justify-content: space-between;
            flex-direction: column;
            cursor: pointer;
            transition: transform 0.3s ease;
        }

        .iem-item img {
            width: 100%;
            height: 60%;
            border-top-left-radius: 12px;
            border-top-right-radius: 12px;
            object-fit: cover;
        }

        /* IEM Details */
        .iem-item p {
            margin: 10px 0 5px;
            font-weight: bold;
            color: #333;
        }

        /* Sticky Select Button */
        .iem-item .select-btn {
            background-color: #4CAF50;
            color: #fff;
            border: none;
            padding: 6px 12px;
            width: 100%;
            border-bottom-left-radius: 15px;
            border-bottom-right-radius: 15px;
            cursor: pointer;
            position: absolute;
            bottom: 0;
            left: 0;
            transition: background 0.3s ease, box-shadow 0.3s ease;
        }

        .iem-item .select-btn:hover {
            background-color: #45a049;
            box-shadow: 0 0 15px #4CAF50;
        }

        button.select-gear {
            background-color: #0078FF;
            color: #fff;
            border: none;
            padding: 12px 24px;
            border-radius: 30px;
            cursor: pointer;
            transition: background 0.3s ease, transform 0.2s ease;
        }

        button.select-gear:hover {
            background-color: #005ecb;
            transform: scale(1.08);
        }

        .category-selection {
            display: flex;
            gap: 20px;
            justify-content: center;
            margin-top: 20px;
        }

        .alert-success {
            background-color: #4CAF50;
            color: #fff;
            padding: 10px;
            text-align: center;
            border-radius: 5px;
            margin-bottom: 15px;
        }

        .actions {
            margin  : 20px;
            text-align: center;
            position: sticky;
            bottom: 20px;
            z-index: 9;
        }

        .clear-btn {
            background-color: #ff4d4d;
            color: #fff;
            padding: 12px 30px;
            border: none;
            border-radius: 30px;
            text-decoration: none;
            text-transform: uppercase;
            font-weight: bold;
            letter-spacing: 1px;
            cursor: pointer;
            box-shadow: 0 4px 10px rgba(255, 77, 77, 0.5);
            transition: background 0.3s ease, transform 0.2s ease;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            width: 90%;
            max-width: 400px;
        }

        .clear-btn:hover {
            background-color: #e63c3c;
            transform: scale(1.05);
            box-shadow: 0 6px 15px rgba(255, 77, 77, 0.7);
        }

        .clear-btn::before {
            content: '🗑️';
            font-size: 18px;
        }

        .gear-specs {
            width: 100%;
            display: flex;
            flex-direction: column;
            gap: 20px;
            box-sizing: border-box; 
        }

        .specs-section {
            width: 100%;
        }

        .specs-section h3 {
            width: 100%;
            padding: 10px;
            color: black;
            text-align: center;
        }
        
        .specs-section li, .specs-section .li {
            width: 100%;
            list-style: none;
            padding: 10px;
            background: #fafafa;
            margin: 5px 0;
            text-align: left;
        }

        .specs-section li::before {
            content: '✔️';
            color: #4CAF50;
            margin-right: 8px;
        }

        .specs-section p {
            width: 100%;
            padding: 10px;
            background: #fff;
            border: 1px solid #ddd;
            text-align: center;
        }

        .sound-test {
            margin-top: 20px;
            padding: 15px;
            background: #fafafa;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }

        .sound-test audio {
            width: 100%;
            margin-bottom: 10px;
            border-radius: 20px;
        }

        .sound-test canvas {
            width: 100%;
            height: 100px;
            background: #000;
            border-radius: 8px;
        }

    </style>
</head>

<body>
    <?php echo view(name: "includes/header.php"); ?>

    <?php if (session()->getFlashdata('success')): ?>
        <div class="alert-success">
            <?= session()->getFlashdata('success') ?>
        </div>
    <?php endif; ?>


    <div class="comparison-table">
        <div class="title">
            <h1>Comparison Table</h1>
        </div>

        <div class="category-selection">
            <label for="category">Select Category:</label>
            <select id="category">
                <option value="">-- Choose Category --</option>
                <option value="Vanilla Series">Vanilla Series</option>
                <option value="Stage Series">Stage Series</option>
                <option value="Prestige Series">Prestige Series</option>
                <option value="Personalized Series">Personalized Series</option>
            </select>
        </div>

        <div id="iemModal" class="modal">
            <div class="modal-content">
                <div class="modal-fix">
                    <h2>Select IEM</h2>
                    <span class="close-btn" onclick="closeModal()">&times;</span>
                </div>
                <div id="iemList"></div>
            </div>
        </div>

        <div class="earphone-container">
            <div class="left earphone">
                <button onclick="showModal('left')">Select Left Gear</button>
                <div id="leftGearContainer">
                    <p>No product selected for comparison.</p>
                </div>
                <div id="leftGearSpecs" class="gear-specs"></div>
            </div>

            <div class="right earphone">
                <button onclick="showModal('right')">Select Right Gear</button>
                <div id="rightGearContainer">
                    <p>No product selected for comparison.</p>
                </div>
                <div id="rightGearSpecs" class="gear-specs"></div>
            </div>
        </div>


        <div class="actions">
            <a href="<?= base_url('clearComparison') ?>" class="clear-btn">Clear Comparison</a>
        </div>
    </div>

    <script>
        let selectedSide = '';

        function showModal(side) {
    selectedSide = side;
    const category = document.getElementById('category').value;

    if (!category) {
        alert('Please select a category first.');
        return;
    }

    fetch(`<?= base_url('library/getIemsByCategory/') ?>${encodeURIComponent(category)}`)
        .then(response => response.json())
        .then(data => {
            const iemList = document.getElementById('iemList');
            iemList.innerHTML = '';

            if (data.length === 0) {
                iemList.innerHTML = '<p>No items found in this category.</p>';
            } else {
                data.forEach(iem => {
                    const item = document.createElement('div');
                    item.classList.add('iem-item');
                    item.innerHTML = `
                        <img src="${iem.image_url}" alt="${iem.product_name}" />
                        <p>${iem.product_name}</p>
                        <button onclick="selectIEM('${iem.product_id}', '${iem.product_name}', '${iem.image_url}', '${iem.description}', '${iem.price}', '${iem.stock_quantity}', '${category}')">
                            Select
                        </button>
                    `;
                    iemList.appendChild(item);
                });

                const modal = document.getElementById('iemModal');
                modal.style.maxWidth = data.length <= 5 ? '400px' : '90%';
            }
        })
        .catch(error => console.error('Error fetching IEMs:', error));

    const modal = document.getElementById('iemModal');
    modal.classList.add('show');
}



        function closeModal() {
            const modal = document.getElementById('iemModal');
            modal.classList.remove('show');
        }


        function selectIEM(id, name, img, description, price, stock) {
            const gearContainer = document.getElementById(selectedSide + 'GearContainer');
            gearContainer.innerHTML = `
                <div class="img-block">
                    <img src="${img}" alt="${name}">
                    <p>${name}</p>
                </div>
                <div class="info-block">
                    <label for="description">Description</label>
                    <p>${description}</p>
                    <label for="price">Price</label>
                    <p>₱${price}</p>
                    <label for="stock">Stock</label>
                    <p>${stock} pcs available</p>
                </div>
            `;
            closeModal();
        }
    </script>
    <script>
        document.querySelector('.clear-btn').addEventListener('click', function(e) {
    e.preventDefault();

    fetch('<?= base_url('clearComparison') ?>')
        .then(() => {
            document.getElementById('leftGearContainer').innerHTML = '<p>No product selected for comparison.</p>';
            document.getElementById('rightGearContainer').innerHTML = '<p>No product selected for comparison.</p>';
            
            document.getElementById('leftGearSpecs').innerHTML = '';
            document.getElementById('rightGearSpecs').innerHTML = '';
        })
        .catch(error => console.error('Error clearing comparison:', error));
});

    </script>
    <script>
        const gearSpecs = {
            'Vanilla Series': {
                driverConfig: [
                    'Balanced Armature Drivers per side',
                    '1 x Custom 9.2mm LSR Dynamic Driver – Delivers deep, punchy bass with natural warmth.',
                    '1 x Knowles Balanced Armature Driver – Enhances clarity in mids and highs for a smooth, detailed sound.',
                    '2-Way Crossover – Ensures a seamless transition between bass and mids/highs for a well-balanced sound signature.'
                ],
                soundSignature: [
                    'Balanced and natural tuning, suitable for a variety of genres',
                    'Mild bass boost, keeping the low end warm yet controlled',
                    'Clear mids, allowing vocals and instruments to shine',
                    'Smooth highs, preventing harshness for extended listening comfort'
                ],
                frequencyResponse: '20Hz – 18kHz, tuned for a fun yet natural listening experience',
                technicalSpecs: [
                    'Frequency Response: 20Hz – 20kHz',
                    'Sensitivity: 105dB @ 100mV @ 1kHz',
                    'Impedance: 16Ω @ 1kHz'
                ]
            },
            'Stage Series': {
                driverConfig: [
                    '3-Driver Hybrid System',
                    '1 × Custom 9.2mm LSR Dynamic Driver – Produces powerful and controlled bass, ideal for live monitoring.',
                    '1 × Knowles Balanced Armature for Mids – Ensures clear and natural midrange for instruments and vocals.',
                    '1 × Sonion Balanced Armature for Highs – Provides extended treble for a crisp and detailed listening experience.',
                    '3-Way Crossover – Separates lows, mids, and highs efficiently for precision in live performance scenario'
                ],
                soundSignature: [
                    'Enhanced bass for live-stage impact',
                    'Crisp and clear vocals for maximum performance clarity',
                    'Highs tuned to prevent fatigue during long sessions'
                ],
                frequencyResponse: '15Hz – 30kHz, ideal for stage performers and audiophiles',
                technicalSpecs: [
                    'Frequency Response: 15Hz – 30kHz',
                    'Sensitivity: 102dB @ 1kHz',
                    'Impedance: 12Ω @ 1kHz'
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
        },
        'Personalized Series': {
            driverConfig: [
                'Quad Balanced Armature Drivers per side',
                'Low-End Driver – Provides deep, powerful bass for live performances',
                'Mid-High Driver – Ensures crystal-clear vocals and instruments',
                '3-Way Crossover System – Delivers precision frequency balance'
            ],
            soundSignature: [
                'Enhanced bass for live-stage impact',
                'Crisp and clear vocals for maximum performance clarity',
                'Highs tuned to prevent fatigue during long sessions'
            ],
            frequencyResponse: '15Hz – 30kHz, ideal for stage performers and audiophiles',
            technicalSpecs: [
                'Frequency Response: 15Hz – 30kHz',
                'Sensitivity: 110dB @ 1kHz',
                'Impedance: 32Ω @ 1kHz'
            ]
        }
        };

        function selectIEM(id, name, img, description, price, stock, category) {
            const gearContainer = document.getElementById(selectedSide + 'GearContainer');
            const gearSpecsContainer = document.getElementById(selectedSide + 'GearSpecs');
            const specs = gearSpecs[category] || {};

            const driverConfig = specs.driverConfig ? specs.driverConfig.map(item => `<li>${item}</li>`).join('') : '<li>N/A</li>';
            const soundSignature = specs.soundSignature ? specs.soundSignature.map(item => `<li>${item}</li>`).join('') : '<li>N/A</li>';
            const technicalSpecs = specs.technicalSpecs ? specs.technicalSpecs.map(item => `<li>${item}</li>`).join('') : '<li>N/A</li>';

            gearContainer.innerHTML = `
                <div class="img-block">
                    <img src="${img}" alt="${name}">
                    <p>${name}</p>
                </div>
                <div class="info-block">
                    <label for="description">Description</label>
                    <p>${description}</p>
                    <label for="price">Price</label>
                    <p>₱${price}</p>
                    <label for="stock">Stock</label>
                    <p>${stock} pcs available</p>
                </div>
            `;

            gearSpecsContainer.innerHTML = `
                <div class="specs-section">
                    <h3>Driver Configuration:</h3>
                    <ul>${driverConfig}</ul>

                    <h3>Sound Signature:</h3>
                    <ul>${soundSignature}</ul>

                    <h3>Frequency Response:</h3>
                    <p class="li">${specs.frequencyResponse || 'N/A'}</p>

                    <h3>Technical Specifications:</h3>
                    <ul>${technicalSpecs}</ul>
                    
                    <h3>Sound Test:</h3>
                    <div class="sound-test">
                        <audio id="${selectedSide}SoundTest" controls class="w-100"></audio>
                        <canvas id="${selectedSide}Visualizer" width="300" height="100"></canvas>
                    </div>
                </div>
            `;

            // Initialize audio after adding elements to DOM
            setTimeout(() => {
                updateAudioSource(selectedSide, category);
                initializeAudioVisualizer(selectedSide);
            }, 100);

            closeModal();
        }

        let audioContexts = {};
        let analysers = {};

        function updateAudioSource(side, category) {
            const soundTest = document.getElementById(`${side}SoundTest`);
            let audioSrc = "";

            switch (category) {
                case "Vanilla Series":
                    audioSrc = "assets/sounds/vanilla.mp3";
                    break;
                case "Stage Series":
                    audioSrc = "assets/sounds/stage.mp3";
                    break;
                case "Prestige Series":
                    audioSrc = "assets/sounds/prestige.mp3";
                    break;
                case "Personalized Series":
                    audioSrc = "assets/sounds/personalized.mp3";
                    break;
            }

            soundTest.src = "<?= base_url() ?>/" + audioSrc;
        }

        function initializeAudioVisualizer(side) {
            const soundTest = document.getElementById(`${side}SoundTest`);
            const canvas = document.getElementById(`${side}Visualizer`);
            
            if (!canvas || !soundTest) return;
            
            if (audioContexts[side]) {
                audioContexts[side].close();
                delete audioContexts[side];
                delete analysers[side];
            }
            
            const ctx = canvas.getContext("2d");
            
            audioContexts[side] = new (window.AudioContext || window.webkitAudioContext)();
            const analyser = audioContexts[side].createAnalyser();
            const source = audioContexts[side].createMediaElementSource(soundTest);
            source.connect(analyser);
            analyser.connect(audioContexts[side].destination);
            
            analyser.fftSize = 256;
            analysers[side] = analyser;

            function drawVisualizer() {
                if (!analysers[side]) return;
                
                requestAnimationFrame(() => drawVisualizer());
                
                const bufferLength = analysers[side].frequencyBinCount;
                const dataArray = new Uint8Array(bufferLength);
                analysers[side].getByteFrequencyData(dataArray);
                
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
            
            soundTest.addEventListener('play', () => {
                if (audioContexts[side].state === "suspended") {
                    audioContexts[side].resume();
                }
                drawVisualizer();
            });
        }

        document.querySelector('.clear-btn').addEventListener('click', function(e) {
            e.preventDefault();

            Object.keys(audioContexts).forEach(side => {
                if (audioContexts[side]) {
                    audioContexts[side].close();
                    delete audioContexts[side];
                    delete analysers[side];
                }
            });

            fetch('<?= base_url('clearComparison') ?>')
                .then(() => {
                    document.getElementById('leftGearContainer').innerHTML = '<p>No product selected for comparison.</p>';
                    document.getElementById('rightGearContainer').innerHTML = '<p>No product selected for comparison.</p>';
                    
                    document.getElementById('leftGearSpecs').innerHTML = '';
                    document.getElementById('rightGearSpecs').innerHTML = '';
                })
                .catch(error => console.error('Error clearing comparison:', error));
        });
    </script>
</body>
</html>