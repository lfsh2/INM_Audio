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
    <!-- <link rel="stylesheet" href=" <?= base_url('assets/css/customize.css') ?>"> -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.13/cropper.min.css" integrity="sha512-6l5Qw6Qn6Qn5Qw6Qn6Qn5Qw6Qn6Qn5Qw6Qn6Qn5Qw6Qn6Qn5Qw6Qn6Qn5Qw6Qn6Qn5Qw6Qn6Qn5Qw6Qn6Qn5Qw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <title>INM Costumization</title>
    <style>
 body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #121212;
            color: #e0e0e0;
            margin: 0;
            padding: 0;
        }
        
        .main-container {
            display: flex;
            flex-direction: row;
            height: 100vh;
            width: 100%;
            overflow: hidden;
        }
        
        .earphone-container {
            flex: 1.5;
            background-color: #1e1e1e;
            position: relative;
            overflow: hidden;
        }
        
        #canvas-container {
            height: 100%;
            width: 100%;
            background-color: #121212;
            position: relative;
        }
        
        .model-controls {
            position: absolute;
            bottom: 20px;
            left: 0;
            right: 0;
            text-align: center;
            color: rgba(255, 255, 255, 0.7);
            font-size: 14px;
            pointer-events: none;
        }
        
        .customization-panel {
            flex: 1;
            max-width: 400px;
            background-color: #1e1e1e;
            padding: 0;
            overflow-y: auto;
            border-left: 1px solid #333;
        }
        
        .navigation-buttons {
            display: flex;
            justify-content: space-between;
            padding: 10px;
            border-bottom: 1px solid #333;
        }
        
        .nav-button {
            background-color: #2d2d2d;
            color: white;
            border: none;
            border-radius: 4px;
            padding: 10px 20px;
            font-size: 16px;
            cursor: pointer;
            transition: background-color 0.2s;
            width: 48%;
        }
        
        .nav-button:hover {
            background-color: #3d3d3d;
        }
        
        .color-grid {
            display: grid;
            grid-template-columns: repeat(7, 1fr);
            gap: 8px;
            padding: 15px;
        }
        
        .color-option {
            width: 100%;
            aspect-ratio: 1/1;
            border-radius: 4px;
            cursor: pointer;
            transition: transform 0.2s;
            border: 2px solid transparent;
        }
        
        .color-option:hover {
            transform: scale(1.1);
        }
        
        .color-option.selected {
            border: 2px solid #fff;
            transform: scale(1.1);
        }
        
        .section-header {
            padding: 15px;
            font-weight: 500;
            display: flex;
            align-items: center;
            cursor: pointer;
            border-bottom: 1px solid #333;
        }
        
        .section-header .icon {
            margin-right: 10px;
            transition: transform 0.3s;
        }
        
        .section-header.collapsed .icon {
            transform: rotate(-90deg);
        }
        
        .section-content {
            padding: 0 15px;
            max-height: 0;
            overflow: hidden;
            transition: max-height 0.3s ease-out;
        }
        
        .section-content.expanded {
            max-height: 1000px;
            padding: 15px;
            border-bottom: 1px solid #333;
        }
        
        .texture-option {
            background-size: cover;
            background-position: center;
            position: relative;
        }
        
        .texture-option::after {
            content: attr(data-name);
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            background: rgba(0, 0, 0, 0.7);
            color: white;
            font-size: 10px;
            padding: 2px;
            text-align: center;
            opacity: 0;
            transition: opacity 0.2s;
        }
        
        .texture-option:hover::after {
            opacity: 1;
        }
        
        .control-slider {
            width: 100%;
            margin: 10px 0;
        }
        
        .control-slider label {
            display: flex;
            justify-content: space-between;
            margin-bottom: 5px;
        }
        
        .control-slider input[type="range"] {
            width: 100%;
            background: #333;
            height: 5px;
            border-radius: 5px;
            -webkit-appearance: none;
            appearance: none;
        }
        
        .control-slider input[type="range"]::-webkit-slider-thumb {
            -webkit-appearance: none;
            width: 15px;
            height: 15px;
            border-radius: 50%;
            background: #007bff;
            cursor: pointer;
        }
        
        .material-options {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
            margin-top: 10px;
        }
        
        .material-option {
            background-color: #2d2d2d;
            color: white;
            border: none;
            border-radius: 4px;
            padding: 8px 12px;
            font-size: 14px;
            cursor: pointer;
            transition: background-color 0.2s;
        }
        
        .material-option.selected {
            background-color: #007bff;
        }
        
        .premium-textures {
            margin-top: 15px;
            border-top: 1px solid #444;
            padding-top: 15px;
        }
        
        .premium-textures h4 {
            font-size: 14px;
            margin-bottom: 10px;
            color: #f0ad4e;
        }
        
        /* Background Mode Toggle Switch */
        .background-mode-toggle {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 10px 15px;
            border-bottom: 1px solid #333;
        }
        
        .toggle-switch {
            position: relative;
            display: inline-block;
            width: 50px;
            height: 24px;
        }
        
        .toggle-switch input {
            opacity: 0;
            width: 0;
            height: 0;
        }
        
        .toggle-slider {
            position: absolute;
            cursor: pointer;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: #333;
            transition: .4s;
            border-radius: 24px;
        }
        
        .toggle-slider:before {
            position: absolute;
            content: "";
            height: 18px;
            width: 18px;
            left: 3px;
            bottom: 3px;
            background-color: white;
            transition: .4s;
            border-radius: 50%;
        }
        
        input:checked + .toggle-slider {
            background-color: #007bff;
        }
        
        input:checked + .toggle-slider:before {
            transform: translateX(26px);
        }
        
        .toggle-label {
            font-size: 14px;
        }
        
        .toggle-icon {
            margin-right: 8px;
            font-size: 16px;
        }
    </style>
</head>

<body>

    <?php echo view("includes/header.php"); ?>
    <?php echo view("includes/cropper_modal.php"); ?>

    <div class="main-container">
        <div class="earphone-container">
            <div id="canvas-container"></div>
            <div class="model-controls">
                <p>Click and drag to rotate the model</p>
            </div>
        </div>

        <div class="customization-panel">
            <div class="navigation-buttons">
                <button class="nav-button" id="backButton">Back</button>
                <button class="nav-button" id="nextButton">Next</button>
            </div>

            <!-- Background Mode Toggle -->
            <div class="background-mode-toggle">
                <div class="toggle-label">
                    <span class="toggle-icon"><i class="fas fa-moon"></i></span>
                    <span>Dark Mode</span>
                </div>
                <label class="toggle-switch">
                    <input type="checkbox" id="backgroundModeToggle" checked>
                    <span class="toggle-slider"></span>
                </label>
            </div>

            <div class="section-header" id="leftShellHeader">
                <span class="icon">▼</span>
                <span>Left Shell</span>
                <span id="leftShellInfo">Clear</span>
            </div>
            <div class="section-content expanded" id="leftShellContent">
                <div class="color-grid" id="leftShellColors">
                    <div class="color-option selected" style="background-color: #f2e6d8;" data-color="#f2e6d8"></div>
                    <div class="color-option" style="background-color: #1a1a1a;" data-color="#1a1a1a"></div>
                    <div class="color-option" style="background-color: #1e5cb3;" data-color="#1e5cb3"></div>
                    <div class="color-option" style="background-color: #ff7b25;" data-color="#ff7b25"></div>
                    <div class="color-option" style="background-color: #7fc6e4;" data-color="#7fc6e4"></div>
                    <div class="color-option" style="background-color: #8b0f55;" data-color="#8b0f55"></div>
                    <div class="color-option" style="background-color: #b83d8b;" data-color="#b83d8b"></div>
                    <div class="color-option" style="background-color: #ff9ebc;" data-color="#ff9ebc"></div>
                    <div class="color-option" style="background-color: #00b2a9;" data-color="#00b2a9"></div>
                    <div class="color-option" style="background-color: #2c8437;" data-color="#2c8437"></div>
                    <div class="color-option" style="background-color: #d1d1d1;" data-color="#d1d1d1"></div>
                    <div class="color-option" style="background-color: #5a5a5a;" data-color="#5a5a5a"></div>
                    <div class="color-option" style="background-color: #a7c7e7;" data-color="#a7c7e7"></div>
                    <div class="color-option" style="background-color: #c25450;" data-color="#c25450"></div>
                    <div class="color-option" style="background-color: #e9a94a;" data-color="#e9a94a"></div>
                    <div class="color-option" style="background-color: #9370db;" data-color="#9370db"></div>
                    <div class="color-option" style="background-color: #b5835a;" data-color="#b5835a"></div>
                    <div class="color-option" style="background-color: #daa520;" data-color="#daa520"></div>
                    <div class="color-option" style="background-color: #90ee90;" data-color="#90ee90"></div>
                    <div class="color-option" style="background-color: #2e8b57;" data-color="#2e8b57"></div>
                    <div class="color-option" style="background-color: #000000;" data-color="#000000"></div>
                </div>

                <div class="premium-textures">
                    <h4>Premium Textures</h4>
                    <div class="color-grid" id="leftShellTextures">
                        <div class="color-option texture-option" style="background-image: url('assets/textures/abalone-gold.webp');" data-texture="abalone-gold.webp" data-name="Abalone Gold"></div>
                        <div class="color-option texture-option" style="background-image: url('assets/textures/abalone-silver.webp');" data-texture="abalone-silver.webp" data-name="Abalone Silver"></div>
                        <div class="color-option texture-option" style="background-image: url('assets/textures/abalone.webp');" data-texture="abalone.webp" data-name="Abalone"></div>
                        <div class="color-option texture-option" style="background-image: url('assets/textures/carbon.jpeg');" data-texture="carbon.jpeg" data-name="Carbon Fiber"></div>
                        <div class="color-option texture-option" style="background-image: url('assets/textures/celluloid-black.webp');" data-texture="celluloid-black.webp" data-name="Celluloid"></div>
                        <div class="color-option texture-option" style="background-image: url('assets/textures/flakes-gold.webp');" data-texture="flakes-gold.webp" data-name="Gold Flakes"></div>
                        <div class="color-option texture-option" style="background-image: url('assets/textures/flakes-silver.webp');" data-texture="flakes-silver.webp" data-name="Silver Flakes"></div>
                        <div class="color-option texture-option" style="background-image: url('assets/textures/galaxy-black.webp');" data-texture="galaxy-black.webp" data-name="Galaxy Black"></div>
                        <div class="color-option texture-option" style="background-image: url('assets/textures/galaxy-blue.webp');" data-texture="galaxy-blue.webp" data-name="Galaxy Blue"></div>
                        <div class="color-option texture-option" style="background-image: url('assets/textures/wood.jpeg');" data-texture="wood.jpeg" data-name="Wood"></div>
                        <div class="color-option texture-option" style="background-image: url('assets/textures/steampunk.webp');" data-texture="steampunk.webp" data-name="Steampunk"></div>
                        <div class="color-option texture-option" style="background-image: url('assets/textures/sparkle-purple.webp');" data-texture="sparkle-purple.webp" data-name="Sparkle Purple"></div>
                        <div class="color-option texture-option" style="background-image: url('assets/textures/sparkle-blue.webp');" data-texture="sparkle-blue.webp" data-name="Sparkle Blue"></div>
                        <div class="color-option texture-option" style="background-image: url('assets/textures/scattered-copper.webp');" data-texture="scattered-copper.webp" data-name="Scattered Copper"></div>
                        <div class="color-option texture-option" style="background-color: #333; display: flex; justify-content: center; align-items: center;" data-texture="custom" data-name="Custom">
                            <span class="help-icon">+</span>
                        </div>
                    </div>
                    <input type="file" id="leftShellTextureUpload" accept="image/*" style="display: none;">
                </div>
            </div>

            <div class="section-header" id="rightShellHeader">
                <span class="icon">▼</span>
                <span>Right Shell</span>
                <span id="rightShellInfo">Clear</span>
            </div>
            <div class="section-content expanded" id="rightShellContent">
                <div class="color-grid" id="rightShellColors">
                    <div class="color-option selected" style="background-color: #f2e6d8;" data-color="#f2e6d8"></div>
                    <div class="color-option" style="background-color: #1a1a1a;" data-color="#1a1a1a"></div>
                    <div class="color-option" style="background-color: #1e5cb3;" data-color="#1e5cb3"></div>
                    <div class="color-option" style="background-color: #ff7b25;" data-color="#ff7b25"></div>
                    <div class="color-option" style="background-color: #7fc6e4;" data-color="#7fc6e4"></div>
                    <div class="color-option" style="background-color: #8b0f55;" data-color="#8b0f55"></div>
                    <div class="color-option" style="background-color: #b83d8b;" data-color="#b83d8b"></div>
                    <div class="color-option" style="background-color: #ff9ebc;" data-color="#ff9ebc"></div>
                    <div class="color-option" style="background-color: #00b2a9;" data-color="#00b2a9"></div>
                    <div class="color-option" style="background-color: #2c8437;" data-color="#2c8437"></div>
                    <div class="color-option" style="background-color: #d1d1d1;" data-color="#d1d1d1"></div>
                    <div class="color-option" style="background-color: #5a5a5a;" data-color="#5a5a5a"></div>
                    <div class="color-option" style="background-color: #a7c7e7;" data-color="#a7c7e7"></div>
                    <div class="color-option" style="background-color: #c25450;" data-color="#c25450"></div>
                    <div class="color-option" style="background-color: #e9a94a;" data-color="#e9a94a"></div>
                    <div class="color-option" style="background-color: #9370db;" data-color="#9370db"></div>
                    <div class="color-option" style="background-color: #b5835a;" data-color="#b5835a"></div>
                    <div class="color-option" style="background-color: #daa520;" data-color="#daa520"></div>
                    <div class="color-option" style="background-color: #90ee90;" data-color="#90ee90"></div>
                    <div class="color-option" style="background-color: #2e8b57;" data-color="#2e8b57"></div>
                    <div class="color-option" style="background-color: #000000;" data-color="#000000"></div>
                </div>

                <div class="premium-textures">
                    <h4>Premium Textures</h4>
                    <div class="color-grid" id="rightShellTextures">
                        <div class="color-option texture-option" style="background-image: url('<?= base_url('assets/textures/abalone-gold.webp') ?>');" data-texture="abalone-gold.webp" data-name="Abalone Gold"></div>
                        <div class="color-option texture-option" style="background-image: url('<?= base_url('assets/textures/abalone-silver.webp') ?>');" data-texture="abalone-silver.webp" data-name="Abalone Silver"></div>
                        <div class="color-option texture-option" style="background-image: url('<?= base_url('assets/textures/abalone.webp') ?>');" data-texture="abalone.webp" data-name="Abalone"></div>
                        <div class="color-option texture-option" style="background-image: url('<?= base_url('assets/textures/carbon.jpeg') ?>');" data-texture="carbon.jpeg" data-name="Carbon Fiber"></div>
                        <div class="color-option texture-option" style="background-image: url('<?= base_url('assets/textures/celluloid-black.webp') ?>');" data-texture="celluloid-black.webp" data-name="Celluloid"></div>
                        <div class="color-option texture-option" style="background-image: url('<?= base_url('assets/textures/flakes-gold.webp') ?>');" data-texture="flakes-gold.webp" data-name="Gold Flakes"></div>
                        <div class="color-option texture-option" style="background-image: url('<?= base_url('assets/textures/flakes-silver.webp') ?>');" data-texture="flakes-silver.webp" data-name="Silver Flakes"></div>
                        <div class="color-option texture-option" style="background-image: url('<?= base_url('assets/textures/galaxy-black.webp') ?>');" data-texture="galaxy-black.webp" data-name="Galaxy Black"></div>
                        <div class="color-option texture-option" style="background-image: url('<?= base_url('assets/textures/galaxy-blue.webp') ?>');" data-texture="galaxy-blue.webp" data-name="Galaxy Blue"></div>
                        <div class="color-option texture-option" style="background-image: url('<?= base_url('assets/textures/wood.jpeg') ?>');" data-texture="wood.jpeg" data-name="Wood"></div>
                        <div class="color-option texture-option" style="background-image: url('<?= base_url('assets/textures/steampunk.webp') ?>');" data-texture="steampunk.webp" data-name="Steampunk"></div>
                        <div class="color-option texture-option" style="background-image: url('<?= base_url('assets/textures/sparkle-purple.webp') ?>');" data-texture="sparkle-purple.webp" data-name="Sparkle Purple"></div>
                        <div class="color-option texture-option" style="background-image: url('<?= base_url('assets/textures/sparkle-blue.webp') ?>');" data-texture="sparkle-blue.webp" data-name="Sparkle Blue"></div>
                        <div class="color-option texture-option" style="background-image: url('<?= base_url('assets/textures/scattered-copper.webp') ?>');" data-texture="scattered-copper.webp" data-name="Scattered Copper"></div>

                        <div class="color-option texture-option" style="background-color: #333; display: flex; justify-content: center; align-items: center;" data-texture="custom" data-name="Custom">
                            <span class="help-icon">+</span>
                        </div>
                    </div>
                    <input type="file" id="rightShellTextureUpload" accept="image/*" style="display: none;">
                </div>
            </div>

            <div class="section-header" id="leftFaceplateHeader">
                <span class="icon">▼</span>
                <span>Left Faceplate</span>
                <span id="leftFaceplateInfo">Clear</span>
            </div>
            <div class="section-content expanded" id="leftFaceplateContent">
                <div class="color-grid" id="leftFaceplateColors">
                    <div class="color-option selected" style="background-color: #f2e6d8;" data-color="#f2e6d8"></div>
                    <div class="color-option" style="background-color: #1a1a1a;" data-color="#1a1a1a"></div>
                    <div class="color-option" style="background-color: #1e5cb3;" data-color="#1e5cb3"></div>
                    <div class="color-option" style="background-color: #ff7b25;" data-color="#ff7b25"></div>
                    <div class="color-option" style="background-color: #7fc6e4;" data-color="#7fc6e4"></div>
                    <div class="color-option" style="background-color: #8b0f55;" data-color="#8b0f55"></div>
                    <div class="color-option" style="background-color: #b83d8b;" data-color="#b83d8b"></div>
                    <div class="color-option" style="background-color: #ff9ebc;" data-color="#ff9ebc"></div>
                    <div class="color-option" style="background-color: #00b2a9;" data-color="#00b2a9"></div>
                    <div class="color-option" style="background-color: #2c8437;" data-color="#2c8437"></div>
                    <div class="color-option" style="background-color: #d1d1d1;" data-color="#d1d1d1"></div>
                    <div class="color-option" style="background-color: #5a5a5a;" data-color="#5a5a5a"></div>
                </div>

                <div class="premium-textures">
                    <h4>Premium Textures</h4>
                    <div class="color-grid" id="leftFaceplateTextures">
                        <div class="color-option texture-option" style="background-image: url('<?= base_url('assets/textures/abalone-gold.webp') ?>');" data-texture="abalone-gold.webp" data-name="Abalone Gold"></div>
                        <div class="color-option texture-option" style="background-image: url('<?= base_url('assets/textures/abalone-silver.webp') ?>');" data-texture="abalone-silver.webp" data-name="Abalone Silver"></div>
                        <div class="color-option texture-option" style="background-image: url('<?= base_url('assets/textures/abalone.webp') ?>');" data-texture="abalone.webp" data-name="Abalone"></div>
                        <div class="color-option texture-option" style="background-image: url('<?= base_url('assets/textures/carbon.jpeg') ?>');" data-texture="carbon.jpeg" data-name="Carbon Fiber"></div>
                        <div class="color-option texture-option" style="background-image: url('<?= base_url('assets/textures/celluloid-black.webp') ?>');" data-texture="celluloid-black.webp" data-name="Celluloid"></div>
                        <div class="color-option texture-option" style="background-image: url('<?= base_url('assets/textures/flakes-gold.webp') ?>');" data-texture="flakes-gold.webp" data-name="Gold Flakes"></div>
                        <div class="color-option texture-option" style="background-image: url('<?= base_url('assets/textures/flakes-silver.webp') ?>');" data-texture="flakes-silver.webp" data-name="Silver Flakes"></div>
                        <div class="color-option texture-option" style="background-image: url('<?= base_url('assets/textures/galaxy-black.webp') ?>');" data-texture="galaxy-black.webp" data-name="Galaxy Black"></div>
                        <div class="color-option texture-option" style="background-image: url('<?= base_url('assets/textures/galaxy-blue.webp') ?>');" data-texture="galaxy-blue.webp" data-name="Galaxy Blue"></div>
                        <div class="color-option texture-option" style="background-image: url('<?= base_url('assets/textures/wood.jpeg') ?>');" data-texture="wood.jpeg" data-name="Wood"></div>
                        <div class="color-option texture-option" style="background-image: url('<?= base_url('assets/textures/steampunk.webp') ?>');" data-texture="steampunk.webp" data-name="Steampunk"></div>
                        <div class="color-option texture-option" style="background-image: url('<?= base_url('assets/textures/sparkle-purple.webp') ?>');" data-texture="sparkle-purple.webp" data-name="Sparkle Purple"></div>
                        <div class="color-option texture-option" style="background-image: url('<?= base_url('assets/textures/sparkle-blue.webp') ?>');" data-texture="sparkle-blue.webp" data-name="Sparkle Blue"></div>
                        <div class="color-option texture-option" style="background-image: url('<?= base_url('assets/textures/scattered-copper.webp') ?>');" data-texture="scattered-copper.webp" data-name="Scattered Copper"></div>

                        <div class="color-option texture-option" style="background-color: #333; display: flex; justify-content: center; align-items: center;" data-texture="custom" data-name="Custom">
                            <span class="help-icon">+</span>
                        </div>
                    </div>
                    <input type="file" id="leftFaceplateTextureUpload" accept="image/*" style="display: none;">
                </div>
            </div>

            <div class="section-header" id="rightFaceplateHeader">
                <span class="icon">▼</span>
                <span>Right Faceplate</span>
                <span id="rightFaceplateInfo">Clear</span>
            </div>
            <div class="section-content expanded" id="rightFaceplateContent">
                <div class="color-grid" id="rightFaceplateColors">
                    <div class="color-option selected" style="background-color: #f2e6d8;" data-color="#f2e6d8"></div>
                    <div class="color-option" style="background-color: #1a1a1a;" data-color="#1a1a1a"></div>
                    <div class="color-option" style="background-color: #1e5cb3;" data-color="#1e5cb3"></div>
                    <div class="color-option" style="background-color: #ff7b25;" data-color="#ff7b25"></div>
                    <div class="color-option" style="background-color: #7fc6e4;" data-color="#7fc6e4"></div>
                    <div class="color-option" style="background-color: #8b0f55;" data-color="#8b0f55"></div>
                    <div class="color-option" style="background-color: #b83d8b;" data-color="#b83d8b"></div>
                    <div class="color-option" style="background-color: #ff9ebc;" data-color="#ff9ebc"></div>
                    <div class="color-option" style="background-color: #00b2a9;" data-color="#00b2a9"></div>
                    <div class="color-option" style="background-color: #2c8437;" data-color="#2c8437"></div>
                    <div class="color-option" style="background-color: #d1d1d1;" data-color="#d1d1d1"></div>
                    <div class="color-option" style="background-color: #5a5a5a;" data-color="#5a5a5a"></div>
                    <div class="color-option" style="background-color: #a7c7e7;" data-color="#a7c7e7"></div>
                    <div class="color-option" style="background-color: #c25450;" data-color="#c25450"></div>
                    <div class="color-option" style="background-color: #e9a94a;" data-color="#e9a94a"></div>
                    <div class="color-option" style="background-color: #9370db;" data-color="#9370db"></div>
                    <div class="color-option" style="background-color: #b5835a;" data-color="#b5835a"></div>
                    <div class="color-option" style="background-color: #daa520;" data-color="#daa520"></div>
                    <div class="color-option" style="background-color: #90ee90;" data-color="#90ee90"></div>
                    <div class="color-option" style="background-color: #2e8b57;" data-color="#2e8b57"></div>
                    <div class="color-option" style="background-color: #000000;" data-color="#000000"></div>
                </div>

                <div class="premium-textures">
                    <h4>Premium Textures</h4>
                    <div class="color-grid" id="rightFaceplateTextures">
                        <div class="color-option texture-option" style="background-image: url('<?= base_url('assets/textures/abalone-gold.webp') ?>');" data-texture="abalone-gold.webp" data-name="Abalone Gold"></div>
                        <div class="color-option texture-option" style="background-image: url('<?= base_url('assets/textures/abalone-silver.webp') ?>');" data-texture="abalone-silver.webp" data-name="Abalone Silver"></div>
                        <div class="color-option texture-option" style="background-image: url('<?= base_url('assets/textures/abalone.webp') ?>');" data-texture="abalone.webp" data-name="Abalone"></div>
                        <div class="color-option texture-option" style="background-image: url('<?= base_url('assets/textures/carbon.jpeg') ?>');" data-texture="carbon.jpeg" data-name="Carbon Fiber"></div>
                        <div class="color-option texture-option" style="background-image: url('<?= base_url('assets/textures/celluloid-black.webp') ?>');" data-texture="celluloid-black.webp" data-name="Celluloid"></div>
                        <div class="color-option texture-option" style="background-image: url('<?= base_url('assets/textures/flakes-gold.webp') ?>');" data-texture="flakes-gold.webp" data-name="Gold Flakes"></div>
                        <div class="color-option texture-option" style="background-image: url('<?= base_url('assets/textures/flakes-silver.webp') ?>');" data-texture="flakes-silver.webp" data-name="Silver Flakes"></div>
                        <div class="color-option texture-option" style="background-image: url('<?= base_url('assets/textures/galaxy-black.webp') ?>');" data-texture="galaxy-black.webp" data-name="Galaxy Black"></div>
                        <div class="color-option texture-option" style="background-image: url('<?= base_url('assets/textures/galaxy-blue.webp') ?>');" data-texture="galaxy-blue.webp" data-name="Galaxy Blue"></div>
                        <div class="color-option texture-option" style="background-image: url('<?= base_url('assets/textures/wood.jpeg') ?>');" data-texture="wood.jpeg" data-name="Wood"></div>
                        <div class="color-option texture-option" style="background-image: url('<?= base_url('assets/textures/steampunk.webp') ?>');" data-texture="steampunk.webp" data-name="Steampunk"></div>
                        <div class="color-option texture-option" style="background-image: url('<?= base_url('assets/textures/sparkle-purple.webp') ?>');" data-texture="sparkle-purple.webp" data-name="Sparkle Purple"></div>
                        <div class="color-option texture-option" style="background-image: url('<?= base_url('assets/textures/sparkle-blue.webp') ?>');" data-texture="sparkle-blue.webp" data-name="Sparkle Blue"></div>
                        <div class="color-option texture-option" style="background-image: url('<?= base_url('assets/textures/scattered-copper.webp') ?>');" data-texture="scattered-copper.webp" data-name="Scattered Copper"></div>

                        <div class="color-option texture-option" style="background-color: #333; display: flex; justify-content: center; align-items: center;" data-texture="custom" data-name="Custom">
                            <span class="help-icon">+</span>
                        </div>
                    </div>
                    <input type="file" id="rightFaceplateTextureUpload" accept="image/*" style="display: none;">
                </div>
            </div>

            <div class="section-header" id="materialHeader">
                <span class="icon">▼</span>
                <span>Material & Lighting</span>
            </div>
            <div class="section-content expanded" id="materialContent">
                <h4>Material Type</h4>
                <div class="material-options">
                    <button class="material-option selected" data-material="glossy">Glossy</button>
                    <button class="material-option" data-material="matte">Matte</button>
                    <button class="material-option" data-material="metallic">Metallic</button>
                    <button class="material-option" data-material="ceramic">Ceramic</button>
                </div>

                <h4 style="margin-top: 20px;">Lighting</h4>
                <div class="control-slider">
                    <label><span>Ambient Light</span><span id="ambientValue">0.7</span></label>
                    <input type="range" id="ambientIntensity" min="0" max="1" step="0.1" value="0.7">
                </div>

                <div class="control-slider">
                    <label><span>Key Light</span><span id="keyValue">1.2</span></label>
                    <input type="range" id="keyIntensity" min="0" max="2" step="0.1" value="1.2">
                </div>

                <div class="control-slider">
                    <label><span>Fill Light</span><span id="fillValue">0.8</span></label>
                    <input type="range" id="fillIntensity" min="0" max="1.5" step="0.1" value="0.8">
                </div>

                <div class="control-slider">
                    <label><span>Rim Light</span><span id="rimValue">0.7</span></label>
                    <input type="range" id="rimIntensity" min="0" max="1.5" step="0.1" value="0.7">
                </div>

                <div style="display: flex; gap: 10px; margin-top: 15px;">
                    <div style="flex: 1;">
                        <label>Key Light Color</label>
                        <input type="color" id="keyLightColor" value="#ffffff" style="width: 100%; height: 30px;">
                    </div>
                    <div style="flex: 1;">
                        <label>Fill Light Color</label>
                        <input type="color" id="fillLightColor" value="#ffffff" style="width: 100%; height: 30px;">
                    </div>
                </div>
            </div>

            <div class="controls">
                <div class="control-group">
                    <label for="sizeSelect">Select Size:</label>
                    <select id="sizeSelect">
                        <option value="super small">SS</option>
                        <option value="small">S</option>
                        <option value="medium small">MS</option>
                        <option value="medium" selected>M</option>
                        <option value="medium large">ML</option>
                        <option value="large">L</option>
                    </select>
                </div>
            </div>

            <!-- <div class="control">
                <div class="control-group">
                    <label for="userDesignUpload">Upload Custom Logo/Design:</label>
                    <input type="file" id="userDesignUpload" accept="image/*">
                    <small class="text-muted">This will be applied to the right faceplate</small>
                </div>
            </div> -->

            <div class="control">
                <div class="control-group">
                    <label for="categorySelect">Select Category:</label>
                    <select id="categorySelect">
                        <option value="Vanilla Series">Vanilla Series</option>
                        <option value="Stage Series">Stage Series</option>
                        <option value="Prestige Series">Prestige Series</option>
                    </select>
                </div>

                <div class="specs-section">
                    <h3>Specifications</h3>
                    <ul id="specsList" class="list-group">
                        <li class="list-group-item">Driver Type: Balanced Armature</li>
                        <li class="list-group-item">Cable Type: 3.5mm Silver-Plated Copper</li>
                        <li class="list-group-item">Frequency Range: 20Hz - 20kHz</li>
                    </ul>
                </div>

                <div class="sound-test mt-3">
                    <h3>Sound Test</h3>
                    <audio id="soundTest" controls class="w-100"></audio>
                    <canvas id="visualizer"></canvas>
                </div>
            </div>

            <!-- Save Design button moved to the submit-design-section below -->

            <div class="submit-design-section mt-4">
                <h3>Save Your Design</h3>
                <div class="form-group">
                    <label for="designName">Design Name</label>
                    <input type="text" id="designName" class="form-control" placeholder="Enter a name for your design" required>
                </div>
                <button id="saveDesign" class="btn btn-primary w-100 mt-3">Save Design</button>
                <div id="saveMessage" class="mt-2 text-center"></div>
            </div>

            <div class="control mt-3">
                <h3>Keyboard Controls</h3>
                <p>Press 'R' to toggle rotation of the model</p>
                <p>Use mouse to rotate and scroll to zoom the view</p>
            </div>
        </div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/three.js/r128/three.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/three/examples/js/loaders/GLTFLoader.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/three/examples/js/controls/OrbitControls.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.13/cropper.min.js" integrity="sha512-6l5Qw6Qn6Qn5Qw6Qn6Qn5Qw6Qn6Qn5Qw6Qn6Qn5Qw6Qn6Qn5Qw6Qn6Qn5Qw6Qn6Qn5Qw6Qn6Qn5Qw6Qn6Qn5Qw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
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
            "Vanilla Series": [
                "Driver Type: Balanced Armature",
                "Cable Type: 3.5mm Silver-Plated Copper",
                "Frequency Range: 20Hz - 20kHz"
            ],
            "Stage Series": [
                "Driver Type: Dynamic Driver",
                "Cable Type: Detachable 2-pin",
                "Frequency Range: 15Hz - 30kHz"
            ],
            "Prestige Series": [
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
                case "Vanilla Series":
                    audioSrc = "assets/sounds/vanilla.mp3";
                    break;
                case "Stage Series":
                    audioSrc = "assets/sounds/stage.mp3";
                    break;
                case "Prestige Series":
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
        document.getElementById("saveDesign").addEventListener("click", function() {
            const designName = document.getElementById("designName").value.trim();
            if (!designName) {
                document.getElementById("saveMessage").innerHTML = '<div class="alert alert-danger">Please enter a design name</div>';
                return;
            }
            
            const leftShellColorEl = document.querySelector('#leftShellColors .color-option.selected');
            const leftShellColor = leftShellColorEl ? leftShellColorEl.getAttribute('data-color') : '#f2e6d8';
            
            const rightShellColorEl = document.querySelector('#rightShellColors .color-option.selected');
            const rightShellColor = rightShellColorEl ? rightShellColorEl.getAttribute('data-color') : '#f2e6d8';
            
            const leftFaceplateColorEl = document.querySelector('#leftFaceplateColors .color-option.selected');
            const leftFaceplateColor = leftFaceplateColorEl ? leftFaceplateColorEl.getAttribute('data-color') : leftShellColor;
            
            const rightFaceplateColorEl = document.querySelector('#rightFaceplateColors .color-option.selected');
            const rightFaceplateColor = rightFaceplateColorEl ? rightFaceplateColorEl.getAttribute('data-color') : rightShellColor;
            
            const leftTextureEl = document.querySelector('#leftShellTextures .color-option.selected');
            const leftTexture = leftTextureEl ? leftTextureEl.getAttribute('data-texture') : '';
            
            const rightTextureEl = document.querySelector('#rightShellTextures .color-option.selected');
            const rightTexture = rightTextureEl ? rightTextureEl.getAttribute('data-texture') : '';
            
            const leftFaceplateTextureEl = document.querySelector('#leftFaceplateTextures .color-option.selected');
            const leftFaceplateTexture = leftFaceplateTextureEl ? leftFaceplateTextureEl.getAttribute('data-texture') : leftTexture;
            
            const rightFaceplateTextureEl = document.querySelector('#rightFaceplateTextures .color-option.selected');
            const rightFaceplateTexture = rightFaceplateTextureEl ? rightFaceplateTextureEl.getAttribute('data-texture') : rightTexture;
            
            const materialEl = document.querySelector('.material-option.selected');
            const material = materialEl ? materialEl.getAttribute('data-material') : 'glossy';
            
            const size = document.getElementById("sizeSelect").value;
            const category = document.getElementById("categorySelect").value;
            
            const customizationData = {
                designName: designName,
                leftColor: leftShellColor,
                rightColor: rightShellColor,
                leftFaceplateColor: leftFaceplateColor,
                rightFaceplateColor: rightFaceplateColor,
                leftTexture: leftTexture,
                rightTexture: rightTexture,
                leftFaceplateTexture: leftFaceplateTexture,
                rightFaceplateTexture: rightFaceplateTexture,
                material: material,
                size: size,
                category: category
            };
            
            console.log("Saving Customization:", customizationData);
            document.getElementById("saveMessage").innerHTML = '<div class="spinner-border text-primary" role="status"><span class="sr-only">Saving...</span></div>';

            fetch("<?= site_url('IEMCustomizationController/saveDesign') ?>", {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json"
                    },
                    body: JSON.stringify(customizationData),
                })
                .then(response => response.json())
                .then(data => {
                    if (data.status === 'success') {
                        document.getElementById("saveMessage").innerHTML = '<div class="alert alert-success">' + data.message + '</div>';
                        // No redirect, just show the success message
                    } else if (data.status === 'login_required') {
                        // Redirect to login page if user is not logged in
                        document.getElementById("saveMessage").innerHTML = '<div class="alert alert-warning">' + data.message + '</div>';
                        setTimeout(() => {
                            window.location.href = "<?= site_url('login') ?>";
                        }, 1500);
                    } else {
                        document.getElementById("saveMessage").innerHTML = '<div class="alert alert-danger">' + data.message + '</div>';
                    }
                })
                .catch(error => {
                    console.error("Error saving customization:", error);
                    document.getElementById("saveMessage").innerHTML = '<div class="alert alert-danger">Error saving design. Please try again.</div>';
                });
        });
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const backgroundModeToggle = document.getElementById('backgroundModeToggle');
            const toggleIcon = document.querySelector('.toggle-icon i');
            const toggleLabel = document.querySelector('.toggle-label span:last-child');
            
            function updateToggleUI(isDark) {
                if (isDark) {
                    toggleIcon.className = 'fas fa-moon';
                    toggleLabel.textContent = 'Dark Mode';
                } else {
                    toggleIcon.className = 'fas fa-sun';
                    toggleLabel.textContent = 'Light Mode';
                }
            }
            
            const isDarkMode = localStorage.getItem('backgroundMode') !== 'light';
            updateToggleUI(isDarkMode);
            
            if (backgroundModeToggle) {
                backgroundModeToggle.addEventListener('change', function() {
                    updateToggleUI(this.checked);
                });
            }
        });
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const urlParams = new URLSearchParams(window.location.search);
            const series = urlParams.get('series');
            const model = urlParams.get('model');
            
            if (series) {
                console.log('Series from URL:', series);
                console.log('Model from URL:', model);
                
                const seriesInput = document.createElement('input');
                seriesInput.type = 'hidden';
                seriesInput.id = 'selected_series';
                seriesInput.name = 'selected_series';
                seriesInput.value = series;
                document.querySelector('.customization-panel').appendChild(seriesInput);
                
                const modelInput = document.createElement('input');
                modelInput.type = 'hidden';
                modelInput.id = 'selected_model';
                modelInput.name = 'selected_model';
                modelInput.value = model;
                document.querySelector('.customization-panel').appendChild(modelInput);
            }
            const sectionHeaders = document.querySelectorAll('.section-header');
            sectionHeaders.forEach(header => {
                header.addEventListener('click', function() {
                    const content = this.nextElementSibling;
                    const icon = this.querySelector('.icon');

                    if (content.classList.contains('expanded')) {
                        content.classList.remove('expanded');
                        this.classList.add('collapsed');
                        if (icon) icon.style.transform = 'rotate(-90deg)';
                    } else {
                        content.classList.add('expanded');
                        this.classList.remove('collapsed');
                        if (icon) icon.style.transform = 'rotate(0deg)';
                    }
                });
            });

            const colorOptions = document.querySelectorAll('.color-option');
            colorOptions.forEach(option => {
                option.addEventListener('click', function() {
                    const grid = this.closest('.color-grid');
                    if (grid) {
                        grid.querySelectorAll('.color-option').forEach(opt => {
                            opt.classList.remove('selected');
                        });
                    }

                    this.classList.add('selected');
                });
            });

            const customTextureButtons = document.querySelectorAll('.texture-option[data-texture="custom"]');
            customTextureButtons.forEach(button => {
                button.addEventListener('click', function() {
                    const grid = this.closest('.color-grid');
                    const section = grid.closest('.section-content');

                    if (section) {
                        const uploadInput = section.querySelector('input[type="file"]');
                        if (uploadInput) {
                            uploadInput.click();
                        }
                    }
                });
            });

            const materialOptions = document.querySelectorAll('.material-option');
            materialOptions.forEach(option => {
                option.addEventListener('click', function() {
                    materialOptions.forEach(opt => opt.classList.remove('selected'));
                    this.classList.add('selected');
                });
            });

            const backButton = document.getElementById('backButton');
            const nextButton = document.getElementById('nextButton');

            if (backButton && nextButton) {
                backButton.addEventListener('click', function() {
                    const expandedSections = document.querySelectorAll('.section-content.expanded');
                    if (expandedSections.length > 0) {
                        const currentSection = expandedSections[0].previousElementSibling;
                        const prevSection = currentSection.previousElementSibling?.previousElementSibling;

                        if (prevSection && prevSection.classList.contains('section-header')) {
                            document.querySelectorAll('.section-content').forEach(content => {
                                content.classList.remove('expanded');
                            });
                            document.querySelectorAll('.section-header').forEach(header => {
                                header.classList.add('collapsed');
                                const icon = header.querySelector('.icon');
                                if (icon) icon.style.transform = 'rotate(-90deg)';
                            });

                            prevSection.classList.remove('collapsed');
                            const icon = prevSection.querySelector('.icon');
                            if (icon) icon.style.transform = 'rotate(0deg)';
                            prevSection.nextElementSibling.classList.add('expanded');
                        }
                    }
                });

                nextButton.addEventListener('click', function() {
                    const expandedSections = document.querySelectorAll('.section-content.expanded');
                    if (expandedSections.length > 0) {
                        const currentSection = expandedSections[0].nextElementSibling;

                        if (currentSection && currentSection.classList.contains('section-header')) {
                            document.querySelectorAll('.section-content').forEach(content => {
                                content.classList.remove('expanded');
                            });
                            document.querySelectorAll('.section-header').forEach(header => {
                                header.classList.add('collapsed');
                                const icon = header.querySelector('.icon');
                                if (icon) icon.style.transform = 'rotate(-90deg)';
                            });

                            currentSection.classList.remove('collapsed');
                            const icon = currentSection.querySelector('.icon');
                            if (icon) icon.style.transform = 'rotate(0deg)';
                            currentSection.nextElementSibling.classList.add('expanded');
                        }
                    }
                });
            }
        });
    </script>
    <script>
        // Cropper integration for texture uploads
let cropper = null;
let currentTextureTarget = null;

function openCropperModal(file, targetPart) {
    const reader = new FileReader();
    reader.onload = function (e) {
        const cropperImage = document.getElementById('cropperImage');
        cropperImage.src = e.target.result;
        currentTextureTarget = targetPart;
        if (cropper) {
            cropper.destroy();
        }
        // Wait for image to load
        cropperImage.onload = function () {
            cropper = new Cropper(cropperImage, {
                aspectRatio: 1,
                viewMode: 1,
                autoCropArea: 1,
                background: false,
                movable: true,
                zoomable: true,
                rotatable: true,
                scalable: true
            });
        };
        // Show modal
        const cropperModal = new bootstrap.Modal(document.getElementById('cropperModal'));
        cropperModal.show();
    };
    reader.readAsDataURL(file);
}

document.addEventListener('DOMContentLoaded', function() {
    // Patch upload input listeners for cropper
    const leftShellTextureUpload = document.getElementById("leftShellTextureUpload");
    const rightShellTextureUpload = document.getElementById("rightShellTextureUpload");
    const leftFaceplateTextureUpload = document.getElementById("leftFaceplateTextureUpload");
    const rightFaceplateTextureUpload = document.getElementById("rightFaceplateTextureUpload");

    if (leftShellTextureUpload) {
        leftShellTextureUpload.addEventListener("change", function(event) {
            if (event.target.files[0]) openCropperModal(event.target.files[0], 'leftShell');
        });
    }
    if (rightShellTextureUpload) {
        rightShellTextureUpload.addEventListener("change", function(event) {
            if (event.target.files[0]) openCropperModal(event.target.files[0], 'rightShell');
        });
    }
    if (leftFaceplateTextureUpload) {
        leftFaceplateTextureUpload.addEventListener("change", function(event) {
            if (event.target.files[0]) openCropperModal(event.target.files[0], 'leftFaceplate');
        });
    }
    if (rightFaceplateTextureUpload) {
        rightFaceplateTextureUpload.addEventListener("change", function(event) {
            if (event.target.files[0]) openCropperModal(event.target.files[0], 'rightFaceplate');
        });
    }

    // Handle crop & apply
    document.getElementById('cropImageBtn').addEventListener('click', function() {
        if (cropper && currentTextureTarget) {
            const croppedCanvas = cropper.getCroppedCanvas({
                width: 512,
                height: 512,
                imageSmoothingQuality: 'high'
            });
            const croppedDataUrl = croppedCanvas.toDataURL('image/png');
            // Custom event to pass cropped image to Three.js logic
            document.dispatchEvent(new CustomEvent('customTextureCropped', {
                detail: {
                    part: currentTextureTarget,
                    dataUrl: croppedDataUrl
                }
            }));
            // Hide modal
            bootstrap.Modal.getInstance(document.getElementById('cropperModal')).hide();
            cropper.destroy();
            cropper = null;
            currentTextureTarget = null;
        }
    });
});
// Listen for customTextureCropped event and apply to 3D model
if (typeof THREE !== 'undefined') {
    document.addEventListener('customTextureCropped', function(e) {
        const { part, dataUrl } = e.detail;
        // Wait for the 3D model to be loaded and available
        if (window.applyCroppedTextureToPart) {
            window.applyCroppedTextureToPart(part, dataUrl);
        } else {
            // If not ready, queue it
            window._pendingCroppedTextures = window._pendingCroppedTextures || [];
            window._pendingCroppedTextures.push({ part, dataUrl });
        }
    });
}
    </script>
</body>

</html>