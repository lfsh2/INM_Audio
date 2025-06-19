// Debug script to test cropper functionality
document.addEventListener('DOMContentLoaded', function() {
    console.log("Debug script loaded");
    
    // Check if Bootstrap is loaded
    console.log("Bootstrap loaded:", typeof bootstrap !== 'undefined');
    
    // Check if Cropper is loaded
    console.log("Cropper loaded:", typeof Cropper !== 'undefined');
    
    // Test modal functionality
    const testButton = document.createElement('button');
    testButton.textContent = "Test Cropper";
    testButton.className = "btn btn-warning position-fixed";
    testButton.style.top = "70px";
    testButton.style.right = "10px";
    testButton.style.zIndex = "9999";
    document.body.appendChild(testButton);
    
    testButton.addEventListener('click', function() {
        // Create a test image
        const img = new Image();
        img.src = 'data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAQAAAAEACAIAAADTED8xAAADMElEQVR4nOzVMQEAIAzAMMC/5yFjRxMFfXpnZg5Eve0A2GQAggxAkAEIMgBBBiDIAAQZgCADEGQAggxAkAEIMgBBBiDIAAQZgCADEGQAggxAkAEIMgBBBiDIAAQZgCADEGQAggxAkAEIMgBBBiDIAAQZgCADEGQAggxAkAEIMgBBBiDIAAQZgCADEGQAggxAkAEIMgBBBiDIAAQZgCADEGQAggxAkAEIMgBBBiDIAAQZgCADEGQAggxAkAEIMgBBBiDIAAQZgCADEGQAggxAkAEIMgBBBiDIAAQZgCADEGQAggxAkAEIMgBBBiDIAAQZgCADEGQAggxAkAEIMgBBBiDIAAQZgCADEGQAggxAkAEIMgBBBiDIAAQZgCADEGQAggxAkAEIMgBBBiDIAAQZgCADEGQAggxAkAEIMgBBBiDIAAQZgCADEGQAggxAkAEIMgBBBiDIAAQZgCADEGQAggxAkAEIMgBBBiDIAAQZgCADEGQAggxAkAEIMgBBBiDIAAQZgCADEGQAggxAkAEIMgBBBiDIAAQZgCADEGQAggxAkAEIMgBBBiDIAAQZgCADEGQAggxAkAEIMgBBBiDIAAQZgCADEGQAggxAkAEIMgBBBiDIAAQZgCADEGQAggxAkAEIMgBBBiDIAAQZgCADEGQAggxAkAEIMgBBBiDIAAQZgCADEGQAggxAkAEIMgBBBiDIAAQZgCADEGQAggxAkAEIMgBBBiDIAAQZgCADEGQAggxAkAEIMgBBBiDIAAQZgCADEGQAggxAkAEIMgBBBiDIAAQZgCADEGQAggxAkAEIMgBBBiDIAAQZgCADEGQAggxAkAEIMgBBBiDIAAQZgCADEGQAggxAkAEIMgBBBiDIAAQZgCADEGQAggxAkAEIMgBBBiDIAAQZgCADEGQAggxAkAEIMgBBBiDIAAQZgCADEGQAggxAkAEIMgBBBiDIAAQZgCADEGQAggxAkAEIMgBBBiDIAAQZgCADEGQAggxAkAEIMgBBBiDIAAQZgCADEGQAggxAkAEIMgBBBiDIAAQZgCADEGQAggxAkAEIMgBBBiDIAAQZgCADEGQAggxAkAEIMgBBBiDIAAQZgCADEPQD1d0BXdCggYYAAAAASUVORK5CYII=';
        img.id = 'debug-image';
        
        // Create a test modal
        const modal = document.createElement('div');
        modal.className = 'modal fade';
        modal.id = 'debugModal';
        modal.tabIndex = '-1';
        modal.setAttribute('aria-labelledby', 'debugModalLabel');
        modal.setAttribute('aria-hidden', 'true');
        
        modal.innerHTML = `
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="debugModalLabel">Debug Cropper</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div id="debug-container" style="max-height: 400px; overflow: auto;">
                            <img src="${img.src}" id="debug-cropper-image">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        `;
        
        document.body.appendChild(modal);
        
        // Show the modal
        const bsModal = new bootstrap.Modal(document.getElementById('debugModal'));
        bsModal.show();
        
        // Initialize cropper on the image
        document.getElementById('debugModal').addEventListener('shown.bs.modal', function () {
            const debugImage = document.getElementById('debug-cropper-image');
            try {
                const debugCropper = new Cropper(debugImage, {
                    viewMode: 1,
                    autoCropArea: 0.8,
                    ready: function() {
                        console.log('Cropper is ready!');
                    }
                });
                console.log('Cropper initialized successfully');
            } catch (e) {
                console.error('Error initializing Cropper:', e);
            }
        });
    });
});
