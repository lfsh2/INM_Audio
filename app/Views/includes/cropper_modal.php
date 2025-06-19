<!-- Cropper Modal -->
<div class="modal fade" id="cropperModal" tabindex="-1" aria-labelledby="cropperModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-centered">
    <div class="modal-content bg-dark text-light">
      <div class="modal-header">
        <h5 class="modal-title" id="cropperModalLabel">Crop Image</h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div class="img-container mb-3">
          <img id="cropperImage" src="" style="max-width: 100%; display: block;" />
        </div>
        <div class="cropper-controls text-center">
          <div class="btn-group">
            <button type="button" class="btn btn-outline-light btn-sm" id="rotateLeft" title="Rotate Left">
              <i class="fas fa-rotate-left"></i>
            </button>
            <button type="button" class="btn btn-outline-light btn-sm" id="rotateRight" title="Rotate Right">
              <i class="fas fa-rotate-right"></i>
            </button>
            <button type="button" class="btn btn-outline-light btn-sm" id="zoomIn" title="Zoom In">
              <i class="fas fa-search-plus"></i>
            </button>
            <button type="button" class="btn btn-outline-light btn-sm" id="zoomOut" title="Zoom Out">
              <i class="fas fa-search-minus"></i>
            </button>
            <button type="button" class="btn btn-outline-secondary btn-sm" id="resetCropper" title="Reset">
              <i class="fas fa-refresh"></i> Reset
            </button>
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
        <button type="button" class="btn btn-primary" id="cropImageBtn">Crop & Apply</button>
      </div>
    </div>
  </div>
</div>
