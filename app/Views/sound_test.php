<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sound Test</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/wavesurfer.js/5.2.0/wavesurfer.min.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            text-align: center;
            padding: 20px;
        }
        h1 {
            font-size: 32px;
        }
        .container {
            display: flex;
            flex-direction: column;
            align-items: center;
        }
        .earphones {
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 50px;
            margin: 20px 0;
        }
        .earphones img {
            width: 250px;
        }
        .earphones button {
            background-color: #007BFF;
            color: white;
            border: none;
            padding: 10px 20px;
            font-size: 18px;
            font-weight: bold;
            cursor: pointer;
            border-radius: 5px;
        }
        .earphones button:hover {
            background-color: #0056b3;
        }
        .audio-player {
            margin-top: 20px;
            width: 100%;
            max-width: 600px;
        }
        #waveform {
            width: 100%;
            height: 128px;
            background: #f2f2f2;
            margin-top: 20px;
        }
    </style>
</head>
<body>

    <h1>Sound Test</h1>
    
    <div class="container">
        <div class="earphones">
            <button onclick="playLeft()">Left</button>
            <img src="<?= base_url('assets/img/earphones2.jpg'); ?>" alt="Earphones">
            <button onclick="playRight()">Right</button>
        </div>

        <div class="audio-player">
            <button onclick="playBass()">Bass Test</button>
            <button onclick="playSong()">Play Song</button>
            <div id="waveform"></div>
        </div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/wavesurfer.js/5.2.0/wavesurfer.min.js"></script>
    <script>
        const baseUrl = '<?= base_url('assets/sounds/'); ?>';

        const waveSurfer = WaveSurfer.create({
            container: '#waveform',
            waveColor: '#007BFF',
            progressColor: '#0056b3',
            height: 128,
            responsive: true
        });

        function playLeft() {
            playSound('lfr.mp3');
        }

        function playRight() {
            playSound('lfr.mp3');
        }

        function playBass() {
            playSound('bass.mp3');
        }

        function playSong() {
            playSound('testsong.mp3');
        }

        function playSound(fileName) {
            waveSurfer.load(baseUrl + fileName);
            waveSurfer.on('ready', function () {
                waveSurfer.play();
            });
        }
    </script>

</body>
</html>
