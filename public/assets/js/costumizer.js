document.addEventListener("DOMContentLoaded", function () {
    const container = document.getElementById("canvas-container");
    
    const leftShellColors = document.getElementById('leftShellColors');
    const rightShellColors = document.getElementById('rightShellColors');
    const leftFaceplateColors = document.getElementById('leftFaceplateColors');
    const rightFaceplateColors = document.getElementById('rightFaceplateColors');
    
    const leftShellTextures = document.getElementById('leftShellTextures');
    const rightShellTextures = document.getElementById('rightShellTextures');
    const leftFaceplateTextures = document.getElementById('leftFaceplateTextures');
    const rightFaceplateTextures = document.getElementById('rightFaceplateTextures');
    
    const leftShellTextureUpload = document.getElementById("leftShellTextureUpload");
    const rightShellTextureUpload = document.getElementById("rightShellTextureUpload");
    const leftFaceplateTextureUpload = document.getElementById("leftFaceplateTextureUpload");
    const rightFaceplateTextureUpload = document.getElementById("rightFaceplateTextureUpload");
    
    const materialOptions = document.querySelectorAll('.material-option');
    const ambientIntensity = document.getElementById("ambientIntensity");
    const keyIntensity = document.getElementById("keyIntensity");
    const fillIntensity = document.getElementById("fillIntensity");
    const rimIntensity = document.getElementById("rimIntensity");
    const keyLightColor = document.getElementById("keyLightColor");
    const fillLightColor = document.getElementById("fillLightColor");
    
    const ambientValue = document.getElementById("ambientValue");
    const keyValue = document.getElementById("keyValue");
    const fillValue = document.getElementById("fillValue");
    const rimValue = document.getElementById("rimValue");
    
    const leftShellInfo = document.getElementById("leftShellInfo");
    const rightShellInfo = document.getElementById("rightShellInfo");
    const leftFaceplateInfo = document.getElementById("leftFaceplateInfo");
    const rightFaceplateInfo = document.getElementById("rightFaceplateInfo");

    const scene = new THREE.Scene();
    scene.background = new THREE.Color(0x121212);
    
    const camera = new THREE.PerspectiveCamera(45, container.clientWidth / container.clientHeight, 0.1, 1000);
    const renderer = new THREE.WebGLRenderer({ antialias: true });
    renderer.setSize(container.clientWidth, container.clientHeight);
    renderer.shadowMap.enabled = true;
    renderer.shadowMap.type = THREE.PCFSoftShadowMap;
    renderer.toneMapping = THREE.ACESFilmicToneMapping;
    renderer.toneMappingExposure = 1.5;
    container.appendChild(renderer.domElement);

    const controls = new THREE.OrbitControls(camera, renderer.domElement);
    controls.enableDamping = true;
    controls.dampingFactor = 0.05;
    controls.maxDistance = 5;
    controls.minDistance = 1;

    const lights = {
        ambient: new THREE.AmbientLight(0xffffff, 1.2),
        key: new THREE.DirectionalLight(0xffffff, 2.0),
        fill: new THREE.DirectionalLight(0xffffff, 1.4),
        rim: new THREE.DirectionalLight(0xffffff, 1.2),
        bottom: new THREE.DirectionalLight(0xffffff, 0.8)
    };
    
    lights.key.position.set(3, 3, 5);
    lights.key.castShadow = true;
    lights.key.shadow.mapSize.width = 2048;
    lights.key.shadow.mapSize.height = 2048;
    lights.key.shadow.bias = -0.0001;
    
    lights.fill.position.set(-3, 1, 3);
    lights.rim.position.set(0, 0, -5);
    lights.bottom.position.set(0, -3, 0);
    
    Object.values(lights).forEach(light => scene.add(light));

    const lightSettings = {
        ambientIntensity: 1.2,
        keyIntensity: 2.0,
        fillIntensity: 1.4,
        rimIntensity: 1.2,
        bottomIntensity: 0.8,
        keyColor: 0xffffff,
        fillColor: 0xffffff
    };

    let leftShell, rightShell, leftFaceplate, rightFaceplate;
    let turntable;

    function ensureMeshUVs(mesh) {
        if (!mesh.geometry.attributes.uv) {
            console.log("Generating UVs for mesh:", mesh.name);
            mesh.geometry.computeBoundingBox();
            const bbox = mesh.geometry.boundingBox;
            const positions = mesh.geometry.attributes.position;
            const uvs = [];
            
            for (let i = 0; i < positions.count; i++) {
                const x = positions.getX(i);
                const y = positions.getY(i);
                const z = positions.getZ(i);
                
                const isFaceplate = mesh.name && (mesh.name.toLowerCase().includes("faceplate") || 
                                                mesh.name.toLowerCase().includes("face"));
                
                if (isFaceplate) {
                    const u = (x - bbox.min.x) / (bbox.max.x - bbox.min.x);
                    const v = (y - bbox.min.y) / (bbox.max.y - bbox.min.y);
                    uvs.push(u, v);
                } else {
                    const theta = Math.atan2(z, x);
                    const phi = Math.acos(Math.max(-1, Math.min(1, y / Math.sqrt(x*x + y*y + z*z))));
                    
                    const u = (theta + Math.PI) / (2 * Math.PI);
                    const v = phi / Math.PI;
                    uvs.push(u, v);
                }
            }
            
            mesh.geometry.setAttribute('uv', new THREE.Float32BufferAttribute(uvs, 2));
        }
        
        mesh.geometry.computeVertexNormals();
        mesh.geometry.computeTangents();
    }

    function applyTextureToMesh(textureSrc, mesh, repeatX = 1, repeatY = 1) {
        if (!mesh) return;
        
        ensureMeshUVs(mesh);

        if (!(mesh.material instanceof THREE.MeshPhysicalMaterial)) {
            const oldMat = mesh.material;
            mesh.material = new THREE.MeshPhysicalMaterial({
                color: oldMat.color ? oldMat.color.clone() : 0xffffff,
                metalness: 0.8,
                roughness: 0.2,
                clearcoat: 0.5,
                clearcoatRoughness: 0.2,
                envMapIntensity: 1.0,
                side: THREE.DoubleSide,
                transparent: false, 
                opacity: 1.0, 
                alphaTest: 0, 
                depthWrite: true, 
                depthTest: true 
            });
            mesh.material.name = oldMat.name || '';
        }

        if (textureSrc && textureSrc !== "none") {
            const loader = new THREE.TextureLoader();
            loader.load(
                textureSrc,
                function (texture) {
                    console.log("Texture loaded successfully:", textureSrc);
                    
                    texture.wrapS = THREE.RepeatWrapping;
                    texture.wrapT = THREE.RepeatWrapping;
                    
                    const isFaceplate = mesh.name && (mesh.name.toLowerCase().includes("faceplate") || 
                                                    mesh.name.toLowerCase().includes("face"));
                    
                    if (isFaceplate) {
                        texture.repeat.set(repeatX * 1.0, repeatY * 1.0); 
                        texture.offset.set(0, 0); 
                    } else {
                        texture.repeat.set(repeatX, repeatY);
                    }
                    
                    texture.anisotropy = renderer.capabilities.getMaxAnisotropy();
                    texture.encoding = THREE.sRGBEncoding;
                    texture.generateMipmaps = true;
                    texture.minFilter = THREE.LinearMipmapLinearFilter;
                    texture.magFilter = THREE.LinearFilter;
                    
                    mesh.material.map = texture;
                    mesh.material.transparent = false;
                    mesh.material.opacity = 1.0;
                    mesh.material.side = THREE.DoubleSide;
                    mesh.material.needsUpdate = true;
                    
                    mesh.geometry.attributes.uv.needsUpdate = true;
                    
                    console.log("Texture applied to mesh:", mesh.name);
                },
                undefined,
                function (error) {
                    console.error("Error loading texture:", textureSrc, error);
                }
            );
        } else {
            mesh.material.map = null;
            mesh.material.needsUpdate = true;
        }
    }

    function applyTextureFromFolder(textureName, object) {
        if (!object || !textureName) return;
        
        let repeatX = 1, repeatY = 1;
        
        const isFaceplate = object.name && (object.name.toLowerCase().includes("faceplate") || 
                                          object.name.toLowerCase().includes("face"));
        
        const textureSettings = {
            'wood': { 
                repeatX: isFaceplate ? 1.2 : 0.8, 
                repeatY: isFaceplate ? 1.2 : 0.8 
            },
            'carbon': { 
                repeatX: isFaceplate ? 2.0 : 0.6, 
                repeatY: isFaceplate ? 2.0 : 0.6 
            }, 
            'marble': { 
                repeatX: isFaceplate ? 1.0 : 0.8, 
                repeatY: isFaceplate ? 1.0 : 0.8 
            }, 
            'galaxy': { 
                repeatX: isFaceplate ? 1.5 : 0.4, 
                repeatY: isFaceplate ? 1.5 : 0.4 
            }, 
            'flakes': { 
                repeatX: isFaceplate ? 2.5 : 0.6, 
                repeatY: isFaceplate ? 2.5 : 0.6 
            }, 
            'abalone': { 
                repeatX: isFaceplate ? 1.8 : 0.4, 
                repeatY: isFaceplate ? 1.8 : 0.4 
            }, 
            'celluloid': { 
                repeatX: isFaceplate ? 1.5 : 0.4, 
                repeatY: isFaceplate ? 1.5 : 0.4 
            }
        };
        
        for (const [key, settings] of Object.entries(textureSettings)) {
            if (textureName.includes(key)) {
                repeatX = settings.repeatX;
                repeatY = settings.repeatY;
                break;
            }
        }
        
        applyTextureToMesh("assets/textures/" + textureName, object, repeatX, repeatY);
        
        setTimeout(() => {
            object.material.transparent = false;
            object.material.opacity = 1.0;
            object.material.side = THREE.DoubleSide;
            
            if (textureName.includes("carbon")) {
                object.material.roughness = 0.4;
                object.material.metalness = 0.6;
                object.material.clearcoat = 0.4;
            } else if (textureName.includes("wood")) {
                object.material.roughness = 0.7;
                object.material.metalness = 0.1;
                object.material.clearcoat = 0.3;
            } else if (textureName.includes("abalone")) {
                object.material.roughness = 0.2;
                object.material.metalness = 0.9;
                object.material.clearcoat = 0.8;
                object.material.envMapIntensity = 1.2;
            } else if (textureName.includes("galaxy")) {
                object.material.roughness = 0.3;
                object.material.metalness = 0.7;
                object.material.clearcoat = 0.6;
            } else if (textureName.includes("flakes")) {
                object.material.roughness = 0.3;
                object.material.metalness = 0.8;
                object.material.clearcoat = 0.7;
                object.material.envMapIntensity = 1.1;
            }
            object.material.needsUpdate = true;
        }, 100);
    }

    function applyUploadedTexture(event, object) {
        if (!object) return;
        const file = event.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function (e) {
                const isFaceplate = object.name && (object.name.toLowerCase().includes("faceplate") || 
                                                  object.name.toLowerCase().includes("face"));
                const repeatX = isFaceplate ? 1.5 : 1;
                const repeatY = isFaceplate ? 1.5 : 1; 
                applyTextureToMesh(e.target.result, object, repeatX, repeatY);
            };
            reader.readAsDataURL(file);
        }
    }

    function updateInfoDisplay(partType, info) {
        const displays = {
            'leftShell': leftShellInfo,
            'rightShell': rightShellInfo,
            'leftFaceplate': leftFaceplateInfo,
            'rightFaceplate': rightFaceplateInfo
        };
        
        if (displays[partType]) {
            displays[partType].textContent = info;
        }
    }

    function setupColorGrid(grid, partType, part) {
        if (!grid || !part) return;
        
        const colorOptions = grid.querySelectorAll('.color-option');
        colorOptions.forEach(option => {
            option.addEventListener('click', function() {
                colorOptions.forEach(opt => opt.classList.remove('selected'));
                this.classList.add('selected');
                
                const color = this.dataset.color;
                if (color) {
                    part.material.color.set(color);
                    part.material.map = null; 
                    part.material.transparent = false;
                    part.material.opacity = 1.0;
                    part.material.needsUpdate = true;
                    updateInfoDisplay(partType, color);
                }
            });
        });
    }

    function setupTextureGrid(grid, partType, part, uploadInput) {
        if (!grid || !part) return;
        
        const textureOptions = grid.querySelectorAll('.texture-option');
        textureOptions.forEach(option => {
            option.addEventListener('click', function() {
                if (this.dataset.texture === 'custom') {
                    if (uploadInput) uploadInput.click();
                    return;
                }
                
                textureOptions.forEach(opt => opt.classList.remove('selected'));
                this.classList.add('selected');
                
                const textureName = this.dataset.texture;
                if (textureName && textureName !== 'none') {
                    applyTextureFromFolder(textureName, part);
                    updateInfoDisplay(partType, this.dataset.name || textureName);
                }
            });
        });
    }

    function updateLighting() {
        lights.ambient.intensity = lightSettings.ambientIntensity;
        lights.key.intensity = lightSettings.keyIntensity;
        lights.fill.intensity = lightSettings.fillIntensity;
        lights.rim.intensity = lightSettings.rimIntensity;
        lights.bottom.intensity = lightSettings.bottomIntensity;
        
        lights.key.color.set(lightSettings.keyColor);
        lights.fill.color.set(lightSettings.fillColor);
    }

    function updateMaterialProperties(materialType) {
        const parts = [leftShell, rightShell, leftFaceplate, rightFaceplate];
        parts.forEach(part => {
            if (!part) return;
            
            part.material.transparent = false;
            part.material.opacity = 1.0;
            part.material.side = THREE.DoubleSide;
            
            switch(materialType) {
                case 'glossy':
                    part.material.roughness = 0.1;
                    part.material.metalness = 0.8;
                    part.material.clearcoat = 1.0;
                    part.material.clearcoatRoughness = 0.1;
                    break;
                case 'matte':
                    part.material.roughness = 0.8;
                    part.material.metalness = 0.2;
                    part.material.clearcoat = 0.0;
                    part.material.clearcoatRoughness = 0.5;
                    break;
                case 'metallic':
                    part.material.roughness = 0.3;
                    part.material.metalness = 1.0;
                    part.material.clearcoat = 0.3;
                    part.material.clearcoatRoughness = 0.2;
                    break;
                case 'ceramic':
                    part.material.roughness = 0.05;
                    part.material.metalness = 0.0;
                    part.material.clearcoat = 0.9;
                    part.material.clearcoatRoughness = 0.05;
                    break;
            }
            part.material.needsUpdate = true;
        });
    }

    const loadingText = document.createElement("p");
    loadingText.innerText = "Loading IEM Model...";
    loadingText.style.color = "white";
    loadingText.style.textAlign = "center";
    loadingText.style.marginTop = "50%";
    container.appendChild(loadingText);

    const loader = new THREE.GLTFLoader();
    loader.load("assets/models/origiem.glb", function (gltf) {
        container.removeChild(loadingText);

        const iemModel = gltf.scene;
        
        iemModel.traverse((child) => {
            if (child.isMesh) {
                ensureMeshUVs(child);
                
                const material = new THREE.MeshPhysicalMaterial({
                    color: 0xf2e6d8,
                    metalness: 0.8,
                    roughness: 0.2,
                    clearcoat: 0.5,
                    clearcoatRoughness: 0.2,
                    envMapIntensity: 1.0,
                    side: THREE.DoubleSide,
                    transparent: false,
                    opacity: 1.0,
                    depthWrite: true,
                    depthTest: true
                });
                
                child.material = material;
                child.castShadow = true;
                child.receiveShadow = true;
                
                if (child.name.toLowerCase().includes("leftshell") || (!leftShell && child.position.x < -0.1)) {
                    leftShell = child;
                    leftShell.material.name = "leftShell";
                } else if (child.name.toLowerCase().includes("rightshell") || (!rightShell && child.position.x > 0.1)) {
                    rightShell = child;
                    rightShell.material.name = "rightShell";
                } else if (child.name.toLowerCase().includes("leftfaceplate") || (!leftFaceplate && child.position.x < -0.05)) {
                    leftFaceplate = child;
                    leftFaceplate.material.name = "leftFaceplate";
                } else if (child.name.toLowerCase().includes("rightfaceplate") || (!rightFaceplate && child.position.x > 0.05)) {
                    rightFaceplate = child;
                    rightFaceplate.material.name = "rightFaceplate";
                }
            }
        });

        if (!leftShell || !rightShell || !leftFaceplate || !rightFaceplate) {
            const meshes = [];
            iemModel.traverse((child) => {
                if (child.isMesh) meshes.push(child);
            });
            
            if (meshes.length >= 2) {
                meshes.sort((a, b) => a.position.x - b.position.x);
                leftShell = leftFaceplate = meshes[0];
                rightShell = rightFaceplate = meshes[meshes.length - 1];
            }
        }

        const box = new THREE.Box3().setFromObject(iemModel);
        const center = box.getCenter(new THREE.Vector3());
        iemModel.position.sub(center);
        
        const size = box.getSize(new THREE.Vector3()).length();
        const scaleFactor = 2 / size;
        iemModel.scale.set(scaleFactor, scaleFactor, scaleFactor);

        turntable = new THREE.Group();
        turntable.add(iemModel);
        turntable.name = "turntable";
        scene.add(turntable);

        camera.position.set(0, 0, 3);
        camera.lookAt(0, 0, 0);
        controls.target.set(0, 0, 0);

        setupColorGrid(leftShellColors, 'leftShell', leftShell);
        setupColorGrid(rightShellColors, 'rightShell', rightShell);
        setupColorGrid(leftFaceplateColors, 'leftFaceplate', leftFaceplate);
        setupColorGrid(rightFaceplateColors, 'rightFaceplate', rightFaceplate);
        
        setupTextureGrid(leftShellTextures, 'leftShell', leftShell, leftShellTextureUpload);
        setupTextureGrid(rightShellTextures, 'rightShell', rightShell, rightShellTextureUpload);
        setupTextureGrid(leftFaceplateTextures, 'leftFaceplate', leftFaceplate, leftFaceplateTextureUpload);
        setupTextureGrid(rightFaceplateTextures, 'rightFaceplate', rightFaceplate, rightFaceplateTextureUpload);
        
        if (leftShellTextureUpload) {
            leftShellTextureUpload.addEventListener("change", (event) => {
                applyUploadedTexture(event, leftShell);
                updateInfoDisplay('leftShell', 'Custom Texture');
            });
        }
        
        if (rightShellTextureUpload) {
            rightShellTextureUpload.addEventListener("change", (event) => {
                applyUploadedTexture(event, rightShell);
                updateInfoDisplay('rightShell', 'Custom Texture');
            });
        }
        
        if (leftFaceplateTextureUpload) {
            leftFaceplateTextureUpload.addEventListener("change", (event) => {
                applyUploadedTexture(event, leftFaceplate);
                updateInfoDisplay('leftFaceplate', 'Custom Texture');
            });
        }
        
        if (rightFaceplateTextureUpload) {
            rightFaceplateTextureUpload.addEventListener("change", (event) => {
                applyUploadedTexture(event, rightFaceplate);
                updateInfoDisplay('rightFaceplate', 'Custom Texture');
            });
        }

        materialOptions.forEach(option => {
            option.addEventListener('click', function() {
                materialOptions.forEach(opt => opt.classList.remove('selected'));
                this.classList.add('selected');
                updateMaterialProperties(this.dataset.material);
            });
        });

        if (ambientIntensity) {
            ambientIntensity.addEventListener("input", function() {
                lightSettings.ambientIntensity = parseFloat(this.value);
                if (ambientValue) ambientValue.textContent = this.value;
                updateLighting();
            });
        }
        
        if (keyIntensity) {
            keyIntensity.addEventListener("input", function() {
                lightSettings.keyIntensity = parseFloat(this.value);
                if (keyValue) keyValue.textContent = this.value;
                updateLighting();
            });
        }
        
        if (fillIntensity) {
            fillIntensity.addEventListener("input", function() {
                lightSettings.fillIntensity = parseFloat(this.value);
                if (fillValue) fillValue.textContent = this.value;
                updateLighting();
            });
        }
        
        if (rimIntensity) {
            rimIntensity.addEventListener("input", function() {
                lightSettings.rimIntensity = parseFloat(this.value);
                if (rimValue) rimValue.textContent = this.value;
                updateLighting();
            });
        }
        
        if (keyLightColor) {
            keyLightColor.addEventListener("input", function() {
                lightSettings.keyColor = this.value;
                updateLighting();
            });
        }
        
        if (fillLightColor) {
            fillLightColor.addEventListener("input", function() {
                lightSettings.fillColor = this.value;
                updateLighting();
            });
        }

        updateMaterialProperties('glossy');
        updateLighting();
        animate();

    }, undefined, function (error) {
        console.error("Error loading model:", error);
        loadingText.innerText = "Error loading model. Please check console.";
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
    });

    const saveDesignBtn = document.getElementById("saveDesign");
    if (saveDesignBtn) {
        saveDesignBtn.addEventListener("click", function() {
            const link = document.createElement('a');
            link.download = 'my-custom-iem.png';
            link.href = renderer.domElement.toDataURL('image/png');
            link.click();
        });
    }
});