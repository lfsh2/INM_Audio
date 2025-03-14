<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gear Library</title>

    <link rel="shortcut icon" href="<?= base_url('assets/img/logo.png') ?>" type="image/x-icon">
    <link rel="stylesheet" href="<?= base_url('assets/css/library.css') ?>">
    <link rel="stylesheet" href="<?= base_url('assets/css/navbar.css') ?>">
    <link rel="stylesheet" href="<?= base_url('assets/css/footer.css') ?>">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">

    <style>
        .modal {
            display: none;
            position: fixed;
            z-index: 1000;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.6);
            justify-content: center;
            align-items: center;
        }

        .modal-content {
            display: flex;
            width: 70%;
            background: #fff;
            border-radius: 12px;
            overflow: hidden;
        }

        .left-gear {
            width: 50%;
            padding: 20px;
            background: #f0f0f0;
            text-align: center;
        }

        .left-gear img {
            width: 100%;
            border-radius: 10px;
            margin-bottom: 10px;
        }

        .left-gear h2 {
            margin: 10px 0 5px;
            font-weight: bold;
        }

        .left-gear p {
            color: #555;
        }

        .right-gear {
            width: 50%;
            padding: 20px;
            background: #fff;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }

        .right-gear .top {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .right-gear .top h2 {
            margin: 0;
            font-weight: bold;
        }

        .close {
            cursor: pointer;
            font-size: 24px;
            color: #ff0000;
        }

        .specifications {
            text-align: left;
            margin-bottom: 15px;
        }

        .specifications h3 {
            font-weight: bold;
            margin-bottom: 5px;
        }

        .specifications p {
            margin: 3px 0;
        }

        .audio-player {
            margin-top: 10px;
        }

        #waveform {
            width: 100%;
            height: 100px;
            background: #f2f2f2;
        }

        .audio-buttons {
            display: flex;
            justify-content: space-evenly;
            margin-top: 10px;
        }

        .audio-buttons button {
            background: #333;
            color: white;
            border: none;
            padding: 8px 20px;
            border-radius: 20px;
            cursor: pointer;
            transition: background 0.3s;
        }

        .audio-buttons button:hover {
            background: #555;
        }

        .audio-buttons .stop-btn {
            background: #FF4C4C;
        }

        .audio-buttons .stop-btn:hover {
            background: #D32F2F;
        }
    </style>
</head>
<body>

    <?php echo view("includes/header.php"); ?>

    <div class="library">
        <div class="library-title">
            <h2>Gear Library</h2>
        </div>

        <div class="bg">
            <div class="category">
                <p><?= esc($category['category']) ?></p>
            </div>

            <div class="card-container">
                <?php if (!empty($gears)) : ?>
                    <?php foreach ($gears as $gear) : ?>
                        <div class="library-card <?= esc($category['category']) ?>" 
                             onclick="openModal(
                                 '<?= esc($gear['product_name']) ?>', 
                                 '<?= esc($gear['description']) ?>', 
                                 '<?= esc($gear['image_url']) ?>', 
                                 '<?= esc($category['category']) ?>')">
                            <img src="<?= esc($gear['image_url']) ?>" alt="<?= esc($gear['product_name']) ?>">
                            <div class="info">
                                <h3><?= esc($gear['product_name']) ?></h3>
                                <p><?= esc($gear['description']) ?></p>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php else : ?>
                    <div class="library-card no">
                        <h3 style="color: red;">No items available in this category.</h3>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <div id="gearModal" class="modal">
    <div class="modal-content">
        <div class="left-gear">
            <img id="gearImage" src="" alt="Gear Image">
            <h2 id="gearTitle"></h2>
            <p id="gearDescription"></p>
        </div>

        <div class="right-gear">
            <div class="top">
                <h2>Specifications</h2>
                <span class="close" onclick="closeModal()">&times;</span>
            </div>

            <div class="specifications" id="gearSpecs"></div>

            <div class="audio-player">
                <h3>Sound Test</h3>
                <div id="waveform"></div>
                <div class="audio-buttons">
                    <button onclick="playBass()">Bass Test</button>
                    <button onclick="playSong()">Play Song</button>
                    <button class="stop-btn" onclick="stopSound()">Stop</button>
                </div>
            </div>
        </div>
    </div>
</div>


    <?php echo view("includes/footer.php"); ?>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/wavesurfer.js/5.2.0/wavesurfer.min.js"></script>

    <script>
    let waveSurfer;

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

    function openModal(title, description, imageUrl, category) {
        document.getElementById('gearTitle').textContent = title;
        document.getElementById('gearDescription').textContent = description;
        document.getElementById('gearImage').src = imageUrl;

        const specs = gearSpecs[category] || {};
        const driverConfig = specs.driverConfig ? specs.driverConfig.map(item => `<li>${item}</li>`).join('') : '<li>N/A</li>';
        const soundSignature = specs.soundSignature ? specs.soundSignature.map(item => `<li>${item}</li>`).join('') : '<li>N/A</li>';
        const technicalSpecs = specs.technicalSpecs ? specs.technicalSpecs.map(item => `<li>${item}</li>`).join('') : '<li>N/A</li>';

        const specsText = `
            <h3>Driver Configuration:</h3>
            <ul>${driverConfig}</ul>
            
            <h3>Sound Signature:</h3>
            <ul>${soundSignature}</ul>
            
            <h3>Frequency Response:</h3>
            <p>${specs.frequencyResponse || 'N/A'}</p>
            
            <h3>Technical Specifications:</h3>
            <ul>${technicalSpecs}</ul>
        `;

        document.getElementById('gearSpecs').innerHTML = specsText;

        document.getElementById('gearModal').style.display = 'flex';

        waveSurfer = WaveSurfer.create({
            container: '#waveform',
            waveColor: '#007BFF',
            progressColor: '#0056b3',
            height: 100,
            responsive: true,
            backend: 'WebAudio'
        });
    }

    function closeModal() {
        document.getElementById('gearModal').style.display = 'none';
        if (waveSurfer) waveSurfer.stop();
    }

    function playSound(fileName) {
        waveSurfer.load('<?= base_url('assets/sounds/') ?>' + fileName);
        waveSurfer.on('ready', () => waveSurfer.play());
    }

    function playBass() { playSound('vanilla.mp3'); }
    function playSong() { playSound('stage.mp3'); }
    function stopSound() { if (waveSurfer) waveSurfer.stop(); }
</script>

</body>
</html>
