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
            background: #f5f5f5;
            font-family: Arial, sans-serif;
        }
        
        #canvas-container {
            width: 80vw;
            height: 500px;
            margin: 20px auto;
            border: 1px solid #ccc;
            background: #fff;
            display: flex;
            justify-content: center;
            align-items: center;
            border-radius: 10px;
            box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.2);
        }

        .controls {
            display: flex;
            justify-content: center;
            flex-wrap: wrap;
            gap: 20px;
            margin-top: 10px;
        }

        .control-group {
            display: flex;
            align-items: center;
            gap: 10px;
            background: #fff;
            padding: 10px 15px;
            border-radius: 5px;
            box-shadow: 0px 2px 5px rgba(0, 0, 0, 0.1);
        }

        label {
            font-weight: bold;
        }

        input[type="color"], select, input[type="file"] {
            padding: 5px;
            border: 1px solid #ddd;
            border-radius: 5px;
            transition: 0.3s;
        }

        input[type="color"]:hover, select:hover, input[type="file"]:hover {
            border-color: #007bff;
        }

        #saveDesign {
            margin-top: 20px;
            padding: 10px 20px;
            background: #007bff;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: 0.3s;
        }

        #saveDesign:hover {
            background: #0056b3;
        }

        .color-preview, .texture-preview {
            width: 40px;
            height: 40px;
            border-radius: 5px;
            border: 1px solid #ccc;
        }
    </style>


</head>

<body>

<?php echo view("includes/header.php"); ?>

    <div id="canvas-container"></div>

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
            <label for="leftTextureUpload">Back IEM Texture:</label>
        <select id="leftTextureSelect">
            <option value="none">None</option>
            <option value="carbon.jpeg">Carbon Fiber</option>
            <option value="clouds.jpeg">Clouds</option>
            <option value="pearls.jpeg">Pearlscent</option>
            <option value="abstract.jpeg">Abstract No.1</option>
            <option value="abstract2.jpeg">Abstract No.2</option>
            <option value="anime1.jpeg">Akatsuki</option>
            <option value="anime2.jpeg">Hentai</option>
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
        </select>
            <input type="file" id="leftTextureUpload" accept="image/*">
        </div>
        <div class="control-group">
            <label for="rightTextureUpload">Front IEM Texture:</label>
            <select id="rightTextureSelect">
            <option value="none">None</option>
            <option value="carbon.jpeg">Carbon Fiber</option>
            <option value="clouds.jpeg">Clouds</option>
            <option value="pearls.jpeg">Pearlscent</option>
            <option value="abstract.jpeg">Abstract No.1</option>
            <option value="abstract2.jpeg">Abstract No.2</option>
            <option value="anime1.jpeg">Akatsuki</option>
            <option value="anime2.jpeg">Hentai</option>
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
            <label for="userDesignUpload">Upload Design:</label>
            <input type="file" id="userDesignUpload" accept="image/*">
        </div>
    </div>
	<div class="controls d-flex justify-content-center">
    <button id="saveDesign">Save Design</button>
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