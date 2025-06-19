// Simple self-contained cropper implementation
document.addEventListener('DOMContentLoaded', function() {
    console.log('Simple crop initialized');
    
    // Check if Cropper is available
    if (typeof Cropper === 'undefined') {
        console.error('Cropper.js library not loaded! Attempting to load it dynamically...');
        
        // Try to load Cropper.js dynamically
        const cropperCss = document.createElement('link');
        cropperCss.rel = 'stylesheet';
        cropperCss.href = 'https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.13/cropper.min.css';
        document.head.appendChild(cropperCss);
        
        const cropperScript = document.createElement('script');
        cropperScript.src = 'https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.13/cropper.min.js';
        cropperScript.onload = function() {
            console.log('Cropper.js loaded dynamically');
        };
        cropperScript.onerror = function() {
            console.error('Failed to load Cropper.js dynamically');
            alert('Could not load image cropping library. Please check your internet connection and try again.');
        };
        document.head.appendChild(cropperScript);
    }
    
    // Setup global variables
    let cropper = null;
    let currentTarget = null;
    
    // Get file inputs and setup listeners
    const fileInputs = {
        'leftShell': document.getElementById('leftShellTextureUpload'),
        'rightShell': document.getElementById('rightShellTextureUpload'),
        'leftFaceplate': document.getElementById('leftFaceplateTextureUpload'),
        'rightFaceplate': document.getElementById('rightFaceplateTextureUpload')
    };
    
    // Add event listeners to file inputs
    Object.entries(fileInputs).forEach(([target, input]) => {
        if (input) {
            console.log(`Setting up listener for ${target}`);
            input.addEventListener('change', function(event) {
                if (event.target.files && event.target.files[0]) {
                    handleImageUpload(event.target.files[0], target);
                }
            });
        }
    });
    
    // Function to handle image upload
    function handleImageUpload(file, target) {
        console.log(`Handling image upload for ${target}`);
        const reader = new FileReader();
        
        reader.onload = function(e) {
            currentTarget = target;
            showCropModal(e.target.result);
        };
        
        reader.readAsDataURL(file);
    }
    
    // Function to show crop modal
    function showCropModal(imageData) {
        console.log('Showing crop modal');
        
        // Create a simple modal
        const modalHTML = `
            <div class="modal-backdrop fade show"></div>
            <div class="modal fade show" id="simpleCropModal" tabindex="-1" role="dialog" aria-labelledby="simpleCropModalLabel" style="display: block;">
                <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content bg-dark text-light">
                        <div class="modal-header">
                            <h5 class="modal-title" id="simpleCropModalLabel">Crop Image</h5>
                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close" id="simpleCropCloseBtn"></button>
                        </div>
                        <div class="modal-body">
                            <div class="img-container" style="max-height: 400px;">
                                <img id="simpleCropImage" src="${imageData}" style="max-width: 100%; max-height: 400px;">
                            </div>
                            <div class="cropper-controls mt-3 text-center">
                                <div class="btn-group">
                                    <button type="button" class="btn btn-outline-light btn-sm" id="rotateLeftBtn">
                                        <i class="fas fa-rotate-left"></i> Rotate Left
                                    </button>
                                    <button type="button" class="btn btn-outline-light btn-sm" id="rotateRightBtn">
                                        <i class="fas fa-rotate-right"></i> Rotate Right
                                    </button>
                                    <button type="button" class="btn btn-outline-light btn-sm" id="zoomInBtn">
                                        <i class="fas fa-search-plus"></i> Zoom In
                                    </button>
                                    <button type="button" class="btn btn-outline-light btn-sm" id="zoomOutBtn">
                                        <i class="fas fa-search-minus"></i> Zoom Out
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" id="simpleCropCancelBtn">Cancel</button>
                            <button type="button" class="btn btn-primary" id="simpleCropConfirmBtn">Crop & Apply</button>
                        </div>
                    </div>
                </div>
            </div>
        `;
        
        // Append modal to body
        const modalContainer = document.createElement('div');
        modalContainer.id = 'simpleCropContainer';
        modalContainer.innerHTML = modalHTML;
        document.body.appendChild(modalContainer);
        
        // Initialize cropper
        const image = document.getElementById('simpleCropImage');
          try {
            setTimeout(() => {
                try {
                    console.log('Attempting to initialize cropper...');
                    
                    if (typeof Cropper === 'undefined') {
                        throw new Error('Cropper.js library not loaded. Please check your internet connection or try again later.');
                    }
                    
                    cropper = new Cropper(image, {
                        aspectRatio: NaN,
                        viewMode: 1,
                        dragMode: 'move',
                        autoCropArea: 0.8,
                        responsive: true,
                        restore: false,
                        guides: true,
                        center: true,
                        highlight: true,
                        cropBoxMovable: true,
                        cropBoxResizable: true,
                        toggleDragModeOnDblclick: true,
                        ready() {
                            console.log('Simple cropper is ready');
                        }
                    });
                    
                    console.log('Simple cropper initialized successfully');
                } catch (innerError) {
                    console.error('Failed to initialize cropper inside timeout:', innerError);
                    alert('Error initializing image cropper: ' + innerError.message);
                    closeCropModal();
                }
            }, 300); // Small delay to ensure DOM is ready
        } catch (error) {
            console.error('Failed to initialize cropper:', error);
            alert('Error initializing cropper: ' + error.message);
        }
        
        // Setup event handlers
        document.getElementById('rotateLeftBtn').addEventListener('click', () => {
            if (cropper) cropper.rotate(-90);
        });
        
        document.getElementById('rotateRightBtn').addEventListener('click', () => {
            if (cropper) cropper.rotate(90);
        });
        
        document.getElementById('zoomInBtn').addEventListener('click', () => {
            if (cropper) cropper.zoom(0.1);
        });
        
        document.getElementById('zoomOutBtn').addEventListener('click', () => {
            if (cropper) cropper.zoom(-0.1);
        });
        
        document.getElementById('simpleCropCancelBtn').addEventListener('click', closeCropModal);
        document.getElementById('simpleCropCloseBtn').addEventListener('click', closeCropModal);
        
        document.getElementById('simpleCropConfirmBtn').addEventListener('click', () => {
            if (cropper) {
                try {
                    // Get cropped canvas
                    const canvas = cropper.getCroppedCanvas({
                        width: 512,
                        height: 512,
                        imageSmoothingQuality: 'high'
                    });
                    
                    if (canvas) {
                        const croppedImage = canvas.toDataURL('image/png');
                        applyTextureToModel(croppedImage, currentTarget);
                        closeCropModal();
                    }
                } catch (error) {
                    console.error('Error getting cropped canvas:', error);
                    alert('Failed to crop image: ' + error.message);
                }
            }
        });
    }
      // Function to close crop modal
    function closeCropModal() {
        console.log('Closing crop modal');
        
        try {
            // Clean up cropper
            if (cropper) {
                cropper.destroy();
                cropper = null;
            }
            
            // Remove the modal from DOM
            const container = document.getElementById('simpleCropContainer');
            if (container) {
                document.body.removeChild(container);
            }
        } catch (error) {
            console.error('Error closing crop modal:', error);
            // Forceful cleanup attempt
            try {
                document.getElementById('simpleCropContainer')?.remove();
            } catch (e) {}
        }
        
        currentTarget = null;
    }
    
    // Function to apply texture to model
    function applyTextureToModel(textureDataUrl, targetPart) {
        console.log('Applying texture to', targetPart);
        
        // Dispatch custom event for existing code to handle
        document.dispatchEvent(new CustomEvent('customTextureCropped', {
            detail: {
                part: targetPart,
                dataUrl: textureDataUrl
            }
        }));
        
        // Fallback direct implementation
        if (window.applyCroppedTextureToPart) {
            window.applyCroppedTextureToPart(targetPart, textureDataUrl);
        } else {
            console.warn('applyCroppedTextureToPart not found, using fallback');
            
            // If the window function is not available, queue it up
            window._pendingCroppedTextures = window._pendingCroppedTextures || [];
            window._pendingCroppedTextures.push({
                part: targetPart,
                dataUrl: textureDataUrl
            });
        }
    }
});
