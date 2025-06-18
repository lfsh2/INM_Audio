<!-- Cropper Modal -->
<div class="modal fade" id="cropperModal" tabindex="-1" aria-labelledby="cropperModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content bg-dark text-light">
      <div class="modal-header">
        <h5 class="modal-title" id="cropperModalLabel">Crop Image</h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div style="max-width: 100%; max-height: 400px;">
          <img id="cropperImage" src="" style="max-width: 100%; max-height: 400px; display: block; margin: 0 auto;" />
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
        <button type="button" class="btn btn-primary" id="cropImageBtn">Crop & Apply</button>
      </div>
    </div>
  </div>
</div>
