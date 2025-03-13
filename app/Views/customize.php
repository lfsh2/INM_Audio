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
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
	<title>INM Costumization</title>
	<style>
        body {
    margin: 0;
    padding: 0;
    background: #f5f5f5;
    font-family: Arial, sans-serif;
}

.main-container {
    display: flex;
    flex-wrap: wrap;
    gap: 20px;
    max-width: 95vw;
    height: 100vh;
    margin: 20px auto;
    padding: 20px;
    box-sizing: border-box;
}

/* 3D Model Container */
#canvas-container {
    flex: 1.5;
    height: 100%;
    min-height: 450px;
    background: #fff;
    border: 2px solid #ddd;
    border-radius: 12px;
    box-shadow: 0px 6px 12px rgba(0, 0, 0, 0.2);
    display: flex;
    justify-content: center;
    align-items: center;
}

/* Customization Panel */
.customization-panel {
    flex: 1;
    background: #fff;
    padding: 20px;
    border-radius: 12px;
    box-shadow: 0px 6px 12px rgba(0, 0, 0, 0.1);
    display: flex;
    flex-direction: column;
    gap: 15px;
}

/* Controls */
.controls {
    display: flex;
    flex-direction: column;
    gap: 15px;
}

.control-group {
    display: flex;
    align-items: center;
    gap: 10px;
    background: #f9f9f9;
    padding: 10px 15px;
    border-radius: 8px;
    border: 1px solid #ddd;
    box-shadow: 0px 2px 5px rgba(0, 0, 0, 0.05);
}

/* Form Elements */
label {
    font-weight: bold;
    min-width: 150px;
}

input[type="color"],
select,
input[type="file"] {
    width: 100%;
    padding: 6px;
    border: 1px solid #ddd;
    border-radius: 5px;
    background: #f8f9fa;
    cursor: pointer;
    transition: border 0.3s;
}

input[type="color"]:hover,
select:hover,
input[type="file"]:hover {
    border-color: #007bff;
}

#sizeSelect {
    background-color: #e9f5ff;
}

#saveDesign {
    width: 100%;
    padding: 12px 0;
    background: #007bff;
    color: #fff;
    border: none;
    border-radius: 5px;
    font-weight: bold;
    cursor: pointer;
    transition: background 0.3s, transform 0.2s;
}

#saveDesign:hover {
    background: #0056b3;
    transform: scale(1.03);
}

#saveDesign:active {
    transform: scale(0.97);
}

/* Texture Previews */
.color-preview,
.texture-preview {
    width: 40px;
    height: 40px;
    border-radius: 5px;
    border: 1px solid #ccc;
    background-size: cover;
    background-position: center;
}

@media (max-width: 992px) {
    .main-container {
        flex-direction: column;
        height: auto;
    }

    #canvas-container {
        width: 100%;
        height: 400px;
    }

    .customization-panel {
        width: 100%;
    }
}

@media (max-width: 600px) {
    label {
        min-width: 100px;
    }

    .control-group {
        flex-direction: column;
        align-items: flex-start;
        gap: 8px;
    }

    #saveDesign {
        padding: 10px 0;
        font-size: 1rem;
    }

    .controls {
        gap: 10px;
    }

    #canvas-container {
        min-height: 300px;
    }
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
                    <option value="small">Small</option>
                    <option value="medium">Medium</option>
                    <option value="large">Large</option>
                    <option value="xl">XL</option>
                </select>
            </div>
        </div>

        <div class="controls">
            <div class="control-group">
                <label for="userDesignUpload">Upload Design:</label>
                <input type="file" id="userDesignUpload" accept="image/*">
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
</body>

</html>


<!--document.getElementById("saveButton").addEventListener("click", function () {
    const formData = new FormData();
    formData.append("left_texture", leftTextureSelect.value);
    formData.append("right_texture", rightTextureSelect.value);
    formData.append("uploaded_image", document.getElementById("logoUpload").files[0]);

    fetch("/save-customization", {
        method: "POST",
        body: formData,
    })
    .then(response => response.json())
    .then(data => {
        if (data.status === "success") {
            alert("Customization saved successfully!");
        } else {
            alert("Error: " + data.message);
        }
    })
    .catch(error => console.error("Error:", error));
});
	-->

